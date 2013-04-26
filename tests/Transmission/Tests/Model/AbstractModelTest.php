<?php
namespace Transmission\Tests\Model;

class AbstractModelTest extends \PHPUnit_Framework_TestCase
{
    protected $model;

    /**
     * @test
     */
    public function shouldImplementModelInterface()
    {
        $this->assertInstanceOf('Transmission\Model\ModelInterface', $this->getModel());
    }

    /**
     * @test
     */
    public function shouldHaveEmptyMappingByDefault()
    {
        $this->assertEmpty($this->getModel()->getMapping());
    }

    public function setup()
    {
        $this->model = $this->getMockForAbstractClass('Transmission\Model\AbstractModel');
    }

    private function getModel()
    {
        return $this->model;
    }
}
