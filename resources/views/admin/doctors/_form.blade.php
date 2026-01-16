<div class="form-group">
    @if(isset($doctor))
        <input type="hidden" name="id" value="{{$doctor?->id}}">
    @endif
    <label for="name_ar">{!! __('Name In Arabic') !!} *</label>
    {!! Form::text('name_ar', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'name_ar', 'required', 'placeholder' => __('Enter Doctor Name In Arabic')]) !!}
    @error('name_ar')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="name">{!! __('Name In English') !!} *</label>
    {!! Form::text('name_en', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'name_en', 'required', 'placeholder' => __('Enter Name In English')]) !!}
    @error('name_en')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="title_ar">{!! __('Title In Arabic') !!} *</label>
    {!! Form::text('title_ar', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'title_ar', 'required', 'placeholder' => __('Enter Title In Arabic')]) !!}
    @error('title_ar')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="title_en">{!! __('Title In English') !!} *</label>
    {!! Form::text('title_en', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'title_en', 'required', 'placeholder' => __('Enter Title In English')]) !!}
    @error('title_en')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
            <span>
            @enderror
</div>


<div class="form-group">
    <label for="title_ar">{!! __('About doctor In Arabic') !!} *</label>
    {!! Form::textarea('description_ar', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'description_ar', 'required', 'placeholder' => __('Enter About doctor In Arabic')]) !!}
    @error('description_ar')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="description_en">{!! __('About doctor In English') !!} *</label>
    {!! Form::textarea('description_en', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'description_en', 'required', 'placeholder' => __('Enter About doctor In English')]) !!}
    @error('description_en')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
            <span>
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
    <label for="price">{!! __('Price') !!} *</label>
    {!! Form::number('price', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'price', 'data-parsley-type' => 'integer', 'required', 'placeholder' => __('Enter Price')]) !!}
    @error('price')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

</div>
<div class="form-group">
    <label for="period">{!! __('Period In Minutes') !!} *</label>
    {!! Form::number('period', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'period', 'data-parsley-type' => 'integer', 'required', 'placeholder' => __('Enter Price')]) !!}
    @error('period')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

</div>
{{-- company_name
license_number --}}
<div class="form-group">
    <label for="company_name">{!! __('Enter company name') !!} *</label>
    {!! Form::text('company_name', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'company_name', 'data-parsley-type' => 'string', 'required', 'placeholder' => __('Enter company name')]) !!}
    @error('company_name')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

</div>
<div class="form-group">
    <label for="company_license">{!! __('Enter company license') !!} *</label>
    {!! Form::text('company_license', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'company_license', 'data-parsley-type' => 'string', 'required', 'placeholder' => __('Enter company license')]) !!}
    @error('company_license')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

</div>
<div class="form-group">
    <label for="license_number">{!! __('license number') !!} *</label>
    {!! Form::text('license_number', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'license_number', 'data-parsley-type' => 'integer', 'required', 'placeholder' => __('license number')]) !!}
    @error('license_number')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

</div>


<div class="form-group">
    <label for="gender">{!! __('Gender') !!} *</label>
    {!! Form::select('gender', [__('Male'), __('Female')], null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'gender', 'data-parsley-type' => 'integer', 'required', 'placeholder' => __('Select Gender')]) !!}
    @error('gender')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

</div>


<div class="form-group">
    <label for="heal-cases-ar">{!! __('Heal Cases In Arabic') !!} </label>
    <select name="heal_cases_ar[]" class="select-tags" id="heal-cases-ar" required multiple>
        @foreach (old('heal_cases_ar', isset($doctor) ? $doctor->heal_cases_ar ?? [] : []) as $case)
            <option value="{{ $case }}" selected>{{ $case }} </option>
        @endforeach

    </select>
    @error('heal_cases_ar')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>


<div class="form-group">
    <label for="heal-cases-en">{!! __('Heal Cases In English') !!} </label>
    <select name="heal_cases_en[]" class="select-tags" id="heal-cases-en" required multiple>
        @foreach (old('heal_cases_en', isset($doctor) ? $doctor->heal_cases_en ?? [] : []) as $case)
            <option value="{{ $case }}" selected>{{ $case }} </option>
        @endforeach

    </select>
    @error('heal_cases_en')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>


