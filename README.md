# peridot-doctrine-plugin

[![Build Status](https://img.shields.io/travis/peridot-php/peridot-doctrine-plugin/master.svg?style=flat-square)](https://travis-ci.org/peridot-php/peridot-doctrine-plugin)
[![HHVM (branch)](https://img.shields.io/hhvm/peridot-php/peridot-doctrine-luging/master.svg?style=flat-square)](https://travis-ci.org/peridot-php/peridot-doctrine-plugin)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

Easily integrate Doctrine ORM tests with Peridot BDD.

## Installation

Via [Composer](https://getcomposer.org):

    composer require peridot-php/peridot-doctrine-plugin

## Usage

By default, this plugin builds a sqlite database in memory to run your functional tests. Simply provide it with
your entity namespace(s) and mapping file path(s):

```php
<?php

use Doctrine\ORM\Mapping\Driver\YamlDriver;
use Evenement\EventEmitterInterface;
use Peridot\Plugin\Doctrine\DoctrinePlugin;

return function (EventEmitterInterface $eventEmitter) {
    new DoctrinePlugin(
        $eventEmitter,
        new YamlDriver(
            [__DIR__ . '/src/Persistence/Mapping' => 'Vendor\Project\Domain\Entity']
        ),
    );
};
```

Registering the `DoctrinePlugin` makes available a custom scope method to retrieve the `EntityManager`:

```php
it('...', function () {
    $em = $this->getEntityManager()
});
```

### Specifying Database Connection Information

You can override the database connection information to use your own database during tests by providing an array
of connection information as the third argument to `DoctrinePlugin`:

```php
    new DoctrinePlugin(
        $eventEmitter,
        new YamlDriver(
            [__DIR__ . '/src/Persistence/Mapping' => 'Vendor\Project\Domain\Entity']
        ),
        [
            'driver' => 'pdo_sqlite',
            'path' => __DIR__ . '/data/test.db',
        ]
    );
```

### Loading Fixture Files

Database testing is much more powerful with the ability to load database fixtures, which provide a known state of
data. This plugin does not provide a direct method for loading fixtures as other third party libraries already
provide this capability, such as [Alice](https://github.com/nelmio/alice).

You can load fixture files on a per test basis:

```php
use Nelmio\Alice\Fixtures;

describe('Subject', function () {
    beforeEach(function () {
        $em = $this->getEntityManager();
        Fixtures::load(__DIR__ . '/fixtures/data.yml', $em);
    });
});
```

If you want to load the same set of fixtures for each test case, you can listen for the `entitymanager.created` event,
and load fixtures at that time:

```php
<?php

use Doctrine\ORM\Mapping\Driver\YamlDriver;
use Evenement\EventEmitterInterface;
use Nelmio\Alice\Fixtures;
use Peridot\Plugin\Doctrine\DoctrinePlugin;

return function (EventEmitterInterface $eventEmitter) {
    new DoctrinePlugin(
        $eventEmitter,
        new YamlDriver(
            [__DIR__ . '/src/Persistence/Mapping' => 'Vendor\Project\Domain\Entity']
        ),
    );
    
    $eventEmitter->on('entitymanager.created', function ($em) {
        Fixtures::load(__DIR__ . '/fixtures/*.yml', $em);
    });
};
```

## Running Tests

To run the `DoctrinePlugin` tests:

    vendor/bin/peridot specs
