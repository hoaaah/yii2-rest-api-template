Yii2 MicroFramework Template
===================

Yii2 MicroFramework Template
-------------------
This is a MicroFramework Template use Yii2. This Template build with [this guide ](http://www.yiiframework.com/doc-2.0/guide-tutorial-yii-as-micro-framework.html) and you can modified it to use any of costumization. 


Installation
------------

The preferred way to install this CMS is through [composer](http://getcomposer.org/download/).

Either run

```bash
composer global require "fxp/composer-asset-plugin:^1.2.0"
composer create-project --prefer-dist hoaaah/yii2-micro [app_name]
```

Default database of this microframework use sqlite but you can modified it with your own database.

```php
<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=your_db_name',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
    ],
];

```

If you use your own db, then run migration to create table in selected database.

```bash
vendor/bin/yii migrate/up --appconfig=config.php
```

## Creator

This Template was created by and is maintained by **[Heru Arief Wijaya](http://belajararief.com/)**.

* https://twitter.com/hoaaah
* https://github.com/hoaaah
