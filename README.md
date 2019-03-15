# PHP Console
Manipulate the front end console with PHP.

## Hello World example
```
require_once "console.php";
Console::log("Hello, World!");
```
![Screenshot](Hello%2C%20World!.jpg)

## Documentation

### `void Console::assert($assertion, $msg)`
Does nothing if the assertion is truthy. Logs an error message if the assertion is falsy.

### `void Console::clear()`
Clears the console.

### `void Console::count($label)`
Logs the number of times that `count()` has been called with a particular label.

### `void Console::count_reset($label)`
Resets the `count()` counter for a particular label.

### `void Console::error($msg)`
Logs the argument to the console as an error.

### `void Console::group($label)`
Creates a new inline group in the console.

### `void Console::group_collapsed($label)`
Creates a new collapsed inline group in the console.

### `void Console::group_end()`
Exits the current inline group.

### `void Console::info($msg)`
Logs the argument to the console as info.

### `void Console::log($msg)`
Logs the argument to the console.

### `void Console::time($label)`
Starts a timer.

### `void Console::time_end($label)`
Ends a timer with a particular label and logs the end time.

### `void Console::time_log($label)`
Logs the current time of a timer with a particular label.

### `void Console::warn($msg)`
Logs the argument to the console as a warning.
