@extends('admin.header.header')

@section('content')
<div class="add_new_category">
    <a href="{{ route('admin.products.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> {{ __('New') }} </a>
</div>

<table class="table">
    <thead>
        <tr class="table-primary">
            <th scope="col">{{ __('Name') }}</th>
            <th scope="col">{{ __('Image') }}</th>
            <th scope="col">{{ __('Slug') }}</th>
            <th scope="col">{{ __('Description') }}</th>
            <th scope="col">{{ __('Price') }}</th>
            <th scope="col">{{ __('Accessories') }}</th>
            <th scope="col">{{ __('Warranty') }}</th>
            <th scope="col">{{ __('Color') }}</th>
            <th scope="col">{{ __('Status') }}</th>
            <th scope="col">{{ __('Edit') }}</th>
            <th scope="col">{{ __('Delete') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $key => $product)
            <tr class="table-primary">
                <td class="table-active">{{ $product->name }}</td>
                <td class="table-active">
                    @foreach ($product->images as $image)
                        <img src="{{ asset('images/'.$image->name.'') }}" alt="Điện thoại đẹp" width="100px" class="thumbnail">
                    @endforeach
                </td>
                <td class="table-active">{{ $product->slug }}</td>
                <td class="table-active">{{ $product->description }}</td>
                <td class="table-active">{{ $product->price }}</td>
                <td class="table-active">{{ $product->accessories }}</td>
                <td class="table-active">{{ $product->warranty }}</td>
                <td class="table-active">{{ $product->color }}</td>
                <td class="table-active">{{ $product->status }}</td>
                <td class="table-active">
                    <a href="" class="btn btn-warning"><i class="glyphicon glyphicon-edit"></i> {{ __('Edit') }}</a>
                </td>
                <td class="table-active">
                    <a href="" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div align='left'>
    {{ $products->links('pagination::bootstrap-4') }}
</div>
@endsection