<div class="form-group">
    <label for="category_id">{!! __('Select  Category ') !!} </label>
    {!! Form::select('category_id', $categories ?? [], null, ['class' => 'form-control select2', 'parsley-trigger' => 'change', 'id' => 'category_id', 'placeholder' => __('Category')]) !!}
    @error('category_id')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="emailAddress">{!! __('Email address') !!} *</label>
    {!! Form::email('email', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'emailAddress', 'required', 'placeholder' => __('Enter Email Address')]) !!}
    @error('email')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group">
    <label for="phone" style="width:100%;">{!! __('Phone') !!} *</label>
    {!! Form::text('phone', null, ['class' => 'form-control', 'id' => 'phone', 'required', 'placeholder' => __('Enter Phone')]) !!}
    @error('phone')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="country_id">{!! __('Select  Country ') !!} </label>
    {!! Form::select('country_id', $countries->pluck('name', 'id') ?? [], null, ['class' => 'form-control select2', 'parsley-trigger' => 'change', 'id' => 'country_id', 'placeholder' => __('Country')]) !!}    
    @error('country_id')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="expirence">{!! __('National ID') !!} *</label>
    {!! Form::number('national_id', null, ['class' => 'form-control', 'id' => 'national_id', 'required', 'placeholder' => __('Enter National Id')]) !!}
    @error('national_id')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

</div>

<div class="form-group">
    <label for="expirence">{!! __('Years Of Expirence') !!} *</label>
    {!! Form::number('expirence', null, ['class' => 'form-control', 'id' => 'expirence', 'required', 'placeholder' => __('Enter Expirence')]) !!}
    @error('expirence')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

</div>

<h5>Bank Account Details</h5>
<div class="form-group">
    <label for="expirence">{!! __('Account Name') !!} *</label>
    {{-- {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title', 'required', 'placeholder' => __('Enter Account Name')]) !!} --}}
    <input type="text" class="form-control" name="bank_account[title]" id="title" value="{{ $doctor?->banks?->ttile ?? $doctor?->banks?->data['account_holder_name'] ?? ''}}" placeholder="Enter Account Name" required="required">
    @error('title')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

</div>

<div class="form-group">
    <label for="bank_name">{!! __('Bank Name') !!} *</label>
    {{-- {!! Form::text('bank_name', null, ['class' => 'form-control', 'id' => 'bank_name', 'required', 'placeholder' => __('Enter Bank Name')]) !!} --}}
    <input type="text" class="form-control" name="bank_account[bank_name]" id="bank_name" value="{{ $doctor?->banks?->data['bank_name'] ?? $doctor?->banks?->bank_name ??  ''}}" placeholder="Enter Bank Name" required="required">
    @error('bank_name')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

</div>

<div class="form-group">
    <label for="iban">{!! __('IBAN') !!} *</label>
    {{-- {!! Form::text('iban', null, ['class' => 'form-control', 'id' => 'iban', 'required', 'placeholder' => __('Enter IBAN')]) !!} --}}
    <input type="text" class="form-control" name="bank_account[iban]" id="iban" value="{{ $doctor?->banks?->data['account_iban'] ?? $doctor?->banks?->iban ??  ''}}" placeholder="Enter IBAN" required="required">
    @error('iban')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

</div>


<div class="form-group">
    <label for="image">{!! __('image') !!}</label>
    <input type="file" name="image" class="dropify"
        @if (isset($doctor)) data-default-file="{!! $doctor->image !!}" @endif />
    @error('image')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group">
    <label for="signature">{!! __('signature') !!}</label>
    <input type="file" name="signature" class="dropify" id="signature"
        @if (isset($doctor)) data-default-file="{!! $doctor->signature !!}" @endif />
    @error('image')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
@push('scripts')
    <script>
        $('.select-tags').select2({
            tags: true,

        })
    </script>
@endpush
