<div class="row" x-data="{
    'user_types': '{{ old('user_types', '') }}'
}" x-init="() => {
    $('.select2').select2();
}
$watch('user_types', () => $('.select2').select2())
{{-- $($refs.users).select2();} --}}
{{-- $watch('users_type') --}}">
<style>
    .input_file{
        width: 100% !important;
        border: 1px solid #dbdbdb !important;
        border-radius: 3px !important;
        padding: 5px !important;
    }
</style>

    <div class="form-group col-md-12">
        <label for="title">{!! __('Notification Title') !!} *</label>
        {!! Form::text('title', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'title', 'required', 'placeholder' => __('Enter Address')]) !!}
        @error('title')
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-md-12">
        <label for="body">{!! __('Body ') !!} *</label>
        {!! Form::textarea('body', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'body', 'required', 'placeholder' => __('Enter Body')]) !!}
        @error('body')
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-md-6">
        <label for="file_upload">{!! __('Upload Image (optional)') !!}</label><br>
        <div style = "width: 100%;border:1px solid #ced4da;border-radius: 3px;padding: 5px;">
            {!! Form::file('file_upload', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'file_upload']) !!}
        </div>
        @error('file_upload')
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-md-6">
        <label for="video_url">{!! __('Video Url (optional)') !!}</label><br>
        {!! Form::url('video_url', null, ['class' => 'form-control', 'parsley-trigger' => 'change', 'id' => 'video_url', 'placeholder' => __('Enter url (optional)')]) !!}
        @error('video_url')
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>


    <div class="form-group col-md-12">
        <label for="user_types">{!! __('Users Type') !!} *</label>
        {!! Form::select('user_types', [__('Patients'), __('Doctors')], null, ['class' => 'form-control ', 'id' => 'user_types', 'placeholder' => __('Select Type'), 'x-model' => 'user_types']) !!}
        @error('user_types')
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

    </div>

    <template x-if="user_types==='1'">
        <div class="form-group col-md-12">
            <label for="doctors">{!! __('Doctors') !!} *</label>
            <label for="user_types">{!! __('All') !!}</label>
            <button type="button" class="btn btn-primary checkall">{!! __('All') !!}</button>
            {!! Form::select('doctors[]', $doctors, null, ['class' => 'form-control select2 Sendall', 'parsley-trigger' => 'change', 'id' => 'doctors', 'multiple', 'x-ref' => 'doctors']) !!}
            @error('user_types')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
    </template>
    <template x-if="user_types==='0'">
        <div class="form-group col-md-12">
            <label for="user_types">{!! __('Patients') !!} *</label>
            {{-- <label for="user_types">{!! __('All') !!}</label>
            <input name="all" type="checkbox" id="checkall"> --}}
            <button type="button" class="btn btn-primary checkall">{!! __('All') !!}</button>
            {{-- {!! Form::select('users[]', $users, null, [
                'class' => 'form-control select2',
                'parsley-trigger' => 'change',
                'id' => 'patients',
                'multiple',
                'x-ref' => 'users',
            ]) !!} --}}

            <select for="user_types" multiple="multiple" name="users[]" id="patients" class="form-control select2 Sendall">
                @foreach($users as $user)
                    <option value="{{$user->id}}">@if($user->mydata){{$user->mydata->name}} @else {{$user->phone}} @endif</option>
                @endforeach
            </select>
            @error('user_types')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
    </template>
</div>

@push('scripts')
    <script>
        $('#user_types').change(function() {
            setTimeout(function() {
                $('.checkall').click(function() {
                    $(".Sendall > option").prop("selected","selected");
                    // Select All
                    $(".Sendall").trigger("change");
                });
            });
        });

    </script>
@endpush
