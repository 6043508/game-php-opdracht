<?php
require_once __DIR__ . "/Entities/Obstacle.php";
require_once __DIR__ . "/Entities/Treasure.php";
require_once __DIR__ . "/Locations/Town.php";
require_once __DIR__ . "/Models/AttackLoop.php";
class Map {
    public array $map = [];
    public static int $size = 5;
    protected Player $player;
    private int $fountainCounter = 0;

    public function __construct(Player $player)
    {
        $centerCoord = floor(Map::$size / 2);
        $this->generateGrid($centerCoord);
        $this->populateMap($centerCoord);
        $this->player = $player;
        $player->x = 0;
        $player->y = 0;
    }

    private function generateGrid(int $center): void
    {
        for ($row = 0; $row < Map::$size; $row++) {
             for ($col = 0; $col < Map::$size; $col++) {
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
        
        for ($row = 0; $row < Map::$size; $row++){
            for ($col = 0; $col < Map::$size; $col++){
                if (in_array([$row, $col], $protected)) continue;
                
                $roll = rand(1, 100);
      
                if($roll <= EventChance::Enemy->value)
                    $this->map[$row][$col] = "Enemy";

                elseif ($roll <= EventChance::Enemy->value + EventChance::Obstacle->value) 
                    $this->map[$row][$col] = "Obstacle";
                elseif ($roll <= EventChance::Enemy->value + EventChance::Obstacle->value + EventChance::Treasure->value)
                    $this->map[$row][$col] = "Treasure";
                else
                    $this->map[$row][$col] = "empty";
            }
        }
    }

    public function handleCurrentCell(): void {
        $row = $this->player->x;
        $col = $this->player->y;
        $this->handleCell($row, $col);
    }

    private function handleCell(int $row, int $col) : void {
        $cell = $this->map[$row][$col];
        $this->player->previousEvent =  $this->player->currentEvent;
        $this->player->currentEvent = $cell;

        switch ($cell){
            
            case "Town":
                $town = new Town($this->player);
                $town->enter();
                break;

            case "Fountain":
                Console::color("heeey a fountain!\nYou can stare at it, will you??", "cyan");
                Console::color("1. Yes\n2. No", "white");
                
                $choice = (int)trim(fgets(STDIN));
                 if ($choice === 0) break;
                
                if ($choice === 1) {
                    $this->fountainCounter++;

                    switch ($this->fountainCounter) {
                        case 1:
                            Console::color("A tiny talking fish pops out of the fountain!\n", "cyan");
                            Console::color('"Ah, fresh water! Drink up, weary traveler," it says.\n', "cyan");
                            break;
                        case 2:
                            Console::color("The fountain sparkles brighter as you drink again.\n", "cyan");
                            break;
                        case 3:
                            Console::color("You feel a strange tingling sensation from the water.\n", "cyan");
                            break;
                        case 4:
                            Console::color("The fountain is calm and inviting.\n", "cyan");
                            break;
                        case 5:
                            Console::color("The fish starts giving you the side-eye... you've been staring at the fountain for a while now...\n", "magenta");

                    Console::color("You drink from the fountain. Energy fully restored.\n", "green");
                    $this->player->energy = $this->player->maxEnergy;
                }

                break;
                }

            case "Enemy":
                $enemies = [
                    "CILANTRO",
                    "DUST BUNNY",
                    "COPY PASTA",
                    "CHICKEN?"
                ];

                $enemy = $enemies[array_rand($enemies)];
                $this->checkEnemy($enemy);
                
                break;

            case "Treasure":
                $treasure = new Treasure("Treasure");
                $treasure->interact($this->player);
                break;

            case "Obstacle":
                    $situations = [
                        "You tripped over A PET ROCK", 
                        "You stepped in A PUDDLE", 
                        "You got attacked by A VENGEFUL CROW",
                        ];

                    $sit = $situations[array_rand($situations)];
                    $energyCost = rand(5,10);

                    $obstacle = new Obstacle($sit, $energyCost);
                    $obstacle->interact($this->player);

                break;
            case "empty":
                echo "\n...This area is empty.\n";
                break;
            default:
                Console::color("whoops, an unimplemented enemy/event: " . $cell, "red");
                break;
        }
    }
    private function checkEnemy(string $enemy){
        switch ($enemy) {
            case "CILANTRO":
                Console::color("\nCILANTRO basically resembles a sentient cilantro", "magenta");
                $cilantro = new Enemy("CILANTRO", 5, 3, 5);
                new AttackLoop($cilantro, $this->player);
                break;
            
            case "DUST BUNNY":
                Console::color("\nDUST BUNNY, usually only found by examining certain dusty bookshelves", "magenta");
                $bun = new Enemy("DUST BUNNY", 20, 10, 10);
                new AttackLoop($bun, $this->player);
                break;

            
            case "COPY PASTA":
                Console::color("\nCOPYPASTA is a sentient sedani pasta with two black eyes and a mouth.", "magenta");
                $pasta = new Enemy("COPY PASTA", 25, 7, 20);
                new AttackLoop($pasta, $this->player);
                break;
            case "CHICKEN?":

                Console::color("\nCHICKEN? is an overpowered chicken, taking on the appearance of an actual real-life chicken.", "magenta");
                $chicken = new Enemy("CHICKEN?", 100,  20, 100);
                new AttackLoop($chicken, $this->player);
                break;
            default:
                Console::color("\nA bug??? an unexisting enemy got passed?: " . $enemy, "red");
                break;
        }
    }
   
}
enum EventChance : int {
    case Enemy = 50;
    case Obstacle = 25;
    case Treasure = 20;
}