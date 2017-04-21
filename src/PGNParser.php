<?php

namespace DominikVeils\PGNParser;

/**
 * Class PGNParser
 * @package DominikVeils\PGNParser
 */
class PGNParser
{
    /**
     * Current state
     *
     * @var int
     */
    private $state;
    
    /**
     * Parse PGN from string buffer
     *
     * @param string $pgn
     *
     * @return array
     */
    public function fromString(string $pgn): array
    {
        $pgn = preg_replace("/[\r\n]/", "", $pgn);
        $len = strlen($pgn);
        $games = [];
        if ($len === 0) {
            return $games;
        }
        $this->setState(State::NEW);
        
        /** @var MetaData $metadata */
        $metadata = null;
        /** @var Game $game */
        $game = null;
        /** @var Moves $moves */
        $moves = null;
        
        for ($i = 0; $i < $len; $i++) {
            $char = $pgn[$i];
            switch ($this->getState()) {
                case State::NEW:
                    if ($this->isMetadataOpenTag($char)) {
                        $metadata = new MetaData;
                        $game = new Game;
                        $this->setState(State::METADATA_OPEN);
                    }
                    break;
                case State::WORKING:
                    if ($this->isMetadataOpenTag($char)) {
                        $metadata = new MetaData;
                        $this->setState(State::METADATA_OPEN);
                    } else if ($this->isMove($char)) {
                        $moves = new Moves;
                        $i--; // Step back
                        $this->setState(State::MOVES);
                    }
                    break;
                case State::METADATA_OPEN:
                    if ($this->isMetadataCloseTag($char)) {
                        if ($metadata->isValid()) {
                            $game->addMetadata($metadata);
                            $this->setState(State::WORKING);
                        }
                    } else {
                        // This is not the metadata close tag,
                        // so it should be the metadata contents
                        $metadata->append($char);
                    }
                    break;
                case State::MOVES:
                    if ($this->isMetadataOpenTag($char) === false) {
                        $moves->append($char);
                    }
                    // if its the last iteration
                    // or we've found new metadata open tag
                    if ($i === $len - 1 || $this->isMetadataOpenTag($char)) {
                        $moves->parse();
                        $game->setMoves($moves);
                        $games[] = $game;
                        // Step back if there is another game
                        if ($this->isMetadataOpenTag($char)) {
                            $this->setState(State::NEW);
                            $i--; // Step back
                        }
                    }
                    break;
            }
        }
        
        return $games;
    }
    
    /**
     * @param string $char
     *
     * @return bool
     */
    private function isMetadataOpenTag(string $char): bool
    {
        return $char === Symbols::METADATA_OPEN_TAG;
    }
    
    /**
     * @param string $char
     *
     * @return bool
     */
    private function isMetadataCloseTag(string $char): bool
    {
        return $char === Symbols::METADATA_CLOSE_TAG;
    }
    
    /**
     * @param string $char
     *
     * @return bool
     */
    private function isMove(string $char): bool
    {
        return preg_match("/\d/", $char);
    }
    
    /**
     * @return int
     */
    private function getState(): int
    {
        return $this->state;
    }
    
    /**
     * @param int $state
     */
    private function setState(int $state)
    {
        $this->state = $state;
    }
}