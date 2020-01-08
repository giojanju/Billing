@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Roles</h3>
            </div>
            <div class="panel-body">
                @if (Auth::user()->can('create-roles'))
                    <a type="button" href="{{ route('roles.create') }}" class="btn btn-info">Create new role</a>
                @endif
                <br>
                <br>
                @include('partials.alert')
                @if ($roles->count() && Auth::user()->can('view-roles'))
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td width="10%">{{ $loop->iteration }}</td>
                                <td width="50%">{{ data_get($role, 'display_name') }}</td>
                                <td width="40%">
                                    @if (Auth::user()->can('delete-roles'))
                                        <a href="{{ route('roles.remove', [data_get($role, 'id')]) }}" class="btn btn-danger"><i class="fa fa-trash-o"></i> Remove</a>
                                    @endif
                                    @if (Auth::user()->can('edit-roles'))
                                        <a href="{{ route('roles.edit', [data_get($role, 'id')]) }}" class="btn btn-warning"><i class="fa fa-pencil"></i> Edit</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
