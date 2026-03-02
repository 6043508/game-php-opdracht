<?php
require_once "Map.php" ;
require_once __DIR__ . "\Entities\Player.php" ;

$player = new Player("Player");
$world = new Map($player);

// echo("$player->x");
// var_dump($world->map);
echo "\n";
$world->handleCurrentCell();


while (true) {
    $player->showStatus();
    Console::color("Enter a command (north, east, south, west, inventory, quit): ", "cyan");

    $input = strtolower(trim(fgets(STDIN)));

    if ($input === "quit") {
        echo "Thanks for playing!\n";
        break;
    }
    if ($input === "inventory") {
        $player->listInventory();
        echo "\nEnter the number of the weapon you want to equip\n";

        $choice = (int)trim(fgets(STDIN));
        $player->equipWeapon($choice);
        continue;
    }
    
    $player->moveInDirection($input);   
    $world->handleCurrentCell();
    
    echo "\n";

    if ($player->health <= 0) {
        Console::color("You have died!", "red");
        break;
    }
}
