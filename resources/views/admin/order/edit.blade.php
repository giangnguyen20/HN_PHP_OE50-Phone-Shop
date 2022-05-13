@extends('admin.header.header')

<head>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
@section('content')
<div class="row">
    <div class="col-6">
        <div class="card" style="width: 18rem;">
            <div class="card-header">
                {{ __('Details User') }}
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><span>{{ __('Name') }}: </span>{{ $user->fullname }}</li>
                <li class="list-group-item"><span>{{ __('Phone') }}: </span>{{ $user->phone }}</li>
                <li class="list-group-item"><span>{{ __('Email') }}: </span>{{ $user->email }}</li>
            </ul>
        </div>
    </div>
    <div class="col-6">
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="mt-5" align="right">
                <h4>{{ __('Edit Status') }}</h4>
                <div class="mt-3">
                    <select class="size-select" name="status">
                        <option @if ( $order->status == config('auth.orderStatus.pending')) selected @endif value="1">{{ __('Pending') }}</option>
                        <option @if ( $order->status == config('auth.orderStatus.processing')) selected @endif value="2">{{ __('Processing') }}</option>
                        <option @if ( $order->status == config('auth.orderStatus.delivering')) selected @endif value="3">{{ __('Delivering') }}</option>
                        <option @if ( $order->status == config('auth.orderStatus.complete')) selected @endif value="4">{{ __('Complete') }}</option>
                        <option @if ( $order->status == config('auth.orderStatus.cancel')) selected @endif value="5">{{ __('Cancel') }}</option>
                        <option @if ( $order->status == config('auth.orderStatus.rejected')) selected @endif value="6">{{ __('Rejected') }}</option>
                    </select>
                </div>
                <button class="btn btn-warning mt-3" type="submit"> {{ __('Submit') }}</button>
            </div>
        </form>
    </div>
</div>
<br>
<table class="table">
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
<div class="alert alert-primary" role="alert" align='left'>
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
@endsection
