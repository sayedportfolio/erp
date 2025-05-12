<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// client login page
Route::get('/login', function () {
    return view('auth.client.login');
})->name('login');

// Employee login page
Route::get('/admin/login', function () {
    return view('auth.admin.login');
})->name('admin.login');


// Only authenticate users
Route::group(['middleware' => 'auth'], function () {
    // For unauthorised access
    Route::get('/access-denied', function () {
        return view('unauthorised-access');
    })->name('access-denied');
});

// only admin
Route::group(['middleware' => 'admin'], function () {

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/profile', function () {
        return view('admin.profile');
    })->name('admin.profile');

    Route::get('/admin/change-password', function () {
        return view('admin.change-password');
    })->name('admin.change-password');

    Route::get('/admin/company-details', function () {
        return view('admin.company-details');
    })->name('admin.company-details');

    Route::get('/admin/branches', function () {
        return view('admin.branches');
    })->name('admin.branches');

    Route::get('/admin/departments', function () {
        return view('admin.departments');
    })->name('admin.departments');

    Route::get('/admin/help', function () {
        return view('admin.help');
    })->name('admin.help');

    Route::get('/admin/role-manager', function () {
        return view('admin.role-manager');
    })->name('admin.role-manager');

    Route::get('/admin/permission-manager', function () {
        return view('admin.permission-manager');
    })->name('admin.permission-manager');

    Route::get('/admin/payment-gateway-integration', function () {
        return view('admin.payment-gateway-integration');
    })->name('admin.payment-gateway-integration');

    Route::get('/admin/whatsapp-integration', function () {
        return view('admin.whatsapp-integration');
    })->name('admin.whatsapp-integration');

    Route::get('/admin/sms-integration', function () {
        return view('admin.sms-integration');
    })->name('admin.sms-integration');

    Route::get('/admin/users', function () {
        return view('admin.users');
    })->name('admin.users');

    Route::get('/admin/tasks', function () {
        return view('admin.tasks');
    })->name('admin.tasks');

    Route::get('/admin/projects', function () {
        return view('admin.projects');
    })->name('admin.projects');


    Route::get('/admin/logout', function () {
        return view('admin.users');
    })->name('admin.logout');
});


// only client
Route::group(['middleware' => 'client'], function () {
    Route::get('/client/dashboard', function () {
        return view('client.dashboard');
    })->name('client.dashboard');

    Route::get('/client/profile', function () {
        return view('client.profile');
    })->name('client.profile');

    Route::get('/client/billing', function () {
        return view('client.billing');
    })->name('client.billing');

    Route::get('/client/projects', function () {
        return view('client.projects');
    })->name('client.projects');

    Route::get('/client/settings', function () {
        return view('client.settings');
    })->name('client.settings');
});
