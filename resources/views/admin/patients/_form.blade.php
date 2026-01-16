<div class="form-group">
    <label for="name">{!! __('Name') !!} *</label>
    {!! Form::text('name', null, [
    'class' => 'form-control',
    'parsley-trigger' => 'change',
    'id' => 'name',
    'required',
    'placeholder' => __('Enter
    Name'),
]) !!}
    @error('name')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="birthdate">{!! __('Birthdate') !!} </label>
    {!! Form::text('birthdate', null, [
    'class' => 'form-control
    datepicker',
    'parsley-trigger' => 'change',
    'id' => 'birthdate',
    'parsley-trigger' => 'change',
    'required',
    'placeholder' => __('Birthdate'),
]) !!}
    @error('birthdate')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="gender">{!! __('Gender') !!} *</label>
    {!! Form::select('gender', [__('Male'), __('Female')], null, [
    'class' => 'form-control',
    'parsley-trigger' => 'change',
    'id' => 'gender',
    'data-parsley-type' => 'integer',
    'required',
    'placeholder' => __('Select
    Gender'),
]) !!}
    @error('gender')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

</div>

<div class="form-group">
    <label for="relation">{!! __('Relation') !!} *</label>
    {{-- 'myself', 'cousin', 'child', 'parent', 'wife', 'nephew' --}}
    {!! Form::select('relation', ['myself' => __('Myself'), 'parent' => __('Parent'), 'wife' => __('Wife'), 'child' => __('Child'), 'nephew' => __('Nephew'), 'cousin' => __('Cousin')], null, [
    'class' => 'form-control',
    'parsley-trigger' => 'change',
    'id' => 'relation',
    'data-parsley-type' => 'string',
    'required',
    'placeholder' => __('Select relation'),
]) !!}
    @error('relation')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

</div>




<div class="form-group">
    <label for="emailAddress">{!! __('Email address') !!} *</label>
    {!! Form::email('email', null, [
    'class' => 'form-control',
    'parsley-trigger' => 'change',
    'id' => 'emailAddress',
    'required',
    'placeholder' => __('Enter
    Email Address'),
]) !!}
    @error('email')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="national_id">{!! __('National Id') !!} </label>
    {!! Form::text('national_id', null, [
    'class' => 'form-control',
    'parsley-trigger' => 'change',
    'id' => 'national_id',
    'placeholder' => __('Enter
    National Id'),
]) !!}
    @error('national_id')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>


{{-- <div class="form-group">
    <label for="image">{!! __('image') !!}</label>
    <input type="file" name="image" class="dropify"
        @if (isset($patient)) data-default-file="{!! $patient->image !!}" @endif />
    @error('image')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div> --}}
