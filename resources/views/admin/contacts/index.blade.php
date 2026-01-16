@extends('admin.layouts.app')
@section('title')
    {!! __('Contacts') !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="mt-0 header-title d-inline">@yield('title')</h4>

                <div class="pt-4">
                    {{-- @include('admin.contacts._table') --}}

                    <nav>
                        <div class="nav nav-tabs" id="contact-tab" role="tablist">

                            <a class="nav-item nav-link active" id="active_contact-tab" data-toggle="tab"
                                href="#active_contact" role="tab" aria-controls="active_contact"
                                aria-selected="false">{!! __('New Contact') !!}
                            </a>

                            <a class="nav-item nav-link" id="responded-tab" data-toggle="tab" href="#responded"
                                role="tab" aria-controls="responded" aria-selected="false">{!! __('Responded') !!}
                            </a>

                        </div>
                    </nav>
                    <div class="tab-content" id="contact-tabContent">

                        <div class="tab-pane fade show active" id="active_contact" role="tabpanel"
                            aria-labelledby="open-contacts-tab">
                            {{-- @include('admin.contacts._table', ['contacts' => $contacts->where('reply','!=',null)]) --}}
                            <table id="datatable-buttons" class="table table-striped table-bordered  ">
                                <thead>
                                    <tr>
                                        <th>{!! __('Name') !!}</th>
                                        <th>{!! __('Phone') !!}</th>
                                        <th>{!! __('Seen') !!}</th>
                                        <th>{!! __('Email') !!}</th>
                                        <th>{!! __('Subject') !!}</th>
                                        <th>{!! __('Message') !!}</th>
                                        <th>{!! __('Replay') !!}</th>
                                        <th>{!! __('Actions') !!}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contacts->where('reply', null) as $contact)
                                        <tr>
                                            @if ($contact->name != null)
                                                <td>{!! $contact->name !!}</td>
                                            @else
                                                <td>{!! __('No') !!} {!! __('Name') !!}</td>
                                            @endif
                                            @if ($contact->phone != null)
                                                <td>{!! $contact->phone !!}</td>
                                            @else
                                                <td>{!! __('No') !!} {!! __('Phone') !!}</td>
                                            @endif
                                            <td>{!! date('Y-m-d', strtotime($contact->seen_at)) !!}</td>
                                            <td>{!! $contact->email !!}</td>
                                            <td>{!! $contact->subject !!}</td>
                                            <td>{!! $contact->message !!}</td>
                                            <td>{!! $contact->reply !!}</td>
                                            {{-- <td>{!! optional($contact->admin)->name !!}</td> --}}
                                            <td>
                                                @component('admin.partials._edit_button', [
                                                    'id' => $contact->id,
                                                    'routeName' => 'contacts',
                                                    'permission' => 'edit-contacts',
                                                ])
                                                @endcomponent

                                                @component('admin.partials._delete_button', [
                                                    'id' => $contact->id,
                                                    'routeName' => 'contacts',
                                                    'permission' => 'delete-contacts',
                                                ])
                                                @endcomponent
                                            </td>

                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade show" id="responded" role="tabpanel" aria-labelledby="open-contacts-tab">
                            {{-- @include('admin.contacts._table', ['contacts' => $contacts->where('reply',null)]) --}}
                            <table id="" class="table table-striped table-bordered datatable-buttons">
                                <thead>
                                    <tr>
                                        <th>{!! __('Name') !!}</th>
                                        <th>{!! __('Phone') !!}</th>
                                        <th>{!! __('Seen') !!}</th>
                                        <th>{!! __('Email') !!}</th>
                                        <th>{!! __('Subject') !!}</th>
                                        <th>{!! __('Message') !!}</th>
                                        <th>{!! __('Replay') !!}</th>
                                        <th>{!! __('Actions') !!}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contacts->where('reply','!=', null) as $contact)
                                        <tr>
                                            @if ($contact->name != null)
                                                <td>{!! $contact->name !!}</td>
                                            @else
                                                <td>{!! __('No') !!} {!! __('Name') !!}</td>
                                            @endif
                                            @if ($contact->phone != null)
                                                <td>{!! $contact->phone !!}</td>
                                            @else
                                                <td>{!! __('No') !!} {!! __('Phone') !!}</td>
                                            @endif
                                            <td>{!! date('Y-m-d', strtotime($contact->seen_at)) !!}</td>
                                            <td>{!! $contact->email !!}</td>
                                            <td>{!! $contact->subject !!}</td>
                                            <td>{!! $contact->message !!}</td>
                                            <td>{!! $contact->reply !!}</td>
                                            {{-- <td>{!! optional($contact->admin)->name !!}</td> --}}
                                            <td>
                                                @component('admin.partials._edit_button', [
                                                    'id' => $contact->id,
                                                    'routeName' => 'contacts',
                                                    'permission' => 'edit-contacts',
                                                ])
                                                @endcomponent

                                                @component('admin.partials._delete_button', [
                                                    'id' => $contact->id,
                                                    'routeName' => 'contacts',
                                                    'permission' => 'delete-contacts',
                                                ])
                                                @endcomponent
                                            </td>

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
@endsection
{{-- <script>
    let data_table = document.querySelectorAll('.datatable-buttons');
    console.log(data_table);
    data_table.DataTable({
        responsive: false,
        //  lengthChange: !1,
        paging: false,
        // order: [[ 0, 'DESC' ]],
        buttons: ["copy", "csv", "pdf"],
        //   keys: !0
    });
</script> --}}
