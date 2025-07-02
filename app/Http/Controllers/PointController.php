<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{
    public function earnPoints()
    {
        $user = Auth::user();
        $totalPoints = $user->current_points;

        // Data cara mendapatkan poin (bisa disesuaikan dengan sistem yang ada)
        $pointSources = [
            [
                'title' => 'Pembelian Produk',
                'description' => 'Dapatkan 1 Point dari setiap pembelian produk Oneseven Store senilai Rp 1.250.000',
                'icon' => 'bi-cart',
                'points' => '1 poin/Rp 1250.000'
            ],
            [
                'title' => 'Referral Teman',
                'description' => 'Ajak teman bergabung dan dapatkan bonus poin',
                'icon' => 'bi-person-plus',
                'points' => '1 poin/referral'
            ],
        ];

        return view('earn-point', compact('totalPoints', 'pointSources'));
    }
}
