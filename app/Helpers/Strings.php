<?php

namespace App\Helpers;

class Strings {

    public static function wrapLastWord($string) {
        // Breaks string to pieces
        $pieces = explode(" ", $string);

        // If there is only one word, returns the string
        if( count($pieces) == 1 ){
            return $string;
        }

        // Modifies the last word
        $pieces[count($pieces)-1] = '<span class="text-school_primary">' . $pieces[count($pieces)-1] . '</span>';

        // Returns the glued pieces
        return implode(" ", $pieces);
    }

}
