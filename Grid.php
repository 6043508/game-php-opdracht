<?php
class GameWorld{
    public array $map = [];
    private int $size = 5;
    private array $entities = ["Enemy", "Treasure", "Obstacle"];
    public Player $player;

    public function __construct(Player $player)
    {
        $this->generateGrid();
        $player->x = 0;
        $player->y = 0;
    }

    private function generateGrid(): void
    {
        for ($row = 0; $row < $this->size; $row++) {
            for ($col = 0; $col < $this->size; $col++) {
                $this->map[$row][$col] = [
                    "type" => "empty",
                    "event" => false
                ];
            }
        }

        $this->map[0][0] = 
    }

    private function randomEntity(): string
    {

        return $this->entities[array_rand($this->entities)];
    }
}