<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kindahealth-Patient invoice</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{!! assets('assets/dashboard/logo.png') !!}">
    <link href="{!! assets('dashboard/light/assets/css/bootstrap.min.css') !!}" rel="stylesheet" type="text/css" />
    <link href="{!! assets('dashboard/light/assets/css/icons.min.css') !!}" rel="stylesheet" type="text/css" />
    <style>
        /* remove toolbar */
        .sf-toolbar-clearer,.sf-toolbarreset{
            display: none !important;
        }

        .h5-title {
            color: #969696;
            font-weight: 500;
        }
        .text-gray-1{
            color: #969696;
        }
        .text-gray-2{
            color: #5b5b5b;
        }

        .p-color {
            color: #000000aa;
        }
        
        tr,th,td{            
            border-bottom: 1px solid #b5b3b3; 
        }
        td,th{
            padding: 20px 0px;
            width: 100px;
            font-size: 18px;
        }
        td{
            color: #050505;
        }
       
    </style>

</head>

<body>
    <section style="padding: 0;width: 100%;margin-right: auto;margin-left: auto;">
        <div style="position: relative;">
            <div class="bg-dark" style="padding: 4.5rem 4.5rem 300px 4.5rem; padding-bottom: 300px;">
                <div class="d-flex px-2" >
                    <div class="" style="flex: 0 70%;width: 70%;">
                        <h2 class="mb-3 text-white">
                            Kindahealth Medical Consultation<br>
                            كيندا هيلث للاستشارات الطبية
                        </h2>
                        <h3 class="text-white">
                            VAT No. /
                            <br>
                            ABC-00001234509876
                        </h3>
                    </div>
                    <div class="" style="flex: 0 30%;width: 30%;">
                        <div style="width:100%;display:flex;justify-content:center;gap:20px;position: relative;">
                            <div>
                                {{-- <h2 class="text-white">Dr.Fateh Al Saleh</h2>
                                <h3 class="text-white">Kindahealth Medical Complex</h3> --}}
                            </div>
                            <div style="position: absolute;right:0">
                                <div style="width:9rem;height:9rem;background-color:white;border-radius: 50%;">
                                    <img src="{!! assets('dashboard/logo.png') !!}" alt="" style="width: 100%;;height: 100%;object-fit: cover;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card px-5" style="margin-top: -200px;background: none;">
                <div class="card-body"
                    style="padding:2.25rem 4.5rem 2.25rem 4.5rem; background-color: white;border-radius: 50px;min-height: 50px;">
                    <div class="d-flex w-100" style="position: relative;">
                        <div style="position: absolute;right: 0;top: 20px;">
                            <div style="width:100%;display:flex;justify-content: right;">
                                {!! QrCode::size(250)->generate('https://kindahealth.com') !!}
                            </div>
                        </div>
                        <div class="w-75 mt-1">
                            <h3>Simplified Tax Invoice - فاتورة ضريبية مبسطة</h3>
                            <div style="flex: 0 0 100%;max-width: 100%;">
                                <div class="d-flex my-4" style="justify-content: space-between;">
                                    <div class="" style="flex: 0 50%;width: 50%; margin-top:2rem;" >
                                        <h4 class="h5-title">Patient No</h4>
                                        <h4 class="p-color">{{ $reservation?->patient_id ?? '--'}}</h4>
                                    </div>
                                    <div class="" style="flex: 0 50%;width: 50%; margin-top:2rem;" >
                                        <h4 class="h5-title">Patient Name</h4>
                                        <h4 class="p-color">{{ $reservation?->patient?->name ?? '--'}}</h4>
                                    </div>                                                                  
                                </div>
                                <div class="d-flex my-4" style="justify-content: space-between;">
                                    <div class="" style="flex: 0 50%;width: 50%; margin-top:2rem;" > 
                                        <h4 class="h5-title">National Id</h4>
                                        <h4 class="p-color">{{ $reservation?->patient?->national_id ?? '--'}}</h4>
                                    </div>
                                    <div class="" style="flex: 0 50%;width: 50%; margin-top:2rem;" >
                                        <h4 class="h5-title">Clinic Name</h4>
                                        <h4 class="p-color">{{ $reservation?->doctor?->category?->name_en ?? '--'}}</h4>
                                    </div>                                                                
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <div class="w-100 mt-1">
                        <div style="flex: 0 0 100%;max-width: 100%;">
                            <div class="d-flex my-4" style="justify-content: space-between;">
                                <div class="" style="flex: 0 0 37.333%;width: 37.333%;margin-top:3.5rem;" > 
                                    <h4 class="h5-title">Doctor Name</h4>
                                    <h4 class="p-color">{{ $reservation?->doctor?->name_en ?? '--'}}</h4>
                                </div>
                                <div class="" style="flex: 0 0 33.333%;width: 33.333%;margin-top:3.5rem;" >
                                    <h4 class="h5-title">Appointment No</h4>
                                    <h4 class="p-color">{{ $reservation?->id ?? '--'}}</h4>
                                </div>                                                                
                                <div class="" style="flex: 0 0 33.333%;width: 33.333%;margin-top:3.5rem;" >
                                    <h4 class="h5-title">App. Date & Time </h4>
                                    <h4 class="p-color">{{ $reservation?->date .' '.$reservation?->from_time ?? '--'}}</h4>
                                </div>                                                                
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
            @php
                $service_rate = number_format((float)$reservation?->transaction?->amount??'0.00', 2, '.', '');
                $commission = number_format((float)$reservation?->transaction?->commission??'0.00', 2, '.', '');
                $price = $service_rate + $commission;
                $dicount = number_format((float)calculateDiscount($reservation?->promocode?->percent,$price), 2, '.', '');
                $vat = number_format((float)$reservation?->transaction?->vat_tax??'0.00', 2, '.', '');
                $total = $price + $vat;
            @endphp

            <div class="card px-4" style="margin-top: 30px;background: none;">
                <div class="card-body px-5 pt-4 pb-0">
                    <table style="width:100%;">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Service Rate</th>
                                <th>Discount</th>
                                <th>VAT</th>
                                <th>Amount With VAT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Reservation Appointment</td>
                                <td>{{$price}}</td>
                                <td>{{$dicount}}</td>
                                <td>{{$vat}}</td>
                                <td>{{number_format((float)$total, 2, '.', '')}}</td>
                            </tr>
                            <tr>
                                <td><h4>Grand Total</h4></td>
                                <td><h4>{{$price}}</h4></td>
                                <td><h4>{{$dicount}}</h4></td>
                                <td><h4>{{$vat}}</h4></td>
                                <td><h3>{{number_format((float)$total, 2, '.', '')}}</h3></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-dark" style="margin-top:200px;padding: 2rem;">
                <div class="d-flex text-white text-center justify-content-center" style="margin: auto;">
                    <div style="padding: 20px;">
                        <h5 class="text-gray-1">Tel:</h5>
                        <span>011/123456789</span>
                    </div>
                    <div style="padding: 20px;">
                        <h5 class="text-gray-1">Website:</h5>
                        <span ><a class="text-white" href="https://kindahealth.com/" target="_blank">Kindahealth.com</a></span>
                    </div>
                    <div style="padding: 20px;">
                        <h5 class="text-gray-1">E-mail:</h5>
                        <span ><a class="text-white" href="mailto:info@kindahealth.com ">info@kindahealth.com </a></span>
                    </div>
                    <div style="padding: 20px;">
                        <h5 class="text-gray-1">Address:</h5>
                        <span >دي حنيفة - حي العليا - وحدة 42 - الرياض 12214-8</span>
                    </div>
                </div>
            </div>
                
        </div>
    </section>
</body>
</html>
