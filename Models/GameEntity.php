<?php
require_once(__DIR__ . "\..\Entities\Player.php");
abstract class GameEntity{
    public string $name;
    public int $health;
    
    public function __construct(string $name, int $health)
    {
        $this->name = $name;
        $this->health = $health;
    }

    abstract function interact(Player $player);
}