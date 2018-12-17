<?php
class Console
{
    public function log($string)
    {
        echo "<script type='text/javascript'>";
        echo "console.log('%cPHP:%c$string', 'color:white;background-color:black;padding:0 .25em;', 'padding-left: .5em');";
        echo "</script>";
    }
}
$console = new Console;