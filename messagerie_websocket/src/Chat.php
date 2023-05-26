<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
 
        protected $clients;
        protected $rooms;
    
        public function __construct() {
            $this->clients = new \SplObjectStorage;
            $this->rooms = array();
        }
    
        public function onOpen(ConnectionInterface $conn)
        {
            $query = $conn->httpRequest->getUri()->getQuery();
            parse_str($query, $params);
            $room = isset($params['room']) ? $params['room'] : 'default';
        
            $this->rooms[$room][] = $conn;
            echo "New connection! ({$conn->resourceId})\n";
            // ...
        }
        
    
        public function onMessage(ConnectionInterface $from, $msg) {
            //envoyer le message a tous les clients sauf le client qui a envoye le message
            $numRecv = count($this->clients) - 1;
            echo sprintf('Connection %d sending message "%s" to %d other connection%s '  . "\n"
                , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
                $data = json_decode($msg);

            $numRecv = count($this->clients) - 1;
            echo sprintf('Connection %d sending message "%s" to %d other connection%s '  . "\n"
                , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
                $data = json_decode($msg);
            //recuperer la room du message et envoyer le message a tous les clients de la room
            $currentRoom =$data->room ;
         //enfoyer le message a tous les clients de la room sauf le client qui a envoye le message
            foreach ($this->rooms[$currentRoom] as $client) {
                if ($from !== $client) {
                    // The sender is not the receiver, send to each client connected
                    $client->send($msg);
                }
            }


            // Send message to clients in the same room as the sender
            $currentRoom =$data->room ;
            foreach ($this->rooms[$currentRoom] as $client) {
                if ($from !== $client) {
                    // The sender is not the receiver, send to each client connected
                    $client->send($msg);
                }
            }
            //send message to all clients
            // foreach ($this->clients as $client) {
            //     if ($from !== $client) {
            //         // The sender is not the receiver, send to each client connected
            //         $client->send($msg);
            //     }
            // }
        }
        
        
    
    public function onClose(ConnectionInterface $conn) {
        session_destroy();
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}