<?php
require_once(__DIR__ . "/../Entities/Player.php");
require_once(__DIR__ . "/../Locations/Locations.php");
require_once(__DIR__ . "/../Locations/Shop.php");

class Town extends Locations{
    protected Player $player;

    public function __construct(Player $player){
        parent::__construct($player);
    }

    public function enter() : void {
        if($this->player->previousEvent === "")
            Console::color("You are currently in the town! (0,0) \nThere are no monsters here and you can return home to rest and heal!", "cyan");

        else Console::color("You have entered the town.", "cyan");
        $this->showOptions();   
    }

    private function showOptions() : void{
        echo "Choose an option:\n";
        echo "1. Home (rest)\n";
        echo "2. Shop\n";
        echo "3. Leave town\n";

        $choice = (int)trim(fgets(STDIN));
        
        switch ($choice) {
            case 1:
                $this->restAtHome();
                break;

            case 2:
                $shop = new Shop(
                    $this->player, [
                    Weapon::Knife,
                    Weapon::Sword,
                    Weapon::Hammer
                ]);

                $shop->enter();
                break;
            case 3:
                Console::color("You leave the town.", "blue");
                $this->player->moveInDirection("east");
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

}