<?php

class HiddenItemGame
{
    private const GRID_HEIGHT = 6;
    private const GRID_WIDTH = 8;
    private const OBSTACLE = '#';
    private const PATH = '.';
    private const PLAYER = 'X';
    private const ITEM = '$';

    private $grid;
    private $playerPosition;
    private $itemPosition;

    public function __construct()
    {
        $this->initializeGrid();
        $this->placePlayer();
        $this->placeItem();
    }

    private function initializeGrid()
    {
        $this->grid = array_fill(0, self::GRID_HEIGHT, array_fill(0, self::GRID_WIDTH, self::OBSTACLE));
        for ($i = 1; $i < self::GRID_HEIGHT - 1; $i++) {
            for ($j = 1; $j < self::GRID_WIDTH - 1; $j++) {
                $this->grid[$i][$j] = self::PATH;
            }
        }
    }

    private function placePlayer()
    {
        $this->playerPosition = [$this->getRandomCoordinate(self::GRID_HEIGHT), $this->getRandomCoordinate(self::GRID_WIDTH)];
        $this->grid[$this->playerPosition[0]][$this->playerPosition[1]] = self::PLAYER;
    }

    private function placeItem()
    {
        $upSteps = rand(1, self::GRID_HEIGHT - 3);
        $rightSteps = rand(1, self::GRID_WIDTH - 1 - $upSteps);
        $downSteps = self::GRID_HEIGHT - 1 - $upSteps;

        $this->itemPosition = [
            $this->playerPosition[0] - $upSteps,
            $this->playerPosition[1] + $rightSteps
        ];

        $this->grid[$this->itemPosition[0]][$this->itemPosition[1]] = self::ITEM;
    }

    private function getRandomCoordinate($max)
    {
        return rand(1, $max - 2);
    }

    public function displayGrid()
    {
        foreach ($this->grid as $row) {
            echo implode('', $row) . PHP_EOL;
        }
    }

    public function findItemProbableLocations()
    {
        $probableLocations = [];
        for ($i = 1; $i < self::GRID_HEIGHT - 1; $i++) {
            for ($j = 1; $j < self::GRID_WIDTH - 1; $j++) {
                if ($this->grid[$i][$j] === self::PATH) {
                    $probableLocations[] = [$i, $j];
                }
            }
        }
        return $probableLocations;
    }
}

// Main Program
$game = new HiddenItemGame();
echo "Grid with Player (X) and Item (\$):\n";
$game->displayGrid();

$probableLocations = $game->findItemProbableLocations();

echo "\nProbable Item Locations:\n";
foreach ($probableLocations as $location) {
    echo "($location[0], $location[1])\n";
}
