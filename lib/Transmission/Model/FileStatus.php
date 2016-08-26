<?php
namespace Transmission\Model;

/**
 * @author DnAp <dnlebedev@gmail.com>
 */
class FileStatus extends AbstractModel
{
    /**
     * @var int
     */
    protected $bytesCompleted;

    /**
     * @var int
     */
    protected $priority;

    /**
     * @var bool
     */
    protected $wanted;

    /**
     * @return int
     */
    public function getBytesCompleted()
    {
        return $this->bytesCompleted;
    }

    /**
     * @param int $bytesCompleted
     */
    public function setBytesCompleted($bytesCompleted)
    {
        $this->bytesCompleted = $bytesCompleted;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return boolean
     */
    public function isWanted()
    {
        return $this->wanted;
    }

    /**
     * @param boolean $wanted
     */
    public function setWanted($wanted)
    {
        $this->wanted = $wanted;
    }

    /**
     * {@inheritDoc}
     */
    public static function getMapping()
    {
        return array(
            'bytesCompleted' => 'bytesCompleted',
            'priority' => 'priority',
            'wanted' => 'wanted'
        );
    }
}