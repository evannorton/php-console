<?php

class Console
{

    private function wrap_script($script)
    {
        return "<script type='text/javascript'>" . $script . "</script>";
    }

    private function format_by_type($input)
    {
        $type = gettype($input);
        switch ($type) {
            case "array":
                $contents = "Array(";
                foreach ($input as $key => $element) {
                    $contents .= $this->format_by_type($element);
                    if ($key !== count($input) - 1) {
                        $contents .= ", ";
                    }
                }
                $contents .= ")";
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

        echo $this->wrap_script($console_start . $meta . "%c" . $contents . $console_end);
    }

    public function clear()
    {
        echo $this->wrap_script("console.clear()");
    }

}

$console = new Console;