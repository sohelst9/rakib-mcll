<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ZipArchive;

class BattleGameController extends Controller
{
    //--index
    public function index()
    {
        $games = Game::latest()->with('category')->get();
        return view('Admin.game.battleGame.index', compact('games'));
    }

    //--- create
    public function create()
    {
        $categories = category::all();
        return view('Admin.game.battleGame.create', compact('categories'));
    }

    //-- store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'thumbnail' => 'required|image|mimes:png,jpg,jpeg,webp',
            'file' => 'required|mimes:zip',
        ]);

        $slug = Str::slug($request->name);
        $game = new Game();
        $game->name = $request->name;
        $game->slug = $slug;
        $game->category_id = $request->category_id;

        //-- upload image
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnail_name = time() . $slug . '.' . $thumbnail->getClientOriginalExtension();
            $path = 'admin/battlegame/thumbnail/' . $thumbnail_name;
            $thumbnail->move(public_path('admin/battlegame/thumbnail'), $thumbnail_name);
            $game->thumbnail = $path;
        }

        //-- game file upload process
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $zip = new ZipArchive();
            $zip->open($file->path());
            $pathName = 'admin/battlegame/game/' . $slug;
            $zip->extractTo($pathName);
            $game->file = $pathName;
        }

        $game->description = $request->description;
        //-- save game
        if ($game->save()) {
            return redirect()->route('admin.battle.games')->with('success', 'Game created successfully');
        } else {
            return redirect()->back()->with('error', 'Game creation failed');
        }
    }

    //--edit
    public function edit($slug)
    {
        $game = Game::where('slug', $slug)->first();
        $categories = Category::all();
        return view('Admin.game.battleGame.edit', compact('game', 'categories'));
    }

    //--update
    public function update(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'thumbnail' => 'nullable|image|mimes:png,jpg,jpeg,webp',
            'file' => 'nullable|mimes:zip',
        ]);
        $game = Game::where('slug', $slug)->first();
        $slug = Str::slug($request->name);

        $game->name = $request->name;
        $game->slug = $slug;
        $game->category_id = $request->category_id;
        $game->description = $request->description;

        //-- thumbnail upload process
        if ($request->hasFile('thumbnail')) {
            //-- delete old thumbnail
            if ($game->thumbnail && file_exists(public_path($game->thumbnail))) {
                unlink(public_path($game->thumbnail));
            }
            //-- upload new thumbnail
            $thumbnail = $request->file('thumbnail');
            $thumbnail_name = time() . $slug . '.' . $thumbnail->getClientOriginalExtension();
            $path = 'admin/battlegame/thumbnail/' . $thumbnail_name;
            $thumbnail->move(public_path('admin/battlegame/thumbnail'), $thumbnail_name);
            $game->thumbnail = $path;
        }

        //-- file upload process
        if ($request->hasFile('file')) {
            //-- delete old file
            $oldFile = $game->file;
            if ($oldFile && file_exists(public_path($oldFile))) {
                File::deleteDirectory(public_path($oldFile));
            }
            //-- upload new file
            $file = $request->file('file');
            $zip = new ZipArchive();
            $zip->open($file->path());
            $pathName = 'admin/battlegame/game/' . $slug;
            $zip->extractTo($pathName);
            $game->file = $pathName;
        }

        //-- update game
        if ($game->save()) {
            return redirect()->route('admin.battle.games')->with('success', 'Game Updated successfully');
        } else {
            return redirect()->back()->with('error', 'Game Updated failed');
        }
    }

    //---delete
    public function delete($slug)
    {
        $game = Game::where('slug', $slug)->first();
        if ($game) {
            //-- delete thumbnail
            if ($game->thumbnail && file_exists(public_path($game->thumbnail))) {
                unlink(public_path($game->thumbnail));
            }
            //-- delete file
            if ($game->file && file_exists(public_path($game->file))) {
                File::deleteDirectory(public_path(
                    $game->file
                ));
            }
            //-- delete game
            $game->delete();
            return redirect()->route('admin.battle.games')->with('success', 'Game Deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Game Deleted failed');
        }
    }
}
