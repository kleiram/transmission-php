<?php
namespace Transmission\Util;

use Transmission\Model\ModelInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * The PropertyMapper is used to map responses from Transmission to models
 *
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class PropertyMapper
{
    /**
     * @param  ModelInterface $model
     * @param  \stdClass                          $dto
     * @return ModelInterface
     */
    public static function map(ModelInterface $model, $dto)
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $mapping  = array_filter($model->getMapping(), function ($value) {
            return !is_null($value);
        });

        foreach ($mapping as $source => $dest) {
            try {
                $accessor->setValue(
                    $model,
                    $dest,
                    $accessor->getValue($dto, $source)
                );
            } catch (\Exception $e) {
                continue;
            }
        }

        return $model;
    }
}
