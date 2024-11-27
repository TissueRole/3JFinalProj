<?php
include '../../connection.php';

if (!isset($_POST['therapist_id'])) {
    echo "Therapist ID is missing.<br>";
}
if (!isset($_POST['day'])) {
    echo "Date is missing.<br>";
}
if (!isset($_POST['start'])) {
    echo "Start time is missing.<br>";
}
if (!isset($_POST['end'])) {
    echo "End time is missing.<br>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $therapist_id = isset($_POST['therapist_id']) ? $_POST['therapist_id'] : null;
    $available_date = isset($_POST['day']) ? $_POST['day'] : null;
    $start_time = isset($_POST['start']) ? $_POST['start'] : null;
    $end_time = isset($_POST['end']) ? $_POST['end'] : null;

    if ($therapist_id && $available_date && $start_time && $end_time) {

        $therapist_id = intval($therapist_id);
        $available_date = mysqli_real_escape_string($conn, $available_date);
        $start_time = mysqli_real_escape_string($conn, $start_time);
        $end_time = mysqli_real_escape_string($conn, $end_time);


        $check_sql = "SELECT * FROM availability WHERE therapist_id = $therapist_id AND date = '$available_date'";
        $check_result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            echo "<h1>This therapist already has availability for the selected date.</h1>";
        } else {
            $insert_sql = "INSERT INTO availability (therapist_id, date, start_time, end_time) 
                           VALUES ($therapist_id, '$available_date', '$start_time', '$end_time')";

            if (mysqli_query($conn, $insert_sql)) {
                echo "Availability added successfully!";
                header("Location: ../index.php#therapistSched");

            } else {
                echo "Error adding availability: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Please provide all required fields: Therapist ID, Date, Start Time, and End Time.";
    }
} else {
    echo "Invalid request method.";
}
?>
