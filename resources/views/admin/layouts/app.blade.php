<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>@if (env('APP_NAME'))
        {!! env('APP_NAME') !!} @else Kinda Health
    @endif || @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{!!assets('dashboard/logo.png')  !!}">


    <!-- third party css -->
    <link href=" {!! assets('dashboard/animate.css') !!}" rel="stylesheet"
          type="text/css"/>
    <link href="{!! assets('dashboard/light/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css') !!}"
          rel="stylesheet">

    <link href="{!! assets('dashboard/light/assets/libs/bootstrap-datepicker/bootstrap-datepicker.css')!!}"
          rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="{!!assets('dashboard/light/assets/libs/datatables/dataTables.bootstrap4.css')  !!}" rel="stylesheet"
          type="text/css"/>
    <link href="{!!assets('dashboard/light/assets/libs/datatables/responsive.bootstrap4.css')  !!}" rel="stylesheet"
          type="text/css"/>
    <link href="{!!assets('dashboard/light/assets/libs/datatables/buttons.bootstrap4.css')  !!}" rel="stylesheet"
          type="text/css"/>
    <link href="{!!assets('dashboard/light/assets/libs/datatables/select.bootstrap4.css')  !!}" rel="stylesheet"
          type="text/css"/>
    <!-- third party css end -->
 <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"
    />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">

    <link href="{!! assets('dashboard/light/assets/libs/dropify/dropify.min.css')!!}" rel="stylesheet" type="text/css"/>

    <link href="{!! assets('dashboard/light/assets/libs/multiselect/multi-select.css') !!}" rel="stylesheet"
          type="text/css"/>
    <!-- App css -->
    <link href="{!! assets('dashboard/light/assets/css/bootstrap.min.css') !!}" rel="stylesheet" type="text/css"/>
    <link href="{!! assets('dashboard/light/assets/css/icons.min.css') !!}" rel="stylesheet" type="text/css"/>
@if(app()->getLocale()=='ar')
    <link href="{!! assets('dashboard/light/assets/css/app-rtl.min.css') !!}" rel="stylesheet" type="text/css"/>
    @else
        <link href="{!! assets('dashboard/light/assets/css/app.min.css') !!}" rel="stylesheet" type="text/css"/>

    @endif

    @stack('header')
    <style>
        .ltr{
            direction: ltr !important;
        }
        .rtl{
            direction: rtl !important;
        }

        .nav2-second{
            padding-right: 10px !important;
        }
        .nav2-second li{
            background: #f6f6f6 !important;
            border-radius: 5px;
            margin-bottom: 4px;
        }
        .nav2-second li:hover{
            background: #b0b0b07c !important;
        }
    </style>

</head>

<body class="left-side-menu-light">
@include('sweetalert::alert')

<!-- Begin page -->
<div id="wrapper">

    <!-- Topbar Start -->
@include('admin.layouts._header')
<!-- end Topbar -->

    <!-- ========== Left Sidebar Start ========== -->
@include('admin.layouts._sidebar')
<!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                @yield('content')
                {{--
                 <!-- end row -->

 --}}
            </div> <!-- container -->

        </div> <!-- content -->

        @include('admin.layouts._footer')

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

@routes
<!-- Vendor js -->
<script src="{!! assets('dashboard/light/assets/js/vendor.min.js') !!}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"
        integrity="sha256-AdQN98MVZs44Eq2yTwtoKufhnU+uZ7v2kXnD5vqzZVo=" crossorigin="anonymous"></script>

