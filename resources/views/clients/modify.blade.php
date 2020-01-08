@extends('layouts.app')

@php
    $route = route('clients.store');
    $text = 'Client';
    $modify = false;
    if (isset($client) && data_get($client, 'id', null)) {
        $route = route('clients.update', [data_get($client, 'id')]);
        $text = 'Client';
        $modify = true;
    }
@endphp

@section('content')
    <div class="container-fluid">
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $text }}</h3>
            </div>
            <div class="panel-body">
                @include('partials.alert')
                <form action="{{ $route }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div>
                        @foreach (['name', 'surname', 'email'] as $field)
                            @component('partials.input', [
                                'key' => $field,
                                'error_key' => $field,
                                'title' => ucwords($field),
                                'value' => $modify ?
                                    data_get($client, $field) :
                                    old($field)
                            ])
                            @endcomponent
                        @endforeach

                        <button type="submit" class="btn btn-primary btn-lg btn-block">SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
