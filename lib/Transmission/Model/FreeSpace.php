<?php
namespace Transmission\Model;

/**
 * @author Joysen Chellem
 */
class FreeSpace extends AbstractModel
{
    private $path;
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
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
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
     *
     * @return self
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    public static function getMapping()
    {
        return array(
            'path' => 'path',
            'size-bytes' => 'size',
        );
    }
}
