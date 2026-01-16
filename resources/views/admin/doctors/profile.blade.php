@extends('admin.layouts.app')
@section('title') {!! __("Doctor") !!} @endsection

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
                  @if($doctor?->image)
                <img src="@if($doctor) {{url($doctor->image)}} @endif" onerror="this.src='{!! assets('dashboard/logo.png') !!}'"
                alt="Doctor" style="width: 100%;height: 100%;object-fit: cover;"/>
                @else
                    <img src="{{ assets('dashboard/logo.png')}}" alt="Doctor" style="width: 100%;height: 100%;object-fit: cover;"/>
                @endif
            </div>
        </div>
        <div class="col-sm-12 col-md-8 mt-4 align-self-center align-self-lg-end">
            <div>
                <div class="p-1 mb-2 d-flex align-items-center">                    
                    <div style="width:100px; height:100px;">
                         <img src="{!! assets('dashboard/doctor_logo.png') !!}" 
                            alt="Doctor Logo" style="width: 100%;height: 100%;object-fit: fill;"/>
                    </div>
                    <h1 class="text-blue pl-2">Doctor Info</h1>
                </div>
                <div>
                    <table class="profile-table">
                        <tr>
                            <td><b>Name:</b></td>
                            <td><span class="text-blue-dark">{{$doctor->name_en}}</span></td>
                            <td><b>Email:</b></td>
                            <td><a href="mailto:{{$doctor->email}}"><span class="text-blue-dark">{{$doctor->email}}</span></a></td>
                            <td><b>Contact:</b></td>
                            <td><span class="text-blue-dark">{{$doctor->phone}}</span></td>
                        </tr>
                        <tr>
                            <td><b>National Id:</b></td>
                            <td><span class="text-blue-dark">{{$doctor->national_id}}</span></td>
                            <td><b>Gender:</b></td>
                            <td><span class="text-blue-dark">{{$doctor->gender == 0 ? 'Male' : 'Female'}}</span></td>
                            {{-- <td><b>Rating:</b></td>
                            <td><span class="text-blue-dark">n/a</span></td> --}}
                        </tr>
                        {{-- <tr>
                            <td><b>Zip Code:</b></td>
                            <td><span class="text-blue-dark">n/a</span></td>
                            <td><b>Address:</b></td>
                            <td colspan="3"><span class="text-blue-dark">{{$doctor->company_name}}</span> </td>
                        </tr>
                        <tr>
                            <td><b>City:</b> </td>
                            <td><span class="text-blue-dark">n/a</span></td>
                            <td><b>State:</b> </td>
                            <td><span class="text-blue-dark">n/a</span></td>
                            <td><b>Country:</b> </td>
                            <td><span class="text-blue-dark">{{$doctor->country?->name_en ?? 'n/a'}}</span></td>
                        </tr> --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="pt-4">
                    <nav>
                        <div class="nav nav-tabs" id="doctors-tab" role="tablist">
                            <a class="nav-item nav-link active" id="schedules-tab" data-toggle="tab"
                               href="#schedules" role="tab" aria-controls="schedules-tab"
                               aria-selected="true">{!! __("Schedules") !!}</a>
            
                            <a class="nav-item nav-link" id="reservation-list" data-toggle="tab" href="#reservation"
                               role="tab" aria-controls="reservation-list"
                               aria-selected="false">{!! __("Reservation List") !!}</a>
            
                            <a class="nav-item nav-link" id="packages-list" data-toggle="tab" href="#packages"
                               role="tab" aria-controls="packages-list"
                               aria-selected="false">{!! __("Packages List") !!}</a>
                            
                            <a class="nav-item nav-link" id="rating-list" data-toggle="tab" href="#ratings"
                               role="tab" aria-controls="rating-list"
                               aria-selected="false">{!! __("Rating & Reviews") !!}</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="doctors-tabContent">
                        <div class="tab-pane fade show active" id="schedules" role="tabpanel"
                             aria-labelledby="sub-cat-tab">
                             <div class="row">
                                <div class="col-12">
                                    <div class="card-box">
                                        <div class="card-title"><h2>Schedules</h2></div>
                                        <div class="pt-1">
                                            <nav>
                                                <div class="nav nav-tabs" id="days-tab" role="tablist">
                                                    <a class="nav-item nav-link active" id="sunday-tab" data-toggle="tab"
                                                       href="#sunday" role="tab" aria-controls="sunday"
                                                       aria-selected="true">{!! __("Sunday") !!}</a>
                                                    <a class="nav-item nav-link" id="sub-cat-tab" data-toggle="tab" href="#monday"
                                                       role="tab" aria-controls="monday"
                                                       aria-selected="false">{!! __("Monday") !!}</a>
                                                    <a class="nav-item nav-link" id="sub-cat-tab" data-toggle="tab" href="#tuesday"
                                                       role="tab" aria-controls="tuesday"
                                                       aria-selected="false">{!! __("Tuesday") !!}</a>
                                                    <a class="nav-item nav-link" id="sub-cat-tab" data-toggle="tab" href="#wednesday"
                                                       role="tab" aria-controls="wednesday"
                                                       aria-selected="false">{!! __("Wednesday") !!}</a>
                                                    <a class="nav-item nav-link" id="sub-cat-tab" data-toggle="tab" href="#thursday"
                                                       role="tab" aria-controls="thursday"
                                                       aria-selected="false">{!! __("Thursday") !!}</a>
                                                    <a class="nav-item nav-link" id="sub-cat-tab" data-toggle="tab" href="#friday"
                                                       role="tab" aria-controls="friday"
                                                       aria-selected="false">{!! __("Friday") !!}</a>
                                                    <a class="nav-item nav-link" id="sub-cat-tab" data-toggle="tab" href="#saturday"
                                                       role="tab" aria-controls="saturday"
                                                       aria-selected="false">{!! __("Saturday") !!}</a>
                                                </div>
                                            </nav>
                                            <div class="tab-content" id="days-tabContent">
                        
                                                @php
                        
                                                    $days = ['sunday','monday','tuesday','wednesday' ,'thursday','friday','saturday'];
                                                
                                                @endphp
                        
                                                <h3>Time Slots</h3>
                        
                                                @foreach($days as $day)
                                                    <div class="tab-pane fade {{$loop->first ? 'active show' : ''}}" id="{{$day}}" role="tabpanel" aria-labelledby="sub-cat-tab">
                                                        <div class="days_header">
                                                            <div class="start_time text-success">
                                                                Start Time
                                                            </div>
                                                            <div class="end_time text-success">
                                                                End Time
                                                            </div>
                                                            <div class="hospital_name text-success">
                                                                Hospital Name
                                                            </div>
                                                        </div>
                        
                                                        @if(isset($schedule[$loop->index]))
                                                            <div class="days_header">
                                                                <div class="start_time">
                                                                    {{date('H:i',strtotime($schedule[$loop->index]->from_time))}}
                                                                </div>
                                                                <div class="end_time">
                                                                {{ date('H:i',strtotime($schedule[$loop->index]->to_time))}}
                                                                </div>
                                                                <div class="hospital_name">
                                                                {{$doctor->company_name}}
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <div class="tab-pane fade " id="reservation" role="tabpanel" aria-labelledby="sub-cat-tab">
                            <div class="row mb-3 px-md-3">
                                <div class="col-12 pb-2"><h2>Reservation List</h2></div>
                                <div class="col-12">
                                    <table class="table table-striped" id="reservationTable">
                                        <thead>
                                            <tr>                    
                                                <th>Patient Name</th>
                                                <th>Appt Date</th>
                                                <th>Appt Time</th>
                                                <th>Payment</th>
                                                <th>Details</th>                    
                                            </tr>
                                        </thead>
                        
                                        <tbody>
                                            @foreach($reservations as $reservation)
                                                <tr class="align-items-center">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="mr-2" style="width:40px; height:40px;">
                                                                <img 
                                                                src="{{$reservation->patient->image ? url($reservation->patient->image) : assets('dashboard/logo.png') }}" 
                                                                alt="image" style="width: 100%;height: 100%;object-fit: cover;"/>
                                                            </div>
                                                            {{$reservation->patient->name}} 
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
                        </div>
            
                        <div class="tab-pane fade " id="packages" role="tabpanel" aria-labelledby="sub-cat-tab">
                            <div class="row mb-3 px-md-3">
                                <div class="col-12 pb-2"><h2>Packages List</h2></div>
                                <div class="col-12">
                                    <table class="table table-striped" id="packageTable">
                                        <thead>
                                            <tr>                    
                                                <th>Patient Name</th>
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
                                                            {{$package->patient->name}}
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
                        </div>

                        <div class="tab-pane fade " id="ratings" role="tabpanel" aria-labelledby="sub-cat-tab">
                            <div class="row mb-3 px-md-3">
                                <div class="col-12 pb-2"><h2>Rating</h2></div>
                                <div class="col-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>                    
                                                <th>Patient</th>
                                                <th>Reservation Id</th>
                                                <th>Review</th>
                                                <th>Rate</th>
                                                <th>Date</th>                    
                                            </tr>
                                        </thead>
                        
                                        <tbody>
                                            @foreach($ratings ?? [] as $rate)
                                                <tr class="align-items-center">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="mr-2" style="width:40px; height:40px;">
                                                            <img 
                                                            src="{{$rate->patient->image ? url($rate->patient->image) : assets('dashboard/logo.png') }}" 
                                                            alt="image" style="width: 100%;height: 100%;object-fit: cover;"/>
                                                        </div>
                                                        {{$rate->patient->name}}
                                                    </div>
                                                </td>
                                                <td>{{$rate->reservation_id}}</td>
                                                <td>{{$rate->description}}</td>
                                                <td>{{$rate->rate}}</td>
                                                <td>{{date('d M Y h:i a', strtotime($rate->created_at))}}</td>
                                                                          
                                                </tr>
                                            @endforeach                
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
            
                    </div>
            
                </div>
                

            </div>
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