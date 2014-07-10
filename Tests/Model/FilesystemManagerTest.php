<?php


namespace Abc\Bundle\FileDistributionBundle\Tests\Model;

use Abc\Bundle\FileDistributionBundle\Model\FilesystemManager;

class FilesystemManagerTest extends \PHPUnit_Framework_TestCase {

    /** @var FilesystemManager|\PHPUnit_Framework_MockObject_MockObject */
    protected $subject;

    public function setUp()
    {
        $this->subject = $this->getMockForAbstractClass('Abc\Bundle\FileDistributionBundle\Model\FilesystemManager');
    }


    public function testCreate()
    {
        $this->subject->expects($this->any())
            ->method('getClass')
            ->will($this->returnValue('Abc\Bundle\FileDistributionBundle\Entity\Filesystem'));

        $entity = $this->subject->create();

        $this->assertInstanceOf('Abc\Bundle\FileDistributionBundle\Entity\Filesystem', $entity);
    }
}
 