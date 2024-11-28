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

    $sql = "SELECT * FROM appointments WHERE appointment_id = $appointment_id";
    $result = $conn->query($sql);

    if ($result->num_rows === 0) {
        echo "Appointment not found.";
        exit();
    }

    $appointment = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_date = $_POST['new_date'];
        $new_start_time = $_POST['new_start_time'];
        $new_end_time = $_POST['new_end_time'];

        $update_sql = "UPDATE appointments 
                    SET appointment_date = '$new_date', start_time = '$new_start_time', end_time = '$new_end_time', status = 'pending'
                    WHERE appointment_id = $appointment_id";

        if ($conn->query($update_sql) === TRUE) {
            echo "Appointment rescheduled successfully!";
            header("Location: ../index.php");
            exit();
        } else {
            echo "Error updating appointment: " . $conn->error;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reschedule Appointment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h1>Reschedule Appointment</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="new_date" class="form-label">New Date</label>
                <input type="date" class="form-control" id="new_date" name="new_date" value="<?php echo $appointment['appointment_date']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="new_start_time" class="form-label">New Start Time</label>
                <input type="time" class="form-control" id="new_start_time" name="new_start_time" value="<?php echo $appointment['start_time']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="new_end_time" class="form-label">New End Time</label>
                <input type="time" class="form-control" id="new_end_time" name="new_end_time" value="<?php echo $appointment['end_time']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Reschedule</button>
            <a href="../userDashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
