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
     * @return mixed
     */
    public static function transform(\stdClass $response, $subject, array $mapping)
    {
        $accessor = PropertyAccess::getPropertyAccessor();

        foreach ($mapping as $from => $to) {
            $from = is_string($from) ? $from : $to;

            if (isset($response->$from)) {
                $accessor->setValue(
                    $subject,
                    $to,
                    $accessor->getValue($response, $from)
                );
            }
        }

        return $subject;
    }
}
