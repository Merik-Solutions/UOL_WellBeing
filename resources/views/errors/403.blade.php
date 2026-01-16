@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message')

<div class="mt-0 header-title float-right  d-inline">
<h5 style="color:#a0aec0; text-align:center">You don't have access to this page.</h5>
    <a style="color:blue; font-weight: bolder;" href="{!! route('admin.dashboard') !!}">
        <i class="fas fa-arrow-left"></i><u>Back To Dashboard</u></a>
</div>
@endsection
