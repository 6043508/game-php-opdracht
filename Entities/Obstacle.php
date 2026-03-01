<?php
require_once(__DIR__ . "/../Models/GameEntity.php");
require_once("Player.php");
require_once(__DIR__ . "/../Console.php");

//add silly description for obstacles

class Obstacle extends GameEntity {
    public int $energyCost;
    public function __construct(string $obstacle, int $energyCost,int $health = -1)
    {   
        parent::__construct($obstacle, $health);
        $this->energyCost = $energyCost;
    }

    public function interact(Player $player)
    {
        $player->energy -= $this->energyCost;
        Console::color("{$this->name} and lost {$this->energyCost} energy", "cyan");
    }
}