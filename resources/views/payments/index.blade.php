@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Payments</h3>
            </div>
            <div class="panel-body">
                @include('partials.alert')
                @php
                    $showAction = true;
                    if (
                        !Auth::user()->can('delete-payments')
                    ) {
                        $showAction = false;
                    }

                    $searchUserId = true;
                    if (!Auth::user()->can('search-by-user-id')) {
                        $searchUserId = false;
                    }

                $viewHistory = Auth::user()->can('view-payments-history');
                $viewClientId = Auth::user()->can('view-payments-client-id');
                $viewClientName = Auth::user()->can('view-payments-client-name');
                $viewSource = Auth::user()->can('view-payments-source');
                @endphp

                <form action="{{ url()->current() }}" class="row">
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" value="{{ request('id') }}" name="id" placeholder="#id">
                    </div>
                    @if ($searchUserId)
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" value="{{ request('user_id') }}" name="user_id" placeholder="#User id">
                        </div>
                    @endif
                    <div class="form-group {{ $searchUserId ? 'col-md-4' : 'col-md-8' }}">
                        @if ($viewClientName)
                            <input type="text" class="form-control" value="{{ request('client_name') }}"  name="client_name" placeholder="Client name">
                        @endif
                    </div>
                    <div class="form-group col-md-2">
                        <button type="submit" class="btn-block btn-primary btn">Search</button>
                    </div>
                </form>
                @if (Auth::user()->can('view-payments') && $payments->count())
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#Id</th>
                            <th>#User id</th>
                            @if ($viewClientId)
                                <th>#Client id</th>
                            @endif
                            @if ($viewClientName)
                                <th>Client name</th>
                            @endif
                            <th>Amount</th>
                            @if ($viewHistory)
                                <th>History</th>
                            @endif
                            @if ($viewSource)
                                <th>Source</th>
                            @endif
                            @if ($showAction)
                                <th>Action</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payments as $item)
                            <tr>
                                <td width="5%">{{ data_get($item, 'id') }}</td>
                                <td width="10%">{{ data_get($item, 'user_id') }}</td>
                                @if ($viewClientId)
                                    <td width="10%">{{ data_get($item, 'client_id') }}</td>
                                @endif
                                @if ($viewClientName)
                                    <td width="20%">{{ data_get($item, 'client.name') }}</td>
                                @endif
                                <td width="15%">{{ data_get($item, 'amount') }}</td>
                                @if ($viewHistory)
                                    <td width="20%">{{ data_get($item, 'history') }}</td>
                                @endif
                                @if ($viewSource)
                                    <td width="20%">{{ data_get($item, 'source') }}</td>
                                @endif
                                @if ($showAction)
                                    <td width="30%">
                                        @if (Auth::user()->can('delete-payments'))
                                            <a href="{{ route('payments.remove', [data_get($item, 'id')]) }}" class="btn btn-danger"><i class="fa fa-trash-o"></i> Remove</a>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $payments->appends(request()->query())->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection
