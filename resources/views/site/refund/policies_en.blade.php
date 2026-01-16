<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <!-- Meta Tags
        ==============================-->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="keywords" content="" />
    <meta name="copyright" content="" />
    <title>WELLBEING | MEDICAL CONSULTATION</title>

    <!-- Fave Icons
    ================================-->
    <link rel="shortcut icon" href="{{ asset('kinda/assets/images/fav-icon.png') }}" />

    <!-- CSS Files
    ================================-->
    <link rel="stylesheet" href="{{ asset('kinda') }}/assets/vendor/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('kinda') }}/assets/vendor/owl/owl.carousel.css" />
    <link rel="stylesheet" href="{{ asset('kinda') }}/assets/vendor/fancybox/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('kinda') }}/assets/vendor/aos/aos.css" />
    <link rel="stylesheet" href="{{ asset('kinda') }}/assets/vendor/aos/animate.css" />
    <link rel="stylesheet" href="{{ asset('kinda') }}/assets/css/style.css" />
</head>

<body>
    <!-- Modal
    ==========================================-->
    <div class="modal" tabindex="-1" role="dialog" id="terms_of_use">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Terms of Use</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! \App\Models\Setting::find('12', ['value'])->value !!}

                </div>
            </div>
        </div>
    </div>
    <!-- Loader
     ==========================================-->
    <div class="loading">
        <div class="load_cont">
            <img src="{{ asset('kinda') }}/assets/images/logo_icon.png" />
            <img src="{{ asset('kinda') }}/assets/images/logo_word.png" class="fa-spin" />
        </div>
    </div>
    <!-- Header
     ==========================================-->
    <header class="top">
        <div class="container">
            <nav class="navbar navbar-expand-lg nav-flex">
                <a href="/en" class="navbar-brand">
                    <img src="{{ asset('kinda') }}/assets/images/logo.png" />
                </a>
                <ul>
                    <li>
                        <a href="">
                            <img src="{{ asset('kinda') }}/assets/images/google.png" />
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <img src="{{ asset('kinda') }}/assets/images/app.png" />
                        </a>
                    </li>
                    <li> <a href="/ar/refundpolicies"> Arabic </a></li>
                </ul>
        </div>
        </nav>
        <!--End Nav-->
        </div>
        <!--End Container fluid-->
    </header>
    <div class="page_content">
        <!--  Section
      ==========================================-->
        <section class="section_color static_sec">
            <div class="container">
                <div class="row">

                    <div class="col-lg-6">
                        <div class="static">
                            <h2>Cancellation and refund policy </h2>
                            <h3>Video consultation </h3>
                            <p>
                                The full amount paid will be refunded if the appointment is cancelled 4 hours or more
                                ahead of schedule.
                            </p>
                            <p>
                                No refund for missed appointments due to the patient's absence nor will be rescheduled.

                            </p>
                            <h3>Medical consultation by text messaging</h3>
                            <p>

                                The amount paid (or part of the amount) will not be refunded if the patient does not use
                                the entire package during the prescribed duration. </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img src="{{ asset('kinda') }}/assets/images/refund.png">
                    </div>
                </div>
                <!--End Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Section-->
    </div>
    <!--  Section
      ==========================================-->
    <section class="subscribe">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="subscribe_form" data-aos="fade-up" data-aos-delay="50">
                        <i class="far fa-envelope"></i>
                        <h3>Subscribe to Our Newsletter</h3>
                        <form>
                            <i class="far fa-envelope"></i>
                            <input type="email" placeholder="Email Address" class="form-control" />
                            <button class="link">
                                <span>Subscribe Now </span>
                            </button>
                        </form>
                        <span class="txt">
                            <i class="fa fa-info-circle"></i>
                            We never Send you any spam mail.
                        </span>
                    </div>
                </div>
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!--End Section-->
    </div>
    <!--End Page Content-->
    <!--  Footer
    ==========================================-->
    <footer>
        <div class="container">
            <div class="row top_footer">
                <div class="col-lg-4 col-md-12">
                    <img src="{{ asset('kinda') }}/assets/images/logo.png" class="logo" />
                </div>
                <!--End Col-->
                <div class="col-lg-4 col-md-7">
                    <ul class="contact_info">
                        <span> Contact Info</span>
                        <li>
                            <a target="_blank"
                                href="https://www.google.com.eg/maps/place/2526+building%D8%8C+1565+Road+1722%D8%8C+Manama,+Bahrain%E2%80%AD/@26.2410925,50.5916634,18.54z/data=!4m5!3m4!1s0x3e49a5ff4f1b27d5:0xe8292cc0426f78ad!8m2!3d26.2410815!4d50.5917463?hl=en&authuser=0">
                                <i class="fa fa-map-marker-alt"></i>
                                2526 building 1565, Road 1722 Block 317, Diplomatic Area,
                                Manama
                            </a>
                        </li>
                        <li>
                            <a href="mailto:info@WELLBEING.com">
                                <i class="fa fa-envelope"></i>
                                info@WELLBEING.com
                            </a>
                        </li>
                    </ul>
                </div>
                <!--End Col-->
                <div class="col-lg-4 col-md-5">
                    <ul>
                        <span>Download App Now!</span>
                        <li>
                            <a href="">
                                <img src="{{ asset('kinda') }}/assets/images/google.png" />
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="{{ asset('kinda') }}/assets/images/app.png" />
                            </a>
                        </li>
                    </ul>
                </div>
                <!--End Col-->
            </div>
        </div>
        <div class="container-fluid">
            <div class="row bottom_footer">
                <div class="col-12">
                    <ul>
                        <li>
                            <a href="#terms_of_use" data-toggle="modal" data-target="#terms_of_use">Term of Use</a>
                        </li>
                        <li><a href="/ar/refundpolicies"> العربية </a></li>
                    </ul>
                    <p>All Right Reserved | WELLBEING Copyright © 2021</p>
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </footer>
    <!--End Footer-->
    <!--  Up Button
    ==========================================-->
    <button class="up_btn">
        <i class="fa fa-long-arrow-alt-up"></i>
    </button>
    <!-- JS & Vendor Files
    ==========================================-->
    <script src="{{ asset('kinda') }}/assets/vendor/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="{{ asset('kinda') }}/assets/vendor/bootstrap/bootstrap.min.js"></script>
    <script src="{{ asset('kinda') }}/assets/vendor/aos/aos.js"></script>
    <script src="{{ asset('kinda') }}/assets/vendor/owl/owl.carousel.js"></script>

    <script src="{{ asset('kinda') }}/assets/vendor/fancybox/jquery.fancybox.min.js"></script>
    <script src="{{ asset('kinda') }}/assets/js/main.js"></script>
</body>

</html>
