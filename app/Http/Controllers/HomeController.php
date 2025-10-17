<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::latest()->take(3)->get();
        $categories = Category::orderBy('name')->get();

        return view('home', compact('events', 'categories'));
    }
}
