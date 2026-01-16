@extends('admin.layouts.app')
@section('title')
    {!! __('Chats') !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="mt-0 header-title d-inline">@yield('title')</h4>

                <div class="pt-4">

                    <table class="table table-striped table-bordered   datatable-buttons">
                        <thead>
                            <tr>
                                <th>{!! __('#') !!}</th>
                                <th>{!! __('Doctor Image') !!}</th>
                                <th>{!! __('Doctor Name') !!}</th>
                                <th>{!! __('Patient Image') !!}</th>
                                <th>{!! __('Patient Name') !!}</th>
                                <th>{!! __('Date') !!}</th>
                                <th>{!! __('Actions') !!}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($chats as $chat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{-- <a href="{!! @if ($chat->doctor) url(''.$chat->doctor?->image ?? '') @endif !!}" data-fancybox >
                                            <img src="{!! url(''.$chat?->doctor?->image ?? '')!!}" width="100" height="100"
                                            onerror="this.src='{!! assets('dashboard/logo.png') !!}'"/>
                                        </a> --}}

                                        @if ($chat?->doctor?->image)
                                            <a href="{{ url($chat->doctor?->image) }}" data-fancybox>
                                                <img src="{{ url($chat->doctor?->image) }}" width="100" height="100"
                                                    alt="{{ $chat->doctor?->name }}"
                                                    onerror="this.src='{!! assets('dashboard/logo.png') !!}'" />
                                            </a>
                                        @else
                                            <img src="{{ assets('dashboard/logo.png') }}" width="100" height="100" />
                                        @endif
                                    </td>
                                    <td>{!! $chat->doctor->name !!}</td>

                                    <td>
                                        {{-- <a href="{!! url(''.$chat->patient->image) !!}" data-fancybox >
                                            <img src="{!! url(''.$chat->patient->image) !!}" width="100" height="100"/>
                                        </a> --}}

                                        @if ($chat?->patient?->image)
                                            <a href="{{ url($chat->patient?->image) }}" data-fancybox>
                                                <img src="{{ url($chat->patient?->image) }}" width="100" height="100"
                                                    alt="{{ $chat->patient?->name }}"
                                                    onerror="this.src='{!! assets('dashboard/logo.png') !!}'" />
                                            </a>
                                        @else
                                            <img src="{{ assets('dashboard/logo.png') }}" width="100" height="100" />
                                        @endif


                                    </td>
                                    @if ($chat->patient->name != null)
                                        <td>{!! @$chat->patient->name !!}</td>
                                    @else
                                        <td>{!! @$chat->user->phone !!}</td>
                                    @endif
                                    <td>{!! @$chat->created_at !!}</td>
                                    <td>
                                        <a href="{{ route('admin.printChat', [$chat?->id]) }}"
                                            class="btn btn-secondary text-white" target="_blank">
                                            <i class="fas fa-print text-white"></i>
                                        </a>
                                        <a href="{!! route('admin.chats.show', $chat->id) !!}" class="btn btn-primary">
                                            <i class="fas fa-eye text-white"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
