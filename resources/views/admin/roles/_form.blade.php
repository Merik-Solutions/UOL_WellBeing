<div class="form-group">
    <label for="name">{!! __("Name") !!} *</label>
    {!! Form::text('name',null,['class'=>'form-control','parsley-trigger'=>'change','id'=>'name','required','placeholder'=>__('Enter Role Name')]) !!}
    @error('name')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group">
    <label for="guard_name">{!! __("Guard Name") !!} *</label>
    {!! Form::text('guard_name',null,['class'=>'form-control','parsley-trigger'=>'change','id'=>'guard_name','required','placeholder'=>__('Enter Guard Name')]) !!}
    @error('guard_name')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<h5 class="mt-3">{!! __("Permissions") !!}</h5>
<select multiple="multiple" class="multi-select" id="permissions" name="permissions[]"
        data-plugin="multiselect" data-selectable-optgroup="true">
    @foreach($permissions_groups ??[] as $key=> $groups)
        <optgroup label="{!! __($key) !!}">
            @foreach($groups as $permission)
                <option
                    value="{!! $permission->id !!}"
                    @if(isset($role_permissions) &&in_array($permission->id,$role_permissions)) selected
                    @endif
                >{!! $permission->label !!}</option>

            @endforeach
        </optgroup>
    @endforeach

</select>

