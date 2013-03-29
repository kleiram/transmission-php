<?php
namespace Transmission\Model;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Tracker
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $announce;

    /**
     * @var string
     */
    protected $scrape;

    /**
     * @var integer
     */
    protected $tier;

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = (integer) $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $announce
     */
    public function setAnnounce($announce)
    {
        $this->announce = (string) $announce;
    }

    /**
     * @return string
     */
    public function getAnnounce()
    {
        return $this->announce;
    }

    /**
     * @param string $scrape
     */
    public function setScrape($scrape)
    {
        $this->scrape = (string) $scrape;
    }

    /**
     * @return string
     */
    public function getScrape()
    {
        return $this->scrape;
    }

    /**
     * @param integer $tier
     */
    public function setTier($tier)
    {
        $this->tier = (integer) $tier;
    }

    /**
     * @return integer
     */
    public function getTier()
    {
        return $this->tier;
    }
}
