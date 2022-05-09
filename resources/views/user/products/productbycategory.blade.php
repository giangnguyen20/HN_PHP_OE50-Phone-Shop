@extends('layouts.header')

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <ul id="menu" class="collapse">
            <li><a href="{{ route('users.products.index') }}">{{ __('All') }}</a></li>
            @foreach ($categories as $key => $category)
                <li><a href="{{ route('users.showbycategory', $category->id) }}">{{ $category->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
<div id="prd-new">
    <div class="card-deck">
        @foreach ($products as $key => $product)
        <div class="col-md-4 mt-2">
            <div class="card">
                @foreach($product->images as $image)
                    <a href="{{ route('users.products.show', $product->id) }}"><img src="{{ asset('images/'.$image->name.'') }}" alt="{{ $product->name }}"></a>
                    @break
                @endforeach
                <h3><a href="{{ route('users.products.show', $product->id) }}">{{ $product->name }}</a></h3>
                <p>{{ __('Price') }}: <span>{{ number_format($product->price) }} đ</span></p>
            </div>
        </div>
        @endforeach
    </div>
</div>
<br>
<div id="pagination">
    {{ $products->links('pagination::bootstrap-4') }}
</div>
@endsection
