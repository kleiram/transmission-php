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
     * The ID of the tracker
     *
     * @var integer
     */
    protected $id;

    /**
     * The tier the tracker is on
     *
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
     * Set the ID of the tracker
     *
     * @param integer $id The ID of the tracker
     */
    public function setId($id)
    {
        $this->id = (integer) $id;
    }

    /**
     * Get the ID of the tracker
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the tier the tracker is on
     *
     * @param integer $tier The tier the tracker is on
     */
    public function setTier($tier)
    {
        $this->tier = (integer) $tier;
    }

    /**
     * Get the tier the tracker is on
     *
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
