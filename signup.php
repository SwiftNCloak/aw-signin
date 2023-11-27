<!--Made by Mark. Remove this and modify the codes.-->

<?php
include('config.php');
$disp = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['txtName'];
    $email = $_POST['txtEmail'];
    $contact = $_POST['txtContact'];
    $username = $_POST['txtUname'];
    $password = md5($_POST['txtUpass']);
    $userType = $_POST['userType'] ?? '';

    $checkUsernameQuery = "SELECT * FROM users WHERE user_name='$username'";
    $checkUsernameResult = $conn->query($checkUsernameQuery);

    if ($checkUsernameResult->num_rows > 0) {
        $disp = 'Username already exists.';
    } else {
        $insertQuery = "INSERT INTO users (user_name, user_pass, user_type, name, email, contact) VALUES ('$username', '$password', '$userType', '$name', '$email', '$contact')";

        if ($conn->query($insertQuery) === TRUE) {
            $disp = 'Registration success! You can now log in.';
        } else {
            $disp = 'Registration Error: ' . $conn->error;
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Sign Up</title>
</head>
<body>
<div style="width:300px; margin:auto;">
    <fieldset>
        <legend>USER REGISTRATION</legend>
        <form method="post">
            <label>NAME</label><br/>
            <input type="text" required="true" name="txtName" placeholder="Enter Your Name"/> <br/>
            <label>EMAIL</label><br/>
            <input type="email" required="true" name="txtEmail" placeholder="Enter Email (test@test.com)"/> <br/>
            <label>CONTACT</label><br/>
            <input type="text" required="true" name="txtContact" placeholder="Enter Contact Number"/> <br/>
            <label>USERNAME</label><br/>
            <input type="text" required="true" name="txtUname" placeholder="Enter Username"/> <br/>
            <label>PASSWORD</label><br/>
            <input type="password" required="true" name="txtUpass" placeholder="Enter Password"/> <br/><br/>
            <select name="userType">
                <option value="1">Staff</option>
                <option value="2">Guest</option>
            </select><br/><br/>
            <input type="submit" name="btnSignup" value="Sign Up"/><br/>
            <?php echo $disp; ?>
        </form>
    </fieldset>

    <form action="login.php" method="get">
        <input type="submit" value="Back to Login Page"/>
    </form>
</div>
</body>
</html>