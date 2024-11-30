<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

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
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="User/index.php">Account</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../">Back</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5 pt-5 w-50">
        <div class="container p-5 border">
            <h2 class="text-center mb-5">Book Your Appointment</h2>
            <form id="bookingForm" action="confirmBooking.php" method="POST">
                <div id="step1" class="step">
                    <h5 class="fs-3 mb-4">Step 1: Select Service and Therapist</h5>
                    <div class="mb-3">
                        <label for="serviceSelect" class="form-label">Choose a Service</label>
                        <select id="serviceSelect" class="form-select" name="service_id">
                            <option value="">Select a service</option>
                            <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['service_id'] . '" data-price="' . $row['price'] . '" data-duration="' . $row['duration'] . '">'
                                            . $row['service_name'] . ' | $' . $row['price'] . ' | Duration: ' . $row['duration'] . ' minutes</option>';
                                    }
                                } else {
                                    echo '<option value="">No services available</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="therapistSelect" class="form-label">Preferred Therapist</label>
                        <select id="therapistSelect" class="form-select" name="therapist_id">
                            <option value="">Select a Therapist</option>
                            <?php
                                if ($result2->num_rows > 0) {
                                    while ($row = $result2->fetch_assoc()) {
                                        echo '<option value="' . $row['user_id'] . '">' . $row['full_name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No therapists available</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary w-100" onclick="nextStep()">Next</button>
                </div>
                <div id="step2" class="step d-none">
                    <h5 class="fs-3 mb-4">Step 2: Choose Date and Time</h5>
                    <div class="mb-3">
                        <label for="dateSelect" class="form-label">Select Date</label>
                        <select id="dateSelect" class="form-select" name="appointment_date">
                            <option value="">Select an available date</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="timeSlots" class="form-label">Available Time Slots</label>
                        <select id="timeSlots" class="form-select" name="start_time">
                            <option value="">Select a time slot</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">Back</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>
                </div>
                <div id="step3" class="step d-none">
                    <h5 class="fs-3 mb-4">Step 3: Confirmation and Payment</h5>
                    <div id="appointmentSummary" class="alert alert-secondary">
                        <strong class="fs-4 mb-3">Appointment Summary</strong>
                        <p><strong>Service:</strong> <span id="summaryService"></span></p>
                        <p><strong>Therapist:</strong> <span id="summaryTherapist"></span></p>
                        <p><strong>Date:</strong> <span id="summaryDate"></span></p>
                        <p><strong>Start Time:</strong> <span id="summaryStartTime"></span></p>
                        <p><strong>End Time:</strong> <span id="summaryEndTime"></span></p>
                        <p><strong>Price:</strong> $<span id="summaryPrice"></span></p>
                        <input type="hidden" name="end_time" id="end_time">
                    </div>
                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Payment Method</label>
                        <select id="paymentMethod" class="form-select" name="payment_method">
                            <option value="Cash">Cash</option>
                            <option value="Credit Card">Credit Card</option>
                            <option value="PayPal">PayPal</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-secondary mb-3" onclick="prevStep()">Back</button>
                    <button type="submit" class="btn btn-success w-100">Confirm Appointment</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentStep = 1;

        function nextStep() {
            if (currentStep === 1) {
                const therapistSelect = document.getElementById('therapistSelect');
                if (!therapistSelect.value) {
                    alert('Please select a therapist and service before proceeding.');
                    return;
                }
            } else if (currentStep === 2) {
                const dateSelect = document.getElementById('dateSelect');
                const timeSlots = document.getElementById('timeSlots');

                if (!dateSelect.value) {
                    alert('Please select a date before proceeding.');
                    return;
                }

                if (!timeSlots.value) {
                    alert('Please select a time slot before proceeding.');
                    return;
                }
                updateSummary();
            }

            document.getElementById(`step${currentStep}`).classList.add('d-none');
            currentStep++;
            document.getElementById(`step${currentStep}`).classList.remove('d-none');
        }


        function prevStep() {
            document.getElementById(`step${currentStep}`).classList.add('d-none');
            currentStep--;
            document.getElementById(`step${currentStep}`).classList.remove('d-none');
        }

        document.getElementById('therapistSelect').addEventListener('change', function () {
        const therapistId = this.value;
        const dateSelect = document.getElementById('dateSelect');
        const timeSlots = document.getElementById('timeSlots');

        fetch('booking_date.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `therapist_id=${therapistId}`
        })
        .then(response => response.json())
        .then(data => {
            console.log('Availability data:', data); 

            dateSelect.innerHTML = '<option value="">Select an available date</option>';
            timeSlots.innerHTML = '<option value="">Select a time slot</option>';

            console.log('Date Select:', dateSelect.value); // Debugging log
        console.log('Time Slots:', timeSlots.value); // Debugging log


            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.date;
                option.textContent = item.date;
                dateSelect.appendChild(option);
            });

            dateSelect.onchange = function () {
                const selectedDate = this.value;
                const availability = data.find(item => item.date === selectedDate);

                if (availability) {
                    const startTime = availability.start_time;
                    const endTime = availability.end_time;

                    console.log('Start Time:', startTime, 'End Time:', endTime); 

                    const slots = generateTimeSlots(startTime, endTime, 90); 
                    console.log('Generated slots:', slots); 
                    timeSlots.innerHTML = '<option value="">Select a time slot</option>';
                    slots.forEach(slot => {
                        const option = document.createElement('option');
                        option.value = slot;
                        option.textContent = slot;
                        timeSlots.appendChild(option);
                    });
                } else {
                    timeSlots.innerHTML = '<option value="">No slots available</option>';
                }
            };
        })
        .catch(error => console.error('Error fetching availability:', error));
    });

    function generateTimeSlots(start, end, intervalMinutes) {
        const slots = [];
        let [startHour, startMinute] = start.split(':').map(Number);
        let [endHour, endMinute] = end.split(':').map(Number);

        const startTime = new Date();
        startTime.setHours(startHour, startMinute, 0);

        const endTime = new Date();
        endTime.setHours(endHour, endMinute, 0);

        while (startTime < endTime) {
            const hour = String(startTime.getHours()).padStart(2, '0');
            const minute = String(startTime.getMinutes()).padStart(2, '0');
            slots.push(`${hour}:${minute}`);

            startTime.setMinutes(startTime.getMinutes() + intervalMinutes);
        }

        return slots;
    }

    function updateSummary() {
        const serviceSelect = document.getElementById('serviceSelect');
        const therapistSelect = document.getElementById('therapistSelect');
        const dateSelect = document.getElementById('dateSelect');
        const timeSlots = document.getElementById('timeSlots');

        const summaryService = document.getElementById('summaryService');
        const summaryTherapist = document.getElementById('summaryTherapist');
        const summaryDate = document.getElementById('summaryDate');
        const summaryStartTime = document.getElementById('summaryStartTime');
        const summaryEndTime = document.getElementById('summaryEndTime');
        const summaryPrice = document.getElementById('summaryPrice');

        const serviceName = serviceSelect.options[serviceSelect.selectedIndex].text;
        const serviceDuration = parseInt(serviceSelect.options[serviceSelect.selectedIndex].getAttribute('data-duration'));
        const therapistName = therapistSelect.options[therapistSelect.selectedIndex].text;
        const selectedDate = dateSelect.value;
        const selectedTime = timeSlots.value;

        summaryService.textContent = serviceName;
        summaryTherapist.textContent = therapistName;
        summaryDate.textContent = selectedDate;
        summaryPrice.textContent = serviceSelect.options[serviceSelect.selectedIndex].dataset.price;

        const startTime = new Date(`${selectedDate} ${selectedTime}`);
        const endTime = new Date(startTime.getTime() + serviceDuration * 60000); 

        const startHours = startTime.getHours() % 12 || 12;
        const startMinutes = String(startTime.getMinutes()).padStart(2, '0');
        const startPeriod = startTime.getHours() >= 12 ? 'PM' : 'AM';
        const formattedStartTime = `${startHours}:${startMinutes} ${startPeriod}`;

        const endHours = endTime.getHours() % 12 || 12;
        const endMinutes = String(endTime.getMinutes()).padStart(2, '0');
        const endPeriod = endTime.getHours() >= 12 ? 'PM' : 'AM';
        const formattedEndTime = `${endHours}:${endMinutes} ${endPeriod}`;

        summaryStartTime.textContent = formattedStartTime;
        summaryEndTime.textContent = formattedEndTime;
        document.getElementById('end_time').value = endTime.toTimeString().split(' ')[0];
    }
    document.getElementById('bookingForm').addEventListener('submit', function() {
        updateSummary();
    });


    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
