<div class="vertical-menu">
    <div class="navbar-brand-box">
        <a href="{{url('/')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{asset('imgs/logo.svg')}}" alt="" height="26">
            </span>
            <span class="logo-lg">
                <img src="{{asset('imgs/logo-light-blue.svg')}}" alt="" height="28" style="width: 135px;">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
        <i class="bx bx-menu align-middle"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Dashboard</li>
                <li>
                    <a href="javascript: void(0);">
                        <i class="bx bx-home-alt icon nav-icon"></i>
                        <span class="menu-item" data-key="t-dashboard">Dashboard</span>
                        <span class="badge rounded-pill bg-primary">2</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="index.html" data-key="t-ecommerce">Ecommerce</a></li>
                        <li><a href="dashboard-sales.html" data-key="t-sales">Sales</a></li>
                    </ul>
                </li>

                <li class="menu-title" data-key="t-applications">Applications</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bx-envelope icon nav-icon"></i>
                        <span class="menu-item" data-key="t-email">Email</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="email-inbox.html" data-key="t-inbox">Inbox</a></li>
                        <li><a href="email-read.html" data-key="t-read-email">Read Email</a></li>
                    </ul>
                </li>

                <li>
                    <a href="apps-calendar.html">
                        <i class="bx bx-calendar-event icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">Calendar</span>
                    </a>
                </li>

                <li>
                    <a href="apps-todo.html">
                        <i class="bx bx-check-square icon nav-icon"></i>
                        <span class="menu-item" data-key="t-todo">Todo</span>
                        <span class="badge rounded-pill bg-success" data-key="t-new">New</span>
                    </a>
                </li>

                <li>
                    <a href="apps-file-manager.html">
                        <i class="bx bx-file-find icon nav-icon"></i>
                        <span class="menu-item" data-key="t-filemanager">File Manager</span>
                    </a>
                </li>
                <li>
                    <a href="apps-chat.html">
                        <i class="bx bx-chat icon nav-icon"></i>
                        <span class="menu-item" data-key="t-chat">Chat</span>
                        <span class="badge rounded-pill bg-danger" data-key="t-hot">Hot</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bx-store icon nav-icon"></i>
                        <span class="menu-item" data-key="t-ecommerce">Ecommerce</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="ecommerce-products.html" data-key="t-products">Products</a></li>
                        <li><a href="ecommerce-product-detail.html" data-key="t-product-detail">Product Detail</a></li>
                        <li><a href="ecommerce-orders.html" data-key="t-orders">Orders</a></li>
                        <li><a href="ecommerce-customers.html" data-key="t-customers">Customers</a></li>
                        <li><a href="ecommerce-cart.html" data-key="t-cart">Cart</a></li>
                        <li><a href="ecommerce-checkout.html" data-key="t-checkout">Checkout</a></li>
                        <li><a href="ecommerce-shops.html" data-key="t-shops">Shops</a></li>
                        <li><a href="ecommerce-add-product.html" data-key="t-add-product">Add Product</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>