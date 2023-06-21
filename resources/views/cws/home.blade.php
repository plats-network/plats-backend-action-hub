@extends('cws.layouts.app')

@section('name_page')
    <div class="page-title-box align-self-center d-none d-md-block">
        <h4 class="page-title mb-0">Home</h4>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-3">
        <div class="card">
            <div class="card-body">
                <div>
                    <div class="d-flex align-items-center">
                        <div class="avatar">
                            <div class="avatar-title rounded bg-soft-primary">
                                <i class="bx bx-check-shield font-size-24 mb-0 text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 font-size-15">Total Sales</h6>
                        </div>

                        {{-- <div class="flex-shrink-0">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#"
                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-horizontal text-muted font-size-22"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Yearly</a>
                                    <a class="dropdown-item" href="#">Monthly</a>
                                    <a class="dropdown-item" href="#">Weekly</a>
                                    <a class="dropdown-item" href="#">Today</a>
                                </div>
                            </div>
                        </div> --}}
                    </div>

                    <div>
                        <h4 class="mt-4 pt-1 mb-0 font-size-22">$34,123.20 <span class="text-success fw-medium font-size-13 align-middle"> <i class="mdi mdi-arrow-up"></i> 8.34% </span> </h4>
                        <div class="d-flex mt-1 align-items-end overflow-hidden">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 text-truncate">Total Sales World Wide</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div id="mini-1" data-colors='["#1f58c7"]' class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3">
        <div class="card">
            <div class="card-body">
                <div>
                    <div class="d-flex align-items-center">
                        <div class="avatar">
                            <div class="avatar-title rounded bg-soft-primary">
                                <i class="bx bx-cart-alt font-size-24 mb-0 text-primary"></i>
                            </div>
                        </div>

                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 font-size-15">Total Orders</h6>
                        </div>

                        {{-- <div class="flex-shrink-0">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#"
                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-horizontal text-muted font-size-22"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Yearly</a>
                                    <a class="dropdown-item" href="#">Monthly</a>
                                    <a class="dropdown-item" href="#">Weekly</a>
                                    <a class="dropdown-item" href="#">Today</a>
                                </div>
                            </div>
                        </div> --}}
                    </div>

                    <div>
                        <h4 class="mt-4 pt-1 mb-0 font-size-22">63,234.20 <span class="text-danger fw-medium font-size-13 align-middle"> <i class="mdi mdi-arrow-down"></i> 3.68% </span> </h4>
                        <div class="d-flex mt-1 align-items-end overflow-hidden">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 text-truncate">Total Orders World Wide</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div id="mini-2" data-colors='["#1f58c7"]' class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3">
        <div class="card">
            <div class="card-body">
                <div>
                    <div class="d-flex align-items-center">
                        <div class="avatar">
                            <div class="avatar-title rounded bg-soft-primary">
                                <i class="bx bx-package font-size-24 mb-0 text-primary"></i>
                            </div>
                        </div>

                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 font-size-15">Today Visitor</h6>
                        </div>

                        <div class="flex-shrink-0">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#"
                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-horizontal text-muted font-size-22"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Yearly</a>
                                    <a class="dropdown-item" href="#">Monthly</a>
                                    <a class="dropdown-item" href="#">Weekly</a>
                                    <a class="dropdown-item" href="#">Today</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="mt-4 pt-1 mb-0 font-size-22">425,34.45 <span class="text-danger fw-medium font-size-13 align-middle"> <i class="mdi mdi-arrow-down"></i> 2.64% </span> </h4>
                        <div class="d-flex mt-1 align-items-end overflow-hidden">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 text-truncate">Total Visitor World Wide</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div id="mini-3" data-colors='["#1f58c7"]' class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3">
        <div class="card">
            <div class="card-body">
                <div>
                    <div class="d-flex align-items-center">
                        <div class="avatar">
                            <div class="avatar-title rounded bg-soft-primary">
                                <i class="bx bx-rocket font-size-24 mb-0 text-primary"></i>
                            </div>
                        </div>

                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 font-size-15">Total Expense</h6>
                        </div>

                        <div class="flex-shrink-0">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#"
                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-horizontal text-muted font-size-22"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Yearly</a>
                                    <a class="dropdown-item" href="#">Monthly</a>
                                    <a class="dropdown-item" href="#">Weekly</a>
                                    <a class="dropdown-item" href="#">Today</a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div>
                        <h4 class="mt-4 pt-1 mb-0 font-size-22">6,482.46 <span class="text-success fw-medium font-size-13 align-middle"> <i class="mdi mdi-arrow-down"></i> 5.79% </span> </h4>
                        <div class="d-flex mt-1 align-items-end overflow-hidden">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 text-truncate">Total Expense World Wide</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div id="mini-4" data-colors='["#1f58c7"]' class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xxl-8">
        <div class="row">
            <div class="col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-2">
                            <div class="flex-grow-1">
                                <h5 class="card-title">Popular Products</h5>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-muted" href="#"
                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Today<i class="mdi mdi-chevron-down ms-1"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Yearly</a>
                                        <a class="dropdown-item" href="#">Monthly</a>
                                        <a class="dropdown-item" href="#">Weekly</a>
                                        <a class="dropdown-item" href="#">Today</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-md-5">
                            <div class="popular-product-img p-2">
                                <img src="./assets/images/product/img.png" alt="">
                            </div>
                            </div>
                            <div class="col-md-7">
                                <span class="badge badge-soft-primary font-size-10 text-uppercase ls-05"> Popular Item</span>
                                <h5 class="mt-2 font-size-16"><a href="" class="text-dark">Home & Office Chair Blue</a></h5>
                                <p class="text-muted">But who has any right to find chooses enjoy.</p>

                                <div class="row g-0 mt-3 pt-1 align-items-end">
                                    <div class="col-4">
                                        <div class="mt-1">
                                            <h4 class="font-size-16">800</h4>
                                            <p class="text-muted mb-1">Total Selling</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mt-1">
                                            <h4 class="font-size-16">250</h4>
                                            <p class="text-muted mb-1">Total Stock</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mt-1">
                                            <a href="" class="btn btn-primary btn-sm mb-1">Buy
                                                Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mx-n4 px-4" data-simplebar style="max-height: 205px;">
                            <div class="popular-product-box rounded my-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-md">
                                            <div class="product-img avatar-title img-thumbnail bg-soft-primary border-0">
                                                <img src="assets/images/product/img-1.png" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3 overflow-hidden">
                                        <h5 class="mb-1 text-truncate"><a href="" class="font-size-15 text-dark">Wood Chair dark Brown</a></h5>
                                        <p class="text-muted fw-semibold mb-0 text-truncate">$230.00</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end ms-3">
                                        <h5 class="mb-1"><a href="" class="font-size-15 text-dark">$62300.00</a></h5>
                                        <p class="text-muted fw-semibold mb-0">562 Sales</p>
                                    </div>
                                </div>
                            </div>

                            <div class="popular-product-box rounded my-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-md">
                                                <div class="product-img avatar-title img-thumbnail bg-soft-success border-0">
                                                    <img src="assets/images/product/img-8.png" class="img-fluid" alt="">
                                                </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3 overflow-hidden">
                                        <h5 class="mb-1 text-truncate"><a href="" class="font-size-15 text-dark">Home & Office Chair Crime</a></h5>
                                        <p class="text-muted fw-semibold mb-0 text-truncate">$190.00</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end ms-3">
                                        <h5 class="mb-1"><a href="" class="font-size-15 text-dark">$25698.00</a></h5>
                                        <p class="text-muted fw-semibold mb-0">856 Sales</p>
                                    </div>
                                </div>
                            </div>

                            <div class="popular-product-box rounded my-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-md">
                                            <div class="product-img avatar-title img-thumbnail bg-soft-danger border-0">
                                                <img src="assets/images/product/img-3.png" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3 overflow-hidden">
                                        <h5 class="mb-1 text-truncate"><a href="" class="font-size-15 text-dark">Office Chair Blue</a></h5>
                                        <p class="text-muted fw-semibold mb-0 text-truncate">$420.00</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end ms-3">
                                        <h5 class="mb-1"><a href="" class="font-size-15 text-dark">$64351.00</a></h5>
                                        <p class="text-muted fw-semibold mb-0">524 Sales</p>
                                    </div>
                                </div>
                            </div>

                            <div class="popular-product-box rounded my-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-md">
                                            <div class="product-img avatar-title img-thumbnail bg-soft-success border-0">
                                                <img src="assets/images/product/img-4.png" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3 overflow-hidden">
                                        <h5 class="mb-1 text-truncate"><a href="" class="font-size-15 text-dark">Home & Office Chair Green</a></h5>
                                        <p class="text-muted fw-semibold mb-0 text-truncate">$230.00</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end ms-3">
                                        <h5 class="mb-1"><a href="" class="font-size-15 text-dark">$96485.00</a></h5>
                                        <p class="text-muted fw-semibold mb-0">634 Sales</p>
                                    </div>
                                </div>
                            </div>

                            <div class="popular-product-box rounded my-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-md">
                                            <div class="product-img avatar-title img-thumbnail bg-soft-danger border-0" >
                                                <img src="assets/images/product/img-5.png" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3 overflow-hidden">
                                        <h5 class="mb-1 text-truncate"><a href="" class="font-size-15 text-dark">Wood Chair dark Brown</a></h5>
                                        <p class="text-muted fw-semibold mb-0 text-truncate">$230.00</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end ms-3">
                                        <h5 class="mb-1"><a href="" class="font-size-15 text-dark">$56230.00</a></h5>
                                        <p class="text-muted fw-semibold mb-0">964 Sales</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-2">
                            <div class="flex-grow-1">
                                <h5 class="card-title">Loyal Customers</h5>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-muted" href="#"
                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="bx bx-dots-horizontal font-size-22"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Yearly</a>
                                        <a class="dropdown-item" href="#">Monthly</a>
                                        <a class="dropdown-item" href="#">Weekly</a>
                                        <a class="dropdown-item" href="#">Today</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mx-n4 px-4" data-simplebar style="max-height: 421px;">
                            <div class="border-bottom loyal-customers-box pt-2">
                                <div class="d-flex align-items-center">
                                    <img src="assets/images/users/avatar-4.jpg" class="rounded-circle avatar img-thumbnail" alt="">
                                    <div class="flex-grow-1 ms-3 overflow-hidden">
                                        <h5 class="font-size-15 mb-1 text-truncate">Michelle Bernard</h5>
                                        <p class="text-muted text-truncate mb-0">Michelle@gmail.com</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <h5 class="font-size-14 mb-0 text-truncate w-xs bg-light p-2 rounded text-center">
                                            4.7 <i class="bx bxs-star font-size-14 text-primary ms-1"></i></h5>
                                    </div>
                                </div>
                            </div>

                            <div class="border-bottom loyal-customers-box">
                                <div class="d-flex align-items-center">
                                    <img src="assets/images/users/avatar-5.jpg" class="rounded-circle avatar img-thumbnail" alt="">
                                    <div class="flex-grow-1 ms-3 overflow-hidden">
                                        <h5 class="font-size-15 mb-1 text-truncate">David Grajeda</h5>
                                        <p class="text-muted text-truncate mb-0">David@gmail.com</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <h5 class="font-size-14 mb-0 text-truncate w-xs bg-light p-2 rounded text-center">
                                            3.4 <i class="bx bxs-star font-size-14 text-primary ms-1"></i></h5>
                                    </div>
                                </div>
                            </div>

                            <div class="border-bottom loyal-customers-box">
                                <div class="d-flex align-items-center">
                                    <img src="assets/images/users/avatar-6.jpg" class="rounded-circle avatar img-thumbnail" alt="">
                                    <div class="flex-grow-1 ms-3 overflow-hidden">
                                        <h5 class="font-size-15 mb-1 text-truncate">Charles Roman</h5>
                                        <p class="text-muted text-truncate mb-0">Charles@gmail.com</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <h5 class="font-size-14 mb-0 text-truncate w-xs bg-light p-2 rounded text-center">
                                            4.9 <i class="bx bxs-star font-size-14 text-primary ms-1"></i></h5>
                                    </div>
                                </div>
                            </div>

                            <div class="border-bottom loyal-customers-box">
                                <div class="d-flex align-items-center">
                                    <img src="assets/images/users/avatar-7.jpg" class="rounded-circle avatar img-thumbnail" alt="">
                                    <div class="flex-grow-1 ms-3 overflow-hidden">
                                        <h5 class="font-size-15 mb-1 text-truncate">David Reynolds</h5>
                                        <p class="text-muted text-truncate mb-0">David@gmail.com</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <h5 class="font-size-14 mb-0 text-truncate w-xs bg-light p-2 rounded text-center">
                                            3.5 <i class="bx bxs-star font-size-14 text-primary ms-1"></i></h5>
                                    </div>
                                </div>
                            </div>

                            <div class="border-bottom loyal-customers-box">
                                <div class="d-flex align-items-center">
                                    <img src="assets/images/users/avatar-8.jpg" class="rounded-circle avatar img-thumbnail" alt="">
                                    <div class="flex-grow-1 ms-3 overflow-hidden">
                                        <h5 class="font-size-15 mb-1 text-truncate">Marion Munroe</h5>
                                        <p class="text-muted text-truncate mb-0">Marion@gmail.com</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <h5 class="font-size-14 mb-0 text-truncate w-xs bg-light p-2 rounded text-center">
                                            2.3 <i class="bx bxs-star font-size-14 text-primary ms-1"></i></h5>
                                    </div>
                                </div>
                            </div>

                            <div class="py-3 loyal-customers-box">
                                <div class="d-flex align-items-center">
                                    <img src="assets/images/users/avatar-5.jpg" class="rounded-circle avatar img-thumbnail" alt="">
                                    <div class="flex-grow-1 ms-3 overflow-hidden">
                                        <h5 class="font-size-15 mb-1 text-truncate">Christina Emerson</h5>
                                        <p class="text-muted text-truncate mb-0">Christina@gmail.com</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <h5 class="font-size-14 mb-0 text-truncate w-xs bg-light p-2 rounded text-center">
                                            4.1 <i class="bx bxs-star font-size-14 text-primary ms-1"></i></h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xxl-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="flex-grow-1 overflow-hidden">
                        <h5 class="card-title mb-4 text-truncate">Top Selling Categories</h5>
                    </div>
                    <div class="flex-shrink-0 ms-2">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span class="fw-semibold">Sort By:</span> <span
                                    class="text-muted">Weekly<i
                                        class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Yearly</a>
                                <a class="dropdown-item" href="#">Monthly</a>
                                <a class="dropdown-item" href="#">Weekly</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="saleing-categories" data-colors='["#1f58c7", "#4976cf","#6a92e1", "#e6ecf9"]' class="apex-charts" dir="ltr"></div> 

                <div class="row mt-3 pt-1">
                    <div class="col-md-6">
                        <div class="px-2 mt-2">
                            <div class="d-flex align-items-center mt-sm-0 mt-2">
                                <i class="mdi mdi-circle font-size-10 text-primary"></i>
                                <div class="flex-grow-1 ms-2 overflow-hidden">
                                    <p class="font-size-15 mb-1 text-truncate">Men Fashion</p>
                                </div>
                                <div class="flex-shrink-0 ms-2">
                                    <span class="fw-bold">34.3%</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mt-2">
                                <i class="mdi mdi-circle font-size-10 text-success"></i>
                                <div class="flex-grow-1 ms-2 overflow-hidden">
                                    <p class="font-size-15 mb-0 text-truncate">Women Clothing</p>
                                </div>
                                <div class="flex-shrink-0 ms-2">
                                    <span class="fw-bold">25.7%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="px-2 mt-2">
                            <div class="d-flex align-items-center mt-sm-0 mt-2">
                                <i class="mdi mdi-circle font-size-10 text-info"></i>
                                <div class="flex-grow-1 ms-2 overflow-hidden">
                                    <p class="font-size-15 mb-1 text-truncate">Beauty Products</p>
                                </div>
                                <div class="flex-shrink-0 ms-2">
                                    <span class="fw-bold">18.6%</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mt-2">
                                <i class="mdi mdi-circle font-size-10 text-secondary"></i>
                                <div class="flex-grow-1 ms-2 overflow-hidden">
                                    <p class="font-size-15 mb-0 text-truncate">Others Products</p>
                                </div>
                                <div class="flex-shrink-0 ms-2">
                                    <span class="fw-bold">21.4%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
