<?php
    include 'connection.php';

    $sql = "SELECT * FROM services Where 1";

    $serviceType = isset($_POST['serviceType']) ? $_POST['serviceType'] :'';
    $serviceRange = isset($_POST['serviceRange']) ? $_POST['serviceRange'] :'';
    $serviceDuration = isset($_POST['serviceDuration']) ? $_POST['serviceDuration'] :'';
    $sortOption = isset($_POST['sortOption']) ? $_POST['sortOption'] : '';

    if($serviceType != ''){
        $sql .= " AND type = '$serviceType'";
    }

    if ($serviceRange != '') {
        list($minPrice, $maxPrice) = explode('-', $serviceRange);
        if (is_numeric($minPrice) && is_numeric($maxPrice)) {
            $sql .= " AND price BETWEEN $minPrice AND $maxPrice";
        }
    }
    
    if ($serviceDuration != '') {
        list($minDuration, $maxDuration) = explode('-', $serviceDuration);
        if (is_numeric($minDuration) && is_numeric($maxDuration)) {
            $sql .= " AND duration BETWEEN $minDuration AND $maxDuration";
        }
    }

    if ($sortOption != '') {
        if ($sortOption == 'price') {
            $sql .= " ORDER BY price ASC";
        } elseif ($sortOption == 'duration') {
            $sql .= " ORDER BY duration ASC";
        }
    }

    $result = $conn->query($sql);
    if ($result === false) {
    die("Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Therapy Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script>
    function autoSubmitForm() {
        document.getElementById('filterForm').submit();
    }
  </script>
</head>
<body>
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-2 ms-5 me-1 py-5 px-4 border">
            <h5>Filters</h5>
            <form method="POST" action ="servicepage.php" id="filterForm">
                <div class="mb-3">
                    <label for="serviceType" class="form-label">Service Type</label>
                    <select id="serviceType" class="form-select" name="serviceType" onchange="autoSubmitForm()">
                        <option value="">All</option>
                        <option value="One-on-One" <?= $serviceType == 'One-on-One' ? 'selected' : '' ?>>One-on-One</option>
                        <option value="Couples" <?= $serviceType == 'Couples' ? 'selected' : '' ?>>Couples</option>
                        <option value="Group" <?= $serviceType == 'Group' ? 'selected' : '' ?>>Group</option>
                        <option value="Virtual" <?= $serviceType == 'Virtual' ? 'selected' : '' ?>>Virtual</option>
                    </select>
                </div>
                    <div class="mb-3">
                    <label for="priceRange" class="form-label">Price Range</label>
                    <select id="priceRange" class="form-select" name="serviceRange" onchange="autoSubmitForm()">
                        <option value="">All</option>
                        <option value="60-70" <?= $serviceRange == '60-70' ? 'selected' : '' ?>>$60–$70</option>
                        <option value="71-80" <?= $serviceRange == '71-80' ? 'selected' : '' ?>>$71–$80</option>
                        <option value="81-99" <?= $serviceRange == '81-99' ? 'selected' : '' ?>>$81–$99</option>
                        <option value="100-150" <?= $serviceRange == '100-150' ? 'selected' : '' ?>>$100-$150</option>
                    </select>
                    </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">Duration</label>
                    <select id="duration" class="form-select" name="serviceDuration" onchange="autoSubmitForm()">
                        <option value="">All</option>
                        <option value="30-45" <?= $serviceDuration == '30-45' ? 'selected' : '' ?>>30-45 minutes</option>
                        <option value="46-60" <?= $serviceDuration == '46-60' ? 'selected' : '' ?>>46-60 minutes</option>
                        <option value="61-75" <?= $serviceDuration == '61-75' ? 'selected' : '' ?>>61-75 minutes</option>
                        <option value="76-90" <?= $serviceDuration == '76-90' ? 'selected' : '' ?>>76-90 minutes</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="sortOptions" class="form-label">Sort by</label>
                    <select id="sortOptions" class="form-select w-auto" name="sortOption" onchange="autoSubmitForm()">
                        <option value="">Sort by</option>
                        <option value="price" <?= $sortOption == 'price' ? 'selected' : '' ?>>Price</option>
                        <option value="duration" <?= $sortOption == 'duration' ? 'selected' : '' ?>>Duration</option>
                    </select>
                </div>
            </form>
        </div>
            <?php
                if($result->num_rows > 0){
                    $counter = 0;
                    echo '<div class="col-md-8 p-5">';
                    while($row = $result-> fetch_assoc()){
                        if($counter%3 == 0){
                            echo '<div class="row gap-4 mb-4">';
                        }
                        echo <<<HTML
                        <div class="card col d-flex flex-column">
                            <img src="{$row['image_path']}" class="card-img-top" alt="{$row['service_name']}">
                            <div class="card-body d-flex flex-column flex-grow-1">
                                <h6 class="card-title d-flex justify-content-between">
                                <span>{$row['service_name']}</span>
                                <span class="text-primary">\$${row['price']}</span>
                                </h6>
                                <p class="card-text">{$row['description']}</p>
                                <p class="card-text"><strong>Type: </strong>{$row['type']}</p>
                                <p class="card-text"><strong>Duration: </strong>{$row['duration']} Minutes</p>
                                <div class="mt-auto">
                                    <a href="booking-individual-therapy.html" class="btn btn-primary w-100">Book Now</a>
                                </div>
                            </div>
                        </div>
                        HTML;
                        $counter++;
                        if($counter%3 == 0){
                            echo '</div>';
                        }
                    }
                    $remaining = 3 - ($counter % 3);
                    if ($remaining < 3) {
                        for ($i = 0; $i < $remaining; $i++) {
                            echo '<div class="col-md-4 mb-4"></div>';
                        }
                    }
                }
                else {
                    echo "No services found.";
                }
            ?>
            </div>
        </div>
    </div>
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
