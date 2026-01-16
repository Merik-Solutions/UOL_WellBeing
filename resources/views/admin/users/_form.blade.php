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
    <label for="phone">{!! __('Phone') !!} *</label>
    {!! Form::text('phone', null, [
    'class' => 'form-control',
    'parsley-trigger' => 'change',
    'id' => 'phone',
    'required',
    'placeholder' => __('Enter
    Phone'),
]) !!}
    @error('phone')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

</div>


<div class="form-group">
    <label for="image">{!! __('image') !!}</label>
    <input type="file" name="image" class="dropify"
        @if (isset($user)) data-default-file="{!! $user->image !!}" @endif />
    @error('image')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
