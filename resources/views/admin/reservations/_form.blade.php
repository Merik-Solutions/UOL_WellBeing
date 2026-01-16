{{--'doctor_id', 'patient_id', 'schedule_id', 'date', 'from_time', 'to_time', 'communication_type', 'status_changed_at', 'status', 'description'--}}


<div class="form-group">
    <label for="doctor_id">{!! __("Doctor") !!} *</label>
    {!! Form::select('doctor_id',$doctors??[],null,['class'=>'form-control','parsley-trigger'=>'change','id'=>'doctor_id',"data-parsley-type"=>"integer",'required','placeholder'=>__('Select Doctor'),'onChange'=>'getSchedules()']) !!}
    @error('doctor_id')
    <span class="invalid-feedback d-block" role="alert">
     <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="doctor_id">{!! __("Patient") !!} *</label>
    {!! Form::select('patient_id',$patients??[],null,['class'=>'form-control','parsley-trigger'=>'change','id'=>'patient_id',"data-parsley-type"=>"integer",'required','placeholder'=>__('Select Patient')]) !!}
    @error('patient_id')
    <span class="invalid-feedback d-block" role="alert">
     <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>


<div class="form-group">
    <label for="date">{!! __("Date") !!}  </label>
    {!! Form::text('date',null,['class'=>'form-control datepicker','parsley-trigger'=>'change','id'=>'date','parsley-trigger'=>'change','required','placeholder'=>__('Select Date'),'onChange'=>'getSchedules()']) !!}
    @error('date')
    <span class="invalid-feedback d-block" role="alert">
     <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="communication_type">{!! __("Communication Type") !!} </label>
    {!! Form::select('communication_type',array_flip($communication_types),null,['class'=>'form-control select2','parsley-trigger'=>'change','id'=>'communication_type','placeholder'=>__('Communication Type'),]) !!}
    @error('communication_type')
    <span class="invalid-feedback d-block" role="alert">
     <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>


<div class="form-group">
    <label for="from_time">{!! __("From") !!} * </label>
    {!! Form::text('from_time',null,['class'=>'form-control timepicker','parsley-trigger'=>'change','id'=>'from_time','parsley-trigger'=>'change','required','placeholder'=>__('From')]) !!}
    @error('from_time')
    <span class="invalid-feedback d-block" role="alert">
     <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<div class="form-group">
    <label for="to_time">{!! __("To") !!} * </label>
    {!! Form::text('to_time',null,['class'=>'form-control timepicker','parsley-trigger'=>'change','id'=>'to_time','parsley-trigger'=>'change',
'required','placeholder'=>__('To')]) !!}
    @error('to_time')
    <span class="invalid-feedback d-block" role="alert">
     <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>


<div class="form-group">
    <label for="description">{!! __("Description ") !!} </label>
    {!! Form::textarea('description',null,['class'=>'form-control','parsley-trigger'=>'change','id'=>'description','placeholder'=>__('Enter Description')]) !!}
    @error('description')
    <span class="invalid-feedback d-block" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

@push('scripts')
    {{--  <script>
          var disabled_dates = [0, 1, 2, 3, 4, 5, 6];


          function EnableDay(day) {
              var selected_day = day - 2 >= 0 ? day - 2 : 6;
              var days = disabled_dates.slice();
              days.splice(day, 1);
              var date_selector = 'input[name="date"]';
              $(date_selector).replaceWith(document.querySelector(date_selector).outerHTML);
              $(date_selector).datepicker({
                  autoclose: true,
                  todayHighlight: true,
                  format: 'yyyy-mm-dd',
                  daysOfWeekDisabled: days

              });
          }

          $(document).ready(function () {
              var day = $('select[name="day"]').val();
              var selected_day = day - 2 >= 0 ? day - 2 : 6;
              var days = disabled_dates.slice();
              days.splice(day, 1);
              var date_selector = 'input[name="date"]';
              $(date_selector).replaceWith(document.querySelector(date_selector));
              $(date_selector).datepicker({
                  autoclose: true,
                  todayHighlight: true,
                  format: 'yyyy-mm-dd',
                  daysOfWeekDisabled: days

              });
          })
      </script>
  --}}
{{--
    <script>
        function getSchedules() {
            var date = $('input[name="date"]').val();
            var doctor = $('select[name="doctor_id"]').val();
            if (date != "" && doctor != "") {
                $.ajax({
                    method: 'post',
                    url: route('api.doctor.timetable'),
                    data: {
                        doctor_id: doctor,
                        date: date,
                    }
                })
            }
        }
    </script>--}}
@endpush
