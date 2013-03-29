<?php
namespace Transmission\Test;

use Transmission\Service;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetTorrents()
    {
        $object = (object) array('foo' => 'bar');

        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with(json_encode(
                array(
                    'arguments' => array(
                        'fields' => array(
                            'id', 'name', 'totalSize', 'doneDate',
                            'peers', 'files', 'trackers'
                        )
                    ),
                    'method' => 'torrent-get'
                )
            ))
            ->will($this->returnValue($object));

        $transformer = $this->getMock('Transmission\Transformer\TransformerInterface');
        $transformer
            ->expects($this->once())
            ->method('transform')
            ->with($object)
            ->will($this->returnValue(true));

        $service = new Service();
        $service->setClient($client);
        $service->setTransformer($transformer);

        $this->assertTrue($service->getTorrents());
    }

    public function testGetTorrent()
    {
        $object = (object) array('foo' => 'bar');

        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with(json_encode(
                array(
                    'arguments' => array(
                        'fields' => array(
                            'id', 'name', 'totalSize', 'doneDate',
                            'peers', 'files', 'trackers'
                        ),
                        'ids' => array(1),
                        'method' => 'torrent-get'
                    )
                )
            ))
            ->will($this->returnValue($object));

        $transformer = $this->getMock('Transmission\Transformer\TransformerInterface');
        $transformer
            ->expects($this->once())
            ->method('transform')
            ->with($object)
            ->will($this->returnValue(array(true)));

        $service = new Service();
        $service->setClient($client);
        $service->setTransformer($transformer);

        $this->assertTrue($service->getTorrent(1));
    }

    public function testExceptionWhenTorrentIsNotFound()
    {
        $this->setExpectedException('Transmission\Exception\NoSuchTorrentException');

        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->will($this->returnValue((object) array(
                'result' => 'success',
                'arguments' => array(
                    'torrents' => array()
                )
            )));

        $service = new Service();
        $service->setClient($client);
        $service->getTorrent(1);
    }

    public function testAddTorrent()
    {
        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with(json_encode(array(
                'arguments' => array(
                    'filename' => 'foo'
                ),
                'method' => 'torrent-add'
            )))
            ->will($this->returnValue((object) array()));

        $transformer = $this->getMock('Transmission\Transformer\TransformerInterface');
        $transformer
            ->expects($this->once())
            ->method('transform')
            ->with((object) array())
            ->will($this->returnValue(true));

        $service = new Service();
        $service->setClient($client);
        $service->setTransformer($transformer);

        $this->assertTrue($service->addTorrent('foo'));
    }

    public function testDeleteTorrentWithoutDeletingLocalData()
    {
        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with(json_encode(array(
                'arguments' => array(
                    'ids' => array(1),
                    'deleteLocal' => false
                ),
                'method' => 'torrent-remove'
            )))
            ->will($this->returnValue((object) array('result' => 'success')));

        $service = new Service();
        $service->setClient($client);

        $service->removeTorrent(1);
    }

    public function testDeleteTorrentWithDeletingLocalData()
    {
        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with(json_encode(array(
                'arguments' => array(
                    'ids' => array(1),
                    'deleteLocal' => true
                ),
                'method' => 'torrent-remove'
            )))
            ->will($this->returnValue((object) array('result' => 'success')));

        $service = new Service();
        $service->setClient($client);

        $service->removeTorrent(1, true);
    }
}
