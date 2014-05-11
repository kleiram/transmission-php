<?php
namespace Transmission\Model;

/**
 * @author Joysen Chellem
 */
class FreeSpace extends AbstractModel
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var integer
     */
    private $size;

    /**
     * Gets the value of path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets the value of path.
     *
     * @param string $path the path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Gets the value of size.
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Sets the value of size.
     *
     * @param integer $size the size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * {@inheritDoc}
     */
    public static function getMapping()
    {
        return array(
            'path' => 'path',
            'size-bytes' => 'size',
        );
    }
}
