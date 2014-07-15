<?php


namespace Abc\Bundle\FileDistributionBundle\Tests\Model;

use Abc\Bundle\FileDistributionBundle\Model\DefinitionManager;

class DefinitionManagerTest extends \PHPUnit_Framework_TestCase {

    /** @var DefinitionManager|\PHPUnit_Framework_MockObject_MockObject */
    protected $subject;

    public function setUp()
    {
        $this->subject = $this->getMockForAbstractClass('Abc\Bundle\FileDistributionBundle\Model\DefinitionManager');
    }


    public function testCreate()
    {
        $this->subject->expects($this->any())
            ->method('getClass')
            ->will($this->returnValue('Abc\Bundle\FileDistributionBundle\Entity\Definition'));

        $entity = $this->subject->create();

        $this->assertInstanceOf('Abc\Bundle\FileDistributionBundle\Entity\Definition', $entity);
    }
}
 