<div class="form-group col-md-6">
    <label for="name_ar">{!! __('Name In Arabic') !!} *</label>
    {!! Form::text('name_ar', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'name_ar', 'required', 'placeholder' => __('Enter Question In Arabic')]) !!}
    @error('name_ar')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group col-md-6">
    <label for="name_en">{!! __('Name In English') !!} *</label>
    {!! Form::text('name_en', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'name_en', 'required', 'placeholder' => __('Enter Question In English')]) !!}
    @error('name_en')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group col-md-6">
    <label for="description_ar">{!! __('Description In Arabic') !!} *</label>
    {!! Form::text('description_ar', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'description_ar', 'required', 'placeholder' => __('Enter Description In Arabic')]) !!}
    @error('description_ar')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group col-md-6">
    <label for="description_en">{!! __('Description In English') !!} *</label>
    {!! Form::text('description_en', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'description_en', 'required', 'placeholder' => __('Enter Description In English')]) !!}
    @error('description_en')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group col-md-6">
    <label for="doc_description_ar">{!! __('Doctor App Description In Arabic') !!} *</label>
    {!! Form::text('doc_description_ar', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'doc_description_ar', 'required', 'placeholder' => __('Enter Description In Arabic')]) !!}
    @error('doc_description_ar')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group col-md-6">
    <label for="doc_description_en">{!! __('Doctor App Description In English') !!} *</label>
    {!! Form::text('doc_description_en', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'doc_description_en', 'required', 'placeholder' => __('Enter Description In English')]) !!}
    @error('doc_description_en')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group col-md-6">
    <label for="min_price">{!! __('Min Price') !!} *</label>
    {!! Form::number('min_price', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'min_price', 'required', 'placeholder' => __('Enter Min Price')]) !!}
    @error('min_price')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group col-md-6">
    <label for="max_price">{!! __('Max Price') !!} *</label>
    {!! Form::number('max_price', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'min_price', 'required', 'placeholder' => __('Enter Max Price')]) !!}
    @error('max_price')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>




<div class="form-group col-md-6">
    <label for="expire_in">{!! __('Expire In') !!} *</label>
    {!! Form::number('expire_in', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'expire_in', 'required', 'placeholder' => __('Expire In')]) !!}
    @error('expire_in')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>


<div class="form-group col-md-6">
    <label for="quantity">{!! __('quantity') !!} *</label>
    {!! Form::number('quantity', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'quantity', 'required', 'placeholder' => __('Enter quantity')]) !!}
    @error('quantity')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
