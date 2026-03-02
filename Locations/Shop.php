<?php
require_once(__DIR__ . "/../Locations/Locations.php");

class Shop extends Locations {
    private array $inventory;
    public function __construct(Player $player, array $weapons){
        parent::__construct($player);
        $this->inventory = $weapons;
    }

    public function enter() : void{
        Console::color("Welcome to the shop!", "cyan");
        
        
        while(true){
            $this->listWeapons();
            Console::color("Your gold: " . $this->player->gold, "yellow");
            Console::color("Enter the number of the weapon to buy or 0 to leave:\n", "cyan");
            
            $choice = (int)trim(fgets(STDIN));
            if ($choice === 0) {
                Console::color("Thanks for visiting!\n", "cyan");
                break;
            }

            $this->tryPurchase($this->player, $choice - 1);
        }
    }

    
    private function listWeapons(): void
    {
        foreach ($this->inventory as $i => $weapon) {
            $num = $i + 1;

            $price = $weapon->value * 10;
            echo "{$num}. {$weapon->label()} - {$price} gold\n";
        }
    }
    private function tryPurchase(Player $player, int $index): void
    {
        if (!isset($this->inventory[$index])) {
            Console::color("Invalid choice.\n", "red");
            return;
        }

        $weapon = $this->inventory[$index];
        $price = $weapon->value * 10;

        if ($player->gold < $price) {
            Console::color("Not enough gold!\n", "red");
            return;
        }

        $player->gold -= $price;
        $player->addWeapon($weapon);
    }
}