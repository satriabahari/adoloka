<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // public function index()
    // {
    //     $services = Service::with('category')->where('is_active', true)->get();
    //     return view('services', compact('services'));
    // }

    // public function show(Service $service)
    // {
    //     return $service->load('category');
    // }

    public function index()
    {
        $categories = ServiceCategory::with(['services' => function ($q) {
            $q->where('is_active', true)->orderBy('created_at', 'desc');
        }])->get();


        return view('services', compact('categories'));
    }

    public function show(Service $service)
    {
        $service->load('category');
        return view('service-detail', compact('service'));
    }
}
