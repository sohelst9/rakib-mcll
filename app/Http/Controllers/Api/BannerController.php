<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function banner()
    {
        $banner = Banner::first();
        return response()->json([
            'title' => $banner->title,
            'image' => asset($banner->image),
            'link' => $banner->link,
            'status' => $banner->status == 1 ? 'active' : 'inactive'
        ]);
    }
}
