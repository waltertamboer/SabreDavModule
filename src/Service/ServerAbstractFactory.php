<?php

namespace SabreDavModule\Service;

use SabreDavModule\SabreDav\Server;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServerAbstractFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return strpos($requestedName, 'sabredav.server.') === 0;
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $config = $serviceLocator->get('Config');
        $router = $serviceLocator->get('Router');

        if (!isset($config['sabredav'])) {
            return null;
        }

        $configKey = substr($requestedName, 16);
        $davConfig = $config['sabredav'][$configKey];

        // A list with nodes that will be served to the visitor:
        $nodes = array();

        // Load in the nodes:
        $nodePluginManager = $serviceLocator->get('SabreDavModule\\\Node\\Service\\PluginManager');
        foreach ($davConfig['nodes'] as $nodeOptions) {
            if (!array_key_exists('options', $nodeOptions)) {
                $nodeOptions['options'] = array();
            }

            $nodes[] = $nodePluginManager->get($nodeOptions['name'], $nodeOptions['options']);
        }

        // When we only have one node, we take it out of the array, this changes functionality.
        if (count($nodes) === 1) {
            $nodes = $nodes[0];
        }

        $server = new Server($nodes);
        $server->setBaseUri($router->assemble(array(), array(
            'name' => $davConfig['route'],
        )));

        $pluginManager = $serviceLocator->get('SabreDavModule\\\Plugin\\Service\\PluginManager');
        foreach ($davConfig['plugins'] as $pluginOptions) {
            if (!array_key_exists('options', $pluginOptions)) {
                $pluginOptions['options'] = array();
            }

            $plugin = $pluginManager->get($pluginOptions['name'], $pluginOptions['options']);

            $server->addPlugin($plugin);
        }

        return $server;
    }
}
