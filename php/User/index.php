<?php

include '../connection.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM users WHERE user_id = {$_SESSION['user_id']}";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User details not found.";
    exit();
}

$sql1 = "
    SELECT 
        appointments.appointment_id, 
        services.service_name, 
        users.full_name AS therapist_name, 
        appointments.appointment_date, 
        appointments.start_time, 
        appointments.end_time, 
        appointments.status
    FROM appointments
    JOIN services ON appointments.service_id = services.service_id
    JOIN users ON appointments.therapist_id = users.user_id AND users.role = 'therapist'
    WHERE appointments.user_id = {$_SESSION['user_id']}
    AND appointments.status IN ('pending', 'approved');
";
$result1 = $conn->query($sql1);

$sql2 = "
    SELECT 
        appointments.appointment_id, 
        services.service_name, 
        users.full_name AS therapist_name, 
        appointments.appointment_date, 
        appointments.start_time, 
        appointments.end_time, 
        appointments.status
    FROM appointments
    JOIN services ON appointments.service_id = services.service_id
    JOIN users ON appointments.therapist_id = users.user_id AND users.role = 'therapist'
    WHERE appointments.user_id = {$_SESSION['user_id']} 
    AND appointments.appointment_date < CURDATE()
    AND appointments.status = 'completed';
";
$result2 = $conn->query($sql2);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Therapy Booking</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav> 

    <div class="container my-5 p-5" id="Services">
        <h1 class="fs-3 mb-2">Upcoming Appointments:</h1>
        <div>
            <table class="table table-striped table-bordered">
                <thead class="table-primary">
                    <th scope="col">Id</th>
                    <th scope="col">Service</th>
                    <th scope="col">Therapist</th>
                    <th scope="col">Date</th>
                    <th scope="col">Start</th>
                    <th scope="col">End</th>
                    <th scope="col">Status</th>
                    <th scope="col">Reschedule</th>
                    <th scope="col">Cancel</th>
                </thead>
                <tbody>
                <?php
                    if ($result1->num_rows > 0) {
                        while ($row = $result1->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['appointment_id']}</td>
                                    <td>{$row['service_name']}</td>
                                    <td>{$row['therapist_name']}</td>
                                    <td>{$row['appointment_date']}</td>
                                    <td>{$row['start_time']}</td>
                                    <td>{$row['end_time']}</td>
                                    <td>{$row['status']}</td>
                                    <td><a href='manageServices/edit.php?id={$row['appointment_id']}' class='btn btn-sm btn-warning'>Reschedule</a></td>
                                    <td><a href='manageServices/delete.php?id={$row['appointment_id']}' class='btn btn-sm btn-danger'>Cancel</a></td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center'>No upcoming appointments.</td></tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container my-5 p-5" id="PastAppointments">
        <h1 class="fs-3 mb-2">Past Appointments:</h1>
        <div>
            <table class="table table-striped table-bordered">
                <thead class="table-danger">
                    <th scope="col">Id</th>
                    <th scope="col">Service</th>
                    <th scope="col">Therapist</th>
                    <th scope="col">Date</th>
                    <th scope="col">Start</th>
                    <th scope="col">End</th>
                    <th scope="col">Status</th>
                </thead>
                <tbody>
                <?php
                    if ($result2->num_rows > 0) {
                        while ($row = $result2->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['appointment_id']}</td>
                                    <td>{$row['service_name']}</td>
                                    <td>{$row['therapist_name']}</td>
                                    <td>{$row['appointment_date']}</td>
                                    <td>{$row['start_time']}</td>
                                    <td>{$row['end_time']}</td>
                                    <td>{$row['status']}</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>No past appointments.</td></tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h5>Account Settings</h5>
            </div>
            <div class="card-body">
                <h5>Profile</h5>
                <form action="accountSettings/updateProfile.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['full_name']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone_number']); ?>">
                    </div>
                    <button type="submit" class="btn btn-success">Update Profile</button>
                </form>
                <hr>

                <h5>Change Password</h5>
                <form action="accountSettings/changePassword.php" method="POST">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password">
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password">
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                    </div>
                    <button type="submit" class="btn btn-primary" name="change_password">Change Password</button>
                </form>
            </div>
        </div>
    </div>  
</body>
</html>
