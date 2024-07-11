@extends('front-pages.front-layout')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Carousel</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .carousel img {
            width: 70px;
            max-height: 70px;
            border-radius: 50%;
            margin-right: 1rem;
            overflow: hidden;
        }
        .carousel-inner {
            padding: 1em;
        }
        @media screen and (min-width: 576px) {
            .carousel-inner {
                display: flex;
                width: 90%;
                margin-inline: auto;
                padding: 1em 0;
                overflow: hidden;
            }
            .carousel-item {
                display: block;
                margin-right: 0;
                flex: 0 0 calc(100% / 2);
            }
        }
        @media screen and (min-width: 768px) {
            .carousel-item {
                display: block;
                margin-right: 0;
                flex: 0 0 calc(100% / 3);
            }
        }
        .carousel .card {
            margin: 0 0.5em;
            border: 0;
        }
        .carousel-control-prev,
        .carousel-control-next {
            width: 3rem;
            height: 3rem;
            background-color: grey;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
</head>
<body>
<div class="container-fluid bg-body-tertiary py-3">
    <div id="testimonialCarousel" class="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="card shadow-sm rounded-3">
                    <div class="quotes display-2 text-body-tertiary">
                        <i class="bi bi-quote"></i>
                    </div>
                    <div class="card-body">
                        <p class="card-text">"Some quick example text to build on the card title and make up the
                            bulk of
                            the card's content."</p>
                        <div class="d-flex align-items-center pt-2">
                            <img src="https://codingyaar.com/wp-content/uploads/square-headshot-1.png" alt="bootstrap testimonial carousel slider 2">
                            <div>
                                <h5 class="card-title fw-bold">Jane Doe</h5>
                                <span class="text-secondary">CEO, Example Company</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
  <div class="carousel-item">
        <div class="card shadow-sm rounded-3">
          <div class="quotes display-2 text-body-tertiary">
            <i class="bi bi-quote"></i>
          </div>
          <div class="card-body">
            <p class="card-text">"Some quick example text to build on the card title and make up the
              bulk of
              the card's content."</p>
            <div class="d-flex align-items-center pt-2">
              <img src="https://codingyaar.com/wp-content/uploads/square-headshot-2.png" alt="bootstrap testimonial carousel slider 2">
              <div>
                <h5 class="card-title fw-bold">June Doe</h5>
                <span class="text-secondary">CEO, Example Company</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="card shadow-sm rounded-3">
          <div class="quotes display-2 text-body-tertiary">
            <i class="bi bi-quote"></i>
          </div>
          <div class="card-body">
            <p class="card-text">"Some quick example text to build on the card title and make up the
              bulk of
              the card's content."</p>
            <div class="d-flex align-items-center pt-2">
              <img src="https://codingyaar.com/wp-content/uploads/bootstrap-profile-card-image.jpg" alt="bootstrap testimonial carousel slider 2">
              <div>
                <h5 class="card-title fw-bold">John Doe</h5>
                <span class="text-secondary">CEO, Example Company</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="card shadow-sm rounded-3">
          <div class="quotes display-2 text-body-tertiary">
            <i class="bi bi-quote"></i>
          </div>
          <div class="card-body">
            <p class="card-text">"Some quick example text to build on the card title and make up the
              bulk of
              the card's content."</p>
            <div class="d-flex align-items-center pt-2">
              <img src="https://codingyaar.com/wp-content/uploads/bootstrap-profile-card-image.jpg" alt="bootstrap testimonial carousel slider 2">
              <div>
                <h5 class="card-title fw-bold">John Doe</h5>
                <span class="text-secondary">CEO, Example Company</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="card shadow-sm rounded-3">
          <div class="quotes display-2 text-body-tertiary">
            <i class="bi bi-quote"></i>
          </div>
          <div class="card-body">
            <p class="card-text">"Some quick example text to build on the card title and make up the
              bulk of
              the card's content."</p>
            <div class="d-flex align-items-center pt-2">
              <img src="https://codingyaar.com/wp-content/uploads/bootstrap-profile-card-image.jpg" alt="bootstrap testimonial carousel slider 2">
              <div>
                <h5 class="card-title fw-bold">John Doe</h5>
                <span class="text-secondary">CEO, Example Company</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="card shadow-sm rounded-3">
          <div class="quotes display-2 text-body-tertiary">
            <i class="bi bi-quote"></i>
          </div>
          <div class="card-body">
            <p class="card-text">"Some quick example text to build on the card title and make up the
              bulk of
              the card's content."</p>
            <div class="d-flex align-items-center pt-2">
              <img src="https://codingyaar.com/wp-content/uploads/bootstrap-profile-card-image.jpg" alt="bootstrap testimonial carousel slider 2">
              <div>
                <h5 class="card-title fw-bold">John Doe</h5>
                <span class="text-secondary">CEO, Example Company</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="card shadow-sm rounded-3">
          <div class="quotes display-2 text-body-tertiary">
            <i class="bi bi-quote"></i>
          </div>
          <div class="card-body">
            <p class="card-text">"Some quick example text to build on the card title and make up the
              bulk of
              the card's content."</p>
            <div class="d-flex align-items-center pt-2">
              <img src="https://codingyaar.com/wp-content/uploads/bootstrap-profile-card-image.jpg" alt="bootstrap testimonial carousel slider 2">
              <div>
                <h5 class="card-title fw-bold">John Doe</h5>
                <span class="text-secondary">CEO, Example Company</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="card shadow-sm rounded-3">
          <div class="quotes display-2 text-body-tertiary">
            <i class="bi bi-quote"></i>
          </div>
          <div class="card-body">
            <p class="card-text">"Some quick example text to build on the card title and make up the
              bulk of
              the card's content."</p>
            <div class="d-flex align-items-center pt-2">
              <img src="https://codingyaar.com/wp-content/uploads/bootstrap-profile-card-image.jpg" alt="bootstrap testimonial carousel slider 2">
              <div>
                <h5 class="card-title fw-bold">John Doe</h5>
                <span class="text-secondary">CEO, Example Company</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="card shadow-sm rounded-3">
          <div class="quotes display-2 text-body-tertiary">
            <i class="bi bi-quote"></i>
          </div>
          <div class="card-body">
            <p class="card-text">"Some quick example text to build on the card title and make up the
              bulk of
              the card's content."</p>
            <div class="d-flex align-items-center pt-2">
              <img src="https://codingyaar.com/wp-content/uploads/bootstrap-profile-card-image.jpg" alt="bootstrap testimonial carousel slider 2">
              <div>
                <h5 class="card-title fw-bold">John Doe</h5>
                <span class="text-secondary">CEO, Example Company</span>
              </div>
            </div>
          </div>
        </div>
      </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script>
    const multipleItemCarousel = document.querySelector("#testimonialCarousel");

    if (window.matchMedia("(min-width:576px)").matches) {
        const carousel = new bootstrap.Carousel(multipleItemCarousel, {
            interval: false
        });

        var carouselWidth = $(".carousel-inner")[0].scrollWidth;
        var cardWidth = $(".carousel-item").width();

        var scrollPosition = 0;

        $(".carousel-control-next").on("click", function () {
            if (scrollPosition < carouselWidth - cardWidth * 3) {
                scrollPosition = scrollPosition + cardWidth;
                $(".carousel-inner").animate({ scrollLeft: scrollPosition }, 800);
            }
        });
        $(".carousel-control-prev").on("click", function () {
            if (scrollPosition > 0) {
                scrollPosition = scrollPosition - cardWidth;
                $(".carousel-inner").animate({ scrollLeft: scrollPosition }, 800);
            }
        });
    } else {
        $(multipleItemCarousel).addClass("slide");
    }
</script>
</body>
</html>

@endsection