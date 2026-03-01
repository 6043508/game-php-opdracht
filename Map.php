<?php

class Map {
    public array $map = [];
    public int $size = 5;
    public Player $player;

    public function __construct(Player $player)
    {
        $centerCoord = floor($this->size / 2);
        $this->generateGrid($centerCoord);
        $this->populateMap($centerCoord);
        $this->player = $player;
        $player->x = 0;
        $player->y = 0;
    }

    private function generateGrid(int $center): void
    {
        for ($row = 0; $row < $this->size; $row++) {
             for ($col = 0; $col < $this->size; $col++) {
                $this->map[$row][$col] = "empty";
            }
        }
        $this->map[0][0] = "Town";
      

        $this->map[$center][$center] = "Fountain";
    }

    private function populateMap(int $center) : void {
        $protected = [
            [0,0],
            [$center, $center]
        ];
        
        for ($row = 0; $row <$this->size; $row++){
            for ($col = 0; $col < $this->size; $col++){
                if (in_array([$row, $col], $protected)) continue;
                
                $roll = rand(1, 100);
      
                if($roll <= EventChance::Enemy->value)
                    $this->map[$row][$col] = "Enemy";

                elseif ($roll <= EventChance::Enemy->value + EventChance::Obstacle->value) 
                    $this->map[$row][$col] = "Obstacle";
                elseif ($roll <= EventChance::Enemy->value + EventChance::Obstacle->value + EventChance::Treasure->value)
                    $this->map[$row][$col] = "Treasure";
                elseif  ($roll <= EventChance::Enemy->value + EventChance::Obstacle->value + EventChance::Treasure->value + EventChance::EliteEnemy->value)
                    $this->map[$row][$col] = "EliteEnemy";
                else
                    $this->map[$row][$col] = "empty";
            }
        }
    }

    public function movePlayer(string $direction) {
    $dir = Direction::tryFrom(strtolower($direction)); 

    if ($dir === null)
        Console::color("Invalid direction, choose from: North, East, South and West", "red");
    
    $X = $this->player->x;
    $Y = $this->player->y;

    
    switch ($dir) {
        case Direction::North: $Y--; break;
        case Direction::East:  $X++; break;
        case Direction::South: $Y++; break;
        case Direction::West:  $X--; break;
    }

    if($X < 0 || $Y < 0 || $X >= $this->size || $Y >= $this->size ){
        Console::color("You can't move out of bounds!", "red");
        return;
    }

    $this->player->x = $X;
    $this->player->y = $Y;
    
    $this->handleCell($X, $Y);
    }

    private function handleCell(int $row, int $col) : void {
        $cell = $this->map[$row][$col];

        switch ($cell){
            case "Town":
                $town = new Town($this->player);
                $town->enter();
                break;

            case "Fountain":
                break;

            case "Enemy":
                break;

            case "Treasure":
                $treasure = new Treasure("Treasure");
                $treasure->interact($this->player);
                break;
            case "Obstacle":
                    $situations = [
                        "You tripped over A Rock", 
                        "You stepped in a puddle", 
                        "You got attacked by a vengeful crow"
                        ];

                    $sit = $situations[array_rand($situations)];
                    $energyCost = rand(5,10);

                    $obstacle = new Obstacle($sit, $energyCost);
                    $obstacle->interact($this->player);

                break;
            case "EliteEnemy":
                break;
            case "empty":
                echo "...This area is empty. /n";
                break;
        }
    }


   
}
enum EventChance : int {
    case Enemy = 50;
    case Obstacle = 20;
    case Treasure = 15;
    case EliteEnemy = 10;
}