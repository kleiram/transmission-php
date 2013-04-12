<?php
namespace Transmission\Tests;

use Transmission\ResponseTransformer;

class Foo
{
    public $id;

    protected $bar;

    public function setBar($bar)
    {
        $this->bar = $bar;
    }

    public function getBar()
    {
        return $this->bar;
    }
}

class ResponseTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldTransform()
    {
        $subject  = new Foo();
        $response = (object) array('id' => 1, 'foo' => 'baz');

        $result = ResponseTransformer::transform(
            $response,
            $subject,
            array('id', 'foo' => 'bar', 'lorem' => 'ipsum')
        );

        $this->assertInstanceOf('Transmission\Tests\Foo', $result);
        $this->assertEquals(1, $subject->id);
        $this->assertEquals('baz', $subject->getBar());
    }
}
