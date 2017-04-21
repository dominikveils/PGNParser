# PGNParser
**PHP parser for PGN format**

## Install
```bash
$ composer require dominikveils\pgnparser
```
## Usage
```php
<?php
require 'vendor/autoload.php';

$parser = new DominikVeils\PGNParser\PGNParser;
$pgn = "... pgn string";
$games = $parser->fromString($pgn);

// Now $games is array of DominikVeils\PGNParser\Game objects
foreach ($games as $game) {
    // Do your staff here
    // Each game could be converted into a JSON string or just an array
    $game_json = $game->toJSON();
    $game_array = $game->toArray();
}
```

## Example JSON output
```json
{  
    "metadata":[  
        {  
            "name":"event",
            "value":"Lloyds Bank op"
        },
        {  
            "name":"site",
            "value":"London"
        },
        {  
            "name":"date",
            "value":"1984.??.??"
        },
        {  
            "name":"round",
            "value":"1"
        },
        {  
            "name":"white",
            "value":"Adams, Michael"
        },
        {  
            "name":"black",
            "value":"Sedgwick, David"
        },
        {  
            "name":"result",
            "value":"1-0"
        },
        {  
            "name":"whiteelo",
            "value":""
        },
        {  
            "name":"blackelo",
            "value":""
        },
        {  
            "name":"eco",
            "value":"C05"
        }
    ],
    "moves":[  
        {  
            "number":1,
            "white":"e4",
            "black":"e6"
        },
        {  
            "number":2,
            "white":"d4",
            "black":"d5"
        },
        {  
            "number":3,
            "white":"Nd2",
            "black":"Nf6"
        },
        // ...
    ]
}
```

## Test
```bash
$ vendor/bin/phpunit
```

## TODO
- Add comments support

## License
**MIT**