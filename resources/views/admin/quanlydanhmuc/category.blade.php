@extends('admin.header.header')

@section('content')
<div class="add_new_category">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> {{ __('New') }} </a>
</div>

<table class="table">
    <thead>
        <tr class="table-primary">
            <th scope="col">{{ __('Name') }}</th>
            <th scope="col">{{ __('Edit') }}</th>
            <th scope="col">{{ __('Delete') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($category as $key => $item)
            <tr class="table-primary">
        <td class="table-active">{{ $item->name }}</td>
        <td class="table-active">
            <a href="" class="btn btn-edit"><i class="glyphicon glyphicon-pencil"></i></a>
        </td>
        <td class="table-active">
            <a href="" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
        </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
