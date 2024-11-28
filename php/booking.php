<?php

include 'connection.php';

$sql = "SELECT * FROM services";
$result = $conn->query($sql);

$sql2 = "SELECT * FROM users WHERE role = 'therapist'";
$result2 = $conn->query($sql2);

$sql3 = "SELECT * FROM availability";
$result3 = $conn->query($sql3);

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container-fluid border d-flex align-items-center justify-content-center vh-100">
    <div class="border container p-5">
        <h2 class="text-center mb-5 ">Book Your Appointment</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form id="bookingForm">
                    <div id="step1" class="step">
                        <h5 class="fs-3 mb-5">Step 1: Select Service and Therapist</h5>
                        <div class="mb-3">
                        <label for="serviceSelect" class="form-label fs-5">Choose a Service</label>
                        <select id="serviceSelect" class="form-select mb-5">
                            <option value="">Select a service</option>
                            <?php
                                if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['service_id']. '">' . $row['service_name'] . ' | $'. $row['price'] . '</option>';
                                    }
                                }else {
                                    echo "<tr><td colspan='9' class='text-center'>No services found.</td></tr>";
                                }
                            ?>
                        </select>
                        </div>
                        <div class="mb-3">
                            <label for="therapistSelect" class="form-label fs-5">Preferred Therapist</label>
                            <select id="therapistSelect" class="form-select mb-5">
                                <option value="">Select a Therapist</option>
                                <?php
                                    if ($result2->num_rows > 0) {
                                    while ($row = $result2->fetch_assoc()) {
                                        echo '<option value="' . $row['user_id']. '">' . $row['full_name'] . '</option>';
                                        }
                                    }else {
                                        echo "<tr><td colspan='9' class='text-center'>No services found.</td></tr>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div id="serviceSummary" class="alert alert-info d-none">
                            <strong>Service Summary:</strong>
                            <p id="serviceDetails"></p>
                        </div>
                        <button type="button" class="btn btn-primary w-100 mt-3" onclick="nextStep()">Next</button>
                    </div>
                    <div id="step2" class="step d-none">
                        <h5 class="fs-3 mb-5">Step 2: Choose Date and Time</h5>
                        <div class="mb-3">
                            <label for="datePicker" class="form-label">Select Date</label>
                            <input type="text" id="datePicker" class="form-control mb-5">
                        </div>
                        <div id="timeSlots" class="mt-3">
                            <label class="form-label">Available Time Slots</label>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-outline-secondary">10:00 AM</button>
                                <button type="button" class="btn btn-outline-secondary">11:30 AM</button>
                                <button type="button" class="btn btn-outline-secondary">02:00 PM</button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary" onclick="prevStep()">Back</button>
                            <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                        </div>
                    </div>
                    <div id="step3" class="step d-none">
                        <h5 class="fs-3 mb-5">Step 3: Confirmation and Payment</h5>
                        <div id="appointmentSummary" class="alert alert-secondary">
                            <p class="fs-5"><strong>Appointment Summary</strong></p>
                            <p><strong>Service:</strong> <span id="summaryService"></span></p>
                            <p><strong>Therapist:</strong> <span id="summaryTherapist"></span></p>
                            <p><strong>Date:</strong> <span id="summaryDate"></span></p>
                            <p><strong>Time:</strong> <span id="summaryTime"></span></p>
                            <p><strong>Price:</strong> <span id="summaryPrice"></span></p>
                        </div>
                        <div class="mb-3">
                            <label for="paymentMethod" class="form-label">Payment Method</label>
                            <select id="paymentMethod" class="form-select">
                                <option value="Cash">Cash</option>
                                <option value="Credit Card">Credit Card</option>
                                <option value="PayPal">PayPal</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="promoCode" class="form-label">Promo Code</label>
                            <input type="text" id="promoCode" class="form-control" placeholder="Enter promo code">
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary" onclick="prevStep()">Back</button>
                            <button type="submit" class="btn btn-success">Confirm Appointment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>

  <script>
    let currentStep = 1;

    function nextStep() {
      document.getElementById(`step${currentStep}`).classList.add('d-none');
      currentStep++;
      document.getElementById(`step${currentStep}`).classList.remove('d-none');
    }

    function prevStep() {
      document.getElementById(`step${currentStep}`).classList.add('d-none');
      currentStep--;
      document.getElementById(`step${currentStep}`).classList.remove('d-none');
    }

    document.getElementById('serviceSelect').addEventListener('change', function () {
      const service = this.value;
      const price = this.selectedOptions[0]?.text.split('|')[0];
      if (service) {
        document.getElementById('serviceSummary').classList.remove('d-none');
        document.getElementById('serviceDetails').innerText = `${service} - ${price}`;
      } else {
        document.getElementById('serviceSummary').classList.add('d-none');
      }
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
