
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- CSS -->
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="css/bootstrap-grid.min.css">
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/magnific-popup.css">
	<link rel="stylesheet" href="css/select2.min.css">
	<link rel="stylesheet" href="css/paymentfont.min.css">
	<link rel="stylesheet" href="css/slider-radio.css">
	<link rel="stylesheet" href="css/plyr.css">
	<link rel="stylesheet" href="css/main.css">

	<!-- Favicons -->
	<link rel="icon" type="image/png" href="img/store/logo33.jpg" sizes="64x64">
	<link rel="apple-touch-icon" href="icon/favicon-32x32.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Dmitry Volkov">
	<title>Podcast</title>

</head>

<body>
	<!-- header -->
	<header class="header">
  <div class="header__content">
    <div class="">
      <a href="index.html">
        <img src="img/store/Logo_Black.webp" alt="" style="height: 49px;width: 105px;">
      </a>
    </div>
    <nav class="header__nav">
      <a href="https://poojastore.33crores.com/">Shop</a>
      <a href="https://pandit.33crores.com/">Book Pandit</a>
      <a href="https://poojastore.33crores.com/pages/about-us">About Us</a>
      <a href="https://poojastore.33crores.com/pages/contact">Contact Us</a>
    </nav>
    <button class="header__toggle" aria-label="Toggle navigation menu">
      ☰
    </button>
  </div>
</header>
	<!-- end header -->

	<!-- sidebar -->

	<!-- end sidebar -->
	<div class="player">
  <div class="player__cover">
    <img src="img/covers/cover.svg" alt="">
  </div>
  <div class="player__content">
    <span class="player__track">
      <b class="player__title">Select Podcast</b>
    </span>
    <audio
      src="https://dmitryvolkov.me/demo/blast2.0/audio/12071151_epic-cinematic-trailer_by_audiopizza_preview.mp3"
      id="audio" controls></audio>
  </div>
</div>


	<button class="player__btn" type="button">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
    <path d="M21.65,2.24a1,1,0,0,0-.8-.23l-13,2A1,1,0,0,0,7,5V15.35A3.45,3.45,0,0,0,5.5,15,3.5,3.5,0,1,0,9,18.5V10.86L20,9.17v4.18A3.45,3.45,0,0,0,18.5,13,3.5,3.5,0,1,0,22,16.5V3A1,1,0,0,0,21.65,2.24ZM5.5,20A1.5,1.5,0,1,1,7,18.5,1.5,1.5,0,0,1,5.5,20Zm13-2A1.5,1.5,0,1,1,20,16.5,1.5,1.5,0,0,1,18.5,18ZM20,7.14,9,8.83v-3L20,4.17Z"/>
  </svg>
  Player
