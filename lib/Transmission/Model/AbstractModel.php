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
     * @var Transmission\Client
     */
    protected $client;

    /**
     * Constructor
     *
     * @param Transmission\Client $client
     */
    public function __construct(Client $client = null)
    {
        $this->setClient($client ?: new Client());
    }

    /**
    * @param Transmission\Client $client
    */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Transmission\Client
     */
    public function getClient()
    {
        return $this->client;
    }
}
