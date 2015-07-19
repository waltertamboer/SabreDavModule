<?php

namespace SabreDavModule\Node\Service;

use RuntimeException;
use Sabre\DAV\FS\Directory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\MutableCreationOptionsTrait;
use Zend\ServiceManager\ServiceLocatorInterface;

class DirectoryFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    use MutableCreationOptionsTrait;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if (!isset($this->creationOptions['path'])) {
            throw new RuntimeException(sprintf('Missing "path" in options array for "%s".', __CLASS__));
        }

        if (!is_dir($this->creationOptions['path'])) {
            throw new RuntimeException(sprintf('The directory "%s" does not exists.', $this->creationOptions['path']));
        }

        // We create a full path of the path. This solves a bug on Windows machines where the path could not be read.
        $path = str_replace('\\', '/', realpath($this->creationOptions['path']));

        $directory = new Directory($path);

        $this->creationOptions = array();

        return $directory;
    }
}
