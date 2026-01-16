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
                Print Chat
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
                                        <h3 class="align-self-center">KindaHealth Chat</h3>
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
                                                <td>{!! @$chat?->doctor?->name ?? 'Dr Kinda' !!}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        {{ __('Patient') }}
                                                    </strong>
                                                </td>
                                                @if ($chat?->patient?->name != null)
                                                    <td>{!! @$chat->patient->name !!}</td>
                                                @else
                                                    <td>{!! @$chat->patient->phone !!}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{ __('Files') }}
                                                </td>
                                                <td>
                                                    <div class="row gap-1">
                                                        @foreach ($files as $file)
                                                            <div class="col-1 rounded shadow-sm  bg-white text-center">
                                                                @php
                                                                    $image = explode('storage', $file->original_url);
                                                                    $img = $image[1] ?? '';
                                                                @endphp
                                                                <a href="{!! assets($img ? 'storage' . $img : '') !!}" data-fancybox>
                                                                    <img src="{!! assets($img ? 'storage' . $img : '') !!}"
                                                                        class="img-fluid" />
                                                                </a>
                                                                <span
                                                                    style="font-size:10px;margin-top: -5px; color:#567bff">
                                                                    {{ date('d M g:i a', strtotime($file?->created_at ?? '--:--')) }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <h4 class="mt-4">Messages</h4>
                                    <div class="mx-auto">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="card-text">
                                                    <div class="row py-4" style="background: aliceblue;">
                                                        @php
                                                            $doc = $messages->where('sender_type', 'App\Models\Doctor')->first();
                                                            $user = $messages->where('sender_type', 'App\Models\User')->first();
                                                            $doc_image = $doc->sender?->image ?? avatar();
                                                            $user_image = $user->sender?->image ?? avatar();
                                                        @endphp
                                                        @foreach ($messages ?? [] as $message)
                                                            <div
                                                                class="col-10 
                                                                @if ($message->sender_type != 'App\Models\Doctor') d-flex justify-content-end offset-2 @endif">
                                                                <div>
                                                                    <div class="d-flex align-items-center">
                                                                        <div
                                                                            style="width:25px;height:25px; margin-right:10px;">
                                                                            @if ($message->sender_type == 'App\Models\Doctor')
                                                                                <img src="{{ asset($doc_image) }}"
                                                                                    alt=""
                                                                                    style="border-radius:50%;width: 100%; height:100%; object-fit:cover;">
                                                                            @else
                                                                                <img src="{{ asset($user_image) }}"
                                                                                    alt=""
                                                                                    style="border-radius:50%;width: 100%; height:100%; object-fit:cover;">
                                                                            @endif
                                                                        </div>
                                                                        <div>
                                                                            @if ($message->sender_type != 'App\Models\Doctor')
                                                                                <div style="font-size:12px;">
                                                                                    {{ __('Patient') }}</div>
                                                                            @else
                                                                                <div style="font-size:12px;">
                                                                                    {{ __('Doctor') }}</div>
                                                                            @endif
                                                                            <div
                                                                                style="font-size:10px;margin-top: -5px; color:#567bff">
                                                                                {{ date('d M g:i a', strtotime($message?->created_at ?? date('d M g:i a'))) }}
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="ml-2"
                                                                        style="background: #e3e3e3;margin-bottom: 10px;border-radius: 20px;padding: 5px;width: fit-content;min-width: 60px;">
                                                                        @if (isset($message->original_url))
                                                                            <div style="width:200px;height:100%">
                                                                                @php
                                                                                    $image = explode('storage', $message->original_url);
                                                                                    $img = $image[1] ?? '';
                                                                                @endphp
                                                                                <a href="{!! assets($img ? 'storage' . $img : '') !!}"
                                                                                    data-fancybox>

                                                                                    <img src="{!! assets($img ? 'storage' . $img : '') !!}"
                                                                                        style="width: 100%; height:100%; object-fit:cover;" />
                                                                                </a>
                                                                            </div>
                                                                        @else
                                                                            @if (substr($message->message, 0, 7) == 'http://' || substr($message->message, 0, 8) == 'https://')
                                                                                <div style="width:200px;">
                                                                                    <a href="{!! $message->message !!}"
                                                                                        data-fancybox>
                                                                                        <img src="{{ assets($message->message) }}"
                                                                                            alt=""
                                                                                            style="width: 100%; height:100%; object-fit:cover;">
                                                                                    </a>
                                                                                </div>
                                                                            @else
                                                                                <div class="px-1">
                                                                                    {{ $message->message }}</div>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
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
