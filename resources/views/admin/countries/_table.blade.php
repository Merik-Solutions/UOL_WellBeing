<table class="table table-striped table-bordered   datatable-buttons">
    <thead>
        <tr>
            <th>{!! __('image') !!}</th>
            <th>{!! __('Name') !!}</th>
            <th>{!! __('ISO') !!}</th>
            <th>{!! __('Phone Code') !!}</th>
            <th>{!! __('Date') !!}</th>
            <th>{!! __('Actions') !!}</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($countries as $country)
            <tr>
                <td>

                    <a href="{!! $country->flag !!}" data-fancybox>
                        <img src="{!! $country->flag !!}" width="100" height="100" />
                    </a>
                </td>
                <td>{!! $country->name !!}</td>
                <td>{!! $country->iso !!}</td>
                <td>{!! $country->code !!}</td>
                <td>{!! $country->created_at !!}</td>
                <td>
                     @component('admin.partials._edit_button',
                            [
                                'id'=>$country->id,
                                'routeName'=>'countries',
                                'permission'=>"edit-countries"
                            ])
                    @endcomponent

                    @component('admin.partials._delete_button',
                                    [
                                        'id'=>$country->id,
                                        'routeName'=>'countries',
                                        'permission'=>"delete-countries"
                                    ])

                    @endcomponent

                </td>
            </tr>
        @endforeach


    </tbody>
</table>
