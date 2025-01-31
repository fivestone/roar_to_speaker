<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Reaction to Speaker</title>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <form id="main_form" method="post" action="./client-submit.php">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="hidden" id="msg_type" name="msg_type">

                    <label>Name</label>
                    <input type="input" class="form-control" id="input_name" name="input_name" placeholder="Name">

                    <input class="form-check-input" type="checkbox" id="is_anonymous" name="is_anonymous" value="true" checked>
                    <label class="form-check-label" for="gridCheck">
                    or anonymous
                    </label>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Comment</label>
                    <input type="textarea" height="40" class="form-control" id="input_comment" name="input_comment" placeholder="What's on your mind?">                    
                </div>
            </div>
            <button type="submit" id="submit_msg" class="btn btn-primary">Submit your comment</button>, or just <button type="submit"  id="submit_roar" class="btn btn-danger">ROAR</button> !!!
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Restore input values from local storage
            const inputs = document.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                const savedValue = localStorage.getItem(input.id);
                if (savedValue !== null) {
                    if (input.type === 'checkbox') {
                        // alert(savedValue);
                        input.checked = savedValue === true || savedValue === 'true';
                    } else {
                        input.value = savedValue;
                    }
                }
            });
        });
            // Save input values to local storage before form submission
        document.getElementById('submit_msg').addEventListener('click', function() {
            save_and_submit("MSG");
        });
        document.getElementById('submit_roar').addEventListener('click', function() {
            save_and_submit("ROAR");
        });
        function save_and_submit(msg_type) {
            document.getElementById("msg_type").value = msg_type;
            const inputs = document.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                if (input.type === 'checkbox') {
                    localStorage.setItem(input.id, input.checked);
                } else {
                    localStorage.setItem(input.id, input.value);
                }
            });
            document.getElementById("main_form").submit();
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</body>
</html>