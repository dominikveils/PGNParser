<?php

namespace DominikVeils\PGNParser;

/**
 * Class Game
 * @package DominikVeils\PGNParser
 */
class Game
{
    /**
     * @var array
     */
    private $metadata = [];
    
    /**
     * @var Moves
     */
    private $moves;
    
    /**
     * @param MetaData $metaData
     */
    public function addMetadata(MetaData $metaData)
    {
        $this->metadata[] = $metaData;
    }
    
    /**
     * Return array of Metadata items
     *
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }
    
    /**
     * @param Moves $moves
     */
    public function setMoves(Moves $moves)
    {
        $this->moves = $moves;
    }
    
    /**
     * @return Moves
     */
    public function getMoves(): Moves
    {
        return $this->moves;
    }
    
    /**
     * @return string
     */
    public function toJSON(): string
    {
        return json_encode($this->toArray());
    }
    
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'metadata' => array_map(function (MetaData $m) {
                return [
                    'name'  => strtolower($m->getName()),
                    'value' => $m->getValue(),
                ];
            }, $this->metadata),
            'moves'    => $this->getMoves()->toArray(),
        ];
    }
}