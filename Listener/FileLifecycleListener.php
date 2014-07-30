<?php

namespace Abc\Bundle\FileDistributionBundle\Listener;

use Abc\Bundle\FileDistributionBundle\Entity\FileLifecycleInterface;
use Abc\Bundle\FileDistributionBundle\Tests\Integration\FilesystemManagerIntegrationTest;
use Abc\Filesystem\FilesystemInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Filesystem\Exception\IOException;

/**
 * FileLifecycleListener handles lifecycle for entities that implement the interface FileLifecycleInterface.
 *
 * @see FileLifecycleInterface
 */
class FileLifecycleListener
{

    /** @var \Abc\Filesystem\FilesystemInterface */
    protected $filesystem;
    /** @var LoggerInterface */
    protected $logger;

    /**
     * @param FilesystemInterface           $filesystem
     * @param LoggerInterface|null $logger
     */
    function __construct(FilesystemInterface $filesystem, LoggerInterface $logger = null)
    {
        $this->filesystem = $filesystem;
        $this->logger     = $logger == null ? new NullLogger() : $logger;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->preUpload($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->preUpload($args);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (isset($this->temp)) {
            unlink($this->temp);
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->upload($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->upload($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if($entity instanceof FileLifecycleInterface)
        {
            if($entity->getPath() == null)
            {
                return;
            }

            if($this->filesystem->exists($entity->getPath()))
            {
                try
                {
                    $this->filesystem->remove($entity->getPath());
                }
                catch(\Exception $e)
                {
                    $this->logger->error('Failed to delete file {path} from filesystem {filesystem} with exception {exception}', array('path' => $entity->getPath(), 'filesystem' => $this->filesystem, 'exception' => $e));
                }
            }
            else
            {
                $this->logger->error(
                    'Could not delete file {path} because it does not exist on filesystem {filesystem}',
                    array('path' => $entity->getPath(), 'filesystem' => $this->filesystem)
                );
            }
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if($entity instanceof FileLifecycleInterface)
        {
            $entity->setFilesystemDefinition($this->filesystem->getDefinition());
        }
    }

    /**
     * @param LifecycleEventArgs $args
     * @throws \Exception
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     */
    protected function upload(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if($entity instanceof FileLifecycleInterface && null !== $entity->getFile())
        {
            if($entity->getPreviousPath() != null && $this->filesystem->has($entity->getPreviousPath()))
            {
                $this->filesystem->delete($entity->getPreviousPath());
            }

            $tmpFilename = sha1(uniqid(mt_rand(), true));
            $tmpDir = $this->stripTrailingSlash(sys_get_temp_dir());
            $tmpPath = $tmpDir. '/' . $tmpFilename;

            $entity->getFile()->move($tmpDir, $tmpFilename);

            try
            {
                $this->filesystem->upload($tmpPath, $entity->getPath());

                $this->getLocalFilesystem()->remove($tmpPath);
            }
            catch(IOException $e)
            {
                $this->logger->error('Failed to delete file {path}', array('path' => $tmpPath, 'class' => get_class($this)));

                throw $e;
            }
            catch(\Exception $e)
            {
                $this->logger->error('Failed to upload file {file}', array('file' => $entity->getFile(), 'class' => get_class($this)));

                $this->getLocalFilesystem()->remove($tmpPath);

                throw $e;
            }

            $entity->setFile(null);
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    protected function preUpload(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if($entity instanceof FileLifecycleInterface && null !== $entity->getFile())
        {
            $filename = sha1(uniqid(mt_rand(), true));
            $entity->setPath($entity->getRemoteDir() . '/' . $filename . '.' . $entity->getFile()->guessExtension());
            $entity->setSize($entity->getFile()->getFileInfo()->getSize());
        }
    }

    /**
     * @param string $path
     * @return string
     */
    private function stripTrailingSlash($path)
    {
        $lastStr = substr($path, strlen($path) - 1);
        if($lastStr == '/' || $lastStr == '\\')
        {
            return substr($path, 0, strlen($path) - 1);
        }

        return $path;
    }

    /**
     * @return \Symfony\Component\Filesystem\Filesystem
     */
    private function getLocalFilesystem()
    {
        return new \Symfony\Component\Filesystem\Filesystem();
    }
}