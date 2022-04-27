@extends('admin.header.header')

@section('content')
<div class="mess">
    @if (Session::has('message'))
        <div class="alert alert-success">
            <div class="text-white">{{ Session::get('message') }}</div>
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">
            <div class="text-white">{{ Session::get('message') }}</div>
        </div>
    @endif
</div>

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
                    <a href="{{ route('admin.categories.edit', $item->id) }}" class="btn btn-edit"><i class="glyphicon glyphicon-pencil"></i></a>
                </td>
                <td class="table-active">
                    <form action="{{ route('admin.categories.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="btn-delete" onclick="return confirm('Are you sure?');" class="btn btn-danger"> <i class="fa fa-remove" aria-hidden="true"></i> {{__('Delete')}}</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div align='left'>
    {{ $category->links('pagination::bootstrap-4') }}
</div>
@endsection
