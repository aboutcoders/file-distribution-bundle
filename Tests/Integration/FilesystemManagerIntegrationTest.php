<?php


namespace Abc\Bundle\FileDistributionBundle\Tests\Integration;

use Abc\Bundle\FileDistributionBundle\Model\DefinitionManagerInterface;
use Abc\Filesystem\FilesystemType;
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
        $filesystem->setType(FilesystemType::LOCAL);
        $filesystem->setPath('/tmp');

        $manager->update($filesystem);

        //Just in case save operation is delayed
        $now = new \DateTime();
        $now->add(new \DateInterval('P5M'));
        $this->assertLessThanOrEqual($now, $filesystem->getCreatedAt());
    }

    /**
     * @return DefinitionManagerInterface
     */
    protected function getManager()
    {
        return $this->container->get('abc.file_distribution.definition_manager');
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