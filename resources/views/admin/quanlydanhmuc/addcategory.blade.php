@extends('admin.header.header')

@section('content')
<div class="mess">
    @if (Session::has('message'))
        @php
            $message = Session::get('message');
        @endphp
        <div class="alert alert-success">
            <div class="text-white">{{ $message }}</div>
        </div>
    @endif
    @if (Session::has('error'))
        @php
            $error = Session::get('error');
        @endphp
        <div class="alert alert-danger">
            <div class="text-white">{{ $error }}</div>
        </div>
    @endif
</div>

<table class="table">
    <thead>
        <form action="{{ route('admin.categories.store') }}" method="post">
            @csrf
            <tr>
                <td>{{ __('Name') }}:</td>
                <td><input type="text" name="name" required></td>
            </tr>
            <tr>
                <td><input type="submit" value="{{ __('submit') }}"></td>
            </tr>
        </form>
    </thead>
</table>
@endsection
