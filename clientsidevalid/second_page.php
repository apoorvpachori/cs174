<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include user_functions for handling login and signup
include 'login.php';

$email = '';
$password = '';
$username = '';
$studentId = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (authenticateUser($email, $password)) {
            header('Location: first_page.php');
            exit();
        } else {
            $loginError = 'Could not find your user. Please try again.';
            exit();
        }
    } elseif (isset($_POST['signup'])) {
        $username = $_POST['name'];
        $studentId = $_POST['studentId'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        //sign the user up, function in login.pho
        if (signupUser($username, $studentId, $email, $password)) {
            header('Location: first_page.php');
        } else {
            $signupError = 'Signup failed. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login and Signup</title>
    <script>
        function validateSignup(form) {
            if (validateName(form.name.value) &&
                validateStudentID(form.studentId.value) &&
                validateEmail(form.email.value) &&
                validatePassword(form.password.value)) {
                return true;
            };
            return false;
        }

        //basic client side validation using javascript
        function validateLogin(form) {
            if (validateEmail(form.login_email.value) && validatePassword(form.login_password.value)) {
                return true;
            }
            return false;
        }

        function validateName(name) {
            if (name === "") return false;
            return true;
        }

        function validateStudentID(studentID) {
            if (studentID === "") return false;
            return true;
        }

        function validateEmail(email) {
            if (email === "") return false;
            if (!/^\S+@\S+\.\S+$/.test(email)) return false;
            return true;
        }

        function validatePassword(password) {
            if (password === "") return false;
            if (password.length < 4) return false;
            // Add any additional password validation rules if needed
            return true;
        }
    </script>

</head>

<body>
    <h1>Login</h1>
    <form method="post" action="" onsubmit="return validateLogin(this);">
        <input type="email" name="login_email" placeholder="Email" required value="<?= $email ?>"><br>
        <input type="password" name="login_password" placeholder="Password" required><br>
        <input type="submit" name="login" value="Login">
        <?php if (isset($loginError)): ?>
            <p style="color: red;">
                <?= $loginError ?>
            </p>
        <?php endif; ?>
    </form>

    <h1>Signup</h1>
    <form method="post" action="" onsubmit="return validateSignup(this);">
        <input type="text" name="name" placeholder="Name" required value="<?= $username ?>"><br>
        <input type="text" name="studentId" placeholder="Student ID" required value="<?= $studentId ?>"><br>
        <input type="email" name="email" placeholder="Email" required value="<?= $signupEmail ?>"><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" name="signup" value="Signup">
    </form>
</body>

</html>