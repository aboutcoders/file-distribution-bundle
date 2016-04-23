AbcFileDistributionBundle
=============

The AbcFileDistributionBundle provides a database-backed file management system for Symfony.
It gives you a flexible framework for storing and transferring files between various locations (Local, FTP, CDN).
It is build on top of AbcFileDistribution library.

Build Status: [![Build Status](https://travis-ci.org/aboutcoders/file-distribution-bundle.svg?branch=master)](https://travis-ci.org/aboutcoders/file-distribution-bundle)

## Overview

This bundle provides the following features:

- Filesystem definitions can be stored via Doctrine ORM, MongoDB/CouchDB ODM or Propel
- Filesystem definitions can be defined in configuration 
- Unit tested

We appreciate if you decide to use this bundle and we appreciate your feedback, suggestions or contributions.

## Installation

Add the AbcJobBundle to your `composer.json` file

```json
{
    "require": {
        "aboutcoders/file-distribution-bundle": "~1.1"
    }
}
```

Then include the bundle in the AppKernel.php class

```php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Abc\Bundle\FileDistributionBundle\AbcFileDistributionBundle(),
    );

    return $bundles;
}
```

## Configuration

__Configure doctrine orm__

At the current point only doctrine is supported as ORM. However by changing the configuration you can use a different persistence layer.

```yaml
abc_file_distribution:
    db_driver: orm
    filesystems:
        assets:
            type: LOCAL
            path: "%data_dir%/assets"
            options:
                create: true
```                

__Update the database schema__

Finally you need to update your database schema in order to create the required tables.

```bash
php app/console doctrine:schema:update --force
```

## Further Documentation

- [Configuration Reference](./docs/configuration-reference.md)

## ToDo:

- Update docs


About
-----

AbcFileDistributionBundle is a [AboutCoders](https://aboutcoders.com) initiative.
