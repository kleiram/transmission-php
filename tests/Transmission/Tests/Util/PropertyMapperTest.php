<?php
namespace Transmission\Tests\Util;

use Transmission\Util\PropertyMapper;

class PropertyMapperTest extends \PHPUnit_Framework_TestCase
{
    protected $mapper;

    /**
     * @test
     */
    public function shouldMapSourcesToModelWithMethodCall()
    {
        $source = (object) array(
            'foo' => 'this',
            'bar' => 'that',
            'ba' => 'thus',
            'unused' => false
        );

        $model = $this->getMock('Transmission\Model\ModelInterface', array(
            'getMapping',
            'setFo',
            'setBar',
            'setUnused'
        ));

        $model->expects($this->any())
            ->method('getMapping')
            ->will($this->returnValue(array(
                'foo' => 'fo',
                'bar' => 'bar',
                'unused' => null,
            )));

        $model->expects($this->once())
            ->method('setFo')
            ->with('this');

        $model->expects($this->once())
            ->method('setBar')
            ->with('that');

        $model->expects($this->never())
            ->method('setUnused');

        $this->getMapper()->map($model, $source);
    }

    public function setup()
    {
        $this->mapper = new PropertyMapper();
    }

    private function getMapper()
    {
        return $this->mapper;
    }
}
