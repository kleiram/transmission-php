<?php
namespace Transmission\Model;

use Transmission\Client;

/**
 * Base class for Transmission models
 *
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
abstract class AbstractModel
{
    /**
     * The client used to connect to Transmission
     *
     * @var Transmission\Client
     */
    protected $client;

    /**
     * Constructor
     *
     * @param Transmission\Client $client The client that should be used to
     *                            connect to Transmission
     */
    public function __construct(Client $client = null)
    {
        $this->setClient($client ?: new Client());
    }

    /**
     * Set the client used to connect to Transmission
     *
     * @param Transmission\Client $client The client that should be used
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the client used to connect to Transmission
     *
     * @return Transmission\Client
     */
    public function getClient()
    {
        return $this->client;
    }
}
