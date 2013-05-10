#!/usr/bin/php
<?php

// Initialize
define("BASE", dirname(__FILE__)."/");
@chdir(BASE);

// Load Includes
$incs = glob("inc/inc.*.php");
foreach($incs as $inc) {
   include($inc);
}

// Init Command Binding
$bind = new \Sh\CommandBinding($commands);

// Read from stdin
$linebuffer = "";
$scanner = fopen('php://stdin', 'r');

$user = $_SERVER['USER'];
$host = reset(explode(".", gethostname()));
\Settings::instance()->priv = "\$";

// Login log
$client = "[color style=bold fg=red](".date("Y-m-d H:i:s").")[/color] [color style=bold fg=yellow]<".reset(explode(" ", $_SERVER['SSH_CLIENT'])).">[/color] ";
$client = \Sh\BBCode::parse($client);
file_put_contents("log.txt", $client."Initial Login!\n", FILE_APPEND);

// Process Kill Log
register_shutdown_function(function() {
   $client = "[color style=bold fg=red](".date("Y-m-d H:i:s").")[/color] [color style=bold fg=yellow]<".reset(explode(" ", $_SERVER['SSH_CLIENT'])).">[/color] ";
   $client = \Sh\BBCode::parse($client);
   file_put_contents("log.txt", $client."Shell exited!\n", FILE_APPEND);
});

// Welcome message
if(file_exists("motd.txt") && is_readable("motd.txt")) {
   $text = str_replace(
      array("{hostname}", "{date}"),
      array(gethostname(), date("Y-m-d H:i:s")),
      file_get_contents("motd.txt"));
      
   $text = preg_replace("/[\r\n]\$/", "", $text);
   \Sh\Stdout::printl($text);
}

// Char per char
do {

   if($linebuffer=="") {
      echo "\n".$user."@".$host.":/".\Settings::instance()->priv." ";
   }

   $char = fread($scanner, 1);
   
   // Fill Linebuffer
   if($char == "\n") {
   
      $client = "[color fg=yellow](".date("Y-m-d H:i:s").")[/color] [color fg=red]<".reset(explode(" ", $_SERVER['SSH_CLIENT'])).">[/color] ";
      $client = \Sh\BBCode::parse($client);
      file_put_contents("log.txt", $client.$linebuffer."\n", FILE_APPEND);
   
      if($bind->execLine($linebuffer)==false) {
         \Sh\Stdout::printl(trim(reset(explode(" ", $linebuffer))).": command not found");
      }
      $linebuffer = "";
   } else {
      $linebuffer .= $char;
   }
   

}
while(true);

