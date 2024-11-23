<?php
    include '../connection.php';

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $name = $_POST['name'];
        $description = $_POST['description'];
        $duration = $_POST['duration'];
        $price = $_POST['price'];
        $image = $_POST['image'];
    }

    if(!empty($name)&& !empty ($description)&& !empty ($duration)&& !empty ($price)&& !empty ($image)){
        $sql= "INSERT INTO services (service_name, description, duration, price, image_path) VALUES ('$name','$description','$duration','$price','$image')";

        if($conn->query($sql)=== TRUE){
            echo "<h3 class='h3 mt-5 text-center'>New service added sucessfully!</h3>";
        }
        else{
            echo "Failed to add new service";
        }
    }
    else{
        echo " <h3 class='text-center mt-5'>Please fill all the fields</h1>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container border mt-5 p-5">
        <form action="add.php" method="POST">
            <label for="name" class="form-label fw-semibold">ServiceName:</label>
            <input type="text" class="form-control " id="name" name="name">

            <label for="description" class="form-label fw-semibold">Description:</label>
            <input type="text" class="form-control" id="description" name="description">

            <label for="duration" class="form-label fw-semibold">Duration:</label>
            <input type="number" class="form-control" id="duration" name="duration">

            <label for="price" class="form-label fw-semibold">Price:</label>
            <input type="number" class="form-control" id="price" name="price">

            <label for="image" class="form-label fw-semibold">Image Path:</label>
            <input type="text" class="form-control" id="image" name="image">

            <input type="submit" value ="Add Service" class="btn btn-primary mt-5">
        </form>
        <a href="../../Admin" class="btn btn-primary">Back</a>
    </div>
</body>
</html>