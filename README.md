# PHP Console
Manipulate the front end console with PHP.

## Hello World example
```
require_once "console.php";
Console::log("Hello, World!");
```
![Screenshot](Hello%2C%20World!.jpg)

## Documentation

### `Console::assert($assertion, $msg)`
Does nothing if the assertion is truthy. Logs an error message if the assertion is falsy.

### `Console::clear()`
Clears the console.

### `Console::count($label)`
Logs the number of times that `count()` has been called with a particular label.

### `Console::count_reset($label)`
Resets the `count()` counter for a particular label.

### `Console::error($msg)`
Logs the argument to the console as an error.

### `Console::group($label)`
Creates a new inline group in the console.

### `Console::group_collapsed($label)`
Creates a new collapsed inline group in the console.

### `Console::group_end()`
Exits the current inline group.

### `Console::info($msg)`
Logs the argument to the console as info.

### `Console::log($msg)`
Logs the argument to the console.

### `Console::time($label)`
Starts a timer.

### `Console::time_end($label)`
Ends a timer with a particular label and logs the end time.

### `Console::time_log($label)`
Logs the current time of a timer with a particular label.

### `Console::warn($msg)`
Logs the argument to the console as a warning.
