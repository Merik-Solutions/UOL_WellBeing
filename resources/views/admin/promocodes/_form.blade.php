<div class="form-group">
    <label for="code">{!! __("Code") !!} *</label>
    {!! Form::text('code',null,['class'=>'form-control','parsley-trigger'=>'change','id'=>'code','required','placeholder'=>__('Enter Code')]) !!}
    @error('code')
    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
    @enderror
</div>
<div class="form-group">
    <label for="type">{!! __("Type") !!} *</label>
    {!! Form::select('type',['reservation'=>__('Reservation'),'package'=>__('Package')],null,['class'=>'form-control','parsley-trigger'=>'change','id'=>'type','required','placeholder'=>__('Enter Type')]) !!}
    @error('type')
    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
    @enderror
</div>
<div class="form-group">
    <label for="use_time">{!! __("Use Times") !!} </label>
    {!! Form::number('use_time',null,['class'=>'form-control','parsley-trigger'=>'change','id'=>'use_time','placeholder'=>__('Enter Use Times')]) !!}
    @error('use_time')
    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
    @enderror
</div>
<div class="form-group">
    <label for="percent">{!! __("Percent") !!} *</label>
    {!! Form::number('percent',null,['class'=>'form-control','parsley-trigger'=>'change','id'=>'percent','max'=>100,'min'=>'0.5','step'=>'0.5','required','placeholder'=>__('Enter Percent')]) !!}
    @error('percent')
    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
    @enderror
</div>

<div class="form-group">
    <label for="expired_at">{!! __("Expired At") !!} </label>
    {!! Form::text('expired_at',null,['class'=>'form-control
    datepicker','parsley-trigger'=>'change','id'=>'expired_at','parsley-trigger'=>'change',
    'placeholder'=>__('Expired At')]) !!}
    @error('expired_at')
    <span class="invalid-feedback d-block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
