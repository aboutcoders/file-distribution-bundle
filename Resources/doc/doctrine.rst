More about Doctrine implementations
===================================

AbcFileDistributionBundle was first written for Doctrine-based storage layers. This chapter
describes some things specific to these implementations.

Using a different object manager than the default one
-----------------------------------------------------

Using the default configuration , AbcFileDistributionBundle will use the default doctrine
object manager. If you are using multiple ones and want to handle your users
with a non-default one, you can change the object manager used in the configuration
by giving its name to AbcFileDistributionBundle.

.. code-block:: yaml

    # app/config/config.yml
    abc_file_distribution:
        db_driver: orm
        model_manager_name: non_default # the name of your entity manager

