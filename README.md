<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://belajararief.com/images/yii2.png" height="200px">
    </a>
    <h1 align="center">Yii 2 REST API Template</h1>
    <br>
</p>

Yii2 REST API Template
-------------------
This is a a REST API TEMPLATE with Yii2. This template use [Yii2-Micro](https://github.com/hoaaah/yii2-micro) approach so it will be lightweight and easy to deploy.


# Installation

The preferred way to install this template is through [composer](http://getcomposer.org/download/).

Either run

```bash
composer create-project --prefer-dist hoaaah/yii2-rest-api-template [app_name]
```

Setup your database configuration from `config/db.php`. Create your database because this template will not create it for you :)

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

Then run migration to create table in selected database.

```bash
yii migrate
```

# Directory Structure
Since this template use MicroFramework approach, directory structure might be a little bit different from Yii2.

      config/             contains application configurations
      controllers/        contains Web controller classes
      migration/          contains list of your migration files
      models/             contains model classes
      modules/            contains your rest-api versioning (based on modules)
      vendor/             contains dependent 3rd-party packages
      web/                contains the entry script and Web resources

This template use modules as versioning pattern. Every version of API saved in a module. This template already have v1 module, so it means if consumer want to use v1 API, it can access `https://your-api-url/v1/endpoint`.


# API Scenario
## Supported Authentication
This template support 3 most used authentication. (Actually it's not me who make it, Yii2 already support it all :D ).

1. HTTP Basic Auth:  the access token is sent as the username. This should only be used when an access token can be safely stored on the API consumer side. For example, the API consumer is a program running on a server.
2. Query parameter: the access token is sent as a query parameter in the API URL, e.g., https://example.com/users?access-token=xxxxxxxx. Because most Web servers will keep query parameters in server logs, this approach should be mainly used to serve JSONP requests which cannot use HTTP headers to send access tokens.
3. OAuth 2: the access token is obtained by the consumer from an authorization server and sent to the API server via HTTP Bearer Tokens, according to the OAuth2 protocol.

## Auth Scenario
This template already have basic endpoint that you can use to start your REST-API. Such as:

Endpoint | Type |Usage
---------|------|-----
https://YOUR-API-URL/ | GET| list all post created
https://YOUR-API-URL/view?id={id} | GET| View a post
https://YOUR-API-URL/login | POST | Login with username and password
https://YOUR-API-URL/signup | POST | Signup with username, email and password
https://YOUR-API-URL/v1/post | GET | List all post created
https://YOUR-API-URL/v1/post/create | POST | Create a new post (title, body)
https://YOUR-API-URL/v1/post/update?id={id} | PUT / PATCH | Update a post (title, body)
https://YOUR-API-URL/v1/post/delete?id={id} | DELETE | Delete a post
https://YOUR-API-URL/v1/post/view?id={id} | GET | View a post 


## API versioning
This template give you versioning scenario based on module application. In Yii2 a module are self-contained software units that consist of model, views, controllers and other supporting components. This template already have v1 module, it means all of endpoint for API v1 created in this module. When you publish a new API version (that break backward compatibility / BBC), you can create a new module. For more information create a module, you can visit this [Yii2 Guide on Creating Module](https://www.yiiframework.com/doc/guide/2.0/en/structure-modules).


# TODO
Feel free to contribute if you have any idea.
- [x] Rest API Template
- [x] Login and signup in SiteController
- [x] Example of versioning and Blog Scenario
- [] Authentication Type from params
- [] Rate Limiter from params
- [] Change auth_key for every login
- [] Auth_key have expiration
- [] each auth_key have application token


# Creator

This Template was created by and is maintained by **[Heru Arief Wijaya](http://belajararief.com/)**.

* https://twitter.com/hoaaah
* https://github.com/hoaaah
