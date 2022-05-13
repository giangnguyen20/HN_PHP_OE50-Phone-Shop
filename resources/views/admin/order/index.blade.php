@extends('admin.header.header')

@section('content')
<table class="table">
    <thead>
        <tr class="table-primary">
            <th scope="col">{{ __('Name') }}</th>
            <th scope="col">{{ __('Phone') }}</th>
            <th scope="col">{{ __('Address') }}</th>
            <th scope="col">{{ __('Total') }}</th>
            <th scope="col">{{ __('Status') }}</th>
            <th scope="col">{{ __('Note') }}</th>
            <th scope="col">{{ __('Details') }}</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($orders as $key => $item)
        <tr>
            <td>{{ $item->user['fullname'] }}</td>
            <td>{{ $item->phone }}</td>
            <td>{{ $item->address }}</td>
            <td>{{ number_format($item->total_price) }}</td>
            <td>
                @switch ($item->status)
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
            <td>{{ $item->note }}</td>
            <td>
                <a href="{{ route('admin.orders.edit', $item->id) }}" class="btn btn-warning"><i class="glyphicon glyphicon-edit"></i> {{ __('Details') }}</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div align='left'>
    {{ $orders->links('pagination::bootstrap-4') }}
</div>
@endsection
