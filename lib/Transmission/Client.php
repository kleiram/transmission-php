<?php
namespace Transmission;

use Buzz\Message\Request;
use Buzz\Message\Response;
use Buzz\Client\Curl;
use Buzz\Client\ClientInterface;

/**
 * The Client class is used to make API calls to the Transmission server
 *
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Client
{
    /**
     * @var string
     */
    const DEFAULT_HOST = 'localhost';

    /**
     * @var integer
     */
    const DEFAULT_PORT = 9091;

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
     * @var Buzz\Client\ClientInterface
     */
    protected $client;

    /**
     * Constructor
     *
     * @param string  $host The hostname of the Transmission server
     * @param integer $port The port the Transmission server is listening on
     */
    public function __construct($host = null, $port = null)
    {
        $this->setHost($host ?: self::DEFAULT_HOST);
        $this->setPort($port ?: self::DEFAULT_PORT);
        $this->setToken(null);
        $this->setClient(new Curl());
    }

    /**
     * Make an API call
     *
     * @param string $method
     * @param array  $arguments
     * @return stdClass
     * @throws RuntimeException
     */
    public function call($method, array $arguments)
    {
        $request = new Request('POST', self::DEFAULT_PATH, $this->getUrl());
        $response = new Response();
        $content = array('method' => $method, 'arguments' => $arguments);

        $request->addHeader(sprintf('%s: %s', self::TOKEN_HEADER, $this->getToken()));
        $request->setContent(json_encode($content));

        try {
            $this->getClient()->send($request, $response);
        } catch (\Exception $e) {
            throw new \RuntimeException(
                'Could not connect to Transmission',
                0,
                $e
            );
        }

        if ($response->getStatusCode() != 200 && $response->getStatusCode() != 409) {
            throw new \RuntimeException('Unexpected response received from Transmission');
        }

        if ($response->getStatusCode() == 409) {
            $this->setToken($response->getHeader(self::TOKEN_HEADER));

            return $this->call($method, $arguments);
        }

        return json_decode($response->getContent());
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return sprintf(
            'http://%s:%d',
            $this->getHost(),
            $this->getPort()
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
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param Buzz\Client\ClientInterface $client
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return Buzz\Client\ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }
}
