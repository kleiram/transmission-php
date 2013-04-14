<?php
namespace Transmission;

use Buzz\Browser;
use Buzz\Listener\BasicAuthListener;
use Transmission\Exception\ConnectionException;
use Transmission\Exception\AuthenticationException;
use Transmission\Exception\InvalidResponseException;
use Transmission\Exception\UnexpectedResponseException;

/**
 * The Client is used to connect to the Transmission client
 *
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Client
{
    /**
     * @var string
     */
    const USER_AGENT = 'transmission-rpc/0.4.0';

    /**
     * @var string
     */
    const DEFAULT_PATH = '/transmission/rpc';

    /**
     * @var string
     */
    const TOKEN_HEADER = 'X-Transmission-Session-Id';

    /**
     * @var string
     */
    protected $host;

    /**
     * @var integer
     */
    protected $port;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var Buzz\Browser
     */
    protected $browser;

    /**
     * @var string
     */
    protected $authDigest;

    /**
     * Constructor
     *
     * @param string  $host
     * @param integer $port
     */
    public function __construct($host = null, $port = null)
    {
        $this->setHost($host ?: 'localhost');
        $this->setPort($port ?: 9091);
        $this->setBrowser(new Browser());
    }

    /**
     * Authenticate against the Transmission server
     *
     * @param string $username
     * @param string $password
     */
    public function authenticate($username, $password)
    {
        if ($username && $password) {
            $this->authDigest = base64_encode($username .':'. $password);
        } else {
            $this->authDigest = null;
        }
    }

    /**
     * Make an API call
     *
     * @param string $method
     * @param array  $arguments
     * @param string $tag
     * @return stdClass
     * @throws Transmission\Exception\ConnectionException
     * @throws Transmission\Exception\AuthenticationException
     * @throws Transmission\Exception\InvalidResponseException
     * @throws Transmission\Exception\UnexpectedResponseException
     */
    public function call($method, array $arguments = array(), $tag = null)
    {
        $content = array('method' => (string) $method);

        if ($arguments) {
            $content['arguments'] = $arguments;
        }
        if ($tag) {
            $content['tag'] = (string) $tag;
        }

        $headers = array(
            sprintf('User-agent: %s', self::USER_AGENT)
        );

        if (is_string($this->getToken())) {
            $headers[] = sprintf('%s: %s', self::TOKEN_HEADER, $this->getToken());
        }

        if (is_string($this->authDigest)) {
            $headers[] = sprintf('Authorization: Basic %s', $this->authDigest);
        }

        try {
            $response = $this->browser->post(
                $this->getUrl(),
                $headers,
                json_encode($content)
            );
        } catch (\Exception $e) {
            throw new ConnectionException(
                'Could not connect to Transmission',
                0,
                $e
            );
        }

        $statusCode = $response->getStatusCode();

        if ($statusCode === 409) {
            if ($response->getHeader(self::TOKEN_HEADER) == null) {
                throw new InvalidResponseException(
                    'Invalid response received from Transmission'
                );
            }

            $this->setToken($response->getHeader(self::TOKEN_HEADER));

            return $this->call($method, $arguments, $tag);
        }

        if ($statusCode === 401) {
            throw new AuthenticationException(
                'Access to the Transmission server requires authentication'
            );
        }

        if ($statusCode !== 200) {
            throw new UnexpectedResponseException(
                'Unexpected response received from Transmission'
            );
        }

        return $this->transformResponse($response->getContent());
    }

    /**
     * Set the hostname of the Transmission server
     *
     * @param string $host
     * @return Transmission\Client
     */
    public function setHost($host)
    {
        $this->host = (string) $host;

        return $this;
    }

    /**
     * Get the hostname of the Transmission server
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set the port the Transmission server is listening on
     *
     * @param integer $port
     * @return Transmission\Client
     */
    public function setPort($port)
    {
        $this->port = (integer) $port;

        return $this;
    }

    /**
     * Get the port the Transmission server is listening on
     *
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set the browser used to make API calls
     *
     * @param Buzz\Browser $browser
     * @return Transmission\Client
     */
    public function setBrowser(Browser $browser)
    {
        $this->browser = $browser;

        return $this;
    }

    /**
     * Get the browser used to make API calls
     *
     * @return Buzz\Browser
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * Set the API token
     *
     * @param string $token
     * @return Transmission\Client
     */
    public function setToken($token)
    {
        $this->token = (string) $token;

        return $this;
    }

    /**
     * Get the API token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Get the URL used to connect to transmission
     *
     * @return string
     */
    protected function getUrl()
    {
        return sprintf(
            'http://%s:%d%s',
            $this->getHost(),
            $this->getPort(),
            self::DEFAULT_PATH
        );
    }

    /**
     * @param string $response
     * @return stdClass
     * @throws Transmission\Exception\InvalidResponseException
     */
    protected function transformResponse($response)
    {
        $stdClass = json_decode($response);

        if ($stdClass === null) {
            throw new InvalidResponseException(
                'Invalid response received from Transmission'
            );
        }

        return $stdClass;
    }
}
