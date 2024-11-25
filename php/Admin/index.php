<?php
    include '../connection.php';

    $sql = "SELECT * FROM services";
    $result = $conn->query($sql);
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
            <a class="nav-link text-white" aria-current="page" href="#">Therapist Schedule Management</a>
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
                <thead>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>