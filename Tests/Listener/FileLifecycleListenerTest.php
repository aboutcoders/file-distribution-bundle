<?php

namespace Abc\Bundle\FileDistributionBundle\Listener;


use Abc\Bundle\FileDistributionBundle\Entity\FileLifecycleInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileLifecycleListenerTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Doctrine\ORM\Event\LifecycleEventArgs|\PHPUnit_Framework_MockObject_MockObject */
    protected $args;
    /** @var \Abc\Filesystem\FilesystemInterface|\PHPUnit_Framework_MockObject_MockObject */
    protected $filesystem;
    /** @var FileLifecycleInterface|\PHPUnit_Framework_MockObject_MockObject */
    protected $entity;
    /** @var LoggerInterface */
    protected $logger;
    /** @var FileLifecycleListener */
    protected $subject;

    /**
     * @before
     */
    public function setupSubject()
    {
        $this->args       = $this->getMockBuilder('\Doctrine\ORM\Event\LifecycleEventArgs')->disableOriginalConstructor()->getMock();
        $this->filesystem = $this->getMock('\Abc\Filesystem\FilesystemInterface');
        $this->logger     = new NullLogger();
        $this->entity     = $this->getMock('\Abc\Bundle\FileDistributionBundle\Entity\FileLifecycleInterface');
        $this->subject    = new FileLifecycleListener($this->filesystem, $this->logger);
    }

    public function testPrePersist()
    {
        $this->entity->expects($this->once())
            ->method('setPath')
            ->with($this->matchesRegularExpression('/^remote\/dir\/.*\.gif$/'));

        $this->getEntityExpectations();

        $this->subject->prePersist($this->args);
    }

    public function testPreUpdate()
    {
        $this->entity->expects($this->once())
            ->method('setPath')
            ->with($this->matchesRegularExpression('/^remote\/dir\/.*\.gif$/'));

        $this->getEntityExpectations();
        $this->subject->preUpdate($this->args);
    }

    public function testPostLoad()
    {
        $definition = $this->getMock('\Abc\Filesystem\DefinitionInterface');
        $this->filesystem->expects($this->once())
            ->method('getDefinition')
            ->willReturn($definition);

        $this->entity->expects($this->once())
            ->method('setFilesystemDefinition')
            ->with($definition);

        $this->getEntityExpectations(false);
        $this->subject->postLoad($this->args);
    }

    private function getEntityExpectations($setSize = true)
    {
        $fileSize = filesize(__DIR__ . '/../Fixtures/test.gif');
        $file     = new UploadedFile(
            __DIR__ . '/../Fixtures/test.gif',
            'original.gif',
            null,
            $fileSize,
            UPLOAD_ERR_OK,
            true
        );

        $this->entity->expects($this->any())
            ->method('getFile')
            ->willReturn($file);

        $this->entity->expects($this->any())
            ->method('getRemoteDir')
            ->willReturn('remote/dir');

        $this->args->expects($this->any())
            ->method('getEntity')
            ->willReturn($this->entity);

        if ($setSize) {
            $this->entity->expects($this->once())
                ->method('setSize')
                ->with($fileSize);
        }
    }


}
 