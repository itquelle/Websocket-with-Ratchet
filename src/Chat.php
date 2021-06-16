<?php
namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface{

    public string $restAPIUrl = "http://localhost/chatsocket/rest-api/";
    public bool $debug = true;

    protected \SplObjectStorage $clients;

    // Start Server
    public function __construct(){
        $this->clients = new \SplObjectStorage;
        if($this->debug) {
            echo "Server ist gestartet.\n";
        }
    }

    // Websocket: Neue Verbindung
    public function onOpen(ConnectionInterface $conn){
        $this->clients->attach($conn);
        if($this->debug) {
            echo "Neue Verbindung: " . $conn->resourceId . "\n";
        }
    }

    // Websocket: Response an jeden verbundenen Nutzer
    public function responseMessage(array $responseDataArrayList): bool{
        foreach ($this->clients as $client) {
            $client->send(json_encode($responseDataArrayList));
        }
        return true;
    }

    // Websocket: Neue Nachricht senden
    public function onMessage(ConnectionInterface $from, $msg){

        $numRecv = count($this->clients) - 1;

        if($this->debug) {
            echo print_r([
                "connection"        => true,
                "connectionId"      => $from->resourceId,
                "message"           => $msg,
                "sendOtherUsers"    => $numRecv
            ], 1);
        }

        $data = json_decode($msg, true);

        // Send RestAPI
        $request = file_get_contents($this->restAPIUrl . "?" . http_build_query($data));
        $request = json_decode($request, 1);

        echo match($request["statusCode"]){
            100 => $this->responseMessage($data),
            default => ""
        };

    }

    public function onClose(ConnectionInterface $conn){
        $this->clients->detach($conn);
        if($this->debug){
            echo "Verbindung getrennt von Nutzer " . $conn->resourceId . "\n";
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e){
        if($this->debug){
            echo "Fehler: " . $e->getMessage() . "\n";
        }
        $conn->close();
    }
}