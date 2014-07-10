<?php

namespace Abc\Bundle\FileDistributionBundle\DataFixtures\ORM;

use Abc\Bundle\FileDistributionBundle\Model\FilesystemManagerInterface;
use Abc\File\FilesystemType;
use Abc\Bundle\FileDistributionBundle\Entity\Filesystem;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadFilesystemData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        /** @var FilesystemManagerInterface $manager */
        $manager = $this->container->get('abc.file_distribution.filesystem_manager');

        $filesystem = new Filesystem();
        $filesystem->setName('Default filesystem');
        $filesystem->setPath('/');
        $filesystem->setType(FilesystemType::Filesystem);

        $manager->update($filesystem);
    }
}