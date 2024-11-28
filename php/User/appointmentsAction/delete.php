<?php
    include '../../connection.php';
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    if (!isset($_GET['id'])) {
        echo "No appointment ID specified.";
        exit();
    }

    $appointment_id = intval($_GET['id']);

    $sql = "DELETE FROM appointments WHERE appointment_id = $appointment_id";

    if ($conn->query($sql) === TRUE) {
        echo "Appointment canceled successfully!";
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error deleting appointment: " . $conn->error;
    }
?>
