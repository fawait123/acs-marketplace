<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item {{ Request::is('core/user*') || Request::is('core/role*') ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ Request::is('core/user*') || Request::is('core/role*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Settings
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (in_array('user', $permissionAccess->toArray()))
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}"
                            class="nav-link {{ Request::is('core/user*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Users</p>
                        </a>
                    </li>
                @endif
                @if (in_array('role', $permissionAccess->toArray()))
                    <li class="nav-item">
                        <a href="{{ route('role.index') }}"
                            class="nav-link  {{ Request::is('core/role*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Roles & Permission</p>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{ route('core.market.index') }}"
                class="nav-link {{ Request::is('core/market*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Merchant
                    <span class="right badge badge-danger">New</span>
                </p>
            </a>
        </li>
        <li class="nav-item {{ Request::is('core/type*') || Request::is('core/machine*') ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ Request::is('core/type*') || Request::is('core/machine*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-database"></i>
                <p>
                    Master Data
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (in_array('type', $permissionAccess->toArray()))
                    <li class="nav-item">
                        <a href="{{ route('type.index') }}"
                            class="nav-link {{ Request::is('core/type*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Type</p>
                        </a>
                    </li>
                @endif
                @if (in_array('type', $permissionAccess->toArray()))
                    <li class="nav-item">
                        <a href="{{ route('machine.index') }}"
                            class="nav-link {{ Request::is('core/machine*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Machine</p>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    </ul>
</nav>
