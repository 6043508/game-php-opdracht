<?php
require_once("Enemy.php");
require_once("Console.php");
//add weapons
//base player dmg on energy
//add home and option to rest.
//add day-night system?
class Player{
    public string $name;
    // public Weapon $weapon = Weapon::stick;
    public int $health = 100,
     $energy = 50, 
     $gold = 0, 
     $x, 
     $y;

    public int $maxHealth = 100, $maxEnergy = 50;
    private array $inventory = [];

    public function __construct($name)
    {
        $this->name = $name;
    }   


    public function attack(Enemy $enemy){
        $enemy->takeDamage(10);
        $this->energy -= 5;
    }

    public function run(){
        $success = rand(1, 100) <= 75;

        if ($success)
            Console::color("You successfully escaped!", "cyan");
        else 
            Console::color("You tried to run, but the enemy blocked your way!", "red");
    }

    public function collectGold(int $amount){
        $this->gold += $amount;
    }

    public function showStatus(){
        echo "Current location: " . $this->x . "," . $this->y . "\n";
        echo "Health: " . $this->health . "/" . $this->maxEnergy;
        echo "Energy: " . $this->energy . "/" . $this->maxEnergy . "\n";
        echo "Gold: " . $this->gold . "\n";
    }

    public function listInventory(){
        echo "Inventory: ";
        foreach ($this->inventory as $item){
            echo $item . " ";
        }
    }

}
enum Direction : string {
    case North = "north";
    case East = "east";
    case South = "south";
    case West = "west";
}