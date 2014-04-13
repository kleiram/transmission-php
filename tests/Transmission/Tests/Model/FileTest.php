<?php
namespace Transmission\Tests\Model;

use Transmission\Model\File;
use Transmission\Util\PropertyMapper;


class FileTest extends \PHPUnit_Framework_TestCase
{
    protected $file;

    /**
     * @test
     */
    public function shouldImplementModelInterface()
    {
        $this->assertInstanceOf('Transmission\Model\ModelInterface', $this->getFile());
    }

    /**
     * @test
     */
    public function shouldHaveNonEmptyMapping()
    {
        $this->assertNotEmpty($this->getFile()->getMapping());
    }

    /**
     * @test
     */
    public function shouldBeCreatedFromMapping()
    {
        $source = (object) array(
            'name' => 'foo',
            'length' => 100,
            'bytesCompleted' => 10
        );

        PropertyMapper::map($this->getFile(), $source);

        $this->assertEquals('foo', $this->getFile()->getName());
        $this->assertEquals(100, $this->getFile()->getSize());
        $this->assertEquals(10, $this->getFile()->getCompleted());
        $this->assertFalse($this->getFile()->isDone());
    }

    /**
     * @test
     */
    public function shouldConvertToString()
    {
        $this->getFile()->setName('foo');

        $this->assertInternalType('string', (string) $this->getFile());
        $this->assertEquals('foo', (string) $this->getFile());
    }

    public function setup()
    {
        $this->file = new File();
    }

    private function getFile()
    {
        return $this->file;
    }
}

