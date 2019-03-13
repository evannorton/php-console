<?php

class Console
{
    private static $depth = 0;
    private static $call_point_styling = "\", \"color:white;background-color:black;padding:0 .25em;margin-right:.5em;\", \"\");";
    private static function wrap_script($script)
    {
        $script_element = "document.getElementById(\"php-console\")";
        $delete_script = $script_element . ".parentNode.removeChild(" . $script_element . ");";
        return "<script id=\"php-console\" type=\"text/javascript\">" . $script . $delete_script . "</script>";
    }
    private static function get_backtrace()
    {
        $bt = debug_backtrace();
        $bt_count = 0;
        foreach ($bt as $bt_step) {
            if ($bt_step["file"] !== __FILE__) {
                $bt_count++;
            }
        }
        return $bt[sizeof($bt) - $bt_count];
    }
    private static function get_method()
    {
        $function = self::get_backtrace()["function"];
        $function = $function === "assert" ? "error" : $function;
        $underscore_position = strpos($function, "_");
        if ($underscore_position) {
            $word_separation = substr($function, $underscore_position, 2);
            $capital_letter = ucfirst(substr($word_separation, 1, 1));
            return str_replace($word_separation, $capital_letter, $function);
        } else {
            return $function;
        }
    }
    private static function get_call_point()
    {
        $bt_step = self::get_backtrace();
        $file_dir = $bt_step["file"];
        $file = substr($file_dir, strrpos($file_dir, DIRECTORY_SEPARATOR) + 1);
        $line = $bt_step["line"];
        return $file . ":" . $line;
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
            case "NULL":
                return "\" + null + \"";
                break;
            default:
                $input = str_replace("\\", "\\\\", $input);
                $input = str_replace("\"", "\\\"", $input);
                $input = preg_replace("/\r/", "\\r", $input);
                self::$depth++;
                $input = preg_replace("/\n/", "\\n" . self::get_indent(), $input);
                self::$depth--;
                return $input;
        }
    }
    private static function print_log($contents = "")
    {
        echo self::wrap_script("console." . self::get_method() . "(\"" . self::format_by_type($contents) . "\");");
    }
    private static function print_styled_log($contents = "")
    {
        echo "console." . self::get_method() . "(\"%c" . self::get_call_point() . "%c" . self::format_by_type($contents) . self::$call_point_styling;
        echo self::wrap_script("console." . self::get_method() . "(\"%c" . self::get_call_point() . "%c" . self::format_by_type($contents) . self::$call_point_styling);
    }
    public static function assert($assertion = false, $msg = "console.assert")
    {
        if (!$assertion) {
            self::error("Assertion failed: " . $msg);
        }
    }
    public static function clear()
    {
        self::print_log();
    }
    public static function count($label = "default")
    {
        self::print_log($label);
    }
    public static function count_reset($label = "default")
    {
        self::print_log($label);
    }
    public static function error($msg = "")
    {
        self::print_styled_log($msg);
    }
    public static function group($label = "console.group")
    {
        self::print_styled_log($label);
    }
    public static function group_collapsed($label = "console.groupCollapsed")
    {
        self::print_styled_log($label);
    }
    public static function group_end()
    {
        self::print_log();
    }
    public static function info($msg = "")
    {
        self::print_styled_log($msg);
    }
    public static function log($msg = "")
    {
        self::print_styled_log($msg);
    }
    public static function time($label = "default")
    {
        self::print_log($label);
    }
    public static function time_end($label = "default")
    {
        self::print_log($label);
    }
    public static function time_log($label = "default")
    {
        self::print_log($label);
    }
    public static function warn($msg = "")
    {
        self::print_styled_log($msg);
    }
}
