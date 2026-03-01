<?php
require_once "Map.php" ;
require_once __DIR__ . "\Entities\Player.php" ;

$player = new Player("Player");
$world = new Map($player);

// echo("$player->x");
// var_dump($world->map);
while (true) {
    $player->showStatus();
    echo "Enter a command (north, east, south, west, inventory, quit): ";

    $input = strtolower(trim(fgets(STDIN)));

    if ($input === "quit") {
        echo "Thanks for playing!\n";
        break;
    } elseif ($input === "inventory") {
        $player->listInventory();
        continue;
    }

    $map->movePlayer($input); 

    if ($player->health <= 0) {
        Console::color("You have died!", "red");
        break;
    }
}
