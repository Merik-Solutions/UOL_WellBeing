<table id="datatable-buttons" class="table table-striped table-bordered  ">
    <thead>
        <tr>
            <th>{!! __('#') !!}</th>
            {{-- <th>{!! __('Image') !!}</th> --}}
            <th>{!! __('Code') !!}</th>
            <th>{!! __('Name') !!}</th>
            <th>{!! __('Email') !!}</th>
            <th>{!! __('National Id') !!}</th>
            <th>{!! __('Relation') !!}</th>
            <th>{!! __('Gender') !!}</th>
            <th>{!! __('Date') !!}</th>
            <th>{!! __('Actions') !!}</th>

        </tr>
    </thead>
    @foreach ($patients as $patient)
        <tr>
            <td>{!! $loop->iteration !!}</td>
            {{-- <td>

                <a href="{!! $patient->image !!}" data-fancybox>
                    <img src="{!! $patient->image !!}" width="100" height="100" alt="{{ $patient->name }}"
                        onerror="this.src='{!! asset('dashboard/logo.png') !!}'" />
                </a>
            </td> --}}
            <td>{!! $patient->medical_history !!}</td>
            <td>{!! $patient->name !!}</td>
            <td>{!! $patient->email !!}</td>
            <td>{!! $patient->national_id !!}</td>
            <td>{!! __(\Str::title($patient->relation)) !!}</td>
            <td>{!! $patient->gender == 0 ? __('Male') : __('Female') !!}</td>
            <td>{!! $patient->created_at !!}</td>

            <td>
            

                {{-- @can('Edit ' . \Illuminate\Support\Str::title('patient'))
                    <a href="{!! route('admin.patients.edit', $patient->id) !!}" class="btn btn-primary">
                        <i class="fas fa-pencil-alt text-white"></i>
                    </a>
                @endcan --}}


                   {{-- @if(hasPermission('delete-patients'))
                    <a class="btn btn-warning text-white" onclick="
                                Swal.fire({
                                title: '{!! __('Are you sure?') !!}',
                                text: '{!! __('You Will Not be able to revert this!') !!}',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: '{!! __('Yes, delete it!') !!}'
                                }).then((result) => {
                                if (result.value) {document.getElementById('destroy-user-patient-{{ $patient->id }}').submit();}
                                });event.preventDefault()">
                            <i class=" fas fa-times"></i>
                        </a>
                        <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST"
                            style="display: none;" id="destroy-user-patient-{{ $patient->id }}">
                            {!! csrf_field() !!}
                            @method('delete')
                        </form>
                    @endif --}}

            </td>
        </tr>
    @endforeach
    <tbody>

    </tbody>
</table>
