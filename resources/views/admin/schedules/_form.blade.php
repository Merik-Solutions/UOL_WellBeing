<table class="table  table-hover table-striped table-bordered">
    <thead>
        <tr>
            <th>{{__("Day")}}</th>
            <th>{{__("From")}}</th>
            <th>{{__("To")}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($schedules as $key=>$day)
        <tr>
            <td>
                <input name="schedule[{{$key}}][day]" type="hidden" value="{{$day->day}}">
                {{days()[$key]}}
            </td>
            <td>
                {!! Form::text("schedule[$key][from_time]",$day->from_time,['class'=>'form-control
                timepicker','parsley-trigger'=>'change','placeholder'=>__('From')]) !!}
                @error("schedule.{{$key}}.from_time")
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

            </td>
            <td>
                {!! Form::text("schedule[$key][to_time]",$day->to_time,['class'=>'form-control
                timepicker','placeholder'=>__('To')]) !!}
                @error("schedule.$key.to_time")
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </td>
        </tr>
            @endforeach
    </tbody>
</table>

