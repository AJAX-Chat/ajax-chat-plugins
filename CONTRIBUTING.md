#Contributing

Please use a file structure similar to the following

```
plugins
+---plugin-name
    |
    +--client
    |    plugin-name.css
    |    plugin-name.js
    \--server
         plugin-name.php
    README.md
```

Your plugin must include the following.

1) All necessary files to make the plugin function properly, contained in the appropriate file types.
2) Files divided between `server/` and `client/` folders respectively.
3) A `README.md` with details on valid usage of your plugin, some example commands, and any additional or special steps that must be completed when installing the plugin.
