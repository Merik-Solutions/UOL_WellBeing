@extends('admin.layouts.app')
@section('title') {!! __("Patient") !!} @endsection

@section('content')
<style>
    .profile-table tr td{
        padding: 10px 22px 10px 5px;
    }
    .text-blue-dark{
        color: #004f9c;
        font-weight: 600;
    }
    .nav-tabs .nav-item {
        flex-grow: 1;
        background: #f2f2f6;
        text-align: center;
        font-weight: 600;
        color: black;
    }
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: white;
    background-color: #74abff;
    border-color: #dee2e6 #dee2e6 #fff;
    }
    .days_header{
        display: flex;
        border-bottom: 1px solid gray;
        padding: 20px 10px;
    }
    .days_header div{
        width: 30%;
    }
    #reservationTable td{
        vertical-align: middle;

    }
</style>
<div style="background: white; padding:30px;">
    <div class="row m-0 p-0 mb-5">
        <div class="col-sm-12 col-md-4 align-self-center align-self-lg-end">
            <div class="p-1" style="border:1px solid blue;width: 350px;height: 350px;">
                <img 
                src="@if($patient) {{url($patient->user->image)}} @endif" onerror="this.src='{!! asset('dashboard/logo.png') !!}'"
                alt="Patient image" style="width: 100%;height: 100%;object-fit: cover;"/>
            </div>
        </div>
        <div class="col-sm-12 col-md-8 mt-4 align-self-center align-self-lg-end">
            <div>
                <div class="p-1 mb-2 d-flex align-items-center">                    
                    <div style="width:100px; height:100px;">
                         <img src="{!! assets('dashboard/patient_logo.png') !!}" 
                            alt="Patient Logo" style="width: 100%;height: 100%;object-fit: fill;"/>
                    </div>
                    <h1 class="text-blue">Patient Info</h1>
                </div>
                <div>
                    <table class="profile-table">
                        <tr>
                            <td><b>Name:</b></td>
                            <td><span class="text-blue-dark">{{$patient->name}}</span></td>
                            <td><b>Email:</b></td>
                            <td><a href = "mailto: {{$patient->email}}"><span class="text-blue-dark">{{$patient->email}}</span></a></td>
                            <td><b>Contact:</b></td>
                            <td><span class="text-blue-dark">{{$patient->user->phone}}</span></td>
                        </tr>
                        <tr>
                            <td><b>National Id:</b></td>
                            <td><span class="text-blue-dark">{{$patient->national_id}}</span></td>
                            <td><b>Birth Date:</b></td>
                            <td><span class="text-blue-dark">{{$patient->birthdate}}</span></td>
                            <td><b>Gender:</b></td>
                            <td><span class="text-blue-dark">{{$patient->gender == 0 ? 'Male' : 'Female'}}</span></td>
                        </tr>                        
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3 px-md-3">
        <div class="col-12 pb-2"><h2>Reservation List</h2></div>

        <div class="col-12">
            <table class="table table-striped" id="reservationTable">
                <thead>
                    <tr>                    
                        <th>Doctor Name</th>
                        <th>Appt Date</th>
                        <th>Appt Time</th>
                        <th>Payment</th>
                        <th>Detail</th>
                    
                    </tr>
                </thead>
                <tbody> 
                    @foreach($reservations as $reservation)
                        <tr class="align-items-center">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="mr-2" style="width:40px; height:40px;">
                                        <img  
                                        src="@if($reservation->doctor) {{url($reservation->doctor->image)}} @endif" onerror="this.src='{!! assets('dashboard/logo.png') !!}'" 
                                        alt="image" style="width: 100%;height: 100%;object-fit: cover;"/>
                                    </div>
                                    {{$reservation->doctor->name_en}}
                                </div>
                            </td>
                            <td>{{$reservation->date}}</td>
                            <td>{{date('h:i a', strtotime($reservation->from_time))}}</td>
                            <td>{{number_format($reservation->price,2)}}</td>
                            <td> <a class="btn btn-primary py-1" href="javascript:show_reservation('{{$reservation->id}}')"><i class="fas fa-eye text-white mr-1"></i>view</a> </td>

                        </tr>
                    @endforeach             
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mb-3 px-md-3">
        <div class="col-12 pb-2"><h2>Packages List</h2></div>
        <div class="col-12">
            <table class="table table-striped" id="packageTable">
                <thead>
                    <tr>                    
                        <th>Doctor Name</th>
                        <th>Package Title</th>
                        <th>Expire Date</th>
                        <th>Price</th>
                        <th>Details</th>                    
                    </tr>
                </thead>

                <tbody>
                    @foreach($packages as $package)
                        <tr class="align-items-center">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="mr-2" style="width:40px; height:40px;">
                                        <img 
                                        src="{{$package->patient->image ? url($package->patient->image) : assets('dashboard/logo.png') }}" 
                                        alt="image" style="width: 100%;height: 100%;object-fit: cover;"/>
                                    </div>
                                    {{$package->doctor->name}}
                                </div>
                            </td>
                            <td>{{$package->package->name_en}}</td>
                            <td>{{date('d M Y h:i a', strtotime($package->expired_at))}}</td>
                            <td>{{number_format($package->price,2)}}</td>
                            <td><a class="btn btn-primary py-1" href="javascript:show_package_details('{{$package->id}}')">
                                    <i class="fas fa-eye text-white mr-1"></i>view
                                </a>
                             </td>                        
                        </tr>
                    @endforeach                
                </tbody>
            </table>
        </div>
    </div>


    <!-- Show reservation details modal -->
    <div id="reservation_div"></div>
    <!-- Show package details modal -->
    <div id="package_div"></div>
</div>

@endsection
@push('scripts')

<script>
    $(document).ready(function(){
        $('#reservationTable').dataTable();
        $('#packageTable').dataTable();
    });

     function show_reservation(reservation_id){
        $.ajax("{{url('admin/en/get_reservation_detail')}}",{            
            method: 'post',
            data: { reservation_id},  // data to submit
            success: function (data) {  
                $('#reservation_div').html(data);                
                $('#reservation_modal').modal('show');
            },
            error: function (error) {                
            }
        });
    }

    function show_package_details(package_id){
        $.ajax("{{url('admin/en/get_package_detail')}}",{            
            method: 'post',
            data: {package_id},  // data to submit
            success: function (data) {  
                $('#package_div').html(data);                
                $('#package_modal').modal('show');
            },
            error: function (error) {                
            }
        });
    }
</script>
@endpush