<?php
require_once("../Models/GameEntity.php");
require_once("Player.php");

//add silly description for obstacles

class Obstacle extends GameEntity {
    public int $energyCost;
    public function __construct(string $name, int $health, int $energyCost)
    {
        return parent::__construct($name, $health);
        $this->energyCost = $energyCost;
    }

    public function interact(Player $player)
    {
        $player->energy -= $this->energyCost;
    }
}