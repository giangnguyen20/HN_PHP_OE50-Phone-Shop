@extends('user.cart.payment.header')

@section('content')
<br>
<div class="colorlib-shop">
    <div class="container">
        <div class="row row-pb-md">
            <div class="col-md-12 col-md-offset-1">
                <div class="process-wrap">
                    <h1 class="text-success">{{ __('Payment Success') }}</h1>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 col-md-offset-1 text-center">
            <span class="icon"><i class="icon-shopping-cart"></i></span>
            <p>
                <a href="{{ route('home') }}" class="btn btn-primary">{{ __('Home') }}</a>
                <a href="{{ route('users.products.index') }}" class="btn btn-primary btn-outline">{{ __('Shopping') }}</a>
            </p>
        </div>
    </div>
    <div class="row mt-50 ml-5">
        <div class="col-md-1"></div>
        <div class="col-md-7">
            <h3 class="billing-title mt-20 pl-15">{{ __('Information Order') }}</h3>
            <table class="order-rable">
                <tbody>
                    <tr>
                        <td>{{ __('Time') }}</td>
                        <td>: {{ $order->created_at }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Total') }}</td>
                        <td>: ₫ {{ number_format($order->total_price) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Status') }}</td>
                        <td>:
                        @switch ($order->status)
                            @case (1)
                                {{ __('Pending') }}
                                @break
                            @case (2)
                                {{ __('Processing') }}
                                @break
                            @case (3)
                                {{ __('Delivering') }}
                                @break
                            @case (4)
                                {{ __('Complete') }}
                                @break
                            @case (5)
                                {{ __('Cancel') }}
                                @break
                            @case (6)
                                {{ __('Rejected') }}
                                @break
                        @endswitch
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <h3 class="billing-title mt-20 pl-15 mr-5">{{ __('Address') }}</h3>
            <table class="order-rable">
                <tbody>
                    <tr>
                        <td>{{ __('Fullname') }}</td>
                        <td>: {{ $order->user->fullname }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Phone') }}</td>
                        <td>: {{ $order->phone }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Address') }}</td>
                        <td>: {{ $order->address }} </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="container">
    <div class="billing-form">
        <div class="row">
            <div class="col-12">
                <div class="order-wrapper mt-50">
                    <h3 class="billing-title mb-10">{{ __('Bill') }}</h3>
                    <div class="order-list">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Product') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($order_products as $key => $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->pivot->quantity }}</td>
                                    <td>{{ number_format($item->price) }}</td>
                                    <td>{{ number_format($item->pivot->quantity * $item->price) }}</td>
                                </tr>
                            @endforeach
                                <tr>
                                    <td>{{ __('Total') }}</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ number_format($order->total_price) }}</td>
                                </tr>
                            </tbody>
                            </table>
                        <div class="list-row border-bottom-0 d-flex justify-content-between">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="long"></div>
</div>
@endsection
