<?php
// Handle the form submission

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $message = [
        'time' => time(),
        // 'time' => date('Y-m-d H:i:s'),
        'msg_type' => isset($_POST["msg_type"]) ? $_POST["msg_type"] : 'UNKNOWN',
        'user' => null,
        'comment' => isset($_POST["input_comment"]) ? $_POST["input_comment"] : ''
    ];
    if (!isset($_POST['is_anonymous']) || $_POST['is_anonymous'] <>'true') {
        $message['user'] = isset($_POST["input_name"]) ? $_POST["input_name"] : null;
    }

    include 'config.php';
    $redis = new Redis();
    $redis->connect($redis_host, $redis_port);

    $redis->rpush($redis_key, json_encode($message));
}

// Redirect back to index.php
header("Location: ./");
exit();
?>