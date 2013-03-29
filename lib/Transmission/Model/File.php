<?php
namespace Transmission\Model;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class File
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var integer
     */
    protected $completed;

    /**
     * @var integer
     */
    protected $size;

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
     * @param integer $completed
     */
    public function setCompleted($completed)
    {
        $this->completed = (integer) $completed;
    }

    /**
     * @return integer
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * @param integer $size
     */
    public function setSize($size)
    {
        $this->size = (integer) $size;
    }

    /**
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }
}
