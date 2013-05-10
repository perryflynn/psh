<?php

namespace Sh;

class CommandBinding {

   private $bindings;
   

   function __construct($bindings) {
      $this->bindings = $bindings;
      
      foreach($this->bindings as &$binding) {
         $class = "\\Command\\".$binding;
         if(class_exists($class)) {
            $binding = new $class($this);
            if(!($binding instanceof \Command\BaseCommand)) {
               throw new Exception("'".$class."' is not a extension of \\Command\\BaseCommand");
            }
         } else {
            throw new Exception("Command class '".$class."' does not exist");
         }
      }
      unset($binding);
      
   }
   
   public function getBindings() {
      return $this->bindings;
   }
   
   public function execLine($line) {
      $args = new \Util\Args($line);
      $status = false;
      foreach($this->bindings as $obj) {
         if($obj->isValidCommand($args)) {
            $obj->exec($args);
            $status = true;
         }
      }
      return $status;
   }

}

