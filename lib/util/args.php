<?php

namespace Util;

class Args {

   private $args;
   
   
   function __construct($argstring, $blacklist=null, $encoding_check=true) {
   
      if($encoding_check===true) {
         $argstring = $this->fix_encoding($argstring);
      }
   
      $tempargs = explode(" ", $argstring);
      $temp = array();
      $index = 0;
      
      foreach($tempargs as $temparg) {
         $temparg = trim($temparg);
         if(!(strlen($temparg)<1 || (is_array($blacklist) && $this->regex_check($blacklist, $temparg, $index)>0))) {
            $temp[] = $temparg;
         }
         $index++;
      }
      
      $this->args = $temp;
   }
   
   private function check_umlauts($string) {
      $umlauts = array("€", "ß", "ä", "Ä", "ü", "Ü", "ö", "Ö");
      foreach($umlauts as $umlaut) {
         if(strpos($string, $umlaut)!==false) {
            return true;
         }
      }
      return false;
   }
   
   private function fix_encoding($string) {
      if($this->check_umlauts($string)===false) {
         $utf8 = utf8_encode($string);
         if($this->check_umlauts($utf8)===true) {
            return $utf8;
         }
      }
      return $string;
   }
   
   private function regex_check($regexarray, $subject, $index=null) {
      $matches = 0;
      foreach($regexarray as $regex) {
         
         if(is_array($regex)) {
            $regindex = $regex[0];
            $regex = $regex[1];
         }
         
         if(preg_match($regex, $subject)===1 && ($index==null || (isset($regindex) && $index!=null && $regindex==$index))) {
            $matches++;
         }
      }
      return $matches;
   }
   
   public function get_arg_count() {
      return count($this->args);
   }

   public function get_arg_all() {
      return $this->args;
   }

   public function get_arg_range($start, $end=null, $implode=false, $glue=" ", $strtolower=false) {
      if($end===null) $end=count($this->args)-1;
      if($this->get_arg($start)!==false && $this->get_arg($end)!==false && $start<=$end) {
         $range = array();
         for($i=$start; $i<=$end; $i++) $range[] = $this->get_arg($i);
         if($strtolower===true) for($i=0; $i<count($range); $i++) $range[$i]=strtolower($range[$i]);
         if($implode===true) $range = implode($glue, $range);

         return $range;
      } else {
         return false;
      }
   }

   public function get_arg($i, $strtolower=false) {
      if($strtolower===true) {
         return (isset($this->args[$i]) ? strtolower($this->args[$i]) : false);
      } else {
         return (isset($this->args[$i]) ? $this->args[$i] : false);
      }
   }

   public function check_arg($i, $regex) {
      if(isset($this->args[$i])) {
         return (preg_match($regex, $this->args[$i])===0 ? false : true);
      } else {
         return false;
      }
   }


}

