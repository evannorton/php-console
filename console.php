<?php

class Console
{
    private static $depth = 0;
    private static function wrap_script($script)
    {
        $script_element = "document.getElementById(\"php-console\")";
        $delete_script = $script_element . ".parentNode.removeChild(" . $script_element . ");";
        return "<script id=\"php-console\" type=\"text/javascript\">" . $script . $delete_script . "</script>";
    }
    private static function get_indent()
    {
        return str_repeat("   ", self::$depth);
    }
    private static function format_by_type($input)
    {
        $type = gettype($input);
        switch ($type) {
            case "array":
            case "object":
                self::$depth++;
                $contents = "";
                if ($type === "array") {
                    $contents .= "Array(";
                } else {
                    $contents .= get_class($input) . " Object {";
                }
                if (self::$depth === 1) {
                    $contents = "\\n" . $contents;
                }
                $i = 0;
                foreach ($input as $key => $element) {
                    $contents .= "\\n" . self::get_indent() . "[" . $key . "] => ";
                    $contents .= self::format_by_type($element);
                    if ($i !== count((array) $input) - 1) {
                        $contents .= ", ";
                    }
                    $i++;
                }
                self::$depth--;
                $contents .= "\\n" . self::get_indent();
                if ($type === "array") {
                    $contents .= ")";
                } else {
                    $contents .= "}";
                }
                return $contents;
                break;
            default:
                // escape single quotes
                $input = str_replace("'", "\'", $input);
                // remove line breaks and indents
                $input = preg_replace("/\r/", "\\r", $input);
                self::$depth++;
                $input = preg_replace("/\n/", "\\n" . self::get_indent(), $input);
                self::$depth--;
                return $input;
        }
    }
    private static function print_log($input, $bt, $protocol)
    {
        // styling
        $console_start = "console.$protocol('%c";
        $console_end = "', 'color:white;background-color:black;padding:0 .25em;margin-right:.5em;', '');";
        // file name and line number
        $caller = array_shift($bt);
        $file = $caller["file"];
        $file = substr($file, strrpos($file, DIRECTORY_SEPARATOR) + 1);
        $line = $caller["line"];
        $meta = $file . ":" . $line;
        // contents to log
        $contents = self::format_by_type($input);
        // reset indent depth
        self::$depth = 0;
        // echo script
        echo self::wrap_script($console_start . $meta . "%c" . $contents . $console_end);
    }
    public static function log($input)
    {
        self::print_log($input, debug_backtrace(), "log");
    }
    public static function info($input)
    {
        self::print_log($input, debug_backtrace(), "info");
    }
    public static function warn($input)
    {
        self::print_log($input, debug_backtrace(), "warn");
    }
    public static function error($input)
    {
        self::print_log($input, debug_backtrace(), "error");
    }
    public static function clear()
    {
        echo self::wrap_script("console.clear()");
    }
}
