@extends('admin.header.header')

@section('content')
<table class="table">
    <thead>
        <tr class="table-primary">
            <th scope="col">{{ __('Name') }}</th>
            <th scope="col">{{ __('Email') }}</th>
            <th scope="col">{{ __('Phone') }}</th>
            <th scope="col">{{ __('Role') }}</th>
            <th scope="col">{{ __('Status') }}</th>
            <th scope="col">{{ __('Edit') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $key => $item)
        <tr class="table-primary">
            <td class="table-active">{{ $item->fullname }}</td>
            <td class="table-active">{{ $item->email }}</td>
            <td class="table-active">{{ $item->phone }}</td>
            <td class="table-active">
                @if ($item->status == config('auth.status.active'))
                    {{ __('Active') }}
                @else
                    {{ __('Block') }}
                @endif
            </td>
            <td class="table-active">
                @if ($item->role_id == config('auth.status.admin'))
                    {{ __('Admin') }}
                @else
                    {{ __('User') }}
                @endif
            </td>
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
                            <form action="{{ route('admin.users.update', $item->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <label for="">{{ __('Name') }}:</label>
                                    <strong>{{ $item->fullname }}</strong>
                                    <br>
                                    <label for="">{{ __('Status') }}:</label>
                                    <select name="status">
                                        <option @if ($item->status == config('auth.status.active')) selected @endif value="{{ config('auth.status.active') }}">{{ __('Active') }}</option>
                                        <option @if ($item->status == config('auth.status.block')) selected @endif value="{{ config('auth.status.block') }}">{{ __('Block') }}</option>
                                    </select>
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
        </tr>
        @endforeach
    </tbody>
</table>

<div align='left'>
    {{ $users->links('pagination::bootstrap-4') }}
</div>
@endsection
