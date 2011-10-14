# About lib-zandman
lib-zandman is a collection of classes which I use for my Zend Framework projects. They are published under the new BSD licence.

# Usage
## application.ini
If you want to use this library, add the following lines
  pluginPaths.Zandman_Application_Resource = "Zandman/Application/Resource/"
  pluginPaths.Zandman_Application_Resource = "Zandman/Application/Resource/"
### Zandman_Application_Resource_Router
  resources.router.config = APPLICATION_PATH "/configs/routes.php"
###
  resources.navigation.config = APPLICATION_PATH "/configs/navigation.php"
  resources.navigation.storage.registry = 1
