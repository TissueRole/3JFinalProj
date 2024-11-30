<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['therapist_id'])) {
    $therapist_id = $_POST['therapist_id'];

    $query = "SELECT * FROM availability WHERE therapist_id = $therapist_id";
    $result = $conn->query($query);

    $availability = [];
    while ($row = $result->fetch_assoc()) {
        $availability[] = [
            'date' => $row['date'],
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time']
        ];
    }

    echo json_encode($availability);
    exit;
}
?>
