<?php
    include 'connection.php';

    $sql = "SELECT * FROM services"; 
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Therapy Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-2 ms-5 me-1 py-5 px-4 border">
            <h5>Filters</h5>
            <form>
                <div class="mb-3">
                    <label for="serviceType" class="form-label">Service Type</label>
                    <select id="serviceType" class="form-select">
                        <option value="">All</option>
                        <option value="One-on-One">One-on-One</option>
                        <option value="Couples">Couples</option>
                        <option value="Group">Group</option>
                        <option value="Virtual">Virtual</option>
                    </select>
                </div>
                    <div class="mb-3">
                    <label for="priceRange" class="form-label">Price Range</label>
                    <select id="priceRange" class="form-select">
                        <option value="">All</option>
                        <option value="60-70">$60–$70</option>
                        <option value="71-80">$71–$80</option>
                        <option value="80-90">$81–$90</option>
                        <option value="100-150">$100-$150/option>
                    </select>
                    </div>

                <div class="mb-3">
                    <label for="duration" class="form-label">Duration</label>
                    <select id="duration" class="form-select">
                        <option value="">All</option>
                        <option value="30-60">30–60 minutes</option>
                        <option value="45-90">45–90 minutes</option>
                        <option value="60-75">60–75 minutes</option>
                        <option value="60-90">60–90 minutes</option>
                    </select>
                </div>
            </form>
            <div class="col-md-1">
            <div class="mb-3 ms-2">
                <select id="sortOptions" class="form-select w-auto">
                    <option value="">Sort by</option>
                    <option value="popularity">Popularity</option>
                    <option value="price">Price</option>
                    <option value="duration">Duration</option>
                </select>
            </div>
        </div>
        </div>
            <?php
                if($result->num_rows > 0){
                    $counter = 0;
                    echo '<div class="col-md-8 p-5">'; // 2nd column
                    while($row = $result-> fetch_assoc()){
                        if($counter%3 == 0){
                            echo '<div class="row gap-4 mb-4">'; // row
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
                                <p class="card-text"><strong>Duration: </strong>{$row['duration']}</p>
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
