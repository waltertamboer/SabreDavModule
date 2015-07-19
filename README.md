# SabreDavModule

A Zend Framework 2 module to respect Zend Framework's application flow while working with SabreDav.

## Getting started

It's recommended to install this library via [Composer](https://getcomposer.org).

```json
{
    "require": {
        "waltertamboer/sabredav-module": "dev-master"
    }
}
```

Next copy the configuration file from `vendor/waltertamboer/sabredav-module/config/sabredav.config.global.dist.php` to
`config/autoload/sabredav.config.global.php`.

## Configuration

The configuration file contains a `sabredav` key which is an array. Each entry in the array is considered an entry 
point for SabreDav. This way it becomes possible to split the CalDav, CardDav and WebDav url's from each other. A
basic configuration looks like this:

```
'sabredav' => array(
    'dav' => array(
        'enabled' => true,
        'route' => 'my-route',
        'nodes' => array(
            // All nodes that are supported
        ),
        'plugins' => array(
            // All plugins that are supported
        ),
    ),
),
```

The key `dav` is important. It should match the name from the controller which will be explained later on. The array
contains four entries: enabled, route, nodes and plugins.

* *enabled* simply indicates whether or not this entry point is enabled at the moment.
* *route* contains the name of the route that is used to call this entry point.
* *nodes* is a list with SabreDav nodes that are supported. This way one could only set CardDav for example.
* *plugins* is a list with SabreDav plugins that are supported.

### Nodes

It's possible to configure the server in such a way that one could create different entry points for CalDav, CardDav 
and WebDav. It's also possible to combine the three in one entry point. The default configuration file (as provided in 
the module) contains a setup where CalDav, CardDav and WebDav are combined.

Each node is an array with a `name` and an `options` element. The name should be a valid node services. The options 
array is used to pass additional parameters to the node service. Supported nodes are:

* caldav - Adds CalDav support to the server.
* carddav - Adds CardDav support to the server.
* directory - Adds WebDav support to the server.
* principal - Adds support for multiple users to the server.

### Plugins

Plugins can be used to add additional support to the SabreDav server. They simply correspond to the plugins that 
SabreDav offers. 

Each plpugin is an array with a `name` and an `options` element. The name should be a valid plugin services. The options 
array is used to pass additional parameters to the plugin service. Supported plugins are:

* acl
* auth
* browser
* caldav
* carddav
* lock
* mount
* partial
* property
* schedule
* subscription
* sync

### Router

This module comes with a preset route called "sabredav-dav". It's possible to add additional routes in order to create
a new entry point. It's important to set the route type to `SabreDavModule\\Mvc\\Router\\Http\\SabreDav` which simply
acts as a catch-all route.

The controller name **MUST** start with `sabredavmodule.`. Everything that comes after the dot will be considered the 
name of the entry point. This string will be used to find the configuration in the `sabredav` configuration array.

```
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
```

## Todo

* This module is not unit tested yet.
* Once unit tests are written, Travis CI should be hooked up.
* Docblocks are missing
* The README file should contain badges showing the stability of the module.
