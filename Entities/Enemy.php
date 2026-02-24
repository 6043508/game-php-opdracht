<?php
require_once("../Models/GameEntity.php");
require_once("Player.php");

class Enemy extends GameEntity{
    private int $damage;
    public function __construct(string $name, int $health, int $damage){
        parent::__construct($name, $health);
        $this->damage = $damage;
    }
    public function interact(Player $player)
    {
        $randDmg = floor($this->damage * rand(0.9, 1.1));
        $player->health -= $randDmg;
    }

    public function takeDamage(int $amount){
    
    }
}