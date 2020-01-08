@extends('layouts.app')

@php
    $route = route('roles.store');
    $text = 'Roles create';
    $modify = false;
    if (isset($role) && data_get($role, 'id', null)) {
        $route = route('roles.update', [data_get($role, 'id')]);
        $text = 'Roles modify';
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
                        @component('partials.input', [
                            'key' => 'display_name',
                            'error_key' => 'display_name',
                            'title' => 'Role name',
                            'value' => $modify ?
                                data_get($role, 'display_name') :
                                old('display_name')
                        ])
                        @endcomponent

                        @if($permissions->count())
                            @foreach($permissions as $type => $chunk)
                                <h3>{{ ucwords($type) }}</h3>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group clearfix">
                                            <label class="fancy-checkbox element-left allow-or-deny-permissions">
                                                <input
                                                    name="{{ $type }}"
                                                    data-select-type="allow"
                                                    type="checkbox"
                                                    {{ isset($permissionCounts) && count($chunk) == g($permissionCounts, $type) ? 'checked' : '' }}
                                                >
                                                <span><b>Grant Full Access</b></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group clearfix">
                                            <label class="fancy-checkbox element-left allow-or-deny-permissions">
                                                <input
                                                    name="{{ data_get($chunk, '0.type') }}"
                                                    data-select-type="deny"
                                                    type="checkbox"
                                                    {{ isset($permissionCounts) && g($permissionCounts, $type, 0) == 0 ? 'checked' : '' }}
                                                >
                                                <span><b>Deny All</b></span>
                                            </label>
                                        </div>
                                    </div>
                                    @foreach($chunk as $permission)
                                        <div class="col-sm-4">
                                            <div class="form-group clearfix">
                                                <label class="fancy-checkbox element-left">
                                                    <input
                                                        name="permissions[]"
                                                        value="{{ data_get($permission, 'id') }}"
                                                        data-type="{{ data_get($permission, 'type') }}"
                                                        type="checkbox"
                                                        @if($modify)
                                                            {{ in_array(data_get($role, 'id'), $permission->roles->pluck('id')->all()) ? 'checked' : '' }}
                                                        @endif
                                                    >
                                                    <span>{{ data_get($permission, 'display_name') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        @endif

                        <button type="submit" class="btn btn-primary btn-lg btn-block">SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
