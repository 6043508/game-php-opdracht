<?php
require_once __DIR__ . "/../Entities/Enemy.php";
require_once __DIR__ . "/../Entities/Player.php";

class AttackLoop{
    private Enemy $enemy;
    private Player $player;
    private bool $fightOngoing = true;
    public function __construct(Enemy $enemy, Player $player){
        $this->enemy = $enemy;
        $this->player = $player;
        $this->start();
    }
 
     private function start(){
        Console::color("ATK: " . $this->enemy->getAtk(), "cyan");
        Console::color("HP: " . $this->enemy->health, "cyan");

        $chance = rand(1, 3);
        if ($chance === 1){
            Console::color($this->enemy->name . " ambushed you!", "red");
            $this->enemy->interact($this->player);
        }

        while($this->areAlive() && $this->fightOngoing){
            $this->showChoices();
        }


        //death checks
        if ($this->enemy->health <= 0){
            Console::color("You defeated " . $this->enemy->name . "!", "yellow");
            Console::color("You've gained " . $this->enemy->getGold() . " gold!\n", "yellow");
            $this->fightOngoing = false;
        }

        if ($this->player->health <= 0){
            Console::color("You have 0 health left..", "red");
            $this->fightOngoing = false;
            return;
        }
    }

    private function areAlive() : bool {
        return $this->enemy->health > 0 && $this->player->health > 0;
    }

    private function showChoices(){
        echo("What will you do? \n");
        echo("1. Attack \n");
        echo("2. Dodge \n");
        echo("3. Run \n");

        $choice = trim(fgets(STDIN));
        switch($choice){
            case "1":
                if($this->player->energy <= 0){
                    Console::color("You have no energy left.. return home to rest -> (0,0).", "red");
                    break;
                }
                $this->player->attack($this->enemy);
                Console::color("You swung towards " . $this->enemy->name . "!", "white");
                Console::color($this->enemy->name . " lost " . $this->player->weapon->value . " HP", "green");
                
                $this->enemy->interact($this->player);
                Console::color("Your HP: " .  $this->player->health . " Energy: " . $this->player->energy . "\n", "white"); 
                break;

            case "2":
                Console::color($this->enemy->name . " tried to attack! You dodged it!", "cyan");
                break;

            case "3":
                $tryRun = $this->player->run();
                if (!$tryRun){
                    Console::color("You tried to run, but the enemy blocked your way!", "red");
                    $this->enemy->interact($this->player);
                    break;
                }
                else {
                    Console::color("You successfully escaped!", "cyan");
                    $this->fightOngoing = false;
                    break;
                }
        }
    }


}