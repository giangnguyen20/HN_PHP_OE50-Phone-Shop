@extends('admin.header.header')

@section('content')
<div class="mess">
    @if (Session::has('messages'))
        <div class="alert alert-success">
            <div class="text-white">{{ Session::get('messages') }}</div>
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

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-10">
            <span>{{ __('Name') }}:</span>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>
        <div class="col-md-10">
            <span>{{ __('Price') }}:</span>
            <input type="number" name="price" class="form-control" value="{{ $product->price }}" min="0" required>
        </div>
        <div class="col-md-10">
            <span>{{ __('Accessories') }}:</span>
            <input type="text" name="accessories" class="form-control" value="{{ $product->accessories }}" required>
        </div>
        <div class="col-md-10">
            <span>{{ __('Warranty') }}:</span>
            <input type="number" name="warranty" class="form-control" value="{{ $product->warranty }}" min="0" max="24" required>
        </div>
        <div class="col-md-10">
            <span>{{ __('Color') }}:</span>
            <input type="text" name="color" class="form-control" value="{{ $product->color }}" required>
        </div>
        <div class="col-md-10">
            <br>
            <span>{{ __('Category') }}:</span>
            <select name="category_id">
                @foreach ($categories as $key => $category)
                    <option @if ($category->id == $product->category_id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-10">
            <br>
            <span>{{ __('Status') }}:</span>
            <select name="status">
                <option @if ($product->status == config('auth.status.stocking')) selected @endif value="{{ config('auth.status.stocking') }}">{{ __('Stocking') }}</option>
                <option @if ($product->status == config('auth.status.out_of_stock')) selected @endif value="{{ config('auth.status.out_of_stock') }}">{{ __('out of stock') }}</option>
            </select>
        </div>
        <div class="col-md-10">
            <br>
            <span>{{ __('Image') }}:</span>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>
        <div class="col-md-10">
            <br>
            <span>{{ __('Description') }}:</span>
            <textarea id="editor" name="description"> {{ $product->description}} </textarea>
        </div>
        <div class="col-md-10">
            <br>
            <button type="submit" class="btn btn-success">{{ __('submit') }}</button>
        </div>
    </div>
</form>
@endsection
