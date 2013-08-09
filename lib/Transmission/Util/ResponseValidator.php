<?php
namespace Transmission\Util;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class ResponseValidator
{
    /**
     * @param string   $method
     * @param stdClass $response
     * @throws RuntimeException
     */
    public static function validate($method, \stdClass $response)
    {
        if (!isset($response->result)) {
            throw new \RuntimeException('Invalid response received from Transmission');
        }

        if ($response->result !== 'success') {
            throw new \RuntimeException(
                sprintf('An error occured: "%s"', $response->result)
            );
        }
        switch ($method) {
            case 'torrent-get':
                return self::validateGetResponse($response);
            case 'torrent-add':
                return self::validateAddResponse($response);
            case 'session-get':
            	return self::validateSessionGetResponse($response);
        }
    }

    /**
     * @param stdClass $response
     * @throws RuntimeException
     */
    public static function validateGetResponse(\stdClass $response)
    {
        if (!isset($response->arguments) ||
            !isset($response->arguments->torrents)) {
            throw new \RuntimeException(
                'Invalid response received from Transmission'
            );
        }

        return $response->arguments->torrents;
    }

    /**
     * @param stdClass $response
     * @throws RuntimeException
     */
    public static function validateAddResponse(\stdClass $response)
    {
        $torrentField = 'torrent-added';

        if (!isset($response->arguments) ||
            !isset($response->arguments->$torrentField) ||
            !count($response->arguments->$torrentField)) {
            throw new \RuntimeException(
                'Invalid response received from Transmission'
            );
        }

        return $response->arguments->$torrentField;
    }

    public static function validateSessionGetResponse(\stdClass $response)
    {
        if (!isset($response->arguments)) {
            throw new \RuntimeException(
                'Invalid response received from Transmission'
            );
        }

    	return $response->arguments;
    }
}
