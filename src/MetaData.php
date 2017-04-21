<?php

namespace DominikVeils\PGNParser;

/**
 * Class MetaData
 * @package DominikVeils\PGNParser
 */
class MetaData
{
    /**
     * @var string
     */
    private $buffer = '';
    
    /**
     * Metadata name
     *
     * @var string
     */
    private $name = '';
    
    /**
     * Metadata value
     *
     * @var string
     */
    private $value = '';
    
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
    
    /**
     * @param string $value
     */
    public function setValue(string $value)
    {
        $this->value = $value;
    }
    
    /**
     * @param string $char
     */
    public function append(string $char)
    {
        $this->buffer .= $char;
    }
    
    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->parse();
    }
    
    /**
     * Parse buffer
     *
     * @return bool
     */
    public function parse(): bool
    {
        $this->buffer = trim($this->buffer, "[]");
        
        if (empty($this->buffer)) {
            return false;
        }
        
        if (strpos($this->buffer, ' ') === false) {
            return false;
        }
        
        list($name, $value) = explode(' ', $this->buffer, 2);
        $this->name = $name;
        $this->value = trim($value, '"');
        
        return true;
    }
}