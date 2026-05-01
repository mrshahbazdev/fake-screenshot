<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request, ?string $page = null): View
    {
        if ($page === null) {
            $page = 'firstPage';
        }

        $pageData = Page::where('name', $page)->firstOrFail();
        $allPages = Page::select('name', 'thumbnail')->orderBy('id')->get();

        return view('home', [
            'pageData' => $pageData,
            'allPages' => $allPages,
            'currentPage' => $page,
        ]);
    }
}
