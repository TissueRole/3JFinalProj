<?php
    include '../connection.php';

    $sql = "SELECT * FROM services";
    $result = $conn->query($sql);

    $sql2 = "SELECT * FROM users WHERE role = 'therapist'";
    $result2 = $conn->query($sql2);
    
    $sql3 = "SELECT * FROM availability";
    $result3 = $conn->query($sql3);

    $availabilityDate = [];
    $availabilityTime = [];
    if ($result3->num_rows > 0) {
        while ($row = $result3->fetch_assoc()) {
            $availabilityDate[$row['therapist_id']][] = $row['date'];
            $availabilityTime[$row['therapist_id']][] = "{$row['start_time']} - {$row['end_time']}";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <ul class="nav bg-primary fixed-top mb-5 p-2 nav-underline ps-5">
        <li class="nav-item ">
            <a class="nav-link text-white" aria-current="page" href="#Services">Manage Services</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" aria-current="page" href="#">Manage Bookings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" aria-current="page" href="#therapistSched">Therapist Schedule Management</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" aria-current="page" href="#">Payment and Reports</a>
        </li>
        <li class="nav-item d-flex justify-content-end ms-auto me-5">
            <a href="../logout.php" class="btn text-white">Log Out</a>
        </li>
    </ul>
    <div class="container my-5 p-5" id="Services">
        <h1 class="fs-3 mb-2">Manage Services:</h1>
        <div>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Duration</th>
                    <th scope="col">Price</th>
                    <th scope="col">Type</th>
                    <th scope="col">Image</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Updated at</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </thead>
                <tbody>
                <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['service_id']}</td>
                                    <td>{$row['service_name']}</td>
                                    <td>{$row['description']}</td>
                                    <td>{$row['duration']} mins</td>
                                    <td>$".$row['price']."</td>
                                    <td>{$row['type']}</td>
                                    <td>{$row['image_path']}</td>
                                    <td>{$row['created_at']}</td>
                                    <td>{$row['updated_at']}</td>
                                    <td><a href='manageServices/edit.php?id={$row['service_id']}' class='btn btn-sm btn-warning'>Edit</a></td>
                                    <td><a href='manageServices/delete.php?id={$row['service_id']}' class='btn btn-sm btn-danger'>Delete</a></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center'>No services found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <a class="btn btn-primary" href="manageServices/add.php">Add New</a>
        </div>
    </div>
    <div class="container my-5 p-5" id="therapistSched">
        <h1 class="mb-4">Therapist Availability</h1>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                <th>Therapist Id</th>
                <th>Therapist Name</th>
                <th>Availabale Date</th>
                <th>Available Hours</th>
                <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result2->num_rows > 0) {
                    while ($therapist = $result2->fetch_assoc()) {

                        $therapistId = $therapist['user_id'];
                        $therapistName = $therapist['full_name'];

                        $availabilityDateStr = isset($availabilityDate[$therapistId]) && is_array($availabilityDate[$therapistId])
                            ? implode('<br>', $availabilityDate[$therapistId])
                            : "No availability Date";

                        $availabilityTimeStr = isset($availabilityTime[$therapistId]) && is_array($availabilityTime[$therapistId])
                            ? implode('<br>', $availabilityTime[$therapistId])
                            : "No availability Time";

                        echo "<tr>
                            <td>{$therapistId}</td>
                            <td>{$therapistName}</td>
                            <td>{$availabilityDateStr}</td>
                            <td>{$availabilityTimeStr}</td>
                            <td>
                                <a class='btn btn-primary btn-sm' href='manageAvailability/edit.php' data-bs-toggle='modal' data-bs-target='#editAvailabilityModal' data-id='{$therapistId}' data-name='{$therapistName}'>Edit Hours</a>
                                <a class='btn btn-success btn-sm' href='manageAvailability/add.php' data-bs-toggle='modal' data-bs-target='#addAvailabilityModal' data-id='{$therapistId}' data-name='{$therapistName}'>Add Hours</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No therapists found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="editAvailabilityModal" tabindex="-1" aria-labelledby="editAvailabilityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAvailabilityModalLabel">Edit Availability</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="manageAvailability/edit.php" method="POST">
                        <input type="hidden" name="therapist_id" id="editTherapistId">
                        <div class="mb-3">
                            <label for="editDays" class="form-label">Days</label>
                            <input type="date" class="form-control" id="editDays" name="day" placeholder="Date">
                        </div>
                        <div class="mb-3">
                            <label for="starHours" class="form-label">Start Time:</label>
                            <input type="time" class="form-control" id="startHours" name="start" placeholder="Start Hour">
                            <label for="endHours" class="form-label">End Time:</label>
                            <input type="time" class="form-control" id="endHours" name="end" placeholder="End Hour">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addAvailabilityModal" tabindex="-1" aria-labelledby="addAvailabilityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAvailabilityModalLabel">Add Availability</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="manageAvailability/add.php" method="POST">
                    <input type="hidden" name="therapist_id" id="addTherapistId">
                    <div class="mb-3">
                        <label for="addDays" class="form-label">Day</label>
                        <input type="date" class="form-control" id="addDays" name="day" placeholder="Date">
                    </div>
                    <div class="mb-3">
                        <label for="startHours" class="form-label">Start Time:</label>
                        <input type="time" class="form-control" id="startHours" name="start" placeholder="Start Hour">
                        <label for="endHours" class="form-label">End Time:</label>
                        <input type="time" class="form-control" id="endHours" name="end" placeholder="End Hour">
                    </div>
                    <button type="submit" class="btn btn-success">Add Availability</button>
                </form>
            </div>
        </div>
    </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var editModal = document.getElementById('editAvailabilityModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var therapistId = button.getAttribute('data-id');
        var therapistName = button.getAttribute('data-name');
        document.getElementById('editTherapistId').value = therapistId;
    });

    var addModal = document.getElementById('addAvailabilityModal');
    addModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var therapistId = button.getAttribute('data-id');
        document.getElementById('addTherapistId').value = therapistId;
    });
  </script>
</body>
</html>