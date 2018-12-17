<?php

class Console
{

    private function wrap_script($script)
    {
        return "<script type='text/javascript'>" . $script . "</script>";
    }

    public function clear()
    {
        echo $this->wrap_script("console.clear()");
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

        // content to log
        $contents = $input;

        $log = $this->wrap_script($console_start . $meta . "%c" . $contents . $console_end);
        echo $log;
    }

}

$console = new Console;