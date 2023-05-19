<?php
//Create socket.
$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
if (!$socket) { die("socket_create failed.\n"); }

//Set socket options.
socket_set_nonblock($socket);
socket_set_option($socket, SOL_SOCKET, SO_BROADCAST, 1);
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
if (defined('SO_REUSEPORT'))
    socket_set_option($socket, SOL_SOCKET, SO_REUSEPORT, 1);

//Bind to any address & port 514.
if(!socket_bind($socket, '0.0.0.0', 514))
    die("socket_bind failed.\n");


//Wait for data.
$read = array($socket);
$write = NULL;
$except = NULL;
while(socket_select($read, $write, $except, NULL)) {

    socket_recvfrom($socket,$data,65535,0,$clientIP,$clientPort);
    date_default_timezone_set("Asia/Dhaka");
    $time = date("d-M h:i:s");
    
    if (!file_exists("./".$clientIP)) {
        mkdir("./".$clientIP, 0777, true);
        $file=fopen("./".$clientIP."/Device.log","a");
        fwrite($file, $time." ".$data . "\n");
        fclose($file);
    }else{
        $file=fopen("./".$clientIP."/Device.log","a");
        fwrite($file, $time." ".$data . "\n");
        fclose($file);
    }
}
?>