<?php
namespace Transmission\Model;

/**
 * Represents a tracker used to download a torrent
 *
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Tracker
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $tier;

    /**
     * @var string
     */
    protected $scrape;

    /**
     * @var string
     */
    protected $announce;

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
     * @return array
     */
    public static function getMapping()
    {
        return array('id', 'tier', 'scrape', 'announce');
    }
}
