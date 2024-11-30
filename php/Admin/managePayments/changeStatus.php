<?php
    include '../../connection.php';
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }

    if (isset($_GET['id']) && isset($_GET['payment_status'])) {
        $payment_id = intval($_GET['id']);
        $new_status = $_GET['payment_status'];

        $valid_statuses = ['paid', 'unpaid', 'refunded'];
        if (!in_array($new_status, $valid_statuses)) {
            echo "Invalid status.";
            exit();
        }

        $sql = "UPDATE payments SET payment_status = ? WHERE payment_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_status, $payment_id);

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
