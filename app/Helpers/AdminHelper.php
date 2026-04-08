<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;


class AdminHelper
{
    public static function isAdmin(): bool
    {
        return Auth::check() && Auth::user()->email === env('ADMIN_EMAIL');
    }
}