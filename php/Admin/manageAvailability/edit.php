<?php

include '../../connection.php';

if (empty($_POST['therapist_id'])) {
    echo "Therapist ID is missing.<br>";
}
if (empty($_POST['day'])) {
    echo "Date is missing.<br>";
}
if (empty($_POST['start'])) {
    echo "Start time is missing.<br>";
}
if (empty($_POST['end'])) {
    echo "End time is missing.<br>";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $therapist_id = $_POST['therapist_id'];
    $date = $_POST['day'];
    $start_time = $_POST['start'];
    $end_time = $_POST['end'];

    if (!empty($therapist_id) && !empty($date) && !empty($start_time) && !empty($end_time)) {
        $sql = "UPDATE availability 
                SET start_time = ?, end_time = ? 
                WHERE therapist_id = ? AND date = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssis", $start_time, $end_time, $therapist_id, $date);

            if ($stmt->execute()) {
                echo "Availability updated successfully.";
                header("Location: ../index.php#therapistSched"); 
                exit();
            } else {
                echo "Error updating availability: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "All fields are required.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
