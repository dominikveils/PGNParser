<?php

namespace DominikVeils\PGNParser\Tests;

use DominikVeils\PGNParser\Game;
use DominikVeils\PGNParser\PGNParser;
use PHPUnit\Framework\TestCase;

/**
 * Class PGNParserTest
 * @package DominikVeils\PGNParser\Tests
 */
class PGNParserTest extends TestCase
{
    /** @test */
    public function it_should_instantiate()
    {
        $parser = $this->createPNGParser();
        $this->assertInstanceOf(PGNParser::class, $parser);
    }
    
    /** @test */
    public function it_should_parse_pgn_from_string()
    {
        $parser = $this->createPNGParser();
        
        $pgn = $this->examplePGN();
        $games = $parser->fromString($pgn);
        
        $this->assertTrue(is_array($games), 'fromString method should return array of games');
        $this->assertFalse(empty($games), 'there should be 5 games from example.pgn');
        $this->assertEquals(5, count($games), 'there is 5 games in the example.pgn file');
        
        $expected = [
            ['moves_count' => 32, 'metadata_count' => 10],
            ['moves_count' => 50, 'metadata_count' => 10],
            ['moves_count' => 36, 'metadata_count' => 10],
            ['moves_count' => 42, 'metadata_count' => 10],
            ['moves_count' => 28, 'metadata_count' => 10],
        ];
        
        /**
         * @var integer $k
         * @var Game $game
         */
        foreach ($games as $k => $game) {
            $this->assertInstanceOf(Game::class, $game, 'each item in array should be instance of Game class');
            $this->assertEquals($expected[$k]['moves_count'], $game->getMoves()->count());
            $this->assertEquals($expected[$k]['metadata_count'], count($game->getMetadata()));
        }
        echo $games[0]->toJSON();
        die;
    }
    
    /**
     * @return PGNParser
     */
    private function createPNGParser(): PGNParser
    {
        return new PGNParser;
    }
    
    /**
     * @return string
     */
    private function examplePGN(): string
    {
        return file_get_contents(realpath(__DIR__ . '/data/example.pgn'));
    }
}