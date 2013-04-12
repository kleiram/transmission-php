<?php
namespace Transmission\Model;

class Tracker
{
    protected $id;
    protected $tier;
    protected $scrape;
    protected $announce;

    public function setId($id)
    {
        $this->id = (integer) $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTier($tier)
    {
        $this->tier = (integer) $tier;
    }

    public function getTier()
    {
        return $this->tier;
    }

    public function setScrape($scrape)
    {
        $this->scrape = $scrape;
    }

    public function getScrape()
    {
        return $this->scrape;
    }

    public function setAnnounce($announce)
    {
        $this->announce = $announce;
    }

    public function getAnnounce()
    {
        return $this->announce;
    }

    public static function getMapping()
    {
        return array(
            'id' => 'id',
            'tier' => 'tier',
            'scrape' => 'scrape',
            'announce' => 'announce'
        );
    }
}
