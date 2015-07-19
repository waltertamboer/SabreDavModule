<?php

namespace SabreDavModule;

return array(
    'controllers' => array(
        'abstract_factories' => array(
            'SabreDavModule\\Controller\\Service\\ControllerAbstractFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'sabredav-dav' => array(
                'type' => 'SabreDavModule\\Mvc\\Router\\Http\\SabreDav',
                'options' => array(
                    'regex' => '/dav/(?<slug>.*)',
                    'spec' => '/dav/%slug%',
                    'defaults' => array(
                        'controller' => 'sabredavmodule.dav',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'sabredav_auth_backends' => array(
        'factories' => array(
            'apache' => 'SabreDavModule\\AuthBackend\\Service\\ApacheFactory',
            'callback' => 'SabreDavModule\\AuthBackend\\Service\\CallbackFactory',
            'file' => 'SabreDavModule\\AuthBackend\\Service\\FileFactory',
            'pdo' => 'SabreDavModule\\AuthBackend\\Service\\PdoFactory',
        ),
    ),
    'sabredav_lock_backends' => array(
        'factories' => array(
            'file' => 'SabreDavModule\\LockBackend\\Service\\FileFactory',
            'pdo' => 'SabreDavModule\\LockBackend\\Service\\PdoFactory',
        ),
    ),
    'sabredav_nodes' => array(
        'factories' => array(
            'caldav' => 'SabreDavModule\\Node\\Service\\CalDavFactory',
            'carddav' => 'SabreDavModule\\Node\\Service\\CardDavFactory',
            'directory' => 'SabreDavModule\\Node\\Service\\DirectoryFactory',
            'principal' => 'SabreDavModule\\Node\\Service\\PrincipalCollectionFactory',
        ),
    ),
    'sabredav_plugins' => array(
        'invokables' => array(
            'acl' => 'Sabre\\DAVACL\\Plugin',
            'browser' => 'Sabre\\DAV\\Browser\\Plugin',
            'caldav' => 'Sabre\\CalDAV\\Plugin',
            'carddav' => 'Sabre\\CardDAV\\Plugin',
            'mount' => 'Sabre\\DAV\\Mount\\Plugin',
            'partial' => 'Sabre\\DAV\\PartialUpdate\\Plugin',
            'schedule' => 'Sabre\\CalDAV\\Schedule\\Plugin',
            'subscription' => 'Sabre\\CalDAV\\Subscriptions\\Plugin',
            'sync' => 'Sabre\\DAV\\Sync\\Plugin',
        ),
        'factories' => array(
            'auth' => 'SabreDavModule\\Plugin\\Service\\AuthFactory',
            'lock' => 'SabreDavModule\\Plugin\\Service\\LockBackendFactory',
            'property' => 'SabreDavModule\\Plugin\\Service\\PropertyFactory',
        ),
    ),
    'sabredav_property_backends' => array(
        'factories' => array(
            'pdo' => 'SabreDavModule\\Property\\Service\\PdoFactory',
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'SabreDavModule\\Service\\ServerAbstractFactory',
        ),
        'invokables' => array(
            'SabreDavModule\\AuthBackend\\Service\\PluginManager' =>
                'SabreDavModule\\AuthBackend\\Service\\PluginManager',
            'SabreDavModule\\LockBackend\\Service\\PluginManager' =>
                'SabreDavModule\\LockBackend\\Service\\PluginManager',
            'SabreDavModule\\Node\\Service\\PluginManager' =>
                'SabreDavModule\\Node\\Service\\PluginManager',
            'SabreDavModule\\Plugin\\Service\\PluginManager' =>
                'SabreDavModule\\Plugin\\Service\\PluginManager',
            'SabreDavModule\\Property\\Service\\PluginManager' =>
                'SabreDavModule\\Property\\Service\\PluginManager',
        ),
        'factories' => array(
            'ViewXmlRenderer' => 'SabreDavModule\\Mvc\\Service\\ViewXmlRendererFactory',
            'ViewXmlStrategy' => 'SabreDavModule\\Mvc\\Service\\ViewXmlStrategyFactory',
        ),
    ),
);
