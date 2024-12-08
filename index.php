<?php
  session_start(); 

  $isLoggedIn = isset($_SESSION['user_id']); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomiePage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/homepage.css">
</head>
<body>
      <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container-fluid px-5">
          <a class="navbar-brand ms-5 text-white fs-4" href="#">Tirapi</a>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <?php if ($isLoggedIn): ?>
                    <a class="nav-link fw-semibold text-white btn me-5" href="php/User/index.php">Account</a>
                <?php else: ?>
                    <a class="nav-link fw-semibold text-white btn me-5"  href="#">Home</a>
                <?php endif; ?>
              </li>
              <li class="nav-item">
                <a class="nav-link me-5 fw-semibold text-white" href="php/servicepage.php">Services</a>
              </li>
              <li class="nav-item me-5">
                <a class="nav-link fw-semibold text-white" href="#testimonials">Testimonials</a>
              </li>
              <li class="nav-item me-5">
                <?php if ($isLoggedIn): ?>
                  <a class="nav-link fw-semibold text-white btn" href="php/logout.php">Log Out</a>
                <?php else: ?>
                  <a class="nav-link fw-semibold text-white btn" href="php/login.php">Log In</a>
                <?php endif; ?>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <section class="hero-img d-flex align-items-center">
        <div class="container-fluid w-75">
            <h1 class="text-white display-1 fw-bold fst-italic text-shadow my-3">Welcome to Tirapi</h1>
            <p class="text-white fs-3 mb-5 ms-5 text-shadow">Where Your Well-Being Comes First. Let’s Take the First Step Together!"</p>
            <h3 class="text-white mb-5 ms-5 fs-1 fst-italic text-shadow">Your Path to Healing Starts Here <br>Book Your Therapy Session Today.</h3>
            <div class="pt-5">
                <a class="btn btn-primary mx-5 fs-4 fw-semibold" href="php/booking.php">Book Now</a>
                <a class="btn btn-primary me-5 fs-4 fw-semibold" href="php/servicepage.php">View Services</a>
            </div>
        </div>
      </section>
      <section class="linear-background" id="serviceOverview">
        <div class="container-fluid">
          <div class="row mx-5 p-5">
              <div class="col p-5 text-center d-flex align-items-center">
                <div>
                  <h1 class="text-center mb-5 text-white">Service Overview</h1>
                  <p class="fs-4 mb-4 mx-5 text-white">Our wide range of therapy services is designed to cater to your unique needs, whether you’re seeking personal growth, healing, or support in challenging times. From individual sessions to family and group therapies, our licensed professionals are here to guide you every step of the way. Explore our services below and take the first step toward a healthier, more fulfilling life.</p>
                  <p class="fs-3 fst-italic text-white">Let us help you create a path toward clarity, resilience, and happiness.</p>
                </div>
              </div>
              <div class="col p-5">
                <div id="serviceCar" class="carousel slide">
                  <div class="carousel-indicators">
                    <button type="button" data-bs-target="#serviceCar" data-bs-slide-to="0" class="active text-bg-primary" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#serviceCar" data-bs-slide-to="1" class="text-bg-primary" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#serviceCar" data-bs-slide-to="2" class="text-bg-primary" aria-label="Slide 3"></button>
                  </div>
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <div class="d-flex justify-content-center">
                        <div class="card shadow" style="width: 35rem;">
                          <img src="images/services/individual.jpg" class="card-img-top" alt="individual therapy">
                          <div class="card-body">
                            <h5 class="card-title">Individual Therapy</h5>
                            <p class="card-text text-indent">One-on-one sessions with a licensed therapist to address personal challenges such as anxiety, stress, or life transitions.</p>
                            <p class="card-text"><b>Price:</b> $50–$120 per session.</p>
                            <a href="php/booking.php" class="btn btn-primary ms-5">Book Now</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="carousel-item ">
                      <div class="d-flex justify-content-center">
                        <div class="card shadow" style="width: 35rem;">
                          <img src="images/services/family.jpg" class="card-img-top" alt="...">
                          <div class="card-body ">
                            <h5 class="card-title">Family Therapy</h5>
                            <p class="card-text text-indent">A group session involving family members to work on improving relationships and addressing family dynamics.</p>
                            <p class="card-text"><b>Price:</b> $100–$180 per session.</p>
                            <a href="php/booking.php" class="btn btn-primary">Book Now</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="carousel-item">
                      <div class="d-flex justify-content-center">
                        <div class="card shadow" style="width: 35rem;">
                          <img src="images/services/couple.jpg" class="card-img-top" alt="...">
                          <div class="card-body ">
                            <h5 class="card-title">Couples Therapy</h5>
                            <p class="card-text text-indent">Focused sessions for couples to improve communication, resolve conflicts, and strengthen their relationship.</p>
                            <p class="card-text"><b>Price:</b> $80–$150 per session.</p>
                            <a href="php/booking.php" class="btn btn-primary">Book Now</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#serviceCar" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#serviceCar" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                  </div>
                </div>                
              </div>
          </div>
        </div>
      </section>
      <section class="testimonials" id="testimonials">
        <h1 class="text-center text-white pt-5 mb-5">TESTIMONIALS</h1>
        <div class="d-flex justify-content-center">
          <div id="carouselExample" class="carousel slide w-75 test-color shadow">
            <div class="carousel-inner">
              <div class="carousel-item active py-5 ">
                <div class="d-flex justify-content-center">
                  <img src="images/testimonials/saram.jpg" alt="sara" class="testimonials-images shadow">
                </div>
                <div class="text-center">
                  <p class="fs-4">Sara M.</p>
                  <p class="fs-5"> <b>Rating:</b> 5/5</p>
                  <p class="fs-4 fst-italic">"The individual therapy sessions were life-changing. My therapist helped me uncover strengths I didn’t know I had. Highly recommend!"</p>
                </div>
                
              </div>
              <div class="carousel-item py-5">
                <div class="d-flex justify-content-center">
                  <img src="images/testimonials/daniell.jpg" alt="daniel" class="testimonials-images shadow">
                </div>
                <div class="text-center">
                  <p class="fs-4">Daniel L.</p>
                  <p class="fs-5"><b>Rating:</b> 4.5/5</p>
                  <p class="fs-4 fst-italic">"Couples therapy brought us closer than ever. We learned so much about communication and understanding each other."</p>
                </div>
              </div>
              <div class="carousel-item py-5">
                <div class="d-flex justify-content-center">
                  <img src="images/testimonials/clairep.jpg" alt="claire" class="testimonials-images shadow">
                </div>
                <div class="text-center">
                  <p class="fs-4">Claire P.</p>
                  <p class="fs-5"><b>Rating:</b> 4.5/5</p>
                  <p class="fs-4 fst-italic">"The family therapy sessions helped us rebuild trust and create a more loving environment. Truly grateful for the support."</p>
                </div>
              </div>
              <div class="carousel-item py-5">
                <div class="d-flex justify-content-center">
                  <img src="images/testimonials/jamest.jpg" alt="james" class="testimonials-images shadow">
                </div>
                <div class="text-center">
                  <p class="fs-4">James T.</p>
                  <p class="fs-5"><b>Rating:</b> 4/5</p>
                  <p class="fs-4 fst-italic">"Group therapy gave me a sense of community I didn’t know I needed. Hearing others’ stories made me feel less alone."</p>
                </div>
              </div>
              <div class="carousel-item py-5">
                <div class="d-flex justify-content-center">
                  <img src="images/testimonials/melissar.jpg" alt="melissa" class="testimonials-images shadow">
                </div>
                <div class="text-center">
                  <p class="fs-4">Melissa R.</p>
                  <p class="fs-5"><b>Rating:</b> 4/5</p>
                  <p class="fs-4 fst-italic">"The online therapy option was perfect for my busy schedule. My therapist was understanding and insightful."</p>
                </div>
              </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
          </div>
        </div>
      </section>
      <section>
        <div class="container-fluid my-5 d-flex justify-content-center">
          <div class="container-fluid w-50 border row p-5 create-account">
            <h2 class="mb-5 text-center">Take the First Step Toward Wellness</h2>
            <div class="col">
              <p class="fs-5">Ready to embark on your journey to a healthier, happier you? Don’t wait!Your mental well-being deserves priority!</p>
              <p class="fs-5 fst-italic">Your path to wellness begins here. Let’s make it happen!</p>
            </div>
            <div class="col">
              <div>
                <p class="fs-4 mb-5">Create an Account and Schedule Your First Sessions</p>  
                <a href="php/booking.php" class="btn btn-primary fs-5" target="_blank">Create Account</a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <div class= kolor>
      <footer class="bg-primary d-flex align-items-center">
        <p class="ms-5 pt-3">Copyright 2024</p>
      </footer>
                </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>