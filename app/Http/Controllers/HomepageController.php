<?php

namespace App\Http\Controllers;

use App\Models\Counselor;
use App\Models\HeroSection;
use App\Models\Service;
use App\Models\Testimonial;

class HomepageController extends Controller
{
    public function index()
    {
        $herosection = HeroSection::where('is_active', 1)
            ->latest()
            ->limit(1)
            ->get();

        $service = Service::where('is_active', 1)
            ->latest()
            ->limit(3)
            ->get();

        $testimonial = Testimonial::where('is_active', 1)
            ->latest()
            ->limit(3)
            ->get();

        $counselor = Counselor::latest()
            ->limit(3)
            ->get();

        return view('welcome', compact(
            'herosection',
            'service',
            'testimonial',
            'counselor'
        ));
    }
}
