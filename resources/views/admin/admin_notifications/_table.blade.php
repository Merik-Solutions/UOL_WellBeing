<table class="table table-striped table-bordered   datatable-buttons">
    <thead>
        <tr>
            <th>{!! __("#") !!}</th>
            <th>{!! __("Notification Title") !!}</th>
            <th>{!! __("File") !!}</th>
            <th>{!! __("Date") !!}</th>
            <th>{!! __('Actions') !!}</th>

        </tr>
    </thead>
      <tbody>
    @foreach($notifications as $notification)
    @php
        $video_url = null;
        if($notification->file_url){
            $video = explode('video__',$notification->file_url);
            if(!empty($video[1])){
                $video_url = $video[1];
            }
        }   
    @endphp
    <tr>
        <td>
            {{$loop->iteration}}
    </td>
        <td>{!! $notification->title !!}</td>
        <td>
            @if($notification->file_url)
                @if($video_url)
                    <a href="{!! $video_url !!}" data-fancybox>View Video</a>
                @else
                    <a href="{!! $notification->file_url !!}" data-fancybox>
                        <img src="{{$notification->file_url}}" width="50" height="50" alt="file url"/>
                    </a>
                @endif
            @else
                n/a
            @endif
        </td>
        <td>{!! $notification->created_at !!}</td>
        <td>
            @component('admin.partials._delete_button',
                [
                    'routeName'=>'notifications',
                    'id'=>$notification->id,
                    'permission'=>"delete-notifications"
                ])

            @endcomponent
        </td>
    </tr>
            @endforeach


    </tbody>
</table>

