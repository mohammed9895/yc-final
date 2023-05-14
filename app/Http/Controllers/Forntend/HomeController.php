<?php

namespace App\Http\Controllers\Forntend;

use App\Models\Path;
use App\Models\Statistice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $paths = Path::all();
        $statistices = Statistice::paginate(4);
        return view('frontend.index', compact('paths', 'statistices'));
    }

    public function path($id)
    {
        $path = Path::where('id', $id)->first();
        return view('frontend.paths', compact('id', 'path'));
    }

    public function about()
    {
        $statistices = Statistice::paginate();
        return view('frontend.about', compact('statistices'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }
}
