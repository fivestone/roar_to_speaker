<?php
session_start();

error_log('start');

// Check if the user is an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

include 'config.php';
$redis = new Redis();
$redis->connect($redis_host, $redis_port);

// with parameter reset=1, clear the message queue
if(isset($_GET['reset']) && $_GET['reset'] == '1') {
    $redis->del($redis_key);
    echo json_encode(['messages' => []]);
    exit();
}

// Fetch all messages from the queue
$new_msgs = [];
while(true) {
    $message = $redis->lpop($redis_key);
    if (!$message) {
        break;
    }
    $new_msgs[] = json_decode($message, true);
}

// Respond with the messages as JSON
header('Content-Type: application/json');
echo json_encode(['messages' => $new_msgs]);
?>