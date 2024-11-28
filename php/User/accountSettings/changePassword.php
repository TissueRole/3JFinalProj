<?php 
error_reporting(E_ALL);  
ini_set('display_errors', 1); 
     include '../../connection.php';
     session_start();
     
     if (!isset($_SESSION['user_id'])) {
         header("Location: ../../login.php");
         exit();
     }

     $user_id = $_SESSION['user_id']; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
    
        $password_sql = "SELECT password FROM users WHERE user_id = $user_id";
        $password_result = $conn->query($password_sql);
        $password_data = $password_result->fetch_assoc();
    
        if ($password_data && $password_data['password'] === $current_password) { 
            if ($new_password === $confirm_password) {
                $update_password_sql = "UPDATE users SET password = '$new_password' WHERE user_id = $user_id";
    
                if ($conn->query($update_password_sql) === TRUE) {
                    $password_message = "Password updated successfully.";
                    header("Location: ../index.php"); 
                    exit(); 
                } else {
                    $password_message = "Error updating password: " . $conn->error;
                }
            } else {
                echo "New password do not match"
                $password_message = "New passwords do not match.";
            }
        } else {
            echo "Current password Incorrect"
            $password_message = "Current password is incorrect.";
        }
    }
?>
