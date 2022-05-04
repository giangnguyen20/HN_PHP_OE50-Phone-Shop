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

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-10">
            <span>{{ __('Name') }}:</span>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="col-md-10">
            <span>{{ __('Description') }}:</span>
            <input type="text" name="description" class="form-control" required>
        </div>
        <div class="col-md-10">
            <span>{{ __('Price') }}:</span>
            <input type="number" name="price" class="form-control" min="0" required>
        </div>
        <div class="col-md-10">
            <span>{{ __('Accessories') }}:</span>
            <input type="text" name="accessories" class="form-control" required>
        </div>
        <div class="col-md-10">
            <span>{{ __('Warranty') }}:</span>
            <input type="number" name="warranty" class="form-control" min="0" max="24" required>
        </div>
        <div class="col-md-10">
            <span>{{ __('Color') }}:</span>
            <input type="text" name="color" class="form-control" required>
        </div>
        <div class="col-md-10">
            <br>
            <span>{{ __('Category') }}:</span>
            <select name="category_id">
                @foreach($categories as $key => $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-10">
            <br>
            <span>{{ __('Image') }}:</span>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>
        <div class="col-md-10">
            <br>
            <button type="submit" class="btn btn-success">{{ __('submit') }}</button>
        </div>

    </div>
</form>
@endsection
