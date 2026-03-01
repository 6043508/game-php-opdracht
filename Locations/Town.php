<?php
require_once(__DIR__ . "/../Entities/Player.php");

class Town {
    private Player $player;

    public function __construct(Player $player){
        $this->player = $player;
    }

    public function enter() : void {
        Console::color("You have entered the town.", "blue");
        $this->showOptions();
    }

    private function showOptions() : void{
        echo "Choose an option:\n";
        echo "1. Home (rest)\n";
        echo "2. Shop\n";
        echo "3. Leave town\n";

        $choice = trim(fgets(STDIN));
        
        switch ($choice) {
            case "1":
                $this->restAtHome();
                break;
            case "2":
                $this->visitShop();
                break;
            case "3":
                Console::color("You leave the town.", "blue");
                return;
            default:
                Console::color("Invalid choice. Try again.", "red");
                $this->showOptions();
        }
    }

    private function restAtHome(): void {
        $this->player->health = $this->player->maxHealth;
        $this->player->energy = $this->player->maxEnergy;
        Console::color("You rested at home and fully recovered health and energy!", "green");
        $this->showOptions();
    }

    private function visitShop(): void {
        Console::color("Welcome to the shop! (Feature to implement)", "yellow");
        $this->showOptions();
    }
}