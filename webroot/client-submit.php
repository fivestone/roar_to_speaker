<?php
include_once('init.php');

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

    Config_All::push_message($message);
}

// Redirect back to index.php
header("Location: ./");
exit();
?>