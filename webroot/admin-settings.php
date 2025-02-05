<?php
include_once 'init.php';
session_start();
if ($_SESSION['is_admin'] != 1) {
    header("Location: ./login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" and $_POST['form_type'] == 'change-password') {
    $password_new = $_POST['newPassword'];
    $password_confirm = $_POST['confirmPassword'];

    if ($password_new != $password_confirm) {
        $error = "Passwords do not match. Please try again.";
    } else {
        Config_All::set_Value('admin_password', MD5($password_new));
        $success = "Password changed successfully.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" and $_POST['form_type'] == 'program-settings') {
    $program_settings = [
        'programDescription' => $_POST['programDescription'],
        'enableComments' => isset($_POST['enableComments']) ? true : false,
        'enableRoarButton' => isset($_POST['enableRoarButton']) ? true : false,
        'roarButtonMessage' => $_POST['roarButtonMessage']
    ]; 
    Config_All::set_Value('settings', json_encode($program_settings));   
    $success = "Settings updated.";
}

$program_settings = Config_All::get_Settings();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings</title>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Admin Settings</h2>
        <?php
                if (isset($error)) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
                if (isset($success)) {
                    echo "<div class='alert alert-danger'>$success</div>";
                }
        ?>
        <!-- Program Settings Form -->
        <form action="./admin-settings.php" id="form_program_settings" method="POST" class="mb-4">
            <input type="hidden" name="form_type" id="form_type" value="program-settings">
            <div class="form-group">
                <label for="programDescription">Program Description</label>
                <textarea class="form-control" id="programDescription" name="programDescription" rows="3"><?php echo $program_settings['programDescription'];?></textarea>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="enableComments" name="enableComments" value="true" <?php echo $program_settings['enableComments'] ? 'checked' : '';?>>
                <label class="form-check-label" for="enableComments">Enable Comments</label>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="enableRoarButton" name="enableRoarButton" value="true" <?php echo $program_settings['enableRoarButton'] ? 'checked' : '';?>>
                <label class="form-check-label" for="enableRoarButton">Enable Roar Button</label>
            </div>
            <div class="form-group">
                <label for="roarButtonMessage">Roar Button Message</label>
                <input type="text" class="form-control" id="roarButtonMessage" name="roarButtonMessage" value="<?php echo $program_settings['roarButtonMessage'];?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Settings</button>
        </form>

        <hr> <!-- Separate line between two forms -->

        <!-- Change Password Form -->
        <form action="./admin-settings.php" id="form_change_password" method="POST" class="mb-4">
            <input type="hidden" name="form_type" id="form_type" value="change-password">
            <div class="form-group">
                <label for="newPassword">New Password</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm New Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
            </div>
            <button type="submit" id="btnPassword" class="btn btn-primary">Change Password</button>
        </form>
        <a href="./result.php" class="btn btn-link">Back to Panel</a>
    </div>

    <script src="./js/jquery-3.5.1.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>

</body>
</html>