<?php

namespace Abc\FileDistributionBundle\DataFixtures\ORM;

use Abc\File\FilesystemType;
use Abc\FileDistributionBundle\Entity\Location;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadLocationData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $location1 = new Location();
        $location1->setName('Default location');
        $location1->setPath('/');
        $location1->setType(FilesystemType::Filesystem);
        $manager->persist($location1);

    }

}
