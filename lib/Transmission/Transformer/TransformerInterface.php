<?php
namespace Transmission\Transformer;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
interface TransformerInterface
{
    /**
     * @param stdClass $response
     *
     * @return mixed
     */
    public function transform(\stdClass $response);
}
