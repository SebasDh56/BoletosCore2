<?php
require_once 'vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

try {
    $conn = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    $ch   = $conn->channel();
    $ch->queue_declare('ticket_purchase', false, true, false, false);
    $msg  = new AMQPMessage('prueba');
    $ch->basic_publish($msg, '', 'ticket_purchase');
    echo "✅ Mensaje enviado a ticket_purchase\n";
    $ch->close();
    $conn->close();
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . PHP_EOL;
}