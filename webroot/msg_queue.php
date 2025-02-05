<?php
include_once('init.php');
session_start();

// Check if the user is an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$redis = Config_All::get_Redis();

// with parameter reset=1, clear the message queue
if(isset($_GET['reset']) && $_GET['reset'] == '1') {
    $redis->del(REDIS_KEY.'msg');
    echo json_encode(['messages' => []]);
    exit();
}

// Fetch all messages from the queue
$new_msgs = [];
while(true) {
    $message = $redis->lpop(REDIS_KEY.'msg');
    if (!$message) {
        break;
    }
    $new_msgs[] = json_decode($message, true);
}
$redis->close();

// Respond with the messages as JSON
header('Content-Type: application/json');
echo json_encode(['messages' => $new_msgs]);
?>