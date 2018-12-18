# PHP Console
Manipulate the front end console with PHP.

## Hello World example
```
include "console.php";
$console->log("Hello, World!");
```

## Documentation

### `void console->clear()`
Clears the console.

### `void console->error(mixed $input)`
Logs the argument to the console as an error.

### `void console->info(mixed $input)`
Logs the argument to the console as info.

### `void console->log(mixed $input)`
Logs the argument to the console.

### `void console->warn(mixed $input)`
Logs the argument to the console as a warning.