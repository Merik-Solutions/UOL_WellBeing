{{--
@params int required  $id
@params int required  $routeName
@params string required  $permission

--}}

@if(hasPermission($permission))
    <a class="btn btn-warning text-white"
       onclick="
           Swal.fire({
           title: '{!! __('Are you sure?') !!}',
           text: '{!! __('You Will Not be able to revert this!') !!}',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: '{!! __('Yes, delete it!') !!}'
           }).then((result) => {
           if (result.value) {document.getElementById('destroy-{!! $routeName !!}-{!! $id !!}').submit();}
           });event.preventDefault()">
        <i class=" fas fa-times"></i>
    </a>
    <form action="{{ route('admin.'.$routeName.'.destroy',$id) }}" method="POST"
          style="display: none;"
          id="destroy-{!! $routeName !!}-{!! $id !!}">
        {!! csrf_field() !!}
        @method('delete')
    </form>
@endif
