<?php
namespace Transmission\Model;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Peer
{
    /**
     * @var string
     */
    protected $address;

    /**
     * @var integer
     */
    protected $port;

    /**
     * @var Boolean
     */
    protected $protected;

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = (string) $address;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param integer $port
     */
    public function setPort($port)
    {
        $this->port = (integer) $port;
    }

    /**
     * @var Boolean $protected
     */
    public function setProtected($protected)
    {
        $this->protected = (Boolean) $protected;
    }

    /**
     * @return Boolean
     */
    public function isProtected()
    {
        return $this->protected;
    }
}
