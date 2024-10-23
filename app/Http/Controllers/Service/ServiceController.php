<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class ServiceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return $user;
    }
}
