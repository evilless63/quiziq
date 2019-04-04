<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Rank;
use Illuminate\Support\Facades\Storage;

class RankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $ranks;

    public function __construct()
    {
        $this->ranks = Rank::all();
    }

    public function index()
    {
        return View('admin/ranks')->with('ranks', $this->ranks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin/rank_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'image_path' => 'required',
            'image_path.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'min_score' => 'required'
        ]);

        if($request->hasFile('image_path')) {

            $path = $request->file('image_path')->store('uploads', 'public');
            // $destinationPath = 'rank_images';
            // $imageName = time().'.'.request()->image_path->getClientOriginalExtension();
            // Storage::disk('local')->put($imageName, $destinationPath);
            // $filePath = Storage::url($imageName);
        }

        $rank = new Rank;
        $rank->name = $request->name;
        $rank->min_score = $request->min_score;
        $rank->image_path = $path;

        $rank->save();

        return View('admin/ranks', [
            'ranks' => $this->ranks
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rank = Rank::findOrFail($id);
        return View('admin/rank_edit')->with('rank', $rank);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        $this->validate($request, [
//            'image_path' => 'required',
//            'image_path.w*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            'name' => 'required',
//            'min_score' => 'required'
//        ]);

        $rank = Rank::findOrFail($id);

        if($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('uploads', 'public');
            $rank->image_path = $path;
        }

        $rank->name = $request->name;
        $rank->min_score = $request->min_score;

        $rank->update();
        return View('admin/ranks', [
            'ranks' => $this->ranks
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rank = Rank::findOrFail($id)->delete();
        return redirect()->route('rank.index');
    }
}
