<?php

namespace App\Helpers;

class ProductType
{
    const DVD = 'dvds';
    const BOOK = 'books';
    const FURNITURE = 'furniture';

    // Optional: If you want additional functionality, you can uncomment the following methods
    /*
    public static function getAllTypes()
    {
        return [
            self::BOOK,
            self::DVD,
            self::FURNITURE
        ];
    }

    public static function isValidType($type)
    {
        return in_array($type, self::getAllTypes());
    }
    */
}
