<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    // indexアクションを追加
    public function index()
    {
        return view('posts.index');
    }
}
