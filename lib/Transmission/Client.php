<?php
namespace Transmission;

use Buzz\Browser;

/**
 * Provides communication with the Transmission API
 *
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Client
{
    const RPC_PATH     = '/transmission/rpc';
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
     * Constructor
     *
     * @param string  $host (optional) The hostname of the Transmission server
     * @param integer $port (optional) The port the Transmission server is listening on
     */
    public function __construct($host = null, $port = null)
    {
        $this->setHost($host ?: 'localhost');
        $this->setPort($port ?: 9091);
        $this->setBrowser(new Browser());
    }

    /**
     * Make an API call
     *
     * @param string $method
     * @param array  $arguments
     */
    public function call($method, array $arguments)
    {
        $url     = $this->getUrl();
        $headers = array();
        $request = array(
            'method' => (string) $method,
            'arguments' => $arguments
        );

        // Check if we have an API token, if not, request one
        if ($this->hasToken()) {
            $this->setToken($this->requestToken());
        }

        $headers[] = sprintf('%s: %s', self::TOKEN_HEADER, $this->getToken());

        try {
            $response = $this->getBrowser()->post(
                $url, $headers, json_encode($request)
            );
        } catch (\Exception $e) {
            // TODO: Make ConnectionException
            throw new \Exception(
                'Could not connect to Transmission', 0, $e
            );
        }

        if ($response->getStatusCode() != 200) {
            // TODO: Make UnexpectedResponseException
            throw new \Exception(sprintf(
                'Received unexpected %d, expected %d',
                $response->getStatusCode(),
                200
            ));
        }

        return $this->transformResponse($response->getContent());
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return sprintf(
            'http://%s:%d%s',
            $this->getHost(),
            $this->getPort(),
            self::RPC_PATH
        );
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
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = (string) $token;
    }

    /**
     * @return Boolean
     */
    public function hasToken()
    {
        return !is_null($this->token);
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function requestToken()
    {
        try {
            $response = $this->getBrowser()->post($this->getUrl());
        } catch (\Exception $e) {
            // TODO: Make ConnectionException
            throw new \Exception(
                'Could not connect to Transmission', 0, $e
            );
        }

        if ($response->getStatusCode() != 409) {
            // TODO: Make UnexpectedResponseException
            throw new \Exception(sprintf(
                'Received unexpected %d, expected %d',
                $response->getStatusCode(),
                409
            ));
        }

        if (!($token = $response->getHeader(self::TOKEN_HEADER))) {
            // TODO: Make InvalidResponseException
            throw new \Exception(
                'Did not receive API token from Transmission'
            );
        }

        return $token;
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
}