<!-- third party js -->
<script src="{!! assets('dashboard/light/assets/libs/datatables/jquery.dataTables.min.js')!!}"></script>
<script src="{!! assets('dashboard/light/assets/libs/datatables/dataTables.bootstrap4.js')!!}"></script>
<script src="{!! assets('dashboard/light/assets/libs/datatables/dataTables.responsive.min.js')!!}"></script>
<script src="{!! assets('dashboard/light/assets/libs/datatables/responsive.bootstrap4.min.js')!!}"></script>
<script src="{!! assets('dashboard/light/assets/libs/datatables/dataTables.buttons.min.js')!!}"></script>
<script src="{!! assets('dashboard/light/assets/libs/datatables/buttons.bootstrap4.min.js')!!}"></script>
<script src="{!! assets('dashboard/light/assets/libs/datatables/buttons.html5.min.js')!!}"></script>
<script src="{!! assets('dashboard/light/assets/libs/datatables/buttons.flash.min.js')!!}"></script>
<script src="{!! assets('dashboard/light/assets/libs/datatables/buttons.print.min.js')!!}"></script>
<script src="{!! assets('dashboard/light/assets/libs/datatables/dataTables.keyTable.min.js')!!}"></script>
<script src="{!! assets('dashboard/light/assets/libs/datatables/dataTables.select.min.js')!!}"></script>
<script src="{!! assets('dashboard/light/assets/libs/pdfmake/pdfmake.min.js')!!}"></script>
<script src="{!! assets('dashboard/light/assets/libs/pdfmake/vfs_fonts.js')!!}"></script>
<!-- third party js ends -->

<!-- Datatables init -->
<script src="{!! assets('dashboard/light/assets/js/pages/datatables.init.js')!!}"></script>

<!-- knob plugin -->
<script src="{!! assets('dashboard/light/assets/libs/jquery-knob/jquery.knob.min.js') !!}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script src="{!! assets('dashboard/light/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js')!!}"></script>
<script src="{!! assets('dashboard/light/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')!!}"></script>


<!-- Validation js (Parsleyjs) -->
<script src="{!! assets('dashboard/light/assets/libs/parsleyjs/parsley.min.js')!!}"></script>


<script src="{!! assets('dashboard/light/assets/libs/jquery-quicksearch/jquery.quicksearch.min.js')!!}"></script>
<script src="{!! assets('dashboard/light/assets/libs/multiselect/jquery.multi-select.js')!!}"></script>

<!-- validation init -->
<script src="{!! assets('dashboard/light/assets/js/pages/form-validation.init.js')!!}"></script>


<!-- dropify js -->
<script src="{!! assets('dashboard/light/assets/libs/dropify/dropify.min.js')!!}"></script>

<!-- form-upload init -->
<script src="{!! assets('dashboard/light/assets/js/pages/form-fileupload.init.js')!!}"></script>

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- App js -->
<script src="{!! assets('dashboard/light/assets/js/app.min.js') !!}"></script>

<script src="{!! assets('dashboard/scripts.js') !!}"></script>

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
<script>
    $(document).ready( function(){        
        const input = document.querySelector("#phone");
        if(input){
            window.intlTelInput(input, {
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
                autoInsertDialCode:true,
                autoPlaceholder:"polite",
                nationalMode:false,
                onlyCountries: ['AE','SA','BH','EG'],
                placeholderNumberType:"MOBILE",
            });
        }
        const iti = $(".iti");
        iti.css("width", "100%");       
    });

    var currentLanguage = 'en'; // Initialize with English
        document.addEventListener('input', function(event) {
            var textInputElement = event.target;
            var language = getLanguageFromText(textInputElement.value);

            if (language !== currentLanguage) {
                currentLanguage = language;
                updateTextDirection(textInputElement, language);
            }

        });

        function getLanguageFromText(text) {
            
            var hasArabic = /[\u0600-\u06FF]/.test(text); // Detect Arabic characters            
            var hasEnglish = /[a-zA-Z]/.test(text); // Detect English characters

            if (hasArabic && hasEnglish) {                
                return 'mixed'; // Consider it as mixed
            } else if (hasArabic) {
                return 'ar'; // Arabic
            } else {
                return 'en'; // English (default)
            }
        }

        function updateTextDirection(inputElement, language) {
            if (language === 'mixed') {
                inputElement.style.direction = 'ltr';
            } else if (language === 'ar') {
                inputElement.style.direction = 'rtl';
            }else {
                inputElement.style.direction = 'ltr';
            }
        }

</script>   

@stack('scripts')

</body>
</html>


