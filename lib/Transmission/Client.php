<?php
namespace Transmission;

use Buzz\Browser;
use Transmission\Exception\ConnectionException;
use Transmission\Exception\InvalidTokenException;
use Transmission\Exception\InvalidResponseException;
use Transmission\Exception\UnexpectedResponseException;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Client
{
    const ROOT_PATH = '/transmission/rpc';

    /**
     * @var string
     */
    protected $host;

    /**
     * @var integer
     */
    protected $port;

    /**
     * @var Buzz\Browser
     */
    protected $browser;

    /**
     * @var string
     */
    protected $token;

    /**
     * Constructor
     *
     * @param string       $host
     * @param integer      $port
     * @param Buzz\Browser $browser
     */
    public function __construct($host = null, $port = null, Browser $browser = null)
    {
        $this->setHost($host ?: 'localhost');
        $this->setPort($port ?: 9091);
        $this->setBrowser($browser ?: new Browser());
    }

    /**
     * Make an API call
     *
     * @param string $content
     * @param string $path
     * @param array  $parameters
     *
     * @return stdClass
     *
     * @throws Transmission\Exception\ConnectionException
     * @throws Transmission\Exception\InvalidTokenException
     */
    public function call($content, $path = '/', array $parameters = array())
    {
        $url     = $this->getUrl($path, $parameters);
        $headers = array();

        if (isset($this->token) && is_string($this->token)) {
            $headers[] = sprintf('X-Transmission-Session-Id: %s', $this->token);
        }

        try {
            $response = $this->getBrowser()->post($url, $headers, $content);
        } catch (\Exception $e) {
            throw new ConnectionException(
                'Could not connect to Transmission', 0, $e
            );
        }

        if ($response->getStatusCode() === 409) {
            throw new InvalidTokenException(
                'Invalid or no token given for Transmission, did you forget to'.
                ' call Client::generateToken()?'
            );
        }

        return $this->transformResponse($response->getContent());
    }

    /**
     * Get the URL to make an API call to
     *
     * @param string $path
     * @param array  $parameters
     * @return string
     */
    public function getUrl($path = '/', array $parameters = array())
    {
        if (strpos($path, 'http://') === 0 || strpos('https://', $path) === 0) {
            return $path;
        }

        $url = sprintf(
            'http://%s:%d%s%s',
            $this->getHost(),
            $this->getPort(),
            self::ROOT_PATH,
            substr($path, 0, 1) == '/' ? $path : '/' . $path
        );

        if ($parameters) {
            $url .= '?' . http_build_query($parameters);
        }

        return $url;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = (string) $token;
    }

    /**
     * @param Boolean $refresh
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = (string) $host;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param integer $port
     */
    public function setPort($port)
    {
        $this->port = (integer) $port;
    }

    /**
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param Buzz\Browser $browser
     */
    public function setBrowser(Browser $browser)
    {
        $this->browser = $browser;
    }

    /**
     * @return Buzz\Browser
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * @return string
     */
    public function generateToken()
    {
        $url = sprintf(
            'http://%s:%d%s',
            $this->getHost(),
            $this->getPort(),
            self::ROOT_PATH
        );

        try {
            $response = $this->browser->post($url);
        } catch (\Exception $e) {
            throw new ConnectionException(
                'Could not connect with Transmission', 0, $e
            );
        }

        if ($response->getStatusCode() !== 409) {
            throw new UnexpectedResponseException(sprintf(
                'Received "%d" from Transmission while expected "409"',
                $response->getStatusCode()
            ));
        }

        $this->setToken($response->getHeader('X-Transmission-Session-Id'));

        return $this->getToken();
    }

    /**
     * @param string $response
     *
     * @return stdClass
     *
     * @throws Transmission\Exception\InvalidResponseException
     */
    protected function transformResponse($response)
    {
        $stdClass = json_decode($response);

        if ($stdClass === null) {
            throw new InvalidResponseException(sprintf(
                'Invalid response received from Transmission: "%s"',
                $response
            ));
        }

        return $stdClass;
    }
}
