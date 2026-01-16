{{--
@params int required  $id
@params int required  $routeName
@params string   $permission
--}}
@if(hasPermission($permission))

    <a href="{!! route('admin.'.$routeName.'.edit',$id) !!}" class="btn btn-primary item">
        <i class="fas fa-pencil-alt text-white"></i>
    </a>

@endif
