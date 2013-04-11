<?php
namespace Transmission;

use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class ResponseTransformer
{
    /**
     * @param stdClass $response
     * @param mixed    $subject
     * @param array    $mapping
     */
    public static function transform(\stdClass $response, $subject, array $mapping)
    {
        $accessor = PropertyAccess::getPropertyAccessor();

        foreach ($mapping as $k => $v) {
            $accessor->setValue(
                $subject,
                $v,
                $accessor->getValue($response, is_string($k) ? $k : $v)
            );
        }
    }
}
