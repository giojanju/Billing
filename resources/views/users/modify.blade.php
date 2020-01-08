@extends('layouts.app')

@php
    $route = route('users.store');
    $text = 'User';
    $modify = false;
    if (isset($user) && data_get($user, 'id', null)) {
        $route = route('users.update', [data_get($user, 'id')]);
        $text = 'User';
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
                        @if (Auth::user()->can('edit-users') || (Auth::user()->can('create-users') && !$modify))
                            @foreach (['name', 'email'] as $field)
                                @component('partials.input', [
                                    'key' => $field,
                                    'error_key' => $field,
                                    'title' => ucwords($field),
                                    'value' => $modify ?
                                        data_get($user, $field) :
                                        old($field)
                                ])
                                @endcomponent
                            @endforeach
                        @endif

                        @if (Auth::user()->can('password-change') || Auth::user()->can('edit-users') || Auth::user()->can('add-users'))
                            @component('partials.input', [
                                'key' => 'password',
                                'type' => 'password',
                                'error_key' => 'password',
                                'title' => 'Password'
                            ])
                            @endcomponent

                            @component('partials.input', [
                                'key' => 'password_confirmation',
                                'type' => 'password',
                                'error_key' => 'password_confirmation',
                                'title' => 'Password confirmed'
                            ])
                            @endcomponent
                        @endif

                        @if (Auth::user()->can('edit-users') || (Auth::user()->can('create-users') && !$modify))
                            <div class="form-group">
                                <label for="role_id">Select role</label>
                                <select
                                    name="role_id"
                                    id="role_id"
                                    class="form-control{{ $errors->has('role_id') ? ' parsley-error' : '' }}"
                                >
                                    <option value="">Select role</option>
                                    @if($roles->count())
                                        @foreach($roles as $role)
                                            <option
                                                value="{{ data_get($role, 'id') }}"
                                                @if($modify)
                                                    {{ data_get($role, 'id') == data_get($user, 'role_id') ? 'selected' : '' }}
                                                @endif
                                            >
                                                {{ data_get($role, 'label') }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @if($errors->has('role_id'))
                                    <span class="parsley-errors-list filled">
                                        <strong class="parsley-required">
                                            {{ $errors->first('role_id') }}
                                        </strong>
                                    </span>
                                @endif
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary btn-lg btn-block">SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
