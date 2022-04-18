<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Dashboard;

Route::get('/', [Dashboard::class, 'index'])->name(DASHBOARD_ADMIN_ROUTER);
