<?php
    include 'connection.php';

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['number'];


        if (!empty($name) && !empty($email) && !empty($password) && !empty($phone)) {

            $sql = "INSERT INTO users (full_name, email, password, phone_number, role) VALUES ('$name', '$email', '$password', '$phone', 'customer')";

            if ($conn->query($sql) === TRUE) {
                echo "<h3 class='h3 mt-5 text-center'>Sign-up successful! Welcome, $name.</h3>";
                session_start();
                $_SESSION['user_id'] = $conn->insert_id;
                $_SESSION['name'] = $name;
                header("Location: ../user.html");
                exit();
            } else {
                echo "<h3 class='text-center mt-5'>Error: Could not complete registration. " . $conn->error . "</h3>";
            }
        } else {
            echo "<h3 class='text-center mt-5'>Please fill in all fields.</h3>";
        }
    }

    $conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Sign Up</h3>
                    </div>
                    <div class="card-body">
                        <form action="signup.php" method="POST" class="mb-3 p-3">
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="fullName" 
                                    name="name" 
                                    maxlength="100" 
                                    required 
                                    placeholder="Enter your full name">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input 
                                    type="email" 
                                    class="form-control" 
                                    id="email" 
                                    name="email" 
                                    maxlength="100" 
                                    required 
                                    placeholder="Enter your email">
                            </div>

                            <div class="mb-3">
                                <label for="phoneNumber" class="form-label">Phone Number</label>
                                <input 
                                    type="tel" 
                                    class="form-control" 
                                    id="phoneNumber" 
                                    name="number" 
                                    maxlength="15" 
                                    pattern="[0-9]+" 
                                    required 
                                    placeholder="Enter your phone number">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="password" 
                                    name="password" 
                                    minlength="8" 
                                    maxlength="255" 
                                    required 
                                    placeholder="Enter a strong password">
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="confirmPassword" 
                                    name="confirm_password" 
                                    minlength="8" 
                                    maxlength="255" 
                                    required 
                                    placeholder="Re-enter your password">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Sign Up</button>
                            </div>
                        </form>
                        <a href="php/login.php">Already have an account?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
