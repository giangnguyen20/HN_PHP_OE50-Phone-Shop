@extends('layouts.header')

@section('content')
<div class="mess">
    @if (Session::has('message'))
        <div class="alert alert-danger">
            <div class="text-black">{{ __(Session::get('message')) }}</div>
        </div>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                <div class="text-red">{{ __($error) }}</div>
            </div>
        @endforeach
    @endif
</div>
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

<!-- Details -->
<div id="product">
    <div id="product-head" class="row">
        <div id="product-img" class="col-lg-6 col-md-6 col-sm-12">
            @foreach ($product->images as $image)
                <img src="{{ asset('images/'.$image->name.'') }}" width="100%">
                @break
            @endforeach
        </div>
        <div id="product-details" class="col-lg-6 col-md-6 col-sm-12">
            <form action="{{ route('users.cart.addToCart') }}" method="post">
                @csrf
                <h1>{{ $product->name }}</h1>
                <ul>
                    <li><span>{{ __('Warranty') }}: </span>{{ $product->warranty }} tháng</li>
                    <li><span>{{ __('Accessories') }}: </span>{{ $product->accessories }}</li>
                    <li id="price">{{ __('Price') }}: {{ number_format($product->price) }} đ</li>
                    <li class="text-danger" id="status">
                        @if ($product->quantity > 0)
                            {{ __('Stocking') }}
                        @else
                            {{ __('Out of stock') }}
                        @endif
                    </li>
                    <li>
                        <span>{{ __('Quantity') }}</span>
                        <input type="number" name="quantity" value="1" min="1" max="10">
                    </li>
                </ul>
                <input type="hidden" name="id" value="{{ $product->id }}">
                <div id="add-cart">
                @if ($product->quantity > 0)
                    <button type="submit" class="btn btn-danger">{{ __('Buy') }}</button>
                @else
                    <button type="submit" class="btn btn-danger" disabled>{{ __('Buy') }}</button>
                @endif
                </div>
            </form>
        </div>
    </div>
    <br>
    <div id="product-body" class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h3>{{ __('Details') }}</h3>
            <p>
                {{ $product->description }}
            </p>
        </div>
    </div>
</div>
<!-- End Details -->
<div id="comment">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-3 text-center colorlib-heading">
                <h2>{{ __('Comments') }}</h2>
            </div>
        </div>
        <div id="comments-list" class="row">
            <div class="col-lg-12">
                <div class="comment-list-top">
                </div>
                @foreach ($comments as $item)
                    <div class="comment-item">
                        <ul>
                            <li class="name"><b>{{ $item->user->fullname }}</b></li>
                            <li class="time">{{ $item->created_at }}</li>
                            <li class="detail">{{ $item->content }}</li>
                        </ul>
                    </div>
                @endforeach
            </div>
            <div id="pagination" align="left">
                {{ $comments->links('pagination::bootstrap-4') }}
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <form method="post" action="{{ route('users.comment') }}">
                @csrf
                <div class="form-group">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger col-9">{{ __($error) }}</div>
                        @endforeach
                    @endif
                    <textarea class="form-control comment-input" id="exampleFormControlTextarea1" name="content" rows="3" placeholder="{{ __('comments') }}"></textarea>
                </div>
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" name="sbm" class="btn btn-primary">{{ __('Comment') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
