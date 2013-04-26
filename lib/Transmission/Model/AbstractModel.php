<?php
namespace Transmission\Model;

/**
 * Base class for Transmission models
 *
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
abstract class AbstractModel implements ModelInterface
{
    /**
     * {@inheritDoc}
     */
    public function getMapping()
    {
        return array();
    }
}
