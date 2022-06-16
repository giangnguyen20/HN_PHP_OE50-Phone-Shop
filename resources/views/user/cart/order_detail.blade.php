@extends('layouts.header')
<head>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
@section('content')
<div class="row mt-5">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                {{ __('Details User') }}
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><span>{{ __('Name') }}: </span>{{ $user->fullname }}</li>
                <li class="list-group-item"><span>{{ __('Phone') }}: </span>{{ $order->phone }}</li>
                <li class="list-group-item"><span>{{ __('Email') }}: </span>{{ $user->email }}</li>
            </ul>
        </div>
    </div>
    <div class="col-6">
        <div class="mt-5" align="right">
            <h4>{{ __('Status') }}</h4>
            <div class="mt-3">
            @if ( $order->status == config('auth.orderStatus.pending'))
                <p class="btn btn-secondary"></i>{{ __('Pending') }}</p>
            @elseif ( $order->status == config('auth.orderStatus.processing'))
                <p class="btn btn-info"></i>{{ __('Processing') }}</p>
            @elseif ( $order->status == config('auth.orderStatus.delivering'))
                <p class="btn btn-primary"></i>{{ __('Delivering') }}</p>
            @elseif ( $order->status == config('auth.orderStatus.complete'))
                <p class="btn btn-success"></i>{{ __('Complete') }}</p>
            @elseif ( $order->status == config('auth.orderStatus.cancel'))
                <p class="btn btn-warning"></i>{{ __('Cancel') }}</p>
            @else
                <p class="btn btn-danger"></i>{{ __('Rejected') }}</p>
            @endif
            </div>
        </div>
    </div>
</div>
<table class="table mt-5">
    <thead>
        <th scope="col">{{ __('STT') }}</th>
        <th scope="col">{{ __('Name') }}</th>
        <th scope="col">{{ __('Quantity') }}</th>
        <th scope="col">{{ __('Total') }}</th>
        <th scope="col">{{ __('Time create') }}</th>
    </thead>
    <tbody>
        @foreach ($order_product as $key => $item)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->pivot->quantity }}</td>
            <td>{{ number_format($item->pivot->quantity*$item->price) }}</td>
            <td>{{ $item->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