</button>
	<!-- end player -->
  <section class="row row--grid">
  <div class="col-12 d-flex justify-content-center align-items-center" style="background-color: #C1252F;padding: 70px">
  <div class="col-10">
        <?php
        // Initialize cURL session
        $curl = curl_init();

        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://pandit.33crores.com/api/podcasts',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        // Execute cURL request and get response
        $response = curl_exec($curl);

        // Check for cURL errors
        if (curl_errno($curl)) {
            echo 'cURL error: ' . curl_error($curl);
            curl_close($curl);
            exit;
        }

        // Close cURL session
        curl_close($curl);

        // Decode JSON response
        $podcasts = json_decode($response, true);

        // Check if decoding was successful and the response is an array
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo 'JSON decode error: ' . json_last_error_msg();
        } elseif (!is_array($podcasts) || !isset($podcasts['data'])) {
            echo '<p>API response is not in the expected format.</p>';
        } else {
            // Sort podcasts by 'created_at' in descending order
            usort($podcasts['data'], function ($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });

            // Get only the latest podcast
            $latestPodcast = $podcasts['data'][0]; // Assuming there's at least one podcast

            // Ensure that each field is set and is a string
            $name = isset($latestPodcast['name']) ? htmlspecialchars($latestPodcast['name']) : 'Unknown Name';
            $description = isset($latestPodcast['description']) ? htmlspecialchars($latestPodcast['description']) : 'No Description';
            $image_url = isset($latestPodcast['image_url']) ? htmlspecialchars($latestPodcast['image_url']) : 'default-image.png';
            $music_url = isset($latestPodcast['music_url']) ? htmlspecialchars($latestPodcast['music_url']) : '#';

            // Display only the latest podcast
            echo '
            <div class="store-item">
                <div class="store-item__content">
                    <div class="store-item__carousel owl-carousel">
                        <a data-link data-title="' . $name . '" data-artist="AudioPizza"
                           data-img="' . $image_url . '"
                           href="' . $music_url . '" class="single-item__cover">
                            <img src="' . $image_url . '" alt="">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M18.54,9,8.88,3.46a3.42,3.42,0,0,0-5.13,3V17.58A3.42,3.42,0,0,0,7.17,21a3.43,3.43,0,0,0,1.71-.46L18.54,15a3.42,3.42,0,0,0,0-5.92Zm-1,4.19L7.88,18.81a1.44,1.44,0,0,1-1.42,0,1.42,1.42,0,0,1-.71-1.23V6.42a1.42,1.42,0,0,1,.71-1.23A1.51,1.51,0,0,1,7.17,5a1.54,1.54,0,0,1,.71.19l9.66,5.58a1.42,1.42,0,0,1,0,2.46Z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M16,2a3,3,0,0,0-3,3V19a3,3,0,0,0,6,0V5A3,3,0,0,0,16,2Zm1,17a1,1,0,0,1-2,0V5a1,1,0,0,1,2,0ZM8,2A3,3,0,0,0,5,5V19a3,3,0,0,0,6,0V5A3,3,0,0,0,8,2ZM9,19a1,1,0,0,1-2,0V5A1,1,0,0,1,9,5Z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="store-item__description">
                    <div class="article__content">
                        <h4 style="text-shadow: 10px 12px 20px rgba(10,0,0,0.6);color: #C1252F;font-size: 40px;font-weight: bold;font-family: Times New Roman, serif">' . $name . '</h4>
                        <p style="color: black">' . $description . '</p>
                    </div>
                      <div style="height: 70px; width: 250px">
                      <img id="music-gif" src="img/events/music2.webp" alt="Music playing" style="width: 100%; height: 100%; display: none">
                      <img id="pause-image" src="img/events/music3.png" alt="Music paused" style="width: 100%; height: 100%;>
                   </div>
                
                    <div class="share_banner">
                        <span style="cursor: pointer" class="whatsapp" id="whatsapp-share">
                            <ion-icon name="logo-whatsapp"></ion-icon>
                        </span>
                        <span style="cursor: pointer" class="facebook" id="facebook-share">
                            <ion-icon name="logo-facebook"></ion-icon>
                        </span>
                        <span style="cursor: pointer" class="twitter" id="twitter-share">
                            <i class="fa-brands fa-x-twitter"></i>
                        </span>
                    </div>
                    
                </div>
            </div>';
        }
        ?>
    </div>
    </div>
     
</section>
	<!-- main content -->
	<main class="main">
		<div class="container">
