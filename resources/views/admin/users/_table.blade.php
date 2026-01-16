<table id="datatable-buttons" class="table table-striped table-bordered    ">
    <thead>
        <tr>
            <th>{!! __('#') !!}</th>
            <th>{!! __('Image') !!}</th>
            <th>{!! __('Name ') !!}</th>
            <th>{!! __('Email') !!}</th>
            <th>{!! __('National Id') !!}</th>
            <th>{!! __('Phone') !!}</th>
            <th>{!! __('Date') !!}</th>
            <th>{!! __('Actions') !!}</th>
        </tr>
    </thead>
    <tbody>
        {{-- @dd($users) --}}
        @foreach ($users as $user)
        @if (isset($user->patients) && $user->patients)
                @foreach ($user->patients as $patient)
                    <tr>
                        <td>{!! $loop->iteration !!}</td>
                        <td>
                            <a href="@if ($patient) {{ url($patient?->image ?? asset(avatar())) }} @endif"
                                data-fancybox>
                                <img src="@if ($patient) {{ url($patient?->image ?? asset(avatar())) }} @endif"
                                    width="100" height="100" alt="{{ $patient->name }}"
                                    onerror="this.src='{!! assets('dashboard/logo.png') !!}'" />
                            </a>
                        </td>
                        <td>{!! $patient ? $patient->name : 'No Name' !!}</td>
                        <td>{!! $patient ? $patient->email : 'No Email' !!}</td>
                        <th>{!! $patient ? $patient->national_id : 'No Id' !!}</th>
                        <td>{!! $user->phone !!}</td>
                        <td>{!! $patient->created_at !!}</td>
                        <td>
                            <a href="{!! route('admin.patient_profile', $user->id) !!}" class="btn btn-dark">
                                <i class="fas fa-eye text-white"></i>
                            </a>
                            @if (hasPermission('show-patients'))
                                <a href="{!! route('admin.users.patients.index', $user->id) !!}" class="btn btn-primary">
                                    <i class="fas fa-users text-white"></i>
                                </a>
                            @endif
                            @component('admin.partials._edit_button', [
                                'id' => $user->id,
                                'routeName' => 'users',
                                'permission' => 'edit-users',
                            ])
                            @endcomponent
                            {{-- @component('admin.partials._delete_button', [
                                    'id' => $user->id,
                                    'routeName' => 'users',
                                    'permission' => 'delete-users',
                                ])
                            @endcomponent --}}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>{!! $loop->iteration !!}</td>
                    <td>
                        <a href="@if ($user) {{ url($user?->image ?? asset(avatar())) }} @endif"
                            data-fancybox>
                            <img src="@if ($user) {{ url($user?->image ?? asset(avatar())) }} @endif"
                                width="100" height="100" alt="{{ $user->name }}"
                                onerror="this.src='{!! assets('dashboard/logo.png') !!}'" />
                        </a>
                    </td>
                    <td>{!! $user ? $user->name : 'No Name' !!}</td>
                    <td>{!! $user ? $user->email : 'No Email' !!}</td>
                    <th>{!! $user ? $user->national_id : 'No Id' !!}</th>
                    <td>{!! $user->phone !!}</td>
                    <td>{!! $user->created_at !!}</td>
                    <td>
                        <a href="{!! route('admin.patient_profile', $user->id) !!}" class="btn btn-dark">
                            <i class="fas fa-eye text-white"></i>
                        </a>
                        @if (hasPermission('show-patients'))
                            <a href="{!! route('admin.users.patients.index', $user->id) !!}" class="btn btn-primary">
                                <i class="fas fa-users text-white"></i>
                            </a>
                        @endif
                        @component('admin.partials._edit_button', [
                            'id' => $user->id,
                            'routeName' => 'users',
                            'permission' => 'edit-users',
                        ])
                        @endcomponent
                        {{-- @component('admin.partials._delete_button', [
                                'id' => $user->id,
                                'routeName' => 'users',
                                'permission' => 'delete-users',
                            ])
                        @endcomponent --}}
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
