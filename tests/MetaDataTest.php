<?php

namespace DominikVeils\PGNParser\Tests;

use DominikVeils\PGNParser\MetaData;
use PHPUnit\Framework\TestCase;

/**
 * Class MetaDataTest
 * @package DominikVeils\PGNParser\Tests
 */
class MetaDataTest extends TestCase
{
    /** @test */
    public function it_should_instantiate()
    {
        $class = $this->createMetaData();
        $this->assertInstanceOf(MetaData::class, $class);
    }
    
    /**
     * @test
     * @dataProvider validDataProvider
     *
     * @param array $data
     */
    public function it_should_parse_metadata_string(array $data)
    {
        $class = $this->createMetaData();
        $class->append($data['metadata']);
        $class->parse();
        
        $this->assertEquals($data['expected']['name'], $class->getName());
        $this->assertEquals($data['expected']['value'], $class->getValue());
    }
    
    /**
     * @test
     * @dataProvider validDataProvider
     *
     * @param array $data
     */
    public function it_should_return_tue_when_metadata_is_valid(array $data)
    {
        $class = $this->createMetaData();
        $class->append($data['metadata']);
        $this->assertTrue($class->isValid());
    }
    
    /**
     * @test
     * @dataProvider invalidDataProvider
     *
     * @param array $data
     */
    public function it_should_return_false_when_metadata_is_invalid(array $data)
    {
        $class = $this->createMetaData();
        $class->append($data['metadata']);
        $this->assertFalse($class->isValid());
    }
    
    /**
     * @return array
     */
    public function validDataProvider(): array
    {
        return [
            [
                [
                    "metadata" => "[Event \"Lloyds Bank op\"]",
                    "expected" => [
                        "name"  => "Event",
                        "value" => "Lloyds Bank op",
                    ],
                ],
                [
                    "metadata" => "[Site \"London\"]",
                    "expected" => [
                        "name"  => "Site",
                        "value" => "London",
                    ],
                ],
                [
                    "metadata" => "[Date \"1984.??.??\"]",
                    "expected" => [
                        "name"  => "Date",
                        "value" => "1984.??.??",
                    ],
                ],
                [
                    "metadata" => "[Round \"1\"]",
                    "expected" => [
                        "name"  => "Round",
                        "value" => "1",
                    ],
                ],
                [
                    "metadata" => "[White \"Adams, Michael\"]",
                    "expected" => [
                        "name"  => "White",
                        "value" => "Adams, Michael",
                    ],
                ],
                [
                    "metadata" => "[Black \"Sedgwick, David\"]",
                    "expected" => [
                        "name"  => "Black",
                        "value" => "Sedgwick, David",
                    ],
                ],
            ]
        ];
    }
    
    /**
     * @return array
     */
    public function invalidDataProvider(): array
    {
        return [
            [
                [
                    "metadata" => "[Event\"Invalid\"]", // No space between name and value
                ],
            ],
            [
                [
                    "metadata" => "", // Empty data
                ],
            ]
        ];
    }
    
    /**
     * @return MetaData
     */
    private function createMetaData(): MetaData
    {
        return new MetaData;
    }
}