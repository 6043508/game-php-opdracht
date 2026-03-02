<?php
require_once(__DIR__ . "/../Models/GameEntity.php");
require_once(__DIR__ . "/../Console.php");
require_once("Player.php");

class Treasure extends GameEntity{
    private int $goldAmount;

    public function __construct(string $name, int $health = -1)
    {
        parent::__construct($name, $health);
        $this->goldAmount = $this->generateGold(rand(3, 50));
    }
    private function generateGold($n, $x = 5){
        return (round($n) % $x === 0) ? round($n) : round(($n + $x/2) / $x) * $x;
    }

    public function interact(Player $player){
        $player->collectGold($this->goldAmount);
        Console::color("You stumbled upon a treasure and found " . $this->goldAmount . " gold!", "yellow");
    }

}