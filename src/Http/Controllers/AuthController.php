<?php

namespace Totaa\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Totaa\Auth\DataTables\AdminAuthDataTable;

class AuthController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index(AdminAuthDataTable $dataTable)
    {
        if (Auth::user()->bfo_info->hasAnyPermission(["view-account"])) {
            return $dataTable->render('totaa-account::account', ['title' => 'Quản lý Tài khoản']);
        } else {
            return view('errors.dynamic', [
                'error_code' => '403',
                'error_description' => 'Không có quyền truy cập',
                'title' => 'Quản lý Tài khoản',
            ]);
        }
    }
}
