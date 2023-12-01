<?php

//login.php has all the funcitons to do with the database
//and the database connection. it is included in
//first_page.php and second_page.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
// connecting to local database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "auth_data";

// Establish database connection
$db = new mysqli($servername, $username, $password, $dbname);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

//fun to check check if user logged in or not
function isUserAuthenticated()
{
    return isset($_SESSION['user_id']) && $_SESSION['user_id'] != '';
}

/**
 * Function to authenticate user login, returns result (true or false)
 */
function authenticateUser($email, $password)
{
    global $db;

    $query = "SELECT id, password FROM users WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            return true;
        }
    }
    return false;
}

/**
 * Function to log out user by killing the session
 */
function logoutUser()
{
    $_SESSION = array();
    session_destroy();
}

/**
 * Function to sign up a new user
 */
function signupUser($name, $student_id, $email, $password)
{
    global $db;

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (name, student_id, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ssss", $name, $student_id, $email, $hashedPassword);

    return $stmt->execute();
}
// Function to retrieve advisor info
function getAdvisorInfo($studentId)
{
    global $db;

    // SQL query to find the first advisor, limit to one result
    $query = "SELECT name, email FROM advisors WHERE ? BETWEEN lower_bound_id AND upper_bound_id LIMIT 1";

    $prep = $db->prepare($query);
    $prep->bind_param("s", $studentId);
    $result = $prep->get_result();
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// Add any additional user-related functions here
?>