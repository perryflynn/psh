<?php

namespace Sh;

class Stdout {

   public static function printl($text, $bbcode=true) {
      
      if($bbcode===true) {
         $text = BBCode::parse($text);
      }
      
      echo $text."\n";
      
   }

}

