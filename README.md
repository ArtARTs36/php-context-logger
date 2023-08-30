# Context Logger

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
![Latest Version](https://img.shields.io/packagist/v/artarts36/php-context-logger)
![Total Downloads](https://poser.pugx.org/artarts36/php-context-logger/d/total.svg)

This package provides wrapper to **psr/log** for sharing context between different logs.

## Implemented stores

### Memory Store

Memory Store could be useful for sharing context in single web request or single console command running.

Creating an logger instance:

```php
$logger = \ArtARTs36\ContextLogger\LoggerFactory::wrapInMemory(new class () extends \Psr\Log\AbstractLogger {
    public function log($level, \Stringable|string $message, array $context = []): void
    {
        var_dump($level, $message, $context);
    }
});
```

### Apcu Store

Memory Store could be useful for sharing context for different web requests.

Creating an logger instance:

```php
$logger = \ArtARTs36\ContextLogger\LoggerFactory::wrapInApcu(new class () extends \Psr\Log\AbstractLogger {
    public function log($level, \Stringable|string $message, array $context = []): void
    {
        var_dump($level, $message, $context);
    }
});
```

### File Store

File Store could be useful for sharing context for different web requests or different console command runs.

Creating an logger instance:

```php
$logger = \ArtARTs36\ContextLogger\LoggerFactory::wrapInFile(new class () extends \Psr\Log\AbstractLogger {
    public function log($level, \Stringable|string $message, array $context = []): void
    {
        var_dump($level, $message, $context);
    }
}, '/path/to/file.txt');
```

### Null Store

Null Store could be useful for tests.

Creating an logger instance:

```php
$logger = \ArtARTs36\ContextLogger\LoggerFactory::null();
```
