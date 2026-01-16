<style>
    .btn-green{
        background-color: #10c469;
    }
    .btn-indigo{
        background-color: #675aa9;
    }
    .item {
        flex: 1 0 25%;
        margin-bottom: 5px;    
        overflow: hidden;  
    }

</style>
<table  class="table table-striped table-bordered table-responsive   datatables">
    <thead>
    <tr>
        <th>{!! __("Name") !!}</th>
        <th>{!! __("Title") !!}</th>
        {{-- <th>{!! __("Email") !!}</th> --}}
        <th>{!! __("National Id") !!}</th>
        <th>{!! __("Phone") !!}</th>
        <th>{!! __("Price") !!}</th>
        <th>{!! __("Bank Title") !!}</th>
        <th>{!! __("Bank Name") !!}</th>
        <th>{!! __("IBAN") !!}</th>
        <th>{!! __("Date") !!}</th>

        <th>{!! __('Actions') !!}</th>

    </tr>
    </thead>
    <tbody>
    @foreach($doctors as $doctor)
        <tr>
            <td>{!! $doctor->name !!}</td>
            <td>{!! $doctor->title !!}</td>
            {{-- <td>{!! $doctor->email !!}</td> --}}
            <td>{!! $doctor->national_id !!}</td>
            <td>{!! $doctor->phone !!}</td>
            <td>{!! $doctor->price !!}</td>
            @if($doctor->banks == null)
            <td>{!! __("No Bank Title") !!}</td>
            <td>{!! __("No Bank Title") !!}</td>
            <td>{!! __("No Bank Title") !!}</td>
            @else
                {{-- @foreach ($doctor->banks as $bank) --}}
                <td>{!! $doctor?->banks?->data['account_holder_name'] ?? $doctor->banks->title  !!}</td>
                <td>{!! $doctor?->banks?->data['bank_name'] ?? $doctor->banks->bank_name  !!}</td>
                <td>{!! $doctor?->banks?->data['account_iban'] ?? $doctor->banks->iban  !!}</td>
                {{-- @endforeach --}}
            @endif
            <td>{!! $doctor->created_at !!}</td>
            {{-- <td> 
                <a href="{!! route('admin.doctor.package.status',$doctor->id) !!}" class="btn btn-warning">
                    Deactivite package    
                </a>
            </td> --}}
            <td class="d-flex" style="flex-wrap: wrap;">
                @component('admin.partials._edit_button',
                            [
                            'id'=>$doctor->id,
                            'blocked_at'=>$doctor->status,
                            'routeName'=>'doctors',
                            'textMessage'=>!!$doctor->blocked_at? __('This Doctor Would Not Be Available For Patients'):__("This Doctor Will Be Available For Patients "),
                            'permission'=>'edit-doctors'
                            ])
                @endcomponent
                {{-- @component('admin.partials._delete_button',
                                [
                                    'routeName'=>'doctors',
                                    'id'=>$doctor->id,
                                    'permission'=>'delete-doctors'
                                ])

                @endcomponent --}}


                <a href="{!! route('admin.doctors.block',$doctor) !!}" class="btn btn-danger item">
                    <i class="fas fa-ban text-white"></i>
                </a>

                <a href="{!! route('admin.schedules.index',$doctor->id) !!}" class="btn btn-indigo item">
                    <i class="fas fa-calendar text-white"></i>
                </a>
                <a href="{!! route('admin.doctor_profile',$doctor->id) !!}" class="btn btn-info item">
                    <i class="fas fa-eye text-white"></i>    
                </a>
                @if($doctor->isPackageActive == 1)
                    <a href="{!! route('admin.doctor.package.status',$doctor->id) !!}" class="btn btn-warning item">
                        Deactivite packages
                    </a>
                @else
                    <a href="{!! route('admin.doctor.package.status',$doctor->id) !!}" class="btn btn-green item">
                        Activite packages
                    </a>
                @endif    

            </td>
        </tr>
    @endforeach
    

    </tbody>
</table>
