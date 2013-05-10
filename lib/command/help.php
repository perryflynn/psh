<?php

namespace Command;

class Help extends BaseCommand {

   public function isValidCommand(\Util\Args $args) {
      return ($args->get_arg(0)=="help");
   }
   
   public function comands() {
      return array(
         "help" => "Print this help"
      );
   }
   
   public function description() {
      return "Manage the help";
   }
   
   private function zerofill($string, $length=15) {
      return str_pad($string, $length);
   }
   
   public function exec(\Util\Args $args) {
      $pluginlist = array();
      $helplist = array();
      $commandobjs = $this->binder->getBindings();
      foreach($commandobjs as $commandobj) {
      
         // Plugin
         $pluginlist[end(explode("\\", get_class($commandobj)))] = $commandobj->description();
      
         // Commands
         $templist = $commandobj->comands();
         foreach($templist as $tempindex => $tempitem) {
            $helplist[$tempindex] = $tempitem;//." (Plugin: ".end(explode("\\", get_class($commandobj))).")";
         }
         
      }
      
      ksort($pluginlist);
      ksort($helplist);
      
      \Sh\Stdout::printl(\Sh\Colors::bold("     psh, version ".PSH_VERSION.", release ".PSH_RELEASEDATE."     ", "yellow", "blue"));
      \Sh\Stdout::printl("A restricted shell written in php.");
      \Sh\Stdout::printl("Define your own commands with the full power of php.");
      
      \Sh\Stdout::printl("\n[u]Loaded plugins[/u]");
      foreach($pluginlist as $name => $text) {
         \Sh\Stdout::printl(\Sh\Colors::bold($this->zerofill($name), "red").$text);
      }
      
      \Sh\Stdout::printl("\n[u]Available commands[/u]");
      foreach($helplist as $cmd => $text) {
         \Sh\Stdout::printl(\Sh\Colors::bold($this->zerofill($cmd), "red").$text);
      }
      
   }

}



