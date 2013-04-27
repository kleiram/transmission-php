<?php
namespace Transmission\Tests\Util;

use Transmission\Util\ResponseValidator;

class ResponseValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected $validator;

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function shouldThrowExceptionOnMissingResultField()
    {
        $response = (object) array();

        $this->getValidator()->validate('', $response);
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function shouldThrowExceptionOnErrorResultField()
    {
        $response = (object) array('result' => 'error');

        $this->getValidator()->validate('', $response);
    }

    /**
     * @test
     */
    public function shouldThrowNoExceptionOnValidTorrentGetResponse()
    {
        $response = (object) array(
            'result' => 'success',
            'arguments' => (object) array(
                'torrents' => array(
                    (object) array('foo' => 'bar')
                )
            )
        );

        $this->getValidator()->validate('torrent-get', $response);
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function shouldThrowExceptionOnMissingArgumentsInTorrentGetResponse()
    {
        $response = (object) array('result' => 'success');

        $this->getValidator()->validate('torrent-get', $response);
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function shouldThrowExceptionOnMissingTorrentArgumentInTorrentGetResponse()
    {
        $response = (object) array('result' => 'success', 'arguments' => (object) array());

        $this->getValidator()->validate('torrent-get', $response);
    }

    /**
     * @test
     */
    public function shouldThrowNoExceptionOnValidTorrentAddResponse()
    {
        $response = (object) array(
            'result' => 'success',
            'arguments' => (object) array(
                'torrent-added' => (object) array(
                    'foo' => 'bar'
                )
            )
        );

        $this->getValidator()->validate('torrent-add', $response);
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function shouldThrowExceptionOnMissingArgumentsInTorrentAddResponse()
    {
        $response = (object) array('result' => 'success');

        $this->getValidator()->validate('torrent-add', $response);
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function shouldThrowExceptionOnMissingTorrentFieldArgumentInTorrentAddResponse()
    {
        $response = (object) array('result' => 'success', 'arguments' => (object) array());

        $this->getValidator()->validate('torrent-add', $response);
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function shouldThrowExceptionOnEmptyTorrentFieldInTorrentAddResponse()
    {
        $response = (object) array('result' => 'success', 'arguments' => (object) array('torrent-addres' => (object) array()));

        $this->getValidator()->validate('torrent-add', $response);
    }

    /**
     * @test
     */
    public function shouldThrowNoExceptionOnValidOtherResponses()
    {
        $response = (object) array('result' => 'success');

        $this->getValidator()->validate('torrent-remove', $response);
    }

    public function setup()
    {
        $this->validator = new ResponseValidator();
    }

    private function getValidator()
    {
        return $this->validator;
    }
}
