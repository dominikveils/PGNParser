<?php

namespace DominikVeils\PGNParser;

/**
 * Class Moves
 * @package DominikVeils\PGNParser
 */
class Moves
{
    /**
     * @var string
     */
    private $buffer = '';
    
    /**
     * @var array
     */
    private $moves = [];
    
    /**
     * @param string $char
     */
    public function append(string $char)
    {
        $this->buffer .= $char;
    }
    
    /**
     * Parse moves
     */
    public function parse()
    {
        if (!empty($this->buffer)) {
            $this->buffer = trim($this->buffer);
            // TODO: Add comments parsing
            $this->clearComments();
            $move_regex = "[A-Za-z]\d[A-Za-z]+\d|[A-Za-z]+\d[+#]?[+!?]*|O-O|O-O-O";
            $moves_regex = "/(\d{1,})\.({$move_regex})\s($move_regex)?/u";
            // $matches[1] = move number
            // $matches[2] = white move
            // $matches[3] = black move - could be empty
            preg_match_all($moves_regex, $this->buffer, $matches);
            if (!empty($matches[0])) {
                $count = count($matches[0]);
                for ($i = 0; $i < $count; $i++) {
                    $move = new Move;
                    $move->setMoveNumber($matches[1][$i]);
                    $move->setWhite($matches[2][$i]);
                    $move->setBlack($matches[3][$i]);
                    $this->moves[] = $move;
                }
            }
        }
    }
    
    /**
     * @param int $move_number 1, 2, 3
     * @param string $side     'white', 'black'
     *
     * @return null|Move
     */
    public function getMove(int $move_number, string $side)
    {
        if (!in_array(strtolower($side), ['white', 'black'])) {
            return null;
        }
        
        $side = ucfirst($side);
        $side = "get{$side}";
        
        /** @var Move $move */
        foreach ($this->moves as $move) {
            if ($move->getMoveNumber() === $move_number) {
                return $move->{$side}();
            }
        }
    }
    
    /**
     * @return int
     */
    public function count()
    {
        return count($this->moves);
    }
    
    /**
     * @return array
     */
    public function toArray(): array
    {
        $arr = [];
        /** @var Move $move */
        foreach ($this->moves as $k => $move) {
            $arr[] = [
                'number' => $move->getMoveNumber(),
                'white'  => $move->getWhite(),
                'black'  => $move->getBlack(),
            ];
        }
        
        return $arr;
    }
    
    /**
     * Remove comments from moves
     */
    private function clearComments()
    {
        $this->buffer = preg_replace("/({.*})/U", "", $this->buffer); // Remove comments
        $this->buffer = preg_replace("/\s{2,}/", " ", $this->buffer); // Remove extra spaces
    }
}