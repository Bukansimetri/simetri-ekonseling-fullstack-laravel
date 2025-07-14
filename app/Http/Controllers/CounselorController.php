<?php

namespace App\Http\Controllers;

use App\Models\Counselor;
use Illuminate\Http\Request;

class CounselorController extends Controller
{
    public function index(Request $request)
    {
        $query = Counselor::query();

        // // Filter spesialisasi
        // if ($request->has('specializations')) {
        //     $query->whereIn('specialization', $request->specializations);
        // }

        // // Filter rating
        // if ($request->has('ratings')) {
        //     $ratings = array_map('intval', $request->ratings);
        //     $query->whereIn('rating', $ratings);
        // }

        // // Filter ketersediaan
        // if ($request->has('availability')) {
        //     if (in_array('available_now', $request->availability)) {
        //         $query->where('is_active', 1);
        //     }
        // }

        // // Filter bahasa (contoh field: languages -> JSON array di DB)
        // if ($request->has('languages')) {
        //     foreach ($request->languages as $language) {
        //         $query->whereJsonContains('languages', $language);
        //     }
        // }

        // // Sorting
        // if ($request->sort_by == 'price_low') {
        //     $query->orderBy('price', 'asc');
        // } elseif ($request->sort_by == 'price_high') {
        //     $query->orderBy('price', 'desc');
        // } else {
        //     $query->orderBy('rating', 'desc'); // default sort by rating
        // }

        $counselors = $query->paginate(6)->withQueryString();

        return view('counselors.index', compact('counselors'));
    }

    public function apiIndex()
    {
        $counselors = Counselor::all()->mapWithKeys(function ($counselor) {
            return [
                $counselor->id => [
                    'name' => $counselor->name,
                    'specialty' => $counselor->specialization ?? 'Tidak ada',
                    'bio' => $counselor->essay ?? 'Belum ada bio',
                    'rating' => rand(4, 5), // Sementara random
                    'ratingCount' => '('.rand(50, 300).' ulasan)',
                    'availability' => $counselor->is_active ? 'Tersedia Sekarang' : 'Tidak Tersedia',
                    'price' => 'Rp '.number_format($counselor->price ?? 0, 0, ',', '.').'/sesi',
                    'education' => [
                        $counselor->education ?? 'Belum ada data pendidikan',
                    ],
                    'experience' => [
                        $counselor->experience ?? 'Belum ada data pengalaman',
                    ],
                    'image' => $counselor->image
                        ? asset('storage/'.$counselor->image)
                        : asset('images/default.png'),
                ],
            ];
        });

        return response()->json($counselors);
    }
}
