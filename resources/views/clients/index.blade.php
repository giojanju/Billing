@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Clients</h3>
            </div>
            <div class="panel-body">
                @if (Auth::user()->can('create-clients'))
                    <a type="button" href="{{ route('clients.create') }}" class="btn btn-info">Create new client</a>
                    <br>
                    <br>
                @endif
                @include('partials.alert')
                @php
                    $showAction = true;
                    if (
                        !Auth::user()->can('delete-clients')
                        && !Auth::user()->can('edit-clients')
                    ) {
                        $showAction = false;
                    }
                @endphp

                @if (Auth::user()->can('search-clients'))
                    <form action="{{ url()->current() }}" class="row">
                        <div class="form-group col-md-2">
                            <input type="text" class="form-control" value="{{ request('id') }}" name="id" placeholder="#id">
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" value="{{ request('name') }}" name="name" placeholder="Name">
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" value="{{ request('email') }}"  name="email" placeholder="Email">
                        </div>
                        <div class="form-group col-md-2">
                            <button type="submit" class="btn-block btn-primary btn">Search</button>
                        </div>
                    </form>
                @endif

                @if (Auth::user()->can('view-clients') && $clients->count())
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Email</th>
                            @if ($showAction)
                                <th>Action</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td width="10%">{{ data_get($client, 'id') }}</td>
                                <td width="20%">{{ data_get($client, 'name') }}</td>
                                <td width="20%">{{ data_get($client, 'surname') }}</td>
                                <td width="20%">{{ data_get($client, 'email') }}</td>
                                @if ($showAction)
                                    <td width="30%">
                                        @if (Auth::user()->can('delete-clients'))
                                            <a href="{{ route('clients.remove', [data_get($client, 'id')]) }}" class="btn btn-danger"><i class="fa fa-trash-o"></i> Remove</a>
                                        @endif
                                        @if (Auth::user()->can('edit-clients') || Auth::user()->can('password-change'))
                                            <a href="{{ route('clients.edit', [data_get($client, 'id')]) }}" class="btn btn-warning"><i class="fa fa-pencil"></i> Edit</a>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $clients->appends(request()->query())->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection
