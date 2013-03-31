<?php
namespace Transmission\Model;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Torrent implements ModelInterface
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
     * {@inheritDoc}
     */
    public function getMapping()
    {
        return array(
            'id' => 'id',
            'name' => 'name'
        );
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
}
