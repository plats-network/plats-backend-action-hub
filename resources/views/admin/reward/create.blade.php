@extends('admin.layout')

@section('content')
    <x-admin::top_page :title="trans('admin.reward.create_page')"/>
    @include('admin.reward.form')
@endsection
