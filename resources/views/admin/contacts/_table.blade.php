<table id="datatable-buttons" class="table table-striped table-bordered ">
    <thead>
    <tr>
        <th>{!! __("Name") !!}</th>
        <th>{!! __("Phone") !!}</th>
        <th>{!! __("Seen") !!}</th>
        <th>{!! __("Email") !!}</th>
        <th>{!! __("Subject") !!}</th>
        <th>{!! __("Message") !!}</th>
        <th>{!! __("Replay") !!}</th>
        <th>{!! __('Actions') !!}</th>

    </tr>
    </thead>
    @foreach($contacts as $contact)

        <tr>
            @if ($contact->name != null)
                <td>{!! $contact->name !!}</td>
            @else
                <td>{!! __('No') !!} {!! __("Name") !!}</td>
            @endif
            @if ($contact->phone != null)
                <td>{!! $contact->phone !!}</td>
            @else
                <td>{!! __('No') !!} {!! __("Phone") !!}</td>
            @endif
            <td>{!! date('Y-m-d',strtotime($contact->seen_at)) !!}</td>
            <td>{!! $contact->email !!}</td>
            <td>{!! $contact->subject !!}</td>
            <td>{!! $contact->message !!}</td>
            <td>{!! $contact->reply !!}</td>
            {{-- <td>{!! optional($contact->admin)->name !!}</td> --}}
            <td>

            
            @component('admin.partials._edit_button',
                            [
                                'id'=>$contact->id,
                                'routeName'=>'contacts',
                                'permission'=>"edit-contacts"
                            ])
            @endcomponent

            @component('admin.partials._delete_button',
                            [
                                'id'=>$contact->id,
                                'routeName'=>'contacts',
                                'permission'=>"delete-contacts"
                            ])

            @endcomponent
            </td>

        </tr>
    @endforeach
    <tbody>

    </tbody>
</table>
