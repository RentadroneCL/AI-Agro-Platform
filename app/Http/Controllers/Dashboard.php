<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class Dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function __invoke(): View
    {
        $sites = Auth::user()->hasRole('administrator')
            ? Site::query()->with(['user', 'inspections'])->get()
            : Site::query()->with(['user', 'inspections'])->where(['user_id' => Auth::id()])->get();

        return view('dashboard', compact('sites'));
    }
}
