<?php

namespace Sh;

class Colors {

   static private $fg_colors = array(
         "black" => "30",
         "red" => "31",
         "green" => "32",
         "yellow" => "33",
         "blue" => "34",
         "purple" => "35",
         "cyan" => "36",
         "white" => "37"
      );

   static private $bg_colors = array(
         "black" => "40",
         "red" => "41",
         "green" => "42",
         "yellow" => "43",
         "blue" => "44",
         "purple" => "45",
         "cyan" => "46",
         "white" => "47"
      );
      
   public static function getColorList() {
      return array_keys(self::$fg_colors);
   }
   
   public static function normal($text, $color=null, $bgcolor=null) {
      return "\033[0;".(!is_null($color) ? ";".self::$fg_colors[$color] : "").(!is_null($bgcolor) ? ";".self::$bg_colors[$bgcolor] : "")."m".$text."\033[0m";
   }

   public static function bold($text, $color=null, $bgcolor=null) {
      return "\033[1".(!is_null($color) ? ";".self::$fg_colors[$color] : "").(!is_null($bgcolor) ? ";".self::$bg_colors[$bgcolor] : "")."m".$text."\033[0m";
   }

   public static function underline($text, $color=null, $bgcolor=null) {
      return "\033[4".(!is_null($color) ? ";".self::$fg_colors[$color] : "").(!is_null($bgcolor) ? ";".self::$bg_colors[$bgcolor] : "")."m".$text."\033[0m";
   }

}

?>
