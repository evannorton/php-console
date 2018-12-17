<?php
class Console
{
    public function log($input)
    {

        $bt = debug_backtrace();
        $caller = array_shift($bt);

        $file = $caller["file"];
        $file = substr($file, strrpos($file, "\\") + 1);
        $line = $caller["line"];

        echo "<script type='text/javascript'>";
        echo "console.log('%c";
        echo $file . ":" . $line;
        echo "%c";
        echo $input;
        echo "', 'color:white;background-color:black;padding:0 .25em;', 'padding-left: .5em');";
        echo "</script>";
    }
}
$console = new Console;