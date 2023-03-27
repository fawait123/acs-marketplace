<?php

namespace App\Helpers;

class Socket {
    private $host = "127.0.0.1";
    private $port = 8080;
    private $socket;
    private $result;


    public function __construct()
    {
        // create socket
        $this->socket = socket_create(AF_INET, SOCK_STREAM, 0);
        $this->result = socket_bind($this->socket,$this->host,$this->port);
        // connect to server
        $this->result = socket_connect($this->socket,3);
    }

    public static function emit($emit,$message)
    {
        $socket = new Socket();
        $bytes = socket_write($socket->socket,json_encode(array(
            "emit"=>$emit,
            "message"=>$message
        )));

        return $bytes;
    }


    public static function message()
    {
        $socket = new Socket();

        $message = socket_read($socket->socket,1924);
        $message = trim($message);
        return $message;
    }


}
