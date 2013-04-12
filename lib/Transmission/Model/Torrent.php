<?php
namespace Transmission\Model;

use Transmission\Client;

/**
 * Represents a torrent in Transmissions download queue
 *
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Torrent extends AbstractModel
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * Constructor
     *
     * @param Transmission\Client $client
     */
    public function __construct(Client $client = null)
    {
        parent::__construct($client);
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = (integer) $id;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    protected static function getMapping()
    {
        return array(
            'id' => 'id',
            'name' => 'name'
        );
    }
}
