<!-- Menu Start -->
<div class="col-auto d-none d-lg-flex">
    <ul class="sw-25 side-menu mb-0 primary" id="menuSide">
        @if (optional(auth()->user())->role == ADMIN_ROLE)
            <li>
                <a href="#" data-bs-target="#dashboard">
                    <i data-acorn-icon="grid-1" class="icon" data-acorn-size="18"></i>
                    <span class="label">Dashboard</span>
                </a>
                <ul>
                    <li>
                        <a href="{{ route(DASHBOARD_ADMIN_ROUTER) }}" class="active">
                            <i data-acorn-icon="navigate-diagonal" class="icon" data-acorn-size="18"></i>
                            <span class="label">{{ trans('nav.dashboard') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route(EVENT_LIST_ADMIN_ROUTER) }}">
                            <i data-acorn-icon="form-check" class="icon d-none" data-acorn-size="18"></i>
                            <span class="label">Events</span>
                        </a>
                    </li>
                </ul>
            </li>
        @else
            <li>
                <a href="#" data-bs-target="#services">
                    <i data-acorn-icon="grid-1" class="icon" data-acorn-size="18"></i>
                    <span class="label">Action hub</span>
                </a>
                <ul>
                    <li>
                        <a href="{{ route(TASK_LIST_ADMIN_ROUTER) }}">
                            <i data-acorn-icon="form-check" class="icon d-none" data-acorn-size="18"></i>
                            <span class="label">Tasks</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route(EVENT_LIST_ADMIN_ROUTER) }}">
                            <i data-acorn-icon="form-check" class="icon d-none" data-acorn-size="18"></i>
                            <span class="label">Events</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route(REWARD_LIST_ADMIN_ROUTER) }}">
                            <i data-acorn-icon="form-check" class="icon d-none" data-acorn-size="18"></i>
                            <span class="label">Rewards</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route(GROUP_LIST_ADMIN_ROUTER) }}">
                            <i data-acorn-icon="form-check" class="icon d-none" data-acorn-size="18"></i>
                            <span class="label">Groups</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route(USER_LIST_ADMIN_ROUTER) }}">
                            <i data-acorn-icon="form-check" class="icon d-none" data-acorn-size="18"></i>
                            <span class="label">Users</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</div>
