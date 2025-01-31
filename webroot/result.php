<?php
session_start();
if ($_SESSION['is_admin'] != 1) {
    header("Location: ./login.php");
    exit();
}
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages Coming...</title>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <button id="startBtn" class="btn btn-success">Start</button>
            <button id="stopBtn" class="btn btn-danger">Stop</button>
            <button id="resetBtn" class="btn btn-warning">Reset</button>
            <button id="logoutBtn" class="btn btn-secondary" onclick="window.location.href='logout.php'">Logout</button>
            <button id="test" class="btn btn-info">Test</button>
        </div>
        <div id="roarBlock" style="width: 300px; height: 50px; background-color: green;"></div>
        <div class="form-group">
            <label for="resultArea" id="resultLabel">Results</label>
            <textarea id="resultArea" class="form-control" rows="10" readonly></textarea>
        </div>
    </div>
    <script src="./js/jquery-3.5.1.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script>
        function doInterval(callback, interval=<?php echo $env_interval_milliseconds; ?>) {
            let timerId;
            const loop = async () => {
                callback();
                return (timerId = setTimeout(loop, interval));
            };
            return {
                start: function() {
                    console.log('Interval started');
                    loop();
                },
                end: function() {
                    console.log('Interval ended');
                    clearTimeout(timerId);
                }
            };
        }

        const intervalManager = doInterval(fetch_msg_once);

        // let count = 0;

        function fetch_msg_once(){
        //    count++;
        //    console.log('Number...', count);
            fetch('msg_queue.php')
                .then(response => response.json())
                .then(data => {
                    const resultArea = document.getElementById('resultArea');
                    if (data.messages && data.messages.length > 0) {
                        process_msgs(data.messages);
                    } 
                })
                .catch(error => {
                    console.error('Error fetching messages:', error);
                });
        }

        function process_msgs(messages) {
            // Assuming messages is an array of JSON strings
            messages.forEach(message => {
                const local_date = new Date(message.time*1000);
                const string_time = String(local_date.getHours()).padStart(2, '0') + ':'
                    + String(local_date.getMinutes()).padStart(2, '0') + ':'
                    + String(local_date.getSeconds()).padStart(2, '0');
                var msg_display = string_time + ' - ';
                if (message.user) {
                    msg_display += message.user + ': ';
                }
                if (message.msg_type == 'ROAR') {
                    msg_display += 'ROAR!!!';
                    // Change the color of roarBlock to red for 0.5 seconds
                    roarBlock.style.backgroundColor = 'red';
                    setTimeout(() => {
                        roarBlock.style.backgroundColor = 'green';
                    }, <?php echo $env_roar_milliseconds; ?>);
                }
                else {
                    msg_display += message.comment;
                }
                resultArea.value += msg_display + '\n';
                resultArea.scrollTop = resultArea.scrollHeight;
            });
        }

        async function blinkRoar() {
            roarBlock.style.backgroundColor = 'red';
            await sleep(500);
            roarBlock.style.backgroundColor = 'green';
          //setTimeout(() => {
          //    roarBlock.style.backgroundColor = 'green';
          //}, 50);
        }        
        function sleep(ms) {
            return new Promise(val => setTimeout(val, ms));
        }
        document.getElementById('startBtn').addEventListener('click', function() {
            document.getElementById('resultLabel').textContent = 'Results - Start receiving';
            intervalManager.start();
        });
        document.getElementById('stopBtn').addEventListener('click', function() {
            document.getElementById('resultLabel').textContent = 'Results - Stop receiving';
            intervalManager.end();
        });
        document.getElementById('resetBtn').addEventListener('click', function() {
            intervalManager.end();
            document.getElementById('resultLabel').textContent = 'Results';
            document.getElementById('resultArea').value = '';
            fetch('msg_queue.php?reset=1');
        });

        document.getElementById('test').addEventListener('click', fetch_msg_once);

    </script>
</body>
</html>