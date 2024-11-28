<?php
include '../../connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $appointment_id = intval($_GET['id']);
    $new_status = $_GET['status'];

    $valid_statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
    if (!in_array($new_status, $valid_statuses)) {
        echo "Invalid status.";
        exit();
    }

    $sql = "UPDATE appointments SET status = ? WHERE appointment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_status, $appointment_id);

    if ($stmt->execute()) {
        echo "Status updated successfully.";
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error updating status: " . $conn->error;
    }
    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
