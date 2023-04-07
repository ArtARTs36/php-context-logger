# Context Logger

This package provides wrapper to **psr/log** for sharing context between different logs.

## Implemented stores

### Memory Store

Memory Store could be useful for sharing context in single web request.

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

### Null Store

Null Store could be useful for tests.

Creating an logger instance:

```php
$logger = \ArtARTs36\ContextLogger\LoggerFactory::null();
```
