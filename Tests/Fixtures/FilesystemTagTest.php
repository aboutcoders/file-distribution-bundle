<?php


namespace Abc\Bundle\FileDistributionBundle\Tests\Fixtures;


use Abc\Filesystem\Filesystem;

class FilesystemTagTest
{
    protected $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function getFilesystem()
    {
        return $this->filesystem;
    }
}