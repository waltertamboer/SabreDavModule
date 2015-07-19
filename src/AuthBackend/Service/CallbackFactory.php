<?php

namespace SabreDavModule\AuthBackend\Service;

use RuntimeException;
use Sabre\DAV\Auth\Backend\BasicCallBack;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\MutableCreationOptionsTrait;
use Zend\ServiceManager\ServiceLocatorInterface;

class CallbackFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    use MutableCreationOptionsTrait;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if (!isset($this->creationOptions['callback'])) {
            throw new RuntimeException(sprintf('Missing "callback" in options array for "%s".', __CLASS__));
        }

        $callback = $this->creationOptions['callback'];

        $authBackend = new BasicCallBack($callback);

        $this->creationOptions = array();

        return $authBackend;
    }
}
