<table id="datatable-buttons" class="table table-striped table-bordered ">
    <thead>
        <tr>
            <th>{!! __('Doctor') !!}</th>           
            <th>{!! __('Patient') !!}</th>           
            <th>{!! __('Title') !!}</th>           
            {{-- <th>{!! __('Allergy') !!}</th>            --}}
            <th>{!! __('Date') !!}</th>           
            <th>{!! __('Action') !!}</th>           

        </tr>
    </thead>
    <tbody>
        @foreach ($clinical_notes as $note)
            <tr>
               
                <td>{!! $note->doctor?->name ?? 'Dr kinda' !!}</td>
                <td>{!! $note->patient?->name ?? 'No name' !!}</td>
                <td>{!! $note->title ?? 'n/a' !!}</td>
                {{-- <td>{!! $note->allergy ?? 'n/a' !!}</td> --}}
                <td>{!! date('d M Y g:i a', strtotime($note->created_at)) !!}</td>
                <td>
                    <a href="{{ route('admin.printNote', [$note?->id]) }}"
                        class="btn btn-secondary text-white" target="_blank">
                        <i class="fas fa-print text-white"></i>
                    </a>
                    <a class="btn btn-info text-white"
                        href="javascript:note_details('{{ $note?->id }}')">
                        {!! __('Details') !!}
                    </a>
                </td>

            </tr>
        @endforeach


    </tbody>
</table>