<section class="row row--grid">
    <div class="col-12" style="margin-bottom: 30px;">
        <div class="main__title">
            <h2>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M21.65,2.24a1,1,0,0,0-.8-.23l-13,2A1,1,0,0,0,7,5V15.35A3.45,3.45,0,0,0,5.5,15,3.5,3.5,0,1,0,9,18.5V10.86L20,9.17v4.18A3.45,3.45,0,0,0,18.5,13,3.5,3.5,0,1,0,22,16.5V3A1,1,0,0,0,21.65,2.24ZM5.5,20A1.5,1.5,0,1,1,7,18.5,1.5,1.5,0,0,1,5.5,20Zm13-2A1.5,1.5,0,1,1,20,16.5,1.5,1.5,0,0,1,18.5,18ZM20,7.14,9,8.83v-3L20,4.17Z"/>
                </svg>
                <a href="#">Top Podcasts</a>
            </h2>
        </div>
    </div>

    <?php
    // Initialize cURL session
    $curl = curl_init();

    // Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://pandit.33crores.com/api/podcasts',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    // Execute cURL request and get response
    $response = curl_exec($curl);

    // Check for cURL errors
    if (curl_errno($curl)) {
        echo 'cURL error: ' . curl_error($curl);
        curl_close($curl);
        exit;
    }

    // Close cURL session
    curl_close($curl);

    // Decode JSON response
    $podcasts = json_decode($response, true);

    // Check if decoding was successful and the response is an array
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo 'JSON decode error: ' . json_last_error_msg();
    } elseif (!is_array($podcasts)) {
        echo '<p>API response is not an array.</p>';
    } else {
        // Sort the podcasts array by a specific field in ascending order
        if (isset($podcasts['data']) && is_array($podcasts['data'])) {
            usort($podcasts['data'], function ($a, $b) {
                return strtotime($a['created_at']) - strtotime($b['created_at']); // Adjust the field accordingly
            });

            // Display podcasts
            foreach ($podcasts['data'] as $index => $podcast) {
                // Ensure that each field is set and is a string
                $name = isset($podcast['name']) ? htmlspecialchars($podcast['name']) : 'Unknown Name';
                $description = isset($podcast['description']) ? htmlspecialchars($podcast['description']) : 'No Description';
                $image_url = isset($podcast['image_url']) ? htmlspecialchars($podcast['image_url']) : 'default-image.png';
                $music_url = isset($podcast['music_url']) ? htmlspecialchars($podcast['music_url']) : '#';

                echo'
                <div class="col-md-6 col-xl-4">
                  <li class="single-item" style="height: 380px !important">
                    <a data-link data-title="' . $name . '" data-artist="AudioPizza"
                       data-img="' . $image_url . '"
                       href="' . $music_url . '" class="single-item__cover">
                       <img src="' . $image_url . '" alt="' . $name . '">
                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                           <path d="M18.54,9,8.88,3.46a3.42,3.42,0,0,0-5.13,3V17.58A3.42,3.42,0,0,0,7.17,21a3.43,3.43,0,0,0,1.71-.46L18.54,15a3.42,3.42,0,0,0,0-5.92Zm-1,4.19L7.88,18.81a1.44,1.44,0,0,1-1.42,0,1.42,1.42,0,0,1-.71-1.23V6.42a1.42,1.42,0,0,1,.71-1.23A1.51,1.51,0,0,1,7.17,5a1.54,1.54,0,0,1,.71.19l9.66,5.58a1.42,1.42,0,0,1,0,2.46Z"/>
                       </svg>
                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                           <path d="M16,2a3,3,0,0,0-3,3V19a3,3,0,0,0,6,0V5A3,3,0,0,0,16,2Zm1,17a1,1,0,0,1-2,0V5a1,1,0,0,1,2,0ZM8,2A3,3,0,0,0,5,5V19a3,3,0,0,0,6,0V5A3,3,0,0,0,8,2ZM9,19a1,1,0,0,1-2,0V5A1,1,0,0,1,9,5Z"/>
                       </svg>
                    </a>
                    <div class="single-item__title">
                      <h4 style="font-weight: bold;color: #C1252F;font-size: 18px">' . $name . '</h4>
                      <p style="font-size: 14px;font-weight: bold;">' . $description . '</p>
                    </div>
                    <div class="share">
                      <span style="cursor: pointer" class="whatsapp" id="whatsapp-share-' . $index . '"><ion-icon name="logo-whatsapp"></ion-icon></span>
                      <span style="cursor: pointer" class="facebook" id="facebook-share-' . $index . '"><ion-icon name="logo-facebook"></ion-icon></span>
                      <span style="cursor: pointer" class="twitter" id="twitter-share-' . $index . '"><i class="fa-brands fa-x-twitter"></i></span>
                    </div>
                  </li>
                </div>';
            }
        } else {
            echo '<p>No podcasts available at the moment.</p>';
        }
    }
    ?>
</section>


  </div>
	</main>
	<!-- end main content -->

	<!-- footer -->
	<section class="footer">
  <div class="container">
    <div class="card">
       <div class="footer1-div">
        <h5 class="text-16 fw-500 mb-30">Our Address</h5>
        <p style="color:#fff ;     line-height: 38px;">  33Crores Pooja Products Pvt Ltd ,<br> 403, 4th Floor, O-Hub<br>
          IDCO Sez Infocity,<br>
          Bhubaneswar 751024,<br>
          Odisha , Bharat<br>
          <br></p>
       </div>
    </div>
    <div class="card">
      <div class="footer2-div">
        <h5 class="text-16 fw-500 mb-30">Company</h5>
        <div class="d-flex y-gap-10 flex-column">
          <a href="https://poojastore.33crores.com/pages/about-us">About Us</a>
          <a href="https://poojastore.33crores.com/pages/our-story">Our Story</a>
          <a href="https://poojastore.33crores.com/pages/about-us">What is 33 Crores</a>
          <a href="https://poojastore.33crores.com/pages/contact">Contact</a>
          
        </div>
      </div>  
    </div>
    <div class="card">
      <div class="footer3-div">
        <h5 class="text-16 fw-500 mb-30">Shopping</h5>
        <div class="d-flex y-gap-10 flex-column">
          <a href="https://poojastore.33crores.com/pages/privacy-and-data-policy">Privacy & Data</a>
          <a href="https://poojastore.33crores.com/pages/terms-of-use">Terms & Conditions</a>
          <a href="https://poojastore.33crores.com/pages/product-cancellation-and-returns">Cancellation & Returns</a>
          <a href="https://poojastore.33crores.com/pages/business-tie-up-with-33crores">Business Enrollment</a>
          <a href="https://poojastore.33crores.com/pages/religious-service-provider">Religious Service Provider</a>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="footer4-div">
        <h5 class="text-16 fw-500 mb-30">Follow Us</h5>

             <div class="col-auto">
                <div class="d-flex x-gap-20 items-center">
                  <a href="https://www.facebook.com/33crores"><span style="font-size: 32px;margin-right: 20px" ><i class="fa-brands fa-square-facebook"></i></span></a>
                  <!-- <a href="https://www.youtube.com/33crores"><i class="fa fa-youtube-square text-18 " aria-hidden="true"></i></a> -->
                  <a href="https://www.instagram.com/33crores/"><span style="font-size: 32px;" ><i class="fa-brands fa-instagram"></i></span></a>
                  
                </div>
              </div>
      </div>
    </div>
  </div>
