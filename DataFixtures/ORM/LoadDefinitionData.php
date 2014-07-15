<?php

namespace Abc\Bundle\FileDistributionBundle\DataFixtures\ORM;

use Abc\Bundle\FileDistributionBundle\Model\DefinitionManagerInterface;
use Abc\Filesystem\FilesystemType;
use Abc\Bundle\FileDistributionBundle\Entity\Definition;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadDefinitionData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    private $container;

    public function getOrder()
    {
        return 1;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        /** @var DefinitionManagerInterface $manager */
        $manager = $this->container->get('abc.file_distribution.definition_manager');

        $filesystem = new Definition();
        $filesystem->setName('Default filesystem');
        $filesystem->setPath('/');
        $filesystem->setType(FilesystemType::LOCAL);

        $manager->update($filesystem);
    }
}