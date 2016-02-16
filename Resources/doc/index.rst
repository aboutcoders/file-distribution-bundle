Getting Started With AbcFileDistributionBundle
==============================================

The AbcFileDistributionBundle provides a database-backed file management system for Symfony.
It gives you a flexible framework for storing and transferring files between various locations (Local, FTP, CDN).
It is build on top of AbcFileDistribution library.


Prerequisites
-------------

This version of the bundle requires Symfony 2.6+.


Installation
------------

1. Download AbcFileDistributionBundle using composer
2. Enable the Bundle
3. Configure the AbcFileDistributionBundle
4. Update your database schema

Step 1: Download AbcFileDistributionBundle using composer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Require the bundle with composer:

.. code-block:: bash

    $ composer require aboutcoders/file-distribution-bundle "~1.1@dev"

Composer will install the bundle to your project's ``vendor/aboutcoders/file-distribution-bundle`` directory.

Step 2: Enable the bundle
~~~~~~~~~~~~~~~~~~~~~~~~~

Enable the bundle in the kernel::

    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new \Abc\Bundle\FileDistributionBundle\AbcFileDistributionBundle(),
            // ...
        );
    }

Step 3: Configure the AbcFileDistributionBundle
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
abc_file_distribution:
    db_driver: orm
    filesystems:
        assets:
            type: LOCAL
            path: "%data_dir%/assets"
            options:
                create: true

Add the following configuration to your ``config.yml`` file according to which type
of datastore you are using.

.. configuration-block::

    .. code-block:: yaml

        # app/config/config.yml
        abc_file_distribution:
            db_driver: orm # other valid values are 'mongodb', 'couchdb' and 'propel'
            filesystems:
                assets:
                    type: LOCAL # other valid values are 'FTP', 'SFTP'
                    path: "%data_dir%/assets"
                    options:
                        create: true


Only one configuration value is required to use the bundle:

* The type of datastore you are using (``orm``, ``mongodb``, ``couchdb`` or ``propel``).


Step 4: Update your database schema
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Now that the bundle is configured, the last thing you need to do is update your
database schema because you have new entities for storing the filesystem definitions.

For ORM run the following command.

.. code-block:: bash

    $ php bin/console doctrine:schema:update --force

For MongoDB users you can run the following command to create the indexes.

.. code-block:: bash

    $ php bin/console doctrine:mongodb:schema:create --index

.. note::

    If you use the Symfony 2.x structure in your project, use ``app/console``
    instead of ``bin/console`` in the commands.


Next Steps
~~~~~~~~~~

Now that you have completed the basic installation and configuration of the
AbcFileDistributionBundle, you are ready to learn about more advanced features and usages
of the bundle.

The following documents are available:

-- work in progress --


.. toctree::
:maxdepth: 1

        doctrine
