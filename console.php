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
    private static function format_by_type($msg)
    {
        $type = gettype($msg);
        switch ($type) {
            case "array":
            case "object":
                self::$depth++;
                $contents = "";
                if ($type === "array") {
                    $contents .= "Array(";
                } else {
                    $contents .= get_class($msg) . " Object {";
                }
                if (self::$depth === 1) {
                    $contents = "\\n" . $contents;
                }
                $i = 0;
                foreach ($msg as $key => $element) {
                    $contents .= "\\n" . self::get_indent() . "[" . $key . "] => ";
                    $contents .= self::format_by_type($element);
                    if ($i !== count((array) $msg) - 1) {
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
                $msg = str_replace("'", "\'", $msg);
                // remove line breaks and indents
                $msg = preg_replace("/\r/", "\\r", $msg);
                self::$depth++;
                $msg = preg_replace("/\n/", "\\n" . self::get_indent(), $msg);
                self::$depth--;
                return $msg;
        }
    }
    private static function print_log($msg, $bt, $protocol)
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
        $contents = self::format_by_type($msg);
        // reset indent depth
        self::$depth = 0;
        // echo script
        echo self::wrap_script($console_start . $meta . "%c" . $contents . $console_end);
    }
    public static function log($msg)
    {
        self::print_log($msg, debug_backtrace(), "log");
    }
    public static function info($msg)
    {
        self::print_log($msg, debug_backtrace(), "info");
    }
    public static function warn($msg)
    {
        self::print_log($msg, debug_backtrace(), "warn");
    }
    public static function error($msg)
    {
        self::print_log($msg, debug_backtrace(), "error");
    }
    public static function clear()
    {
        echo self::wrap_script("console.clear()");
    }
    public static function group($label) {
        echo self::wrap_script("console.group('" . $label ."');");
    }
    public static function groupCollapsed($label) {
        echo self::wrap_script("console.groupCollapsed('" . $label ."');");
    }
    public static function groupEnd() {
        echo self::wrap_script("console.groupEnd();");
    }
}
