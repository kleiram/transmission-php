<?php
namespace Transmission\Model;

/**
 * Represents a file downloaded by a torrent
 *
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class File
{
    /**
     * The name of the file
     *
     * @var string
     */
    protected $name;

    /**
     * The size of the file (in bytes)
     *
     * @var integer
     */
    protected $size;

    /**
     * The number of bytes that are downloaded
     *
     * @var integer
     */
    protected $completed;

    /**
     * Set the name of the file
     *
     * @param string $name The name of the file
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * Get the name of the file
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the size of the file
     *
     * @param integer $size The size of the file (in bytes)
     */
    public function setSize($size)
    {
        $this->size = (integer) $size;
    }

    /**
     * Get the size of the file (in bytes)
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set the number of bytes that are downloaded
     *
     * @param integer $completed
     */
    public function setCompleted($completed)
    {
        $this->completed = (integer) $completed;
    }

    /**
     * Get the number of bytes that are downloaded
     *
     * @return integer
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * @return array
     */
    public static function getMapping()
    {
        return array(
            'name' => 'name',
            'length' => 'size',
            'bytesCompleted' => 'completed'
        );
    }
}
