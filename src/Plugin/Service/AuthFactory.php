<?php

namespace SabreDavModule\Plugin\Service;

use Sabre\DAV\Auth\Plugin;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\MutableCreationOptionsTrait;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    use MutableCreationOptionsTrait;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $plugin = new Plugin();

        $authBackendPluginManager =
            $serviceLocator->getServiceLocator()->get('SabreDavModule\\\AuthBackend\\Service\\PluginManager');

        foreach ($this->creationOptions['backends'] as $backend) {
            $authBackend = $authBackendPluginManager->get($backend['name'], $backend['options']);

            $plugin->addBackend($authBackend);
        }

        $this->creationOptions = array();

        return $plugin;
    }
}
