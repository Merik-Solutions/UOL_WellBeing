<div class="form-group">
    <label for="name_ar">{!! __('Name In Arabic') !!} *</label>
    {!! Form::text('name_ar', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'name_ar', 'required', 'placeholder' => __('Enter Name In Arabic')]) !!}
    @error('name_ar')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group">
    <label for="name_en">{!! __('Name In English') !!} *</label>
    {!! Form::text('name_en', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'name_en', 'required', 'placeholder' => __('Enter Name In English')]) !!}
    @error('name_en')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>


<div class="form-group">
    <label for="iso">{!! __('ISO Code') !!} *</label>
    {!! Form::text('iso', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'iso', 'required', 'placeholder' => __('Enter ISO Code')]) !!}
    @error('iso')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>



<div class="form-group">
    <label for="code">{!! __('Phone code') !!} *</label>
    {!! Form::text('code', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'code', 'required', 'placeholder' => __('Enter Phone code')]) !!}
    @error('code')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>


<div class="form-group">
    <label for="flag">{!! __('Flag') !!}</label>
    <input type="file" name="flag" class="dropify"
        @if (isset($country)) data-default-file="{!! $country->flag !!}" @endif />
    @error('flag')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
