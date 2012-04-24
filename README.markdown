# About lib-zandman
lib-zandman is a collection of classes which I use for my Zend Framework projects. They are published under the new [BSD licence](http://www.opensource.org/licenses/bsd-license.php).

# Usage
## application.ini
If you want to use this library, add the following lines

```ini
autoloadernamespaces[] = "Zandman_"
pluginPaths.Zandman_Application_Resource = "Zandman/Application/Resource/"
```
  
### Zandman_Application_Resource_Router
```ini
resources.router.config = APPLICATION_PATH "/configs/routes.php"
```
  
### Zandman_Application_Resource_Navigation
```ini
resources.navigation.config = APPLICATION_PATH "/configs/navigation.php"
resources.navigation.storage.registry = 1
```

### Zandman_Translate_Adapter_Database
#### Usage with Zend_Application_Resource_Db
```ini
resources.db.adapter = "Pdo_Mysql"
resources.db.params.username = "root"
resources.db.params.password = ""
resources.db.params.host = "localhost"
resources.db.params.dbname = "zandman"
resources.translate.adapter = "Zandman_Translate_Adapter_Database"
resources.translate.data.0 = ""
resources.translate.dbModel = "Application_Model_Translations"
```
#### Usage with Zend_Application_Resource_Multidb
```ini
resources.multidb.translate.adapter = "Pdo_Mysql"
resources.multidb.translate.username = "root"
resources.multidb.translate.password = ""
resources.multidb.translate.host = "localhost"
resources.multidb.translate.dbname = "zandman"
resources.translate.adapter = "Zandman_Translate_Adapter_Database"
resources.translate.data.0 = ""
resources.translate.dbAdapter = "translate"
resources.translate.dbModel = "Application_Model_Translations"
```
#### Example Model 'Application_Model_Translations'
```php
<?php
class Application_Model_Translations implements Zandman_Translate_Database_ModelInterface
{
    /**
     * @var Zend_Db_Adapter_Abstract
     */
    protected $dbAdapter;
    
    public function __construct(Zend_Db_Adapter_Abstract $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
    
    public function getTranslations($locale)
    {
        $locale = new Zend_Locale($locale);
        
        
        $select = $this->dbAdapter->select();
        $select->from("language_key", "language_key")
        ->joinLeft("translations", "language_key.id = translations.language_key_id", "translation")
        ->joinLeft("language", "language.id = translations.language_id", array())
        ->where("language.language = ?", $locale->getLanguage());
        
        return $this->dbAdapter->fetchPairs($select);
    }
}
```