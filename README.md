# AttributeAutoRegisterBundle for Symfony

## Introduction
The AttributeAutoRegisterBundle is a Symfony bundle designed to enhance the autowiring process in any Symfony project. It provides a convenient way to automatically register and wire services based on attributes, streamlining dependency injection and configuration.

## Installation
To install the AttributeAutoRegisterBundle, run the following command:

```bash
composer require jcardosokm/attribute-auto-register-bundle
```

## Configuration
Enable the bundle in your Symfony application by adding it to the bundles.php file:

```php
// config/bundles.php
return [
    // ...
    YourVendor\AttributeAutoRegisterBundle\AttributeAutoRegisterBundle::class => ['all' => true],
];
```

Next, configure the directories to be scanned for the Autowired attribute in autoregisterpath.yml:

```yaml
# config/autoregisterpath.yml

attribute_auto_register:
  filePaths:
    - '%kernel.project_dir%/src'
```
    
## Usage

### To use the Autowired attribute, tag your classes as follows:

```php
<?php

namespace App\Service;

use YourVendor\AttributeAutoRegisterBundle\Attribute\Autowired;

#[Autowired(id: 'app.my_service')]
class MyService
{
    public function __construct(
        private readonly MyDependency $dependency
    ) {
    }

    public function doSomething(): void
    {
        // Your logic here
    }
}
```
Parameters:
- id: The service identifier.
- factory: The factory class to use for creating the service instance (optional).
- factoryMethod: The method of the factory class to use for creating the service instance (optional).
- aliases: An array of aliases for the service (optional).

### Service Definition

Here is a simple example to illustrate the usage of the Autowired attribute:

```php
<?php
namespace App\Service;

use YourVendor\AttributeAutoRegisterBundle\Attribute\Autowired;

#[Autowired(id: 'app.custom_service', factory: 'App\Service\CustomServiceFactory', factoryMethod: 'create')]
class CustomService
{
    public function __construct(
        private readonly CustomDependency $dependency
    ) {
    }

    public function execute(): void
    {
        // Custom service logic
    }
}

namespace App\Service;

class CustomServiceFactory
{
    public static function create(): CustomService
    {
        // You can perform custom logic here to create and configure CustomService instance
        return new CustomService(/* pass dependencies here if needed */);
    }
}
```

## Rector Rule

The bundle includes a Rector rule (AutowiredAttributeGenerateRule) to automatically apply the `Autowired` attribute to your classes. You can run Rector to update your codebase:

```bash
vendor/bin/rector process src 
```

## Testing
To verify that your services are properly autowired, use the Symfony console command:
```bash
php bin/console debug:container
```
This command lists all the services and their dependencies, helping you confirm that autowiring is working correctly.

The `AttributeAutoRegisterBundle` is thoroughly tested to ensure reliability and compatibility with Symfony applications. The testing includes:

### Unit Tests

Unit tests verify the functionality of individual components in isolation, ensuring they perform according to specifications.

### Functional Tests

Functional tests evaluate the integration of the bundle within a Symfony application environment. These tests confirm that the features operate correctly in real-world scenarios.

To run the tests locally, use the following command:

```bash
vendor/bin/phpunit
```

## Contributing
If you would like to contribute to the development of the AttributeAutoRegisterBundle, please submit a pull request or open an issue on the GitHub repository.

## License
The AttributeAutoRegisterBundle is open-source software licensed under the MIT license.
