# PHP Console
Manipulate the front end console with PHP.

## Hello World example
```
include_once "console.php";
Console::log("Hello, World!");
```
![Screenshot](Hello%2C%20World!.jpg)

## Documentation

### `void Console::clear()`
Clears the console.

### `void Console::error(mixed $input)`
Logs the argument to the console as an error.

### `void Console::info(mixed $input)`
Logs the argument to the console as info.

### `void Console::log(mixed $input)`
Logs the argument to the console.

### `void Console::warn(mixed $input)`
Logs the argument to the console as a warning.
