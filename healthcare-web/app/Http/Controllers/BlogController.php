<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog; // Pastikan kamu punya model Blog

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();
        return view('blog.index', compact('blogs'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $blogs = Blog::where('judul', 'like', "%$query%")->get();
        return view('blog.index', compact('blogs'));
    }

    
}
