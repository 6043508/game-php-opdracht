<?php
require_once("Enemy.php");
require_once("Console.php");

class Player{
    public string $name;
    public string $currentEvent = "";
    public $previousEvent = "";
    public Weapon $weapon = Weapon::Stick;

    public int $health = 100,
     $energy = 50, 
     $gold = 0, 
     $x = 0, 
     $y = 0;

    public int $maxHealth = 100, $maxEnergy = 50;
    private array $inventory = [];

    public function __construct($name)
    {
        $this->name = $name;
        $this->inventory[0] = Weapon::Stick;
    }   

#region basic actions
    public function attack(Enemy $enemy){
        $enemy->takeDamage($this->weapon->value);
        $this->energy -= 5;
    }

    public function run() : bool{
        return (rand(1, 100) <= 75) ? true : false;
    }

    public function collectGold(int $amount){
        $this->gold += $amount;
    }

    public function moveInDirection(string $direction) {
        $dir = Direction::tryFrom(strtolower($direction)); 

        if ($dir === null)
            Console::color("Invalid direction, choose from: North, East, South and West", "red");
        
        $X = $this->x;
        $Y = $this->y;

        
        switch ($dir) {
            case Direction::North: $Y--; break;
            case Direction::East:  $X++; break;
            case Direction::South: $Y++; break;
            case Direction::West:  $X--; break;
        }

        if($X < 0 || $Y < 0 || $X >= Map::$size || $Y >=  Map::$size ){
            Console::color("You can't move out of bounds!", "red");
            return;
        }

        $this->x = $X;
        $this->y = $Y;
    }

    public function showStatus(){
        echo "Current location: " . $this->x . "," . $this->y . "\n";
        echo "Health: " . $this->health . "/" . $this->maxHealth . "\n";
        echo "Energy: " . $this->energy . "/" . $this->maxEnergy . "\n";
        echo "Gold: " . $this->gold . "\n";
    }
#endregion

#region Weapons and inventory
    public function addWeapon(Weapon $weapon): void
    {
        if (!in_array($weapon, $this->inventory, true)) {
            $this->inventory[] = $weapon;
            Console::color("You obtained {$weapon->label()}!", "yellow");
        }
    }

    public function listInventory(){
            if (empty($this->inventory)) {
            Console::color("Your inventory is empty.", "red");
            return;
        }

        Console::color("Weapons:", "cyan");

        foreach ($this->inventory as $index => $weapon) {
            $number = $index + 1;

            echo "{$number}. {$weapon->label()} ({$weapon->value} dmg)\n";
        }
    }

    public function equipWeapon(int $choice): void
{
    $index = $choice - 1;

    if (!isset($this->inventory[$index])) {
        Console::color("Invalid weapon choice.", "red");
        return;
    }

    $this->weapon = $this->inventory[$index];
    Console::color(
        "You equipped {$this->weapon->label()}!",
        "green"
    );
}

#endregion

#region enums
}
enum Direction : string {
    case North = "north";
    case East = "east";
    case South = "south";
    case West = "west";
}

enum Weapon : int {
    case Stick   = 2;
    case Knife   = 5;
    case Sword   = 10;
    case Hammer  = 20;

    public function label() : string {
        return match($this){
            self::Stick  => "A Stick (deals 2 dmg, barely better than nothing)",
            self::Knife  => "A Knife (deals 5 dmg ,fast and light, not that it matters...)",
            self::Sword  => "A Sword (deals 10 dmg, we're getting somewhere)",
            self::Hammer => "A Hammer (deals 20 dmg, what a brute..)",
        };
    }
}

#endregion