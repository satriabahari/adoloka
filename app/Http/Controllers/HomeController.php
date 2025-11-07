<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\ProductCategory;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::with(['media', 'categories'])
            ->upcoming()
            ->take(3)
            ->get();

        $categories = ProductCategory::orderBy('name')->get();

        $benefits = config('adoloka.home_benefits');

        $features = config('adoloka.home_features');

        return view('home', compact('events', 'categories', 'benefits', 'features'));
    }
}
