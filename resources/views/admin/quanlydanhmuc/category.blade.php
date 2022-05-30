@extends('admin.header.header')

@section('content')
<div class="mess">
    @if (Session::has('message'))
    <div class="alert alert-success">
        <div class="text-white">{{ Session::get('message') }}</div>
    </div>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                <div class="text-white">{{ __($error) }}</div>
            </div>
        @endforeach
    @endif
</div>

<div class="add_new_category">
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Add"><i class="fa fa-plus"></i>
        {{ __('New') }}
    </button>
    <div class="modal fade" id="Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Confirm_Modal') }}</h5>
                </div>
                <form action="{{ route('admin.categories.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <label for="">{{ __('Name') }}:</label>
                        <input type="text" name="name" value="" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button class="btn btn-primary" data-toggle="modal"> {{ __('Confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#Edit{{ $item->id }}"><i class="glyphicon glyphicon-edit"></i>
                    {{ __('Edit') }}
                </button>
                <div class="modal fade" id="Edit{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Confirm_Modal') }}</h5>
                            </div>
                            <form action="{{ route('admin.categories.update', $item->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <label for="">{{ __('Name') }}:</label>
                                    <input type="text" name="name" value="{{ $item->name }}" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> {{ __('Confirm') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </td>
            <td class="table-active">
                <form action="{{ route('admin.categories.destroy', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{ $item->id }}"><i class="fa fa-remove" aria-hidden="true"></i>
                        {{ __('Delete') }}
                    </button>
                    <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Confirm_Modal') }}</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                                    <button type="submit" class="btn btn-primary">{{ __('Confirm') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
