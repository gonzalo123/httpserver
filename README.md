HttpServer
==========

## Starting the Built-In PHP Webserver and handling requests
### Returning a simple text response

```php
use G\HttpServer\Builder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

Builder::createBuiltInServer(function (Request $request) {
        return "Hello " . $request->get('name');
    })->listen(1337);

```

### Returning a Response (one Silex application)
```php
use G\HttpServer\Builder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

$app->get('/', function () {
        return 'Hello';
    });

$app->get('/hello/{name}', function ($name) {
        return 'Hello ' . $name;
    });

Builder::createBuiltInServer(function (Request $request) use ($app) {
        return $app->handle($request);
    })->listen(1337);
```

## Starting one React Webserver and handling requests
https://github.com/reactphp/react
### Returning a simple text response

```php
use G\HttpServer\Builder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

Builder::createReactServer(function (Request $request) {
        return "Hello " . $request->get('name');
    })->listen(1337);

```

### Returning a Response (one Silex application)
```php
use G\HttpServer\Builder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

$app->get('/', function () {
        return 'Hello';
    });

$app->get('/hello/{name}', function ($name) {
        return 'Hello ' . $name;
    });

Builder::createReactServer(function (Request $request) use ($app) {
        return $app->handle($request);
    })->listen(1337);
```