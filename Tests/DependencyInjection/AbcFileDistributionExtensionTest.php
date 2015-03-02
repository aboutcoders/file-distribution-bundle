<?php


namespace Abc\Bundle\FileDistributionBundle\Tests\DependencyInjection;


use Abc\Bundle\FileDistributionBundle\DependencyInjection\AbcFileDistributionExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AbcFileDistributionExtensionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var AbcFileDistributionExtension
     */
    private $extension;

    /**
     * @var bool
     */
    private $includeFormat;

    /**
     * @var array
     */
    private $formats;

    /**
     * @var string
     */
    private $defaultFormat;


    public function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->container->setParameter('kernel.bundles', array('AbcFileDistributionBundle' => true));
        $this->extension = new AbcFileDistributionExtension();
        $this->includeFormat = true;
        $this->formats = array(
            'json' => false,
            'xml'  => false,
            'html' => true,
        );
        $this->defaultFormat = null;
    }

    public function tearDown()
    {
        unset($this->container, $this->extension);
    }


    public function testLoadFilesystems()
    {
        $config = array(
            'db_driver' => 'orm',
            'filesystems' => array(
                'default' => array(
                    'type' => 'LOCAL',
                    'path' => '/path/to/directory',
                    'options' => array(
                        'create' => true,
                        'mode' => 0755
                    )
                )
            )
        );

        $configs = array('abc_file_distribution' => $config);

        $this->extension->load($configs, $this->container);

        $this->assertTrue($this->container->hasDefinition('abc.file_distribution.definition.default'));

        $definition = $this->container->getDefinition('abc.file_distribution.definition.default');

        $this->assertContains(array('setType', array('LOCAL')), $definition->getMethodCalls());
        $this->assertContains(array('setPath', array('/path/to/directory')), $definition->getMethodCalls());
        $this->assertContains(array('setProperties', array(array('create' => true, 'mode' => 0755))), $definition->getMethodCalls());

        $this->assertTrue($this->container->hasDefinition('abc.file_distribution.filesystem.default'));

        $definition = $this->container->getDefinition('abc.file_distribution.filesystem.default');

        $this->assertEquals('Abc\Filesystem\Filesystem', $definition->getClass());
        $this->assertEquals(new Reference('abc.file_distribution.adapter_factory'), $definition->getArgument(0));
        $this->assertEquals(new Reference('abc.file_distribution.definition.default'), $definition->getArgument(1));
    }
}