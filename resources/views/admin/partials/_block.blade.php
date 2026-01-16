{{--
@params required $blocked_at
@params required $id
@params required $permission
@params required $routeName
@params optional $textMessage
--}}
@can("Edit ". \Illuminate\Support\Str::title($permission) )
    <a class="btn btn-{!! !$blocked_at?'danger':'success' !!} text-white"
       onclick="
           Swal.fire({
           title: '{!! __('Are you sure?') !!}',
           text: '{!! $textMessage??__('The Record Will Not Be Available In System !') !!}',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
    {{--    @if(!$blocked_at)
           input: 'textarea',
           inputPlaceholder: '{!! __('Type your message here...') !!}',
           inputAttributes: {
           'aria-label': '{!! __('Type your message here') !!}'
           },
       @endif --}}
           confirmButtonText: ' {!! $blocked_at?  __('Yes, block it!'):__('Yes, Open it!') !!}'
           }).then((result) => {
           if (result.value) {
           var form= document.getElementById('{!! "block-$routeName-$id" !!}');
           var block_reason = document.createElement('INPUT');
           block_reason.name='block_reason';
           block_reason.value=result.value||null;
           form.appendChild(block_reason);
           form.submit();
           }
           });event.preventDefault()">
        <i class="fas  {!! !$blocked_at?'fa-ban':'fa-unlock-alt' !!} "></i>
    </a>
    <form action="{{ route("admin.$routeName.block",$id) }}" method="POST"
          style="display: none;"
          id="{!! "block-$routeName-$id" !!}">
        {!! csrf_field() !!}
        @method('post')
    </form>
@endcan
