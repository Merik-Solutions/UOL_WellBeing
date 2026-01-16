<div class="form-group">
    <label for="name">{!! __("Name") !!} *</label>
    {!! Form::text('name',null,['class'=>'form-control','parsley-trigger'=>'change','id'=>'name','required','placeholder'=>__('Enter Name')]) !!}
    @error('name')
    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
    @enderror
</div>
<div class="form-group">
    <label for="emailAddress">{!! __("Email address") !!} *</label>
    {!! Form::email('email',null,['class'=>'form-control','parsley-trigger'=>'change','id'=>'emailAddress','required','placeholder'=>__('Enter Email Address')]) !!}
    @error('email')
    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
    @enderror
</div>
<div class="form-group">
    <label for="phone">{!! __("Phone") !!} *</label>
    {!! Form::text('phone',null,['class'=>'form-control','parsley-trigger'=>'change','id'=>'phone',"data-parsley-type"=>"integer",'required','placeholder'=>__('Enter Phone')]) !!}
    @error('phone')
    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
    @enderror

</div>
<div class="form-group">
    <label for="pass1">{!! __("Password") !!} @if(!isset($admin)) * @endif</label>
    <input id="pass1" name="password" type="password" placeholder="{!! __("Password") !!}" @if(!isset($admin)) required
           @endif
           class="form-control">
    @error('password')
    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
    @enderror
</div>
<div class="form-group">
    <label for="passWord2">{!! __("Confirm Password") !!} @if(!isset($admin)) * @endif</label>
    <input data-parsley-equalto="#pass1" name="password_confirmation" type="password" @if(!isset($admin)) required
           @endif
           placeholder="{!! __("Confirm Password") !!}" class="form-control" id="passWord2">
</div>

<div class="mb-3">
    <label for="role" class="form-label">Role</label>
    <select class="form-control"
        name="role" required>
        <option value="">Select role</option>
        @foreach($roles as $role)
            <option value="{{ $role->id }}"
                {{ in_array($role->name, $adminRole)
                    ? 'selected'
                    : '' }}>{{ $role->name }}</option>
        @endforeach
    </select>
    @if ($errors->has('role'))
        <span class="text-danger text-left">{{ $errors->first('role') }}</span>
    @endif
</div>


