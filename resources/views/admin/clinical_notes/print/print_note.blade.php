<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Kinda Health -  Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{!! assets('dashboard/logo.png') !!}"> 
    <!-- App css -->
    <link href="{!! assets('dashboard/light/assets/css/bootstrap.min.css') !!}" rel="stylesheet" type="text/css" />
    <link href="{!! assets('dashboard/light/assets/css/icons.min.css') !!}" rel="stylesheet" type="text/css" />
    @if (app()->getLocale() == 'ar')
        <link href="{!! assets('dashboard/light/assets/css/app-rtl.min.css') !!}" rel="stylesheet" type="text/css" />
    @else
        <link href="{!! assets('dashboard/light/assets/css/app.min.css') !!}" rel="stylesheet" type="text/css" />
    @endif
    <style type="text/css" media="print">
        .sf-toolbar{
            display: none !important;
        }
        #print_btn{
            display: none !important;
        }
    </style>    
    <style>
        #print_btn{
            background: black;
        }
        #print_btn:hover{
            background: #5d73ff;
        }
    </style>
</head>

<body class="left-side-menu-light">
    <!-- Begin page -->
    <div id="wrapper">
        <div style="width: 100%;position: fixed;text-align: center;margin-top: 5px;z-index: 999;">
            <a id="print_btn" href="javascript:window.print();" style="color: #f9f7f7;border: 1px solid #050101;padding: 5px 20px;border-radius: 8px;">
                Print Clinical Note
            </a>
        </div>
        <div class="content-page" style="margin-left: auto;margin-top:5px;padding:0;">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12" style="padding: 0px;">
                            <div class="card-box">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a href="https://kindahealth.com">www.kindahealth.com</a>
                                        <h3 class="align-self-center">kindahealth Clinical Note</h3>
                                    </div>
                                    <img height="100" width="150" src="{!! assets('dashboard/logo.png') !!}" alt="" />
                                </div>
                                <div class="pt-4">
                                    <table class="table table-striped table-bordered   datatable-buttons">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        {{ __('Doctor') }}
                                                    </strong>
                                                </td>
                                                <td>
                                                    {!! $note->doctor?->name ?? 'Dr Kinda' !!}
                                                    <br>
                                                    {!! $note->doctor?->email ?? 'Dr Kinda' !!}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        {{ __('Patient') }}
                                                    </strong>
                                                </td>
                                                @if ($note->patient?->name != null)
                                                    <td>{!! $note->patient?->name !!}</td>
                                                @else
                                                    <td>{!! $note->patient?->phone !!}</td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="row p-2">
                                        <div class="col-md-12 pt-2 px-3" style="border: 1px solid #dbdbdb;">
                                            <div class="row" style="padding-top: 10px;">
                                                <div class="col-12"><hr></div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Allergy:</label>
                                                        <p class="form-control border-0 rounded pr-0" style="height: auto;">
                                                            {{ $note?->allergy ?? 'No allergy' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Medical History:</label>
                                                        <p class="form-control border-0 rounded" style="height: auto;">
                                                            {{ Str::ucfirst($note?->title ?? 'No title') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                            </div>
                
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Diagnosis:</label>
                                                    <p class="form-control border-0 rounded" style="height: auto;">
                                                        {{ $note?->diagnosis ?? 'No description given' }}
                                                    </p>
                    
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Medications:</label>
                                                    <p class="form-control border-0 rounded" style="height: auto;">
                                                        {{ $note?->description ?? 'No description given' }}
                                                    </p>
                                                </div>                           
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2" style="font-size: 12px; display:flex; justify-content:space-between;">
                                        <div>
                                            <span style="margin-right: 5px;">Added on:</span>
                                            <span>{{ date('d M Y g:i a', strtotime($note?->created_at)) }}</span>
                                        </div>
                                        <div>
                                            <span style="margin-right: 5px;">Updated:</span>
                                            <span>{{ date('d M Y g:i a', strtotime($note?->updated_at ?? '')) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- container -->
            </div> <!-- content -->
        </div>
    </div>
    <!-- END wrapper -->
</body>
</html>
