<?php
require_once(__DIR__ . "/../Entities/Player.php");

abstract class Locations{
    protected Player $player;

    public function __construct(Player $player){
        $this->player = $player;
    }
    abstract public function enter(): void;
}