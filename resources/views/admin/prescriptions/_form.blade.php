
<div class="form-group">
    <label for="diagnosis">{!! __("Diagnosis ") !!} </label>
    {!! Form::text('diagnosis',null,['class'=>'form-control','parsley-trigger'=>'change','id'=>'diagnosis','placeholder'=>__('Enter Diagnosis')]) !!}
    @error('diagnosis')
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

<hr>

@component('admin.prescriptions.items.create',['items'=>$prescription->items])
@endcomponent
{{--

<div class="row">
    <div class="col-12">
        <div class="card-box">
            <h4 class="mt-0 header-title d-inline">{!! __("Items") !!}</h4>
            <div class="mt-0 header-title float-right  d-inline">

                <a class="btn btn-info text-white">
                    <i class="fas fa-plus"></i> {!! __("Add Item")!!}</a>
            </div>
            <div class="pt-4">


                <table class="table table-striped table-bordered  ">
                    <thead>
                    <tr>
                        <th>{!! __("Medicine") !!}</th>
                        <th>{!! __("Dose") !!}</th>
                        <th>{!! __("Description") !!}</th>
                        <th>{!! __('Actions') !!}</th>

                    </tr>
                    </thead>
                    @foreach($prescription->items as $item)
                        <tr data-item-key="{!! $loop->iteration !!}" data-item-id="{!! $item->id !!}">
                            <td>{!! Form::text("items[$loop->iteration][medicine]",$item->medicine??null,['class'=>'form-control','parsley-trigger'=>'change','required']) !!}</td>
                            <td>{!! Form::text("items[$loop->iteration][dose]",$item->dose??null,['class'=>'form-control','parsley-trigger'=>'change','required']) !!}</td>
                            <td>{!! Form::textarea("items[$loop->iteration][description]",$item->description??null,['class'=>'form-control','parsley-trigger'=>'change','required']) !!}</td>
                            <td>
                                <a class=" btn btn-danger" onclick="alert('{!! $key !!}))'"> <i
                                        class="fas fa-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    <tbody>

                    </tbody>
                </table>


            </div>

        </div>
    </div>
</div>
--}}



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

