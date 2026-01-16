<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kinda health | Prescription</title>
    <link rel="icon" type="image/x-icon" href="https://i.ibb.co/2S9n3J8/logo.png" />
</head>

<body style="margin: 0; padding: 0">
    <div style="
        margin: 15px auto;
        font-family: monospace;
        padding: 0 15px;
        min-width: 148.5mm;
        min-height: 210mm;
        position: relative;
        box-sizing: border-box;
        background-color: #fff;
        border: 1px solid #f6f7ff;
        border-bottom: 0;
        /* border-top: #0a195c solid 10px; */
      ">

        <div style="display:block;width:100%;min-height:250px">
            <div class="left-content" style=" margin: 15px 0; float: left; width:50%">
                <img height="100" width="160" src="{!! assets('dashboard/logo.png') !!}" alt="" />
                <ul style="padding: 0; margin: 0;">
                    <li style="
                    list-style: none;
                    font-size: 20px;
                    margin-bottom: 10px;
                    text-transform: capitalize;
                    font-weight: bold;
                    ">
                        <span style="
                            display: inline-block;
                            font-weight: normal;
                        ">Medical file number</span>
                        <p>--- {{$prescription->patient?->id}} ---</p>
                    </li>
                </ul>
            </div>
            <div class="right-content" style="margin: 25px 0;float:right;width:50%">
                <ul style="padding: 0; margin: 0">
                    <li style="
                    list-style: none;
                    font-size: 25px;
                    margin-bottom: 10px;
                    text-transform: capitalize;
                    font-weight: bold;
                    ">
                        <span style="
                            display: inline-block;
                            min-width: 180px;
                            font-weight: normal;
                        ">Doctor</span>

                        <p>{{ $prescription->doctor?->name }}</p>
                    </li>
                    <li style="
                    list-style: none;
                    font-size: 15px;
                    margin-bottom: 10px;
                    text-transform: capitalize;
                    font-weight: bold;
                    ">
                        <span style="
                            display: inline-block;
                            min-width: 180px;
                            font-weight: normal;
                        ">Patient name</span> {{ $prescription->patient?->name }}
                    </li>
                    <li style="
                        list-style: none;
                        font-size: 15px;
                        margin-bottom: 10px;
                        text-transform: capitalize;
                        font-weight: bold;
                        ">
                        <span style="
                            display: inline-block;
                            min-width: 180px;
                            font-weight: normal;
                        ">Age</span>
                        {{ \Carbon\Carbon::parse($prescription->patient?->birthdate)->diffInYears() }} Years
                    </li>
                    <li style="
                    list-style: none;
                    font-size: 15px;
                    margin-bottom: 10px;
                    text-transform: capitalize;
                    font-weight: bold;
                    ">
                        <span style="
                            display: inline-block;
                            min-width: 180px;
                            font-weight: normal;
                        ">Date</span> {{ $prescription?->created_at->toDateString() }}
                    </li>
                </ul>
            </div>
        </div>
        <br>
        <div style="display:block;width:100%">
            <hr style="border-color: #eee3; margin-bottom: 20px" />
            <h5 style="
            font-size: 15px;
            margin: 15px 0;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            ">
                Diagnosis
            </h5>
            <h3 style="font-size: 14px; margin: 10px 0 10px 25px">
                {{ $prescription->diagnosis }}
            </h3>

            <hr style="border-color: #eee3; margin: 20px 0" />
            <h5 style="
            font-size: 15px;
            margin: 15px 0;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            ">
                Medications
            </h5>
            <ul>

                @foreach ($prescription->items as $item)
                <li style="
                list-style: none;
                font-size: 14px;
                margin-bottom: 10px;
                font-weight: bold;
            ">
                    {{ $item->name }} - {{ $item->dose }} {{ $item->dose_number }} - @if ($item->days != null)
                    for {{ $item->days }}
                    @endif
                </li>
                @endforeach

            </ul>
        </div>
        <footer style="
          display: flex;
          background-color: #f6f7ff;
          letter-spacing: -1px;
          width: 100%;
          max-width: 793.7007874px;
          border-bottom: #0a195c solid 10px;
          padding: 15px;
          position: absolute;
          bottom: 0;
          right: 0;
          left: 0;
          margin: auto;
          align-items: center;
          justify-content: space-between;
          box-sizing: border-box;
        ">
            <div class="sign" style="margin: 5px; min-width: 220px; float:left">
                <strong
                    style="display: block; margin-bottom: 0px;margin-top:5px">{{ $prescription->doctor?->name }}</strong>

                @if ($prescription->doctor?->license_number != null)
                Licence Num {{ $prescription->doctor?->license_number }}
                @endif
                @if ($prescription->doctor?->signature != null)
                <div style="width: 100px;height: 30px;">
                    <img src="{{url($prescription->doctor?->signature)}}" alt="" style="width: 100%; height:100%;object-fit: contain;">
                </div>
                @endif
            </div>
            <div class="sign" style="margin: 5px; min-width: 220px">

                @if ($prescription->doctor?->company_name != null || $prescription->doctor?->company_license != null)
                <strong
                    style="display: block; margin-bottom: 5px;margin-top:5px;">{{ $prescription->doctor?->company_name }}</strong>
                Licence Num {{ $prescription->doctor?->company_license }}
                @endif              

                <div style="
                    float:right;margin-top: -35px ">
                    {!! QrCode::size(70)->generate(Request::url()) !!}

                </div>
            </div>

        </footer>
    </div>
</body>

</html>
