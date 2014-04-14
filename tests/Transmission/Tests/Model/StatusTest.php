<?php
namespace Transmission\Tests\Model;

use Transmission\Model\Status;

class StatusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldConstructUsingStatusInstance()
    {
        $state  = new Status(Status::STATUS_STOPPED);
        $status = new Status($state);

        $this->assertTrue($status->isStopped());
    }
}
