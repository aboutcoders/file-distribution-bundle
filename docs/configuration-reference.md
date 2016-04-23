Configuration Reference
=======================

```yaml
# app/config.yml
abc_file_distribution:
    db_driver: orm                # allowed values: [orm]
    model_manager_name:   ~       # custom model manager
    filesystems:
        # Prototype
        name:
            type: LOCAL           # One of "FTP"; "LOCAL"
            path: /yourpath       # Required
            options:
                create:               ~
                mode:                 ~
                host:                 ~
                port:                 ~
                username:             ~
                password:             ~
                passive:              ~
                ssl:                  ~
    definition:
        definition_manager:   abc.file_distribution.definition_manager.default
```