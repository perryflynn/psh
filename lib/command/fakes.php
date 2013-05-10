<?php

namespace Command;

class Fakes extends BaseCommand {

   public function isValidCommand(\Util\Args $args) {
      $line = $args->get_arg_range(0, null, true);
      return (preg_match("/exit|echo|runlevel|init|su|sudo|whoami|id|shutdown|bash/", $line)===1);
   }
   
   public function comands() {
      return array(
         "exit" => "Logout from shell", 
         "echo" => "Print a sting in shell", 
         "runlevel" => "Displays the runlevel", 
         "su" => "Gain root privileges", 
         "sudo" => "Gain root privileges", 
         "whoami" => "Who am I?", 
         "id" => "Display user id and group memberships",
         "init" => "Changes the runlevel",
         "shutdown" => "Shutdown or reboot the system",
         "bash" => "Creates a burning again shell"
      );
   }
   
   public function description() {
      return "Fake linux shell commands";
   }

   public function exec(\Util\Args $args) {
      if($args->get_arg(0)=="exit") {
         if(\Settings::instance()->priv=="#") {
            \Settings::instance()->priv = "\$";
         } else {
            \Sh\Stdout::printl("Bye.");
            exit();
         }
      }
      elseif($args->get_arg(0)=="echo") {
         \Sh\Stdout::printl($args->get_arg_range(1, null, true));
      }
      elseif($args->get_arg(0)=="runlevel") {
         \Sh\Stdout::printl("3");
      }
      elseif($args->get_arg(0)=="su" || $args->get_arg(0)=="sudo") {
         \Settings::instance()->priv = "#";
      }
      elseif($args->get_arg(0)=="whoami") {
         if(\Settings::instance()->priv == "#") {
            \Sh\Stdout::printl("root");
         } else {
            \Sh\Stdout::printl($_SERVER['USER']);
         }
      }
      elseif($args->get_arg(0)=="id") {
         if(\Settings::instance()->priv == "#") {
            \Sh\Stdout::printl("uid=0(root) gid=0(root) groups=0(root)");
         } else {
            \Sh\Stdout::printl("uid=1000(admin) gid=1000(admin) groups=1000(admin)");
         }
      }
      elseif($args->get_arg(0)=="bash") {
         \Sh\Stdout::printl("Sorry dave, but i can't let you do that");
      }
      elseif($args->get_arg(0)=="shutdown") {
         if($args->get_arg(1)=="-h") {
            \Sh\Stdout::printl("The System in going down for system halt NOW!!");
         } else if($args->get_arg(1)=="-r") {
            \Sh\Stdout::printl("The System in going down for system reboot NOW!!");
         } else {
            \Sh\Stdout::printl("Please specifiy an action!");
         }
      }
      
   }

}

