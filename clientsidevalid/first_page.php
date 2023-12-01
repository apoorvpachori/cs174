<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session 
session_start();

include 'login.php';

// Check if the user is authenticated
if (!isUserAuthenticated()) {
    // header('Location: second_page.php'); // Redirect to login/signup page
    // exit();
}

// Handle form submission
$advisorInfo = null;
$advisorNotFound = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['student_id'] ?? '';
    $advisorInfo = getAdvisorInfo($studentId);

    if (!$advisorInfo) {
        $advisorNotFound = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Advisor Information</title>
</head>

<body>
    <p>Welcome to the Student Advisor Portal</p>
    <p> If you aren't registered, you will be redirected to register </p>
    <form method="post" action="">
        <label for="student_name">Student Name:</label>
        <input type="text" id="student_name" name="student_name" required><br><br>

        <label for="student_id">Student ID:</label>
        <input type="text" id="student_id" name="student_id" required><br><br>

        <input type="submit" value="Search Advisor">
    </form>

    <?php if ($advisorInfo): ?>
        <h2>Advisor Information</h2>
        <p>Name:
            <?= htmlspecialchars($advisorInfo['name']) ?>
        </p>
        <p>Email:
            <?= htmlspecialchars($advisorInfo['email']) ?>
        </p>
    <?php elseif ($advisorNotFound): ?>
        <p>No advisor associated with Student ID.</p>
    <?php endif; ?>
</body>

</html>