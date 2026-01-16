<div class="form-group">
    <label for="{!! $setting->name !!}">{!! __($setting->slug) !!} *</label>

    {!! Form::$type('value',$setting->value,['class'=>'form-control','parsley-trigger'=>'change','id'=>$setting->name,'required']) !!}
</div>
