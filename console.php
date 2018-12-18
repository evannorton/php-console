<?php

class Console
{

    private $array_depth = 0;
    private $array_indent = "";
    private $array_indent_paren = "";

    private function wrap_script($script)
    {
        return "<script type='text/javascript'>" . $script . "</script>";
    }

    private function format_by_type($input)
    {
        $type = gettype($input);
        switch ($type) {
            case "array":
                $this->array_depth++;
                $this->array_indent .= "  ";
                $contents = "Array(";
                if ($this->array_depth === 1) {
                    $contents = "\\n" . $contents;
                } else {
                    $this->array_indent .= "       ";
                }
                foreach ($input as $key => $element) {
                    $contents .= "\\n" . $this->array_indent . "[" . $key . "] => ";
                    $contents .= $this->format_by_type($element);
                    if ($key !== count($input) - 1) {
                        $contents .= ", ";
                    }
                }

                $this->array_depth--;
                $paren_indent_length = $this->array_depth * 9;

                $paren_indent = "";
                for ($i = 0; $i < $paren_indent_length; $i++) {
                    $paren_indent .= " ";
                }
                $contents .= "\\n" . $paren_indent . ")";
                return $contents;
                break;
            default:
                return $input;
        }
    }

    public function log($input)
    {
        // styling
        $console_start = "console.log('%c";
        $console_end = "', 'color:white;background-color:black;padding:0 .25em;', 'padding-left: .5em');";

        // file name and line number
        $bt = debug_backtrace();
        $caller = array_shift($bt);
        $file = $caller["file"];
        $file = substr($file, strrpos($file, "\\") + 1);
        $line = $caller["line"];
        $meta = $file . ":" . $line;

        // contents to log
        $contents = $this->format_by_type($input);

        $this->array_depth = "";
        $this->array_indent = "";

        echo $this->wrap_script($console_start . $meta . "%c" . $contents . $console_end);
    }

    public function clear()
    {
        echo $this->wrap_script("console.clear()");
    }

}

$console = new Console;