@extends('admin.header.header')

@section('content')
<div class="mess">
    @if (Session::has('message'))
        <div class="alert alert-success">
            <div class="text-white">{{ Session::get('message') }}</div>
        </div>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                <div class="text-white">{{ __($error) }}</div>
            </div>
        @endforeach
    @endif
</div>

<table class="table">
    <thead>
        <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
            @csrf
            @method('PUT')
            <tr>
                <td>{{ __('Name') }}:</td>
                <td><input type="text" name="name" value="{{ $category->name }}" required></td>
            </tr>
            <tr>
                <td><input type="submit" value="{{ __('submit') }}"></td>
            </tr>
        </form>
    </thead>
</table>
@endsection
