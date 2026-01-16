@extends('admin.layouts.app')
@section('title'){!! __("Home") !!} @endsection
@section('content')
<div class="row" x-data="{
        type:'all',
        doctors_count:'{{$doctors_count}}',
        reservations_count:'{{$reservations_count}}',
        patients_count:'{{$patients_count}}',
        duration_count:'{{$duration_count}}',
        patient_paid:'{{$patient_paid}}',
        doctor_due:'{{$doctor_due}}',
        doctor_paid:'{{$doctor_paid}}',
        withdraw_amount:'{{$withdraw_amount}}',
        withdraw_count:'{{$withdraw_count}}',
      async  updateData(type){
       let response=  await  fetch(`{{route("admin.update-statistics")}}?type=${type}`)
      let data =await     response.json()
        this.doctors_count=   data.doctors_count
        this.reservations_count=   data.reservations_count
        this.patients_count=   data.patients_count
        this.duration_count=   data.duration_count
        this.patient_paid=   data.patient_paid
        this.doctor_due=   data.doctor_due
        this.doctor_paid=data.doctor_paid
this.withdraw_amount=data.withdraw_amount
this.withdraw_count=data.withdraw_count
    }
    }" x-init="$watch('type',(typ)=>updateData(type))">
    <div class="col-md-12  my-3">

        <select class="form-control" name="period" x-model="type">
            <option value="monthly">{{__("Monthly")}}</option>
            <option value="yearly">{{__("Yearly")}}</option>
            <option value="all" selected>{{__("All")}}</option>
        </select>

    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-box">

            <h4 class="header-title mt-0 mb-3">{{__("No. of Reservations")}}</h4>

            <div class="widget-box-2">
                <div class="widget-detail-2 text-right">

                    <h2 class="font-weight-normal mb-1 overflow-hidden" x-text="reservations_count"> </h2>
                    <p class="text-muted mb-3">{{__("Reservation")}}</p>
                </div>
                <div class="progress progress-bar-alt-success progress-sm">
                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                        aria-valuemax="100" style="width: 100%;">
                        {{-- <span class="sr-only">77% Complete</span> --}}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card-box">

            <h4 class="header-title mt-0 mb-3">{{__("No. of Doctors")}}</h4>

            <div class="widget-box-2">
                <div class="widget-detail-2 text-right">

                    <h2 class="font-weight-normal mb-1 overflow-hidden" x-text="doctors_count"> </h2>
                    <p class="text-muted mb-3">{{__("Doctor")}}</p>
                </div>
                <div class="progress progress-bar-alt-success progress-sm">
                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                        aria-valuemax="100" style="width: 100%;">
                        {{-- <span class="sr-only">77% Complete</span> --}}
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end col -->


    <div class="col-xl-3 col-md-6">
        <div class="card-box">


            <h4 class="header-title mt-0 mb-3">{{__("No. of Patient")}}</h4>

            <div class="widget-box-2">
                <div class="widget-detail-2 text-right">

                    <h2 class="font-weight-normal mb-1 overflow-hidden" x-text="patients_count"> </h2>
                    <p class="text-muted mb-3">{{__("Patient")}}</p>
                </div>
                <div class="progress progress-bar-alt-pink progress-sm">
                    <div class="progress-bar bg-pink" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                        aria-valuemax="100" style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>

    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <div class="card-box">


            <h4 class="header-title mt-0 mb-3">{{__("Total Video Minutes")}}</h4>

            <div class="widget-box-2">
                <div class="widget-detail-2 text-right">

                    <h2 class="font-weight-normal mb-1 overflow-hidden" x-text="duration_count"> </h2>
                    <p class="text-muted mb-3">{{__("Video Mintes")}}</p>
                </div>
                <div class="progress progress-bar-alt-red progress-sm">
                    <div class="progress-bar bg-red" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                        aria-valuemax="100" style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>

    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <div class="card-box">


            <h4 class="header-title mt-0 mb-3">{{__("Total Paid")}}</h4>

            <div class="widget-box-2">
                <div class="widget-detail-2 text-right">

                    <h2 class="font-weight-normal mb-1 overflow-hidden" x-text="patient_paid"> </h2>
                    <p class="text-muted mb-3">{{__("Riyal")}}</p>
                </div>
                <div class="progress progress-bar-alt-pink progress-sm">
                    <div class="progress-bar bg-pink" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                        aria-valuemax="100" style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>

    </div><!-- end col -->



    <div class="col-xl-3 col-md-6">
        <div class="card-box">


            <h4 class="header-title mt-0 mb-3">{{__("Doctor Due")}}</h4>

            <div class="widget-box-2">
                <div class="widget-detail-2 text-right">

                    <h2 class="font-weight-normal mb-1 overflow-hidden" x-text="doctor_due"> </h2>
                    <p class="text-muted mb-3">{{__("Riyal")}}</p>
                </div>
                <div class="progress progress-bar-alt-blue progress-sm">
                    <div class="progress-bar bg-blue" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                        aria-valuemax="100" style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- end col -->

    <div class="col-xl-3 col-md-6">
        <div class="card-box">


            <h4 class="header-title mt-0 mb-3">{{__("Doctor Paid")}}</h4>

            <div class="widget-box-2">
                <div class="widget-detail-2 text-right">

                    <h2 class="font-weight-normal mb-1 overflow-hidden" x-text="doctor_paid"> </h2>
                    <p class="text-muted mb-3">{{__("Riyal")}}</p>
                </div>
                <div class="progress progress-bar-alt-blue progress-sm">
                    <div class="progress-bar bg-blue" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                        aria-valuemax="100" style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card-box">


            <h4 class="header-title mt-0 mb-3">{{__("Withdraw Amount")}}</h4>

            <div class="widget-box-2">
                <div class="widget-detail-2 text-right">

                    <h2 class="font-weight-normal mb-1 overflow-hidden" x-text="withdraw_amount"> </h2>
                    <p class="text-muted mb-3">{{__("Riyal")}}</p>
                </div>
                <div class="progress progress-bar-alt-blue progress-sm">
                    <div class="progress-bar bg-blue" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                        aria-valuemax="100" style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-box">


            <h4 class="header-title mt-0 mb-3">{{__("Withdraw Count")}}</h4>

            <div class="widget-box-2">
                <div class="widget-detail-2 text-right">

                    <h2 class="font-weight-normal mb-1 overflow-hidden" x-text="withdraw_count"> </h2>
                    <p class="text-muted mb-3">{{__("Request")}}</p>
                </div>
                <div class="progress progress-bar-alt-blue progress-sm">
                    <div class="progress-bar bg-blue" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                        aria-valuemax="100" style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- end col -->

</div>
@endsection
