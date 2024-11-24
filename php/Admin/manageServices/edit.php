<?php
    include '../../connection.php';

    if (isset($_GET['id'])){
        $id =$_GET['id'];

        $sql = "SELECT * FROM services WHERE service_id = $id";
        $result=$conn->query($sql);

        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $name = $row ['service_name'];
            $description = $row ['description'];
            $duration = $row ['duration'];
            $price = $row ['price'];
            $type = $row ['type'];
            $image = $row ['image_path'];
            $update = $row ['updated_at'];
        }
        else{
            echo "No movie found";
        }
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $name = $_POST['name'];
        $description = $_POST['description'];
        $duration = $_POST['duration'];
        $price = $_POST['price'];
        $type = $_POST['type'];
        $image = $_POST['image'];
        $id= $_POST['id'];

        if(!empty($name)&& !empty($description)&& !empty($duration)&& !empty($price)&& !empty($type)&& !empty($image)){
            $sql ="UPDATE services SET service_name='$name', description='$description', duration= '$duration', price= '$price', type='$type',image_path ='$image', updated_at=CURRENT_TIMESTAMP  WHERE service_id='$id'";
            
            if($conn->query($sql)=== TRUE){
                echo "<h1 class='text-center fs-3 mt-5'>Service updated sucessfully!</h1>";
                header("Location: ../index.php");
            }
            else{
                echo "Update Failed";
            }
        }
        else{
            echo "<h1 class='text-center fs-3 mt-5'>Fill all the fields!</h1>";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container border mt-5 p-5">
        <form action="edit.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>"> 

            <label for="name" class="form-label fw-semibold">ServiceName:</label>
            <input type="text" class="form-control " id="name" name="name" value="<?php echo $name; ?>">

            <label for="description" class="form-label fw-semibold">Description:</label>
            <input type="text" class="form-control" id="description" name="description" value="<?php echo $description; ?>">

            <label for="duration" class="form-label fw-semibold">Duration:</label>
            <input type="number" class="form-control" id="duration" name="duration" value="<?php echo $duration; ?>">

            <label for="price" class="form-label fw-semibold">Price:</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo $price; ?>">

            <label for="type" class="form-label fw-semibold">Type:</label>
            <input type="text" class="form-control" id="type" name="type" value="<?php echo $type; ?>">

            <label for="image" class="form-label fw-semibold">Image Path:</label>
            <input type="text" class="form-control" id="image" name="image" value="<?php echo $image; ?>">

            <input type="submit" value ="Edit" class="btn btn-primary mt-5">
        </form>
        <a href="../../Admin" class="btn btn-primary mt-5">Back</a>
    </div>
</body>
</html>