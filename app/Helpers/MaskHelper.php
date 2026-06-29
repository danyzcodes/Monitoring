<?php

namespace App\Helpers;

class MaskHelper
{
    /**
     * Censor string by keeping first and last alphanumeric character,
     * and replacing middle characters with 'x'.
     *
     * Example: "dany zahir" -> "dxxy zxxxr"
     * If the word is <= 2 chars, it will be masked with 'x' entirely.
     * Special formatting characters (like -, /, ., ,, :) are preserved.
     */
    public static function mask($value)
    {
        if ($value === null || $value === '' || $value === '-') {
            return '-';
        }

        $valueStr = (string)$value;
        $words = explode(' ', $valueStr);
        $maskedWords = [];

        foreach ($words as $word) {
            if ($word === '') {
                $maskedWords[] = '';
                continue;
            }
            $maskedWords[] = self::maskWordWithSeparators($word);
        }

        return implode(' ', $maskedWords);
    }

    private static function maskWordWithSeparators($word)
    {
        // Split by non-alphanumeric characters (preserving separators)
        $parts = preg_split('/([^a-zA-Z0-9]+)/', $word, -1, PREG_SPLIT_DELIM_CAPTURE);
        $maskedParts = [];
        
        foreach ($parts as $part) {
            if (preg_match('/^[a-zA-Z0-9]+$/', $part)) {
                $len = strlen($part);
                if ($len <= 2) {
                    $maskedParts[] = str_repeat('x', $len);
                } else {
                    $first = substr($part, 0, 1);
                    $last = substr($part, -1, 1);
                    $middle = str_repeat('x', $len - 2);
                    $maskedParts[] = $first . $middle . $last;
                }
            } else {
                // Keep formatting character as-is
                $maskedParts[] = $part;
            }
        }

        return implode('', $maskedParts);
    }
}
