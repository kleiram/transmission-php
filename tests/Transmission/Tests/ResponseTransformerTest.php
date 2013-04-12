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
            array('id', 'foo' => 'bar')
        );

        $this->assertInstanceOf('Transmission\Tests\Foo', $result);
        $this->assertEquals(1, $subject->id);
        $this->assertEquals('baz', $subject->getBar());
    }

    /**
     * @test
     */
    public function shouldIgnoreNonExistingFields()
    {
        $subject = new Foo();
        $response = (object) array('id' => 1, 'foo' => 'baz');

        $result = ResponseTransformer::transform(
            $response,
            $subject,
            array('id', 'foo' => 'bar', 'bar' => 'baz')
        );

        $this->assertInstanceOf('Transmission\Tests\Foo', $result);
        $this->assertEquals(1, $subject->id);
        $this->assertEquals('baz', $subject->getBar());
    }

    /**
     * @test
     */
    public function shouldIgnoreFieldsWhereNullIsSpecified()
    {
        $subject = new Foo();
        $response = (object) array('id' => 1, 'foo' => 'baz');

        $result = ResponseTransformer::transform(
            $response,
            $subject,
            array('id', 'foo' => null)
        );

        $this->assertInstanceOf('Transmission\Tests\Foo', $result);
        $this->assertEquals(1, $subject->id);
        $this->assertNull($subject->getBar());
    }
}
