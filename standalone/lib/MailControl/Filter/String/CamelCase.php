<?php
namespace MailControl\Filter\String;

use MailControl\Filter;

class CamelCase implements Filter\Interf4ce
{
    /**
     * Convert a string like "pink floyd rocks!!!" to "pinkFloydRocks".
     * 
     * @param string $value
     * @param array $options
     * @return string
     */
    public function filter($value, array $options = array())
    {
        // We work with a lowercase string
        $value = strtolower($value);
        
        // Replace word separators with a dash and
        // remove all non-valid characters
        $value = str_replace(array(' ', '-', '.'), '-', $value);
        $value = preg_replace('/[^a-z0-9\-]/', '', $value);
        
        // Replace all dashes followed by a lowercase letter
        // with the uppercase version of the letter.
        // Eg. foo-bar => fooBar
        $closure = function($matches) {
            return strtoupper($matches[1]);
        };
        $value = preg_replace_callback('/\-([a-z])/', $closure, $value);
        
        if (isset($options['ucfirst']) && $options['ucfirst']) {
            $value = ucfirst($value);
        }
        
        return $value;
    }
}