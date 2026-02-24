<?php
require_once("Enemy.php");

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

    public function __construct($name)
    {
        $this->name = $name;
    }   


    public function move(string $direction) : bool {
        $dir = Direction::tryFrom(strtolower($direction)); 

        if ($dir === null){}
            throw new InvalidArgumentException("Invalid direction, choose from: \"North\", \"East\", \"South\" and \"West\"");
        
        switch ($dir) {
            case $dir === Direction::North:

                return true;
            case $dir === Direction::East:

                return true;
            case $dir === Direction::South:

                return true;
            case $dir === Direction::West:

                return true;
        }
     }

    public function attack(Enemy $enemy){
        $enemy->takeDamage(10);
 
    }

    public function collectGold(int $amount){
        $this->gold += $amount;
    }

    public function status(){
        return "";
    }

}
enum Direction : string {
    case North = "north";
    case East = "east";
    case South = "south";
    case West = "west";
}