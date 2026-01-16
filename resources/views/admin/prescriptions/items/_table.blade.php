<table id="datatable-buttons" class="table table-striped table-bordered  ">
    <thead>
    <tr>
        <th>{!! __("Name In Arabic") !!}</th>
        <th>{!! __("Name In English") !!}</th>
        <th>{!! __("Area") !!}</th>
        <th>{!! __("Date") !!}</th>

        <th>{!! __('Actions') !!}</th>

    </tr>
    </thead>
    @foreach($blocks as $block)
        <tr>
            <td>{!! $block->name_ar !!}</td>
            <td>{!! $block->name_en !!}</td>
            <td>{!! optional($block->area)->name !!}</td>
            <td>{!! $block->created_at !!}</td>
            <td>
                @component('admin.partials._action_buttons',
                ['routeName'=>'blocks',
                'id'=>$block->id,
                'permission'=>'Block'])
                @endcomponent
            </td>
        </tr>
    @endforeach
    <tbody>

    </tbody>
</table>
