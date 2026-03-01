<?php
class Console
{
        private static array $colors = [
        "black"   => 30,
        "red"     => 31,  //warning
        "green"   => 32,  //
        "yellow"  => 33,  //gold
        "blue"    => 34,  //notifs location
        "magenta" => 35, //
        "cyan"    => 36,  //notifs event
        "white"   => 37,
    ];

    public static function color(string $text, string $color = ""){
        $prefix = "\033[" .  self::$colors[$color] . "m";
        $suffix = "\033[0m\n";
        echo ($prefix . $text . $suffix);
    }
}