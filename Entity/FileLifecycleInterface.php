<?php

namespace Abc\Bundle\FileDistributionBundle\Entity;

use Abc\Filesystem\FileInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * FileLifecycleInterface to be implemented in order to let file uploads be managed by the FileLifecycleListener
 *
 * @see \Abc\Bundle\FileDistributionBundle\Listener\FileLifecycleListener
 */
interface FileLifecycleInterface extends FileInterface
{
    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile();

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null);

    /**
     * @return string|null The path to directory on the filesystem where the files are located
     */
    public function getRemoteDir();

    /**
     * @return string|null The path before it was updated, null if the path did not change
     */
    public function getPreviousPath();
} 