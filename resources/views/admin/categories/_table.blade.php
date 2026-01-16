<table class="table table-striped table-bordered   datatable-buttons">
    <thead>
        <tr>
            <th>{!! __("image") !!}</th>
            <th>{!! __("Name") !!}</th>
            <th>{!! __("Date") !!}</th>
            <th>{!! __('Actions') !!}</th>

        </tr>
    </thead>
      <tbody>
    @foreach($categories as $category)
    <tr>
        <td>

        <a href="{!! $category->image !!}" data-fancybox >
            <img src="{!! $category->image !!}" width="100" height="100"/>
        </a>
    </td>
        <td>{!! $category->name !!}</td>
        <td>{!! $category->created_at !!}</td>
        <td>
           

            @component('admin.partials._edit_button',
                            [
                                'id'=>$category->id,
                                'routeName'=>'categories',
                                'permission'=>"edit-categories"
                            ])
            @endcomponent

            @component('admin.partials._delete_button',
                            [
                                'id'=>$category->id,
                                'routeName'=>'categories',
                                'permission'=>"delete-categories"
                            ])

            @endcomponent
        </td>
    </tr>
            @endforeach


    </tbody>
</table>

