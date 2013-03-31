<?php
namespace Transmission\Transformer;

use Transmission\Model\ModelInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

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
        $accessor = PropertyAccess::getPropertyAccessor();

        foreach ($model->getMapping() as $property => $field) {
            if (isset($fields->$field)) {
                $accessor->setValue($model, $property, $fields->$field);
            }
        }

        return $model;
    }
}
