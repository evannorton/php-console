<?php

class Console
{
    private static $depth = 0;
    private static $call_point_styling = "', 'color:white;background-color:black;padding:0 .25em;margin-right:.5em;', '');";
    private static function wrap_script($script)
    {
        $script_element = "document.getElementById(\"php-console\")";
        $delete_script = $script_element . ".parentNode.removeChild(" . $script_element . ");";
        return "<script id=\"php-console\" type=\"text/javascript\">" . $script . $delete_script . "</script>";
    }
    private static function get_method()
    {
        return debug_backtrace()[2]["function"];
    }
    private static function get_call_point()
    {
        $bt = debug_backtrace()[2];
        $file = substr($bt["file"], strrpos($bt["file"], DIRECTORY_SEPARATOR) + 1);
        $line = $bt["line"];
        return $file . ":" . $line;
    }
    private static function get_indent()
    {
        return str_repeat("   ", self::$depth);
    }
    private static function format_by_type($contents)
    {
        $type = gettype($contents);
        switch ($type) {
            case "array":
            case "object":
                self::$depth++;
                $contents = "";
                if ($type === "array") {
                    $contents .= "Array(";
                } else {
                    $contents .= get_class($contents) . " Object {";
                }
                if (self::$depth === 1) {
                    $contents = "\\n" . $contents;
                }
                $i = 0;
                foreach ($contents as $key => $element) {
                    $contents .= "\\n" . self::get_indent() . "[" . $key . "] => ";
                    $contents .= self::format_by_type($element);
                    if ($i !== count((array) $contents) - 1) {
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
                return "' + null + '";
                break;
            default:
                $contents = str_replace("\\", "\\\\", $contents);
                $contents = str_replace("'", "\'", $contents);
                $contents = preg_replace("/\r/", "\\r", $contents);
                self::$depth++;
                $contents = preg_replace("/\n/", "\\n" . self::get_indent(), $contents);
                self::$depth--;

                return $contents;
        }
    }
    private static function print_log($contents)
    {
        echo self::wrap_script("console." . self::get_method() . "('%c" . self::get_call_point() . "%c" . self::format_by_type($contents) . self::$call_point_styling);
        self::$depth = 0;
    }
    public static function log($msg)
    {
        self::print_log($msg);
    }
    public static function info($msg)
    {
        self::print_log($msg);
    }
    public static function warn($msg)
    {
        self::print_log($msg);
    }
    public static function error($msg)
    {
        self::print_log($msg);
    }
    public static function group($label = "console.group")
    {
        self::print_log($label);
    }
    public static function groupCollapsed($label = "console.groupCollapsed")
    {
        self::print_log($label);
    }
    public static function groupEnd()
    {
        echo self::wrap_script("console.groupEnd();");
    }
    public static function clear()
    {
        echo self::wrap_script("console.clear()");
    }
    public static function count($label = "default")
    {
        echo self::wrap_script("console.count('$label');");
    }
}
