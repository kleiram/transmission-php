<?php
namespace Transmission\Transformer;

use Transmission\Model\ModelInterface;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class ModelTransformer implements TransformerInterface
{
    /**
     * {@inheritDoc}
     */
    public function transform(ModelInterface $model, \stdClass $fields)
    {
        foreach ($model->getMapping() as $property => $field) {
            if (isset($fields->$field)) {
                $setter = 'set' . ucfirst($property);

                $model->$setter($fields->$field);
            }
        }

        return $model;
    }
}
