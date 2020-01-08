@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Users</h3>
            </div>
            <div class="panel-body">
                @if (Auth::user()->can('create-users'))
                    <a type="button" href="{{ route('users.create') }}" class="btn btn-info">Create new user</a>
                    <br>
                    <br>
                @endif
                @include('partials.alert')
                @if($users->count())
                    @php
                        $showAction = true;
                        if (
                            !Auth::user()->can('delete-users')
                            && !Auth::user()->can('edit-users')
                            && !Auth::user()->can('password-change')
                        ) {
                            $showAction = false;
                        }
                    @endphp

                    @if (Auth::user()->can('view-users') || Auth::user()->can('view-own-users'))
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                @if ($showAction)
                                    <th>Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td width="10%">{{ $loop->iteration }}</td>
                                    <td width="20%">{{ data_get($user, 'name') }}</td>
                                    <td width="20%">{{ data_get($user, 'email') }}</td>
                                    <td width="20%">{{ data_get($user, 'user_role') }}</td>
                                    @if ($showAction)
                                        <td width="30%">
                                            @if(!data_get($user, 'is_root'))
                                                @if (Auth::user()->can('delete-users'))
                                                    <a href="{{ route('users.remove', [data_get($user, 'id')]) }}" class="btn btn-danger"><i class="fa fa-trash-o"></i> Remove</a>
                                                @endif
                                                @if (Auth::user()->can('edit-users') || Auth::user()->can('password-change'))
                                                    <a href="{{ route('users.edit', [data_get($user, 'id')]) }}" class="btn btn-warning"><i class="fa fa-pencil"></i> Edit</a>
                                                @endif
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $users->links() }}
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
