# PHP Console
Manipulate the front end console with PHP.

## Hello World example
```
require_once "console.php";
Console::log("Hello, World!");
```
![Screenshot](Hello%2C%20World!.jpg)

## Documentation

### `void Console::clear()`
Clears the console.

### `void Console::count(mixed $label)`
Logs the number of times that `count()` has been called with a particular label.

### `void Console::count_reset(mixed $label)`
Resets the `count()` counter for a particular label.

### `void Console::error(mixed $msg)`
Logs the argument to the console as an error.

### `void Console::group(mixed $label)`
Creates a new inline group in the console.

### `void Console::group_collapsed(mixed $label)`
Creates a new collapsed inline group in the console.

### `void Console::group_end()`
Exits the current inline group.

### `void Console::info(mixed $msg)`
Logs the argument to the console as info.

### `void Console::log(mixed $msg)`
Logs the argument to the console.

### `void Console::time(mixed $label)`
Starts a timer.

### `void Console::time_end(mixed $label)`
Ends a timer with a particular label and logs the end time.

### `void Console::time_log(mixed $label)`
Logs the current time of a timer with a particular label.

### `void Console::warn(mixed $msg)`
Logs the argument to the console as a warning.
