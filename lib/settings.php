<?php

class Settings {

   private static $instance;

   public static function instance() {
      if(!(self::$instance instanceof Settings)) {
         self::$instance = new Settings();
      }
      return self::$instance;
   }
   
   
   private $settings;
   
   private function __construct() {
      $this->settings = array();
   }
   
   function __set($name, $value) {
      $this->settings[$name] = $value;
   }
   
   function __get($name) {
      return (isset($this->settings[$name]) ? $this->settings[$name] : null);
   }

}
