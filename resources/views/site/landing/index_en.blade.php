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
    <link rel="shortcut icon" href="{{ assets('kinda') }}/assets/images/fav-icon.png" />

    <!-- CSS Files
    ================================-->
    <link rel="stylesheet" href="{{ assets('kinda') }}/assets/vendor/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ assets('kinda') }}/assets/vendor/owl/owl.carousel.css" />
    <link rel="stylesheet" href="{{ assets('kinda') }}/assets/vendor/fancybox/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ assets('kinda') }}/assets/vendor/aos/aos.css" />
    <link rel="stylesheet" href="{{ assets('kinda') }}/assets/vendor/aos/animate.css" />
    <link rel="stylesheet" href="{{ assets('kinda') }}/assets/css/style.css" />
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
            <img src="{{ assets('kinda') }}/assets/images/logo_icon.png" />
            <img src="{{ assets('kinda') }}/assets/images/logo_word.png" class="fa-spin" />
        </div>
    </div>
    <!-- Header
     ==========================================-->
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a href="#" class="navbar-brand">
                    <img src="{{ assets('kinda') }}/assets/images/logo.png" />
                </a>
                <div class="header_btns">
                    <button class="menu-btn" type="button" data-toggle="collapse" data-target="#main-nav">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="main-nav">
                    <ul class="navbar-nav">
                        <li><a class="scroll" href="#home"> Home </a></li>
                        <li><a class="scroll" href="#how_it_works"> How it Works </a></li>
                        <li><a class="scroll" href="#screens"> App Screens </a></li>
                        <li><a class="scroll" href="#faqs"> Faqs </a></li>
                        <li><a class="scroll" href="{{ url('/en/refundpolicies') }}"> Refund Policies </a></li>

                        <li>
                            <a href="/ar"> العربية </a>
                        </li>
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
        <section class="main_section" id="home">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="cont">
                            <h1 class="animated fadeInDown" style="animation-delay: 0.2s">
                                Virtual Care
                            </h1>
                            <h2 class="animated fadeInDown" style="animation-delay: 0.4s">
                                Consult with highly qualified medical personnel
                                via video from the comfort of your own home without having to
                                travel!
                            </h2>

                            <ul class="animated fadeInDown" style="animation-delay: 0.6s">
                                <li>
                                    <a href="">
                                        <img src="{{ assets('kinda') }}/assets/images/google.png" />
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="{{ assets('kinda') }}/assets/images/app.png" />
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--End Col-->
                    <div class="col-lg-6 col-md-6">
                        <div class="main_img animated fadeInUp" style="animation-delay: 0.7s">
                            <img src="{{ assets('kinda') }}/assets/images/main_img.png" />
                        </div>
                    </div>
                    <!--End Col-->
                </div>
                <!--End Row-->
            </div>
            <!--End Container-->
            <a class="scroll scroll_btn" href="#features"><span></span> Scroll down
            </a>
        </section>
        <!--End Section-->
        <!--  Section
      ==========================================-->
        <section class="section_color" id="how_it_works">
            <div class="container">
                <div class="row">
                    <div class="col-12" data-aos="fade-up" data-aos-delay="50">
                        <div class="section_title">
                            <h3>Using WELLBEING is as easy</h3>
                            <p>as one, two, three, four</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="feature_item">
                            <span>1</span>
                            <img src="{{ assets('kinda') }}/assets/images/feature1.png" />

                            Sign Up
                        </div>
                        <!--End Feature Item-->
                    </div>
                    <!--End Col-->
                    <div class="col-lg-3 col-md-6 col-sm-6" data-aos="fade-up" data-aos-delay="150">
                        <div class="feature_item">
                            <span>2</span>
                            <img src="{{ assets('kinda') }}/assets/images/feature2.png" />
                            Choose a doctor
                        </div>
                        <!--End Feature Item-->
                    </div>
                    <!--End Col-->
                    <div class="col-lg-3 col-md-6 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="feature_item">
                            <span>3</span>
                            <img src="{{ assets('kinda') }}/assets/images/feature3.png" />
                            Schedule an appointment
                        </div>
                        <!--End Feature Item-->
                    </div>
                    <!--End Col-->
                    <div class="col-lg-3 col-md-6 col-sm-6" data-aos="fade-up" data-aos-delay="250">
                        <div class="feature_item">
                            <span>4</span>
                            <img src="{{ assets('kinda') }}/assets/images/feature4.png" />
                            Talk to your doctor
                        </div>
                        <!--End Feature Item-->
                    </div>
                    <!--End Col-->
                </div>
                <!--End Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Section-->
        <!--  Section
      ==========================================-->
        <section id="screens">
            <div class="container">
                <div class="row">
                    <div class="col-12" data-aos="fade-up" data-aos-delay="50">
                        <div class="section_title">
                            <p>Simple & Beautiful Interface</p>
                            <h3>ِApp Screens</h3>
                        </div>
                    </div>
                    <!--End Col-->
                    <div class="col-12" data-aos="fade-up" data-aos-delay="100">
                        <div class="owl-carousel screens">
                            <div class="item">
                                <a class="gallery_item" data-fancybox="gallery"
                                    href="{{ assets('kinda') }}/assets/images/screen1.png">
                                    <img src="{{ assets('kinda') }}/assets/images/screen1.png" />
                                </a>
                            </div>
                            <div class="item">
                                <a class="gallery_item" data-fancybox="gallery"
                                    href="{{ assets('kinda') }}/assets/images/screen2.png">
                                    <img src="{{ assets('kinda') }}/assets/images/screen2.png" />
                                </a>
                            </div>
                            <div class="item">
                                <a class="gallery_item" data-fancybox="gallery"
                                    href="{{ assets('kinda') }}/assets/images/screen3.png">
                                    <img src="{{ assets('kinda') }}/assets/images/screen3.png" />
                                </a>
                            </div>
                            <div class="item">
                                <a class="gallery_item" data-fancybox="gallery"
                                    href="{{ assets('kinda') }}/assets/images/screen1.png">
                                    <img src="{{ assets('kinda') }}/assets/images/screen1.png" />
                                </a>
                            </div>

                            <div class="item">
                                <a class="gallery_item" data-fancybox="gallery"
                                    href="{{ assets('kinda') }}/assets/images/screen2.png">
                                    <img src="{{ assets('kinda') }}/assets/images/screen2.png" />
                                </a>
                            </div>

                            <div class="item">
                                <a class="gallery_item" data-fancybox="gallery"
                                    href="{{ assets('kinda') }}/assets/images/screen3.png">
                                    <img src="{{ assets('kinda') }}/assets/images/screen3.png" />
                                </a>
                            </div>

                            <div class="item">
                                <a class="gallery_item" data-fancybox="gallery"
                                    href="{{ assets('kinda') }}/assets/images/screen1.png">
                                    <img src="{{ assets('kinda') }}/assets/images/screen1.png" />
                                </a>
                            </div>
                        </div>
                        <!--End Owl-->
                    </div>
                    <!--End Col-->
                </div>
                <!--End Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Section-->
        <!--  Section
      ==========================================-->
        <section class="section_color" id="faqs">
            <div class="container">
                <div class="row">
                    <div class="col-12" data-aos="fade-up" data-aos-delay="50">
                        <div class="section_title">
                            <p>Have Questions? Look Here</p>
                            <h3>Frequently asked questions</h3>
                        </div>
                    </div>
                    <!--End Col-->
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                        <img src="{{ assets('kinda') }}/assets/images/faqs.png" class="faq_img" />
                    </div>
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="150">
                        <div class="accordion" id="faqs">
                            <div class="panel">
                                <a href="#toggle1" data-toggle="collapse" class="panel-title">
                                    What is WELLBEING?
                                </a>
                                <!--End panel-title-->
                                <div class="panel-collapse collapse show in" id="toggle1" data-parent="#faqs">
                                    WELLBEING Is a platform which facilitate your
                                    communication with doctors. You can consult with highly
                                    qualified medical personnel via video from the comfort of
                                    your own home without having to travel!
                                </div>
                                <!--End Panel Collapse-->
                            </div>
                            <div class="panel">
                                <a href="#toggle2" data-toggle="collapse" class="collapsed panel-title">
                                    How do I register for WELLBEING?
                                </a>
                                <!--End panel-title-->
                                <div class="panel-collapse collapse" id="toggle2" data-parent="#faqs">
                                    You can easily sign up after downloading our Mobil App,
                                    which is available on the iTunes store and Google Play. You
                                    will receive a confirmation message (SMS) to complete your
                                    registration.
                                </div>
                                <!--End Panel Collapse-->
                            </div>
                            <div class="panel">
                                <a href="#toggle3" data-toggle="collapse" class="collapsed panel-title">
                                    When is WELLBEING available?
                                </a>
                                <!--End panel-title-->
                                <div class="panel-collapse collapse" id="toggle3" data-parent="#faqs">
                                    Currently WELLBEING is available from 11 am until 10 pm, 7
                                    days a week, and 365 days a year, even on holidays.
                                </div>
                                <!--End Panel Collapse-->
                            </div>
                            <div class="panel">
                                <a href="#toggle4" data-toggle="collapse" class="collapsed panel-title">
                                    How much does it cost to use WELLBEING?
                                </a>
                                <!--End panel-title-->
                                <div class="panel-collapse collapse" id="toggle4" data-parent="#faqs">
                                    The cost varies depending on which physician you choose,
                                    specialty and time consumed. You will only be charged after
                                    you choose to consult with a doctor and your appointment
                                    time and payment information are confirmed. WELLBEING
                                    accepts most major credit and debit cards.
                                </div>
                                <!--End Panel Collapse-->
                            </div>
                            <div class="panel">
                                <a href="#toggle5" data-toggle="collapse" class="collapsed panel-title">
                                    Can I cancel my appointment and receive a full refund?
                                </a>
                                <!--End panel-title-->
                                <div class="panel-collapse collapse" id="toggle5" data-parent="#faqs">
                                    You can cancel your appointment and receive a full refund,
                                    provided that you cancel at least 4 hours before your
                                    appointment time.
                                </div>
                                <!--End Panel Collapse-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Section-->
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
                    <img src="{{ assets('kinda') }}/assets/images/logo.png" class="logo" />
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
                                <img src="{{ assets('kinda') }}/assets/images/google.png" />
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="{{ assets('kinda') }}/assets/images/app.png" />
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
                        <li><a href="/ar"> العربية </a></li>
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
    <script src="{{ assets('kinda') }}/assets/vendor/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="{{ assets('kinda') }}/assets/vendor/bootstrap/bootstrap.min.js"></script>
    <script src="{{ assets('kinda') }}/assets/vendor/aos/aos.js"></script>
    <script src="{{ assets('kinda') }}/assets/vendor/owl/owl.carousel.js"></script>

    <script src="{{ assets('kinda') }}/assets/vendor/fancybox/jquery.fancybox.min.js"></script>
    <script src="{{ assets('kinda') }}/assets/js/main.js"></script>
</body>

</html>
