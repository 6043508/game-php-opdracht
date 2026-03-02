<?php
require_once(__DIR__ . "/../Models/GameEntity.php");
require_once("Player.php");

class Enemy extends GameEntity{
    private int $atk;
    private int $goldOnDeath;
    public function __construct(string $name, int $health, int $atk, int $gold){
        parent::__construct($name, $health);
        $this->atk = $atk;
        $this->goldOnDeath = $gold;
    }
    public function interact(Player $player)
    {
        Console::color($this->name . " striked towards you!", "red");
        $damage = $this->randDmg();
        Console::color("You lost " . $damage . " hp.", "red");
        $player->health -= $damage;
    }

    public function randDmg(): int
    {
        $multiplier = mt_rand(90, 110) / 100;
        return (int) round($this->atk * $multiplier);
    }
    public function takeDamage(int $amount){
        $this->health  -= $amount;
    }

    public function getGold(){
        return $this->goldOnDeath;
    }

    public function getAtk(){
        return $this->atk;
    }
}