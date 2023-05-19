<?php
$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
$message = "Hi This is a message";
socket_sendto($socket, $message, strlen($message), 0, "192.168.0.101", "514");