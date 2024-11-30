<?php
session_start();
include 'connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $userId = $_SESSION['user_id'];
    $therapistId = $_POST['therapist_id'];
    $serviceId = $_POST['service_id'];
    $appointmentDate = $_POST['appointment_date'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $paymentMethod = $_POST['payment_method'];
    $transactionId = uniqid('txn_', true); 

    $query = "SELECT price FROM services WHERE service_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $serviceId);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($price);
    $stmt->fetch();
    $stmt->close();

    $query = "INSERT INTO appointments (user_id, therapist_id, service_id, appointment_date, start_time, end_time, status, created_at) 
              VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiisss", $userId, $therapistId, $serviceId, $appointmentDate, $startTime, $endTime);
    $stmt->execute();
    $appointmentId = $stmt->insert_id;
    $stmt->close();

    $query = "INSERT INTO payments (appointment_id, amount, payment_method, payment_status, transaction_id, payment_date) 
              VALUES (?, ?, ?, 'unpaid', ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("idss", $appointmentId, $price, $paymentMethod, $transactionId);
    $stmt->execute();
    $stmt->close();

    header("Location: User/index.php");
    exit();
}
?>
