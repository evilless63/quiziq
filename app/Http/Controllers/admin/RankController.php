<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Rank;

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
            $destinationPath = 'rank_images/';
            $imageName = time().'.'.request()->image_path->getClientOriginalExtension();
            request()->image_path->move($destinationPath, $imageName);
            $filePath = $destinationPath.$imageName;
        }

        $rank = new Rank;
        $rank->name = $request->name;
        $rank->min_score = $request->min_score;
        $rank->image_path = $filePath;

        $rank->save();

        return redirect()->route('rank.index');
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
//            'image_path.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            'name' => 'required',
//            'min_score' => 'required'
//        ]);

        $rank = Team::findOrFail($id);

        if($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $destinationPath = '/rank_images/';
            $file->move(public_path().$destinationPath,$file->getClientOriginalName());
            $filePath = public_path().$destinationPath.$file->getClientOriginalName();
        }

        $rank->name = $request->name;
        $rank->min_score = $request->min_score;
        $rank->image_path = $filePath;

        $rank->update();
        return redirect()->route('rank.index');
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
