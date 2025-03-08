<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banner = Banner::first();
        return view('Admin.banner.index', compact('banner'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp'
        ]);

        $banner = Banner::first();
        $banner->title = $request->title;
        $banner->slug = Str::slug($request->title);
        if ($request->hasFile('image')) {
            //--old image delete--
            if ($banner->image && file_exists(public_path($banner->image))) {
                unlink(public_path($banner->image));
            }

            $image = $request->file('image')->getClientOriginalExtension();
            $image_name = time() . '.' . $image;
            $destination_path = 'admin/bannerImage/' . $image_name;
            $request->file('image')->move(public_path('admin/bannerImage'), $image_name);
            $banner->image = $destination_path;
        }
        $banner->link = $request->link;
        $banner->status = $request->status;
        $banner->save();
        return redirect()->route('banner.index')->with('success', 'Banner Added Successfully');
    }
}
