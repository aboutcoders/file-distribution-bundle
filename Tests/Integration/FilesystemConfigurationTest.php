<?php


namespace Abc\Bundle\FileDistributionBundle\Tests\Integration;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FilesystemConfigurationTest extends KernelTestCase
{

    /** @var EntityManager */
    private $em;
    /** @var Application */
    private $application;
    /** @var ContainerInterface */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();;

        $this->container   = static::$kernel->getContainer();
        $this->application = new Application(static::$kernel);
        $this->application->setAutoExit(false);
        $this->application->setCatchExceptions(false);
    }

    public function testConfiguredFilesystemsAreWiredAsServices()
    {
        // the default filesystem is wired in ./Fixtures/app/config/config.yml
        $subject = $this->container->get('abc.file_distribution.filesystem.default');

        $this->assertInstanceOf('Abc\File\FilesystemClient', $subject);
    }
} 