<?php

namespace Abc\Bundle\FileDistributionBundle\Tests\Doctrine;

use Abc\Bundle\FileDistributionBundle\Entity\DefinitionManager;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

class DefinitionManagerTest extends \PHPUnit_Framework_TestCase
{

    /** @var string */
    private $class;
    /** @var ClassMetadata|\PHPUnit_Framework_MockObject_MockObject */
    private $classMetaData;
    /** @var ObjectManager|\PHPUnit_Framework_MockObject_MockObject */
    private $objectManager;
    /** @var ObjectRepository|\PHPUnit_Framework_MockObject_MockObject */
    private $repository;
    /** @var DefinitionManager */
    private $subject;


    public function setUp()
    {
        $this->class         = 'Abc\Bundle\FileDistributionBundle\Entity\Definition';
        $this->classMetaData = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $this->objectManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock();
        $this->repository    = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');

        $this->objectManager->expects($this->any())
            ->method('getClassMetadata')
            ->will($this->returnValue($this->classMetaData));

        $this->classMetaData->expects($this->any())
            ->method('getName')
            ->will($this->returnValue($this->class));

        $this->objectManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($this->repository));

        $this->subject = new DefinitionManager($this->objectManager, $this->class);
    }


    public function testGetClass()
    {
        $this->assertEquals($this->class, $this->subject->getClass());
    }


    public function testUpdate()
    {
        $filesystem = $this->subject->create();

        $this->objectManager->expects($this->once())
            ->method('persist')
            ->with($filesystem);

        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->subject->update($filesystem);
    }


    public function testUpdateWithFlush()
    {
        $filesystem = $this->subject->create();

        $this->objectManager->expects($this->once())
            ->method('persist')
            ->with($filesystem);

        $this->objectManager->expects($this->never())
            ->method('flush');

        $this->subject->update($filesystem, false);
    }


    public function testDelete()
    {
        $filesystem = $this->subject->create();

        $this->objectManager->expects($this->once())
            ->method('remove')
            ->with($filesystem);

        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->subject->delete($filesystem);
    }


    public function testFindAll()
    {
        $this->repository->expects($this->once())
            ->method('findAll');

        $this->subject->findAll();
    }


    public function testFindBy()
    {
        $criteria = array('foo');

        $this->repository->expects($this->once())
            ->method('findOneBy')
            ->with($criteria);

        $this->subject->findOneBy($criteria);
    }
}