</section>

	<!-- end footer -->


	<!-- end modal info -->

	<!-- JS -->

    <script>
 document.addEventListener("DOMContentLoaded", function () {
    // Get all share icons
    var whatsappShare = document.querySelectorAll("#whatsapp-share");
    var facebookShare = document.querySelectorAll("#facebook-share");
    var twitterShare = document.querySelectorAll("#twitter-share");

    // Function to add event listeners for sharing
    function addShareListeners(shares, platform) {
        shares.forEach(function (share) {
            share.addEventListener("click", function () {
                var pageUrl = window.location.href;
                var shareUrl;

                if (platform === "whatsapp") {
                    shareUrl = "https://wa.me/?text=" + encodeURIComponent(pageUrl);
                } else if (platform === "facebook") {
                    shareUrl = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(pageUrl);
                } else if (platform === "twitter") {
                    shareUrl = "https://twitter.com/intent/tweet?url=" + encodeURIComponent(pageUrl);
                }

                window.open(shareUrl, "_blank");
            });
        });
    }

    // Add listeners for each platform
    addShareListeners(whatsappShare, "whatsapp");
    addShareListeners(facebookShare, "facebook");
    addShareListeners(twitterShare, "twitter");
});

document.addEventListener("DOMContentLoaded", function () {
    // Get all share icons
    var whatsappShares = document.querySelectorAll("[id^='whatsapp-share-']");
    var facebookShares = document.querySelectorAll("[id^='facebook-share-']");
    var twitterShares = document.querySelectorAll("[id^='twitter-share-']");

    // Function to add event listeners for sharing
    function addShareListeners(shares, platform) {
        shares.forEach(function (share) {
            share.addEventListener("click", function () {
                var podcastUrl = share.closest("li").querySelector("a.single-item__cover").href;
                var currentPageUrl = window.location.href;
                var shareUrl;

                if (platform === "whatsapp") {
                    shareUrl = "https://wa.me/?text=" + encodeURIComponent(currentPageUrl);
                } else if (platform === "facebook") {
                    shareUrl = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(currentPageUrl);
                } else if (platform === "twitter") {
                    shareUrl = "https://twitter.com/intent/tweet?url=" + encodeURIComponent(currentPageUrl);
                }

                window.open(shareUrl, "_blank");
            });
        });
    }

    // Add listeners for each platform
    addShareListeners(whatsappShares, "whatsapp");
    addShareListeners(facebookShares, "facebook");
    addShareListeners(twitterShares, "twitter");
});


document.addEventListener('DOMContentLoaded', function() {
  const toggleButton = document.querySelector('.header__toggle');
  const nav = document.querySelector('.header__nav');

  toggleButton.addEventListener('click', function() {
    nav.classList.toggle('header__nav--open');
  });
});

document.addEventListener('DOMContentLoaded', function() {
  const audioPlayer = document.getElementById('audio');
  const musicGif = document.getElementById('music-gif');
  const pauseImage = document.getElementById('pause-image');

  // Show GIF when audio is playing
  audioPlayer.addEventListener('play', function() {
    musicGif.style.display = 'block';
    pauseImage.style.display = 'none'; // Hide pause image when playing
  });

  // Show pause image and hide GIF when audio is paused
  audioPlayer.addEventListener('pause', function() {
    musicGif.style.display = 'none';
    pauseImage.style.display = 'block'; // Show pause image
  });

  // Hide both images when audio ends
  audioPlayer.addEventListener('ended', function() {
    musicGif.style.display = 'none';
    pauseImage.style.display = 'none';
  });
});

</script>

	<script src="js/jquery-3.5.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/smooth-scrollbar.js"></script>
	<script src="js/select2.min.js"></script>
	<script src="js/slider-radio.js"></script>
	<script src="js/jquery.inputmask.min.js"></script>
	<script src="js/plyr.min.js"></script>
	<script src="js/main.js"></script>
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>

</html>