<?php
namespace Transmission\Model;

/**
 * @author Ramon Kleiss <ramonkleiss@gmail.com>
 */
class Status extends AbstractModel
{
    /**
     * @var integer
     */
    const STATUS_STOPPED = 0;

    /**
     * @var integer
     */
    const STATUS_CHECK_WAIT = 1;

    /**
     * @var integer
     */
    const STATUS_CHECK = 2;

    /**
     * @var integer
     */
    const STATUS_DOWNLOAD_WAIT = 3;

    /**
     * @var integer
     */
    const STATUS_DOWNLOAD = 4;

    /**
     * @var integer
     */
    const STATUS_SEED_WAIT = 5;

    /**
     * @var integer
     */
    const STATUS_SEED = 6;

    /**
     * @var integer
     */
    protected $status;

    /**
     * @param integer|Status $status
     */
    public function __construct($status)
    {
        if ($status instanceof self) {
            $this->status = $status->getValue();
        } else {
            $this->status = (integer) $status;
        }
    }

    /**
     * @return integer
     */
    public function getValue()
    {
        return $this->status;
    }

    /**
     * @return boolean
     */
    public function isStopped()
    {
        return $this->status == self::STATUS_STOPPED;
    }

    /**
     * @return boolean
     */
    public function isChecking()
    {
        return ($this->status == self::STATUS_CHECK ||
                $this->status == self::STATUS_CHECK_WAIT);
    }

    /**
     * @return boolean
     */
    public function isDownloading()
    {
        return ($this->status == self::STATUS_DOWNLOAD ||
                $this->status == self::STATUS_DOWNLOAD_WAIT);
    }

    /**
     * @return boolean
     */
    public function isSeeding()
    {
        return ($this->status == self::STATUS_SEED ||
                $this->status == self::STATUS_SEED_WAIT);
    }
}
