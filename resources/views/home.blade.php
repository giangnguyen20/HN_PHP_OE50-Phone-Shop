@extends('layouts.header')

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <ul id="menu" class="collapse">
            <li>
                <a href="{{ route('users.products.index') }}">{{ __('All') }}</a>
            </li>
            @foreach ($categories as $key => $category)
                <li>
                    <a href="{{ route('users.showbycategory', $category->id) }}">{{ $category->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 col-md-12 col-sm-12">
        <!-- Slider -->
        @include('layouts.slider')

        <div id="prd-new">
            <h2>{{ __('products.new') }}</h2>
            <div class="card-deck">
                @foreach ($products as $key => $product)
                <div class="col-md-4 mt-2">
                    <div class="card">
                        @foreach ($product->images as $image)
                            <a href="{{ route('users.products.show', $product->id) }}"><img src="{{ asset('images/' . $image->name . '') }}" alt="{{ $product->name }}"></a>
                            @break
                        @endforeach
                        <h3><a href="#">{{ $product->name }}</a></h3>
                        <p>{{ __('Price') }}: <span>{{ $product->price }}đ</span></p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12 col-sm-12">
        @include('layouts.sidebar')
    </div>
</div>
@endsection
