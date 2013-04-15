<?php
namespace Transmission;

use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class ResponseTransformer
{
    /**
     * @param stdClass $source
     * @param mixed    $dest
     * @param array    $mapping
     * @return mixed
     */
    public static function transform(\stdClass $source, $dest, array $mapping)
    {
        if (!is_object($dest)) {
            throw new \InvalidArgumentException(
                sprintf('$dest should be an object, %s given', $dest)
            );
        }

        $accessor = PropertyAccess::getPropertyAccessor();

        foreach ($mapping as $from => $to) {
            $from = is_string($from) ? $from : $to;

            if (isset($source->$from) && !is_null($to)) {
                $accessor->setValue(
                    $dest,
                    $to,
                    $accessor->getValue($source, $from)
                );
            }
        }

        return $dest;
    }
}
