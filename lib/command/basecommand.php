<?php

namespace Command;

abstract class BaseCommand {

   protected $binder;

   final function __construct(\Sh\CommandBinding $b) {
      $this->binder = $b;
      if(method_exists($this, "init")) {
         $this->init();
      }
   }

   abstract public function isValidCommand(\Util\Args $args);
   abstract public function exec(\Util\Args $args);
   abstract public function comands();
   abstract public function description();

}

