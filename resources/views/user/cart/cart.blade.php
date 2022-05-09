@extends('layouts.header')

@section('content')
<div class="mess">
    @if (Session::has('message'))
        <div class="alert alert-success">
            <div class="text-red">{{ __(Session::get('message')) }}</div>
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
<!--	Cart	-->
<div id="my-cart">
    <div class="row">
        <div class="cart-nav-item col-lg-5 col-md-5 col-sm-12">Thông tin sản phẩm</div>
        <div class="cart-nav-item col-lg-2 col-md-2 col-sm-12">Tùy chọn</div>
        <div class="cart-nav-item col-lg-2 col-md-2 col-sm-12">Giá</div>
        <div class="cart-nav-item col-lg-3 col-md-3 col-sm-12">Tổng</div>
    </div>
    <form method="post" action="{{ route('users.cart.update') }}">
        @csrf
        @foreach ($cart as $item)
        <div class="cart-item row">
            <div class="cart-thumb col-lg-5 col-md-5 col-sm-12">
                <img src="{{ asset('images/' . $item->options->image . '') }}">
                <h4>{{ $item->name }}</h4>
                <p>{{ $item->options->color }}</p>
                <input type="hidden" name="rowId[]" value="{{ $item->rowId }}">
            </div>

            <div class="cart-quantity col-lg-2 col-md-2 col-sm-12">
                <input type="number" id="quantity" name="qty[]" class="form-control form-blue quantity" value="{{ $item->qty }}" min="1" max="10">
            </div>
            <div class="cart-price col-lg-2 col-md-2 col-sm-12">
                <b>{{ number_format($item->price) }} đ</b>
            </div>
            <div class="cart-price col-lg-3 col-md-3 col-sm-12">
                <b>{{ number_format($item->price*$item->qty) }} đ</b>
                <a href="{{ route('users.cart.delete', $item->rowId) }}">Xóa</a>
            </div>
        </div>
        @endforeach
        <div class="row">
            <div class="cart-thumb col-lg-7 col-md-7 col-sm-12">
                <button id="update-cart" class="btn btn-success" type="submit" name="sbm">Cập nhật giỏ hàng</button>
            </div>
            <div class="cart-total col-lg-2 col-md-2 col-sm-12"><b>Tổng cộng:</b></div>
            <div class="cart-price col-lg-3 col-md-3 col-sm-12"><b>{{ $priceTotal }} đ</b></div>
        </div>
    </form>

</div>
<!--	End Cart	-->

<!--	Customer Info	-->
<div id="customer">
    <form action="" method="post">
        <div class="row">
            <div id="customer-name" class="col-lg-4 col-md-4 col-sm-12">
                <input placeholder="Họ và tên (bắt buộc)" type="text" name="name" class="form-control" required>
            </div>
            <div id="customer-phone" class="col-lg-4 col-md-4 col-sm-12">
                <input placeholder="Số điện thoại (bắt buộc)" type="text" name="phone" class="form-control" required>
            </div>
            <div id="customer-mail" class="col-lg-4 col-md-4 col-sm-12">
                <input placeholder="Email (bắt buộc)" type="text" name="mail" class="form-control" required>
            </div>
            <div id="customer-add" class="col-lg-12 col-md-12 col-sm-12">
                <input placeholder="Địa chỉ nhà riêng hoặc cơ quan (bắt buộc)" type="text" name="add" class="form-control" required>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="by-now col-lg-6 col-md-6 col-sm-12">
            <a href="#">
                <b>Mua ngay</b>
                <span>Giao hàng tận nơi siêu tốc</span>
            </a>
        </div>
        <div class="by-now col-lg-6 col-md-6 col-sm-12">
            <a href="#">
                <b>Trả góp Online (Đang bảo trì)</b>
                <span>Vui lòng call (+84) 0988 550 553</span>
            </a>
        </div>
    </div>
</div>
<!--	End Customer Info	-->
@endsection
