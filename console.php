<?php

class Console
{

    private $depth = 0;

    private function wrap_script($script)
    {
        return "<script type='text/javascript'>" . $script . "</script>";
    }

    private function get_indent()
    {
        return str_repeat("   ", $this->depth);
    }

    private function format_by_type($input)
    {
        $type = gettype($input);
        switch ($type) {
            case "array":
                $this->depth++;
                $contents = "Array(";
                if ($this->depth === 1) {
                    $contents = "\\n" . $contents;
                }
                foreach ($input as $key => $element) {
                    $contents .= "\\n" . $this->get_indent() . "[" . $key . "] => ";
                    $contents .= $this->format_by_type($element);
                    if ($key !== count($input) - 1) {
                        $contents .= ", ";
                    }
                }
                $this->depth--;
                $contents .= "\\n" . $this->get_indent() . ")";
                return $contents;
                break;
            case "object":
                $this->depth++;
                $contents = get_class($input) . " Object {";
                if ($this->depth === 1) {
                    $contents = "\\n" . $contents;
                }
                $input_keys = get_object_vars($input);
                foreach ($input_keys as $key => $value) {
                    $contents .= "\\n" . $this->get_indent() . "[" . $key . "] => ";
                    $contents .= $this->format_by_type($value);
                }
                $this->depth--;
                $contents .= "\\n" . $this->get_indent() . "}";
                return $contents;
                break;
            default:
                return $input;
        }
    }

    function print($input, $bt, $protocol) {
        // styling
        $console_start = "console.$protocol('%c";
        $console_end = "', 'color:white;background-color:black;padding:0 .25em;', 'padding-left: .5em');";

        // file name and line number
        $caller = array_shift($bt);
        $file = $caller["file"];
        $file = substr($file, strrpos($file, "\\") + 1);
        $line = $caller["line"];
        $meta = $file . ":" . $line;

        // contents to log
        $contents = str_replace("'", "\'", $input);
        $contents = $this->format_by_type($contents);

        $this->depth = 0;

        echo $this->wrap_script($console_start . $meta . "%c" . $contents . $console_end);
    }

    public function log($input)
    {
        $this->print($input, debug_backtrace(), "log");
    }
    public function info($input)
    {
        $this->print($input, debug_backtrace(), "info");
    }
    public function warn($input)
    {
        $this->print($input, debug_backtrace(), "warn");
    }
    public function error($input)
    {
        $this->print($input, debug_backtrace(), "error");
    }

    public function clear()
    {
        echo $this->wrap_script("console.clear()");
    }

}

$console = new Console;