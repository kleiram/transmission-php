<?php
namespace Transmission\Tests\Transformer;

use Transmission\Transformer\ModelTransformer;

class ModelTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldTransformFieldsToModels()
    {
        $model = $this->getMock('Transmission\Model\ModelInterface', array(
            'setId',
            'setName',
            'getMapping'
        ));

        $model
            ->expects($this->once())
            ->method('getMapping')
            ->will($this->returnValue(array(
                'id' => 'id',
                'name' => 'name'
            )));

        $model
            ->expects($this->once())
            ->method('setId')
            ->with(1);

        $model
            ->expects($this->once())
            ->method('setName')
            ->with('foo');

        $fields = (object) array(
            'id' => 1,
            'name' => 'foo'
        );

        $transformer = new ModelTransformer();
        $this->assertEquals($model, $transformer->transform($model, $fields));
    }
}
