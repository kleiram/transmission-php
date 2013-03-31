<?php
namespace Transmission\Tests\Transformer;

use Transmission\Model\Torrent;
use Transmission\Transformer\ModelTransformer;

class ModelTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldTransformFieldsToModels()
    {
        $fields = (object) array(
            'id' => 1,
            'name' => 'foo'
        );

        $transformer = new ModelTransformer();
        $model = $transformer->transform(new Torrent(), $fields);

        $this->assertEquals(1, $model->getId());
        $this->assertEquals('foo', $model->getName());
    }
}
