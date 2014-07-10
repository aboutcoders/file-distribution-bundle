<?php


namespace Abc\Bundle\FileDistributionBundle\Tests\Integration;

use Abc\Bundle\FileDistributionBundle\Model\FilesystemManagerInterface;
use Abc\File\FilesystemType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Hannes Schulz <schulz@daten-bahn.de>
 */
class FilesystemManagerIntegrationTest extends KernelTestCase
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

        $this->runConsole("doctrine:schema:drop", array("--force" => true));
        $this->runConsole("doctrine:schema:update", array("--force" => true));
    }

    public function testSchemaDefinition()
    {
        $manager  = $this->getManager();
        $filesystem = $manager->create();

        $filesystem->setName('foobar');
        $filesystem->setType(FilesystemType::Filesystem);
        $filesystem->setPath('/tmp');

        $manager->update($filesystem);

        $this->assertLessThanOrEqual(new \DateTime(), $filesystem->getCreatedAt());
    }

    /**
     * @return FilesystemManagerInterface
     */
    protected function getManager()
    {
        return $this->container->get('abc.file_distribution.filesystem_manager');
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        //$this->em->close();
    }

    /**
     * @param $command
     * @param array $options
     * @return int
     */
    protected function runConsole($command, array $options = array())
    {
        $options["-e"] = "test";
        $options["-q"] = null;
        $options       = array_merge($options, array('command' => $command));

        return $this->application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
    }
}