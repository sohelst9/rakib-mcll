<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Price;
use App\Models\Admin\TournamentPrice;
use App\Models\category;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ZipArchive;

class TournamentGameController extends Controller
{
    //--index
    public function index()
    {
        $games = Tournament::latest()->with('category')->get();
        return view('Admin.game.tournamentGame.index', compact('games'));
    }

    //--status
    public function status($slug)
    {
        $game = Tournament::where('slug', $slug)->first();
        if ($game) {
            $game->status = $game->status == 1 ? 0 : 1;
            $game->save();
            return redirect()->back()->with('success', 'Game status updated successfully');
        } else {
            return redirect()->back()->with('error', 'Game status updated failed');
        }
    }

    //--- create
    public function create()
    {
        $categories = category::all();
        return view('Admin.game.tournamentGame.create', compact('categories'));
    }

    //-- store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'entry_fee' => 'required',
            'thumbnail' => 'required|image|mimes:png,jpg,jpeg,webp',
            'file' => 'required|mimes:zip',
        ]);

        $slug = Str::slug($request->name);
        $game = new Tournament();
        $game->name = $request->name;
        $game->slug = $slug;
        $game->category_id = $request->category_id;
        $game->start_date = $request->start_date;
        $game->end_date = $request->end_date;
        $game->entry_fee = $request->entry_fee;

        //-- upload image
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnail_name = time() . $slug . '.' . $thumbnail->getClientOriginalExtension();
            $path = 'admin/tournamentGame/thumbnail/' . $thumbnail_name;
            $thumbnail->move(public_path('admin/tournamentGame/thumbnail'), $thumbnail_name);
            $game->thumbnail = $path;
        }

        //-- game file upload process
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $zip = new ZipArchive();
            $zip->open($file->path());
            $pathName = 'admin/tournamentGame/game/' . $slug;
            $zip->extractTo($pathName);
            $game->file = $pathName;
        }

        $game->description = $request->description;
        //-- save game
        if ($game->save()) {
            return redirect()->route('admin.tournament.games')->with('success', 'Game created successfully');
        } else {
            return redirect()->back()->with('error', 'Game creation failed');
        }
    }

    //--edit
    public function edit($slug)
    {
        $game = Tournament::where('slug', $slug)->first();
        $categories = Category::all();
        return view('Admin.game.tournamentGame.edit', compact('game', 'categories'));
    }

    //--update
    public function update(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'entry_fee' => 'required',
            'thumbnail' => 'nullable|image|mimes:png,jpg,jpeg,webp',
            'file' => 'nullable|mimes:zip',
        ]);
        $game = Tournament::where('slug', $slug)->first();
        $slug = Str::slug($request->name);

        $game->name = $request->name;
        $game->slug = $slug;
        $game->category_id = $request->category_id;
        $game->start_date = $request->start_date;
        $game->end_date = $request->end_date;
        $game->entry_fee = $request->entry_fee;
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
            $path = 'admin/tournamentGame/thumbnail/' . $thumbnail_name;
            $thumbnail->move(public_path('admin/tournamentGame/thumbnail'), $thumbnail_name);
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
            $pathName = 'admin/tournamentGame/game/' . $slug;
            $zip->extractTo($pathName);
            $game->file = $pathName;
        }

        //-- update game
        if ($game->save()) {
            return redirect()->route('admin.tournament.games')->with('success', 'Game Updated successfully');
        } else {
            return redirect()->back()->with('error', 'Game Updated failed');
        }
    }

    //---delete
    public function delete($slug)
    {
        $game = Tournament::where('slug', $slug)->first();
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
            return redirect()->route('admin.tournament.games')->with('success', 'Game Deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Game Deleted failed');
        }
    }


    //--prices
    public function prices($slug)
    {
        $game = Tournament::where('slug', $slug)->first();
        $prices = TournamentPrice::where('tournament_id', $game->id)->get();
        return view('Admin.game.tournamentGame.price.index', compact('game', 'prices'));
    }

    //--- price_store
    public function price_store(Request $request, $id)
    {
        // return $request->all();
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'position' => 'required',
        ]);
        $game = Tournament::where('id', $id)->first();
        if ($game) {
            $slug = Str::slug($request->name);
            $price = new TournamentPrice();
            $price->tournament_id = $game->id;
            $price->name = $request->name;
            $price->price = $request->price;
            $price->slug = $slug;
            $price->position = $request->position;
            $price->status = $request->status;
            $price->save();
            return redirect()->route('admin.tournament.game.price', $game->slug)->with('success', 'Price Added successfully');
        }
    }

    //--- price_edit
    public function price_edit($id)
    {
        $price = TournamentPrice::where('id', $id)->first();
        $gameid = $price->tournament_id;
        return view('Admin.game.tournamentGame.price.edit', compact('price', 'gameid'));
    }

    //--- price_update
    public function price_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'position' => 'required',
        ]);
        $game = Tournament::where('id', $request->game_id)->first();
        $price = TournamentPrice::where('id', $id)->first();
        if ($price) {
            $price->name = $request->name;
            $price->slug = Str::slug($request->name);
            $price->price = $request->price;
            $price->position = $request->position;
            $price->status = $request->status;
            $price->save();
            return redirect()->route('admin.tournament.game.price', $game->slug)->with('success', 'Price Updated successfully');
        }
    }

    //--price_status
    public function price_status($id)
    {
        $price = TournamentPrice::where('id', $id)->first();
        if ($price) {
            $price->status = $price->status == 1 ? 0 : 1;
            $price->save();
            return redirect()->back()->with('success', 'Price Status updated successfully');
        } else {
            return redirect()->back()->with('error', 'Price Status updated failed');
        }
    }

    //--price_delete
    public function price_delete($id)
    {
        $price = TournamentPrice::where('id', $id)->first();
        if ($price) {
            $price->delete();
            return redirect()->back()->with('success', 'Price deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Price deleted failed');
        }
    }
}
