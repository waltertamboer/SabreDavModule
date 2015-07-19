<?php

namespace SabreDavModule\AuthBackend\Service;

use RuntimeException;
use Sabre\DAV\Auth\Backend\File;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\MutableCreationOptionsTrait;
use Zend\ServiceManager\ServiceLocatorInterface;

class FileFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    use MutableCreationOptionsTrait;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if (!isset($this->creationOptions['path'])) {
            throw new RuntimeException(sprintf('Missing "path" in options array for "%s".', __CLASS__));
        }

        if (!is_file($this->creationOptions['path'])) {
            throw new RuntimeException(sprintf(
                'File "%s" set in options array for "%s" does not exists.',
                $this->creationOptions['path'],
                __CLASS__
            ));
        }

        $authBackend = new File($this->creationOptions['path']);

        $this->creationOptions = array();

        return $authBackend;
    }
}
