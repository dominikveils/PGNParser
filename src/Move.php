<?php

namespace DominikVeils\PGNParser;

/**
 * Class Move
 * @package DominikVeils\PGNParser
 */
class Move
{
    /**
     * @var string
     */
    private $white = '';
    
    /**
     * @var string
     */
    private $black = '';
    
    /**
     * @var integer
     */
    private $move_number;
    
    /**
     * @return string
     */
    public function getWhite(): string
    {
        return $this->white;
    }
    
    /**
     * @param string $white
     */
    public function setWhite(string $white)
    {
        $this->white = $white;
    }
    
    /**
     * @return string
     */
    public function getBlack(): string
    {
        return $this->black;
    }
    
    /**
     * @param string $black
     */
    public function setBlack(string $black)
    {
        $this->black = $black;
    }
    
    /**
     * @return int
     */
    public function getMoveNumber(): int
    {
        return $this->move_number;
    }
    
    /**
     * @param int $move_number
     */
    public function setMoveNumber(int $move_number)
    {
        $this->move_number = $move_number;
    }
}