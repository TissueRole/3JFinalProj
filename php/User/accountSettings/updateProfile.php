<?php
    include '../../connection.php';
    session_start();
    
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../../login.php");
        exit();
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_SESSION['user_id'];
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $phone = $conn->real_escape_string($_POST['phone']);
    
        $sql = "UPDATE users SET full_name = '$name', email = '$email', phone_number = '$phone' WHERE user_id = $user_id";
    
        if ($conn->query($sql) === TRUE) {
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;
            header("Location: ../index.php");
        } else {
            echo "Error updating profile: " . $conn->error;
        }
    }

?>