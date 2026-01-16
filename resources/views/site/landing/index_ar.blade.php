<!DOCTYPE html>
<html lang="ar" dir="rtl">

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
                    <h5 class="modal-title">تعليمات الاستخدام</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! \App\Models\Setting::find('11', ['value'])->value !!}
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
                        <li><a class="scroll" href="#home"> الرئيسية </a></li>
                        <li><a class="scroll" href="#how_it_works"> كيف نعمل ؟ </a></li>
                        <li><a class="scroll" href="#screens"> شاشات التطبيق </a></li>
                        <li><a class="scroll" href="#faqs"> الأسئلة الشائعة </a></li>
                        <li><a class="scroll" href="{{url('/ar/refundpolicies')}}"> سياسه الإلغاء والاسترداد </a></li>
                        <li>
                            <a href="/en"> English </a>
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
                                مشورة طبية عن بعد
                            </h1>
                            <h2 class="animated fadeInDown" style="animation-delay: 0.4s">
                                يمكنك استشارة طاقم طبي مؤهل تأهيال عاليا عبر
                                الفيديو وأنت مرتاح في منزلك دون الحاجة إلى السفر!
                                !
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
            <a class="scroll scroll_btn" href="#features"><span></span> إلى الأسفل
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
                            <h3>استخدام WELLBEING سهل للغاية</h3>
                            <p>كواحد ، اثنان ، ثلاثة ، أربعة</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="feature_item">
                            <span>1</span>
                            <img src="{{ assets('kinda') }}/assets/images/feature1.png" />

                            إنشاء حساب
                        </div>
                        <!--End Feature Item-->
                    </div>
                    <!--End Col-->
                    <div class="col-lg-3 col-md-6 col-sm-6" data-aos="fade-up" data-aos-delay="150">
                        <div class="feature_item">
                            <span>2</span>
                            <img src="{{ assets('kinda') }}/assets/images/feature2.png" />
                            إختر الطبيب
                        </div>
                        <!--End Feature Item-->
                    </div>
                    <!--End Col-->
                    <div class="col-lg-3 col-md-6 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="feature_item">
                            <span>3</span>
                            <img src="{{ assets('kinda') }}/assets/images/feature3.png" />
                            تحديد موعدا
                        </div>
                        <!--End Feature Item-->
                    </div>
                    <!--End Col-->
                    <div class="col-lg-3 col-md-6 col-sm-6" data-aos="fade-up" data-aos-delay="250">
                        <div class="feature_item">
                            <span>4</span>
                            <img src="{{ assets('kinda') }}/assets/images/feature4.png" />
                            تحدث إلى طبيبك
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
                            <p>واجهة بسيطة وجميلة</p>
                            <h3>شاشات التطبيق</h3>
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
                            <p>هل لديك أسئلة؟ انظر هنا</p>
                            <h3>الأسئلة المتداولة</h3>
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
                                    ما هو KINDAHEALTH؟
                                </a>
                                <!--End panel-title-->
                                <div class="panel-collapse collapse show in" id="toggle1" data-parent="#faqs">
                                    WELLBEING هي منصة تسهل تواصلك مع الأطباء. يمكنك استشارة
                                    طاقم طبي مؤهل تأهيلا عاليا عبر الفيديو وأنت مرتاح في منزلك
                                    دون الحاجة إلى السفر!
                                </div>
                                <!--End Panel Collapse-->
                            </div>
                            <div class="panel">
                                <a href="#toggle2" data-toggle="collapse" class="collapsed panel-title">
                                    كيف أسجل في KINDAHEALTH؟
                                </a>
                                <!--End panel-title-->
                                <div class="panel-collapse collapse" id="toggle2" data-parent="#faqs">
                                    يمكنك التسجيل بسهولة بعد تنزيل تطبيق Mobil المتوفر في متجر
                                    iTunes و Google Play. سوف تتلقى رسالة تأكيد (SMS) لإكمال
                                    التسجيل الخاص بك.
                                </div>
                                <!--End Panel Collapse-->
                            </div>
                            <div class="panel">
                                <a href="#toggle3" data-toggle="collapse" class="collapsed panel-title">
                                    متى يتوفر KINDAHEALTH؟
                                </a>
                                <!--End panel-title-->
                                <div class="panel-collapse collapse" id="toggle3" data-parent="#faqs">
                                    حاليًا WELLBEING متاح من 11 صباحًا حتى 10 مساءً ، 7 أيام
                                    في الأسبوع ، و 365 يومًا في السنة ، حتى في أيام العطلات.
                                </div>
                                <!--End Panel Collapse-->
                            </div>
                            <div class="panel">
                                <a href="#toggle4" data-toggle="collapse" class="collapsed panel-title">
                                    ما هي تكلفة استخدام KINDAHEALTH؟
                                </a>
                                <!--End panel-title-->
                                <div class="panel-collapse collapse" id="toggle4" data-parent="#faqs">
                                    تختلف التكلفة حسب الطبيب الذي تختاره والتخصص والوقت الذي
                                    تستغرقه. ستتم محاسبتك فقط بعد اختيارك استشارة الطبيب وتأكيد
                                    موعدك ومعلومات الدفع. يقبل WELLBEING معظم بطاقات الائتمان
                                    والخصم الرئيسية.
                                </div>
                                <!--End Panel Collapse-->
                            </div>
                            <div class="panel">
                                <a href="#toggle5" data-toggle="collapse" class="collapsed panel-title">
                                    هل يمكنني إلغاء موعدي واسترداد أموالي بالكامل؟
                                </a>
                                <!--End panel-title-->
                                <div class="panel-collapse collapse" id="toggle5" data-parent="#faqs">
                                    يمكنك إلغاء موعدك واسترداد أموالك بالكامل ، بشرط أن تقوم
                                    بالإلغاء قبل 4 ساعة على الأقل من موعد موعدك.
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
                            <h3>اشترك في نشرتنا الإخبارية</h3>
                            <form>
                                <i class="far fa-envelope"></i>
                                <input type="email" placeholder="البريد الألكترونى " class="form-control" />
                                <button class="link">
                                    <span> إشترك الآن</span>
                                </button>
                            </form>
                            <span class="txt">
                                <i class="fa fa-info-circle"></i>
                                نحن لا نرسل لك أي بريد عشوائي.
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
                        <span> معلومات التواصل </span>
                        <li>
                            <a target="_blank"
                                href="https://www.google.com.eg/maps/place/2526+building%D8%8C+1565+Road+1722%D8%8C+Manama,+Bahrain%E2%80%AD/@26.2410925,50.5916634,18.54z/data=!4m5!3m4!1s0x3e49a5ff4f1b27d5:0xe8292cc0426f78ad!8m2!3d26.2410815!4d50.5917463?hl=en&authuser=0">
                                <i class="fa fa-map-marker-alt"></i>
                                2526 مبنى 1565 طريق 1722 مجمع 317 المنطقة الدبلوماسية المنامة
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
                        <span>تحميل التطبيق الآن</span>
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
                            <a href="#terms_of_use" data-toggle="modal" data-target="#terms_of_use">شروط
                                الاستخدام</a>
                        </li>
                        <li><a href="/en"> الأنجليزية </a></li>
                    </ul>
                    <p>جميع الحقوق محفوظة | WELLBEING حقوق الطبع والنشر © 2021</p>
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
