<?php
namespace Transmission\Transformer;

use Transmission\Model\ModelInterface;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
interface TransformerInterface
{
    /**
     * @param Transmission\Model\ModelInterface $model
     * @param stdClass                          $fields
     */
    public function tranform(ModelInterface $model, \stdClass $fields);
}
