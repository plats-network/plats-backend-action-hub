<!-- Menu Start -->
<div class="col-auto d-none d-lg-flex">
    <ul class="sw-25 side-menu mb-0 primary" id="menuSide">
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
                    <a href="#">
                        <i data-acorn-icon="chart-4" class="icon" data-acorn-size="18"></i>
                        <span class="label">Analysis</span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#" data-bs-target="#services">
                <i data-acorn-icon="grid-1" class="icon" data-acorn-size="18"></i>
                <span class="label">Action hub</span>
            </a>
            <ul>
                <li>
                    <a href="{{ route(TASK_LIST_ADMIN_ROUTER) }}">
                        <i data-acorn-icon="form-check" class="icon d-none" data-acorn-size="18"></i>
                        <span class="label">Task Management</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i data-acorn-icon="boxes" class="icon d-none" data-acorn-size="18"></i>
                        <span class="label">NFT Management</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i data-acorn-icon="user" class="icon d-none" data-acorn-size="18"></i>
                        <span class="label">Customer Management</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route(GUILD_LIST_ADMIN_ROUTER) }}">
                        <i data-acorn-icon="spinner" class="icon d-none" data-acorn-size="18"></i>
                        <span class="label">Guilds</span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#" data-bs-target="#account">
                <i data-acorn-icon="user" class="icon" data-acorn-size="18"></i>
                <span class="label">Accounting</span>
            </a>
            <ul>
                <li>
                    <a href="/Account/Settings">
                        <i data-acorn-icon="gear" class="icon d-none" data-acorn-size="18"></i>
                        <span class="label">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="/Account/Billing">
                        <i data-acorn-icon="credit-card" class="icon d-none" data-acorn-size="18"></i>
                        <span class="label">Billing</span>
                    </a>
                </li>
                <li>
                    <a href="/Account/Security">
                        <i data-acorn-icon="shield" class="icon d-none" data-acorn-size="18"></i>
                        <span class="label">Security</span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#" data-bs-target="#support">
                <i data-acorn-icon="help" class="icon" data-acorn-size="18"></i>
                <span class="label">Support</span>
            </a>
            <ul>
                <li>
                    <a href="/Support/Docs">
                        <i data-acorn-icon="file-empty" class="icon d-none" data-acorn-size="18"></i>
                        <span class="label">Docs</span>
                    </a>
                </li>
                <li>
                    <a href="/Support/KnowledgeBase">
                        <i data-acorn-icon="notebook-1" class="icon d-none" data-acorn-size="18"></i>
                        <span class="label">Knowledge Base</span>
                    </a>
                </li>
                <li>
                    <a href="/Support/Tickets">
                        <i data-acorn-icon="bookmark" class="icon d-none" data-acorn-size="18"></i>
                        <span class="label">Tickets</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>

</div>
<!-- Menu End -->
