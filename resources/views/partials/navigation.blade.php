<ul class="nav">
    <li>
        <a
            href="{{ route('home') }}"
            class="{{ Route::currentRouteName() == 'home' ? 'active' : '' }}"
        >
            <i class="lnr lnr-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    @if (
        Auth::user()->can('view-users')
        || Auth::user()->can('view-own-users')
        || Auth::user()->can('create-roles')
        || Auth::user()->can('create-users')
    )
        <li>
            @php
                $usersActive = Str::is("users.*", Route::currentRouteName());
                $rolesActive = Str::is("roles.*", Route::currentRouteName());

                $active = $usersActive || $rolesActive ? ' active' : ' collapsed';
                $activeIndex = $usersActive ? 'active' : null;
                $activeRole = $rolesActive ? 'active' : null;
                $in = ($usersActive || $rolesActive) ? 'in' : null;
            @endphp
            <a href="#users" data-toggle="collapse" class="{{ $active }}" aria-expanded="true">
                <i class="lnr lnr-users"></i>
                <span>Users</span>
                <i class="icon-submenu lnr lnr-chevron-left"></i>
            </a>
            <div id="users" class="collapse{{ $in }}" aria-expanded="true" style="">
                <ul class="nav">
                    @if (Auth::user()->can('view-users') || Auth::user()->can('view-own-users') || Auth::user()->can('create-users'))
                        <li><a href="{{ route('users.index') }}" class="{{ $activeIndex }}">Menage users</a></li>
                    @endif
                    @if (Auth::user()->can('view-roles') || Auth::user()->can('create-roles'))
                        <li><a href="{{ route('roles.index') }}" class="{{ $activeRole }}">Menage roles</a></li>
                    @endif
                </ul>
            </div>
        </li>
    @endif
    @if (Auth::user()->can('view-clients') || Auth::user()->can('create-clients'))
        <li>
            <a
                href="{{ route('clients.index') }}"
                class="{{ Str::is('clients.*', Route::currentRouteName()) ? 'active' : '' }}"
            >
                <i class="lnr lnr-users"></i>
                <span>Clients</span>
            </a>
        </li>
    @endif
    @if (Auth::user()->can('view-payments'))
        <li>
            <a
                href="{{ route('payments.index') }}"
                class="{{ Str::is('payments.*', Route::currentRouteName()) ? 'active' : '' }}"
            >
                <i class="lnr lnr-list"></i>
                <span>Payments</span>
            </a>
        </li>
    @endif
</ul>

