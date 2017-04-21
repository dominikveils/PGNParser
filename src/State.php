<?php

namespace DominikVeils\PGNParser;

/**
 * Class State
 * @package DominikVeils\PGNParser
 */
class State
{
    const NEW = 1;
    const WORKING = 2;
    const METADATA_OPEN = 3;
    const COMMENT_OPEN = 4;
    const MOVES = 5;
}