<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Game;
use App\Team;
use App\Round;
use App\Totalscore;
use App\Rank;

class GameController extends Controller
{

    public $games;

    public function __construct()
    {
        $this->games = Game::orderBy('created_at', 'desc')->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('admin/games')->with('games', $this->games);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teams = Team::all();
        return View('admin/game_create')->with('teams', $teams);
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
            'name' => 'required',
            'date' => 'required',
            'rounds' => 'required'
        ]);

        $game = Game::create($request->all());

        if($request->has('teams')){
            $game->teams()->attach($request->teams);    
        }

        foreach($request->teams as $team){
            for($round = 1; $round <= $request->rounds; $round++){
                $round_obj = new Round;
                $round_obj->team_id = $team;
                $round_obj->score = 0;
                $round_obj->number = $round;
                $round_obj->save();
                $game->rounds()->attach($round_obj);      
            };

            $totalscore = new Totalscore;
            $totalscore->team_id = $team;
            $totalscore->game_id = $game->id;
            $totalscore->totalscore = 0;
            //Доработка логики вывода, если у нас в общем счете есть одинаковые значения, ориентируетмся на предыдущий раунд
            $totalscore->last_round_score = 0;
            $totalscore->save();

            $totalscore->teams()->attach($team);
            $game->totalscores()->attach($totalscore);
        };
        

        return redirect()->route('game.index');
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
        $game = Game::findOrFail($id);
        $teams = Team::all();
        return View('admin/game_edit')->with('game', $game)->with('teams', $teams);
    }

    public function manageGame($id) {
        $game = Game::findOrFail($id);
        return View('admin/game_manage')->with('game', $game);
    }

    public function startGame($id) {
        $game = Game::findOrFail($id);
        $game->go_on = true;
        $game->save();
        return View('admin/game_manage')->with('game', $game);
    }

    public function showClientGame($id) {
        $game = Game::findOrFail($id);
        return View('admin/game_client')->with('game', $game);
    }

    public function addCommentGame(Request $request, $id){
        $game = Game::findOrFail($id);
        $game->comment = $request->comment;
        $game->save();
        return redirect()->route('game.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function ajaxRequestUpdateGame(Request $request)
    {
        $request_data = json_decode($request->request_data, true);
        $gameId = $request->game_id;
        $current_game = Game::findOrFail($gameId);
        
        foreach($request_data as $request) {

            $round = $current_game->rounds()->get();
            $round = $round->where('id', $request['round_id'])
            ->where('team_id', $request['team_id'])->first();

            $round->score = $request['score'];
            $round->update();    

        }

        foreach($request_data as $request) {

            $round = $current_game->rounds()->get();
            $rounds = $round->where('team_id', $request['team_id']);

            $total_score = 0;
            $arr = array();
            $r_n = 1;
            foreach($rounds as $r){
                $total_score = $total_score + $r->score; 
                $i['round_sco'] = $r->score;
                $i['round_num'] = $r->number;

                array_push($arr, $i);

                $r_n = $r_n + 1;
            }
            
            $totalscores = $current_game->totalscores()->get();
            $totalscore = $totalscores->where('team_id', $request['team_id'])->first();
            $totalscore->totalscore = $total_score;

            //Доработка логики вывода, если у нас в общем счете есть одинаковые значения, ориентируетмся на предыдущий раунд
            $last_round_score = 0;
            if($request['max_round'] > 1) {
                $last_round_score = $arr[$request['max_round']-1]['round_sco'];
            } 
           
            $totalscore->last_round_score = $last_round_score;
            
            $totalscore->update();
            // return response()->json(['success'=> $totalscore]);
            
            // ->where('id', $request['round_id'])
            // ->where('team_id', $request['team_id'])
            // ->first();

            // return response()->json(['success'=>$round]); 

            // $round->score = $request['score'];
            // $round->update();    

        }

        return response()->json(['success'=> $request_data]);  
    }

    public function ajaxRequestFinalizeGame(Request $request){
        //Team, TotalScore
        $request_data = json_decode($request->request_data, true);   
        $gameId = $request->game_id;
        $current_game = Game::findOrFail($gameId);
        $current_game->is_over = true;
        $current_game->save();
        foreach($request_data as $request){
            $team = Team::findOrFail($request['team_id']);
             
            $team_wholescore = $team->totalscores()->sum('totalscore');
            $team_wholescore = (int)$team_wholescore;

            
            
            $team->ranks()->detach();
            $ranks = Rank::orderBy('min_score', 'desc')->get();
            
            foreach($ranks as $rank){
                // return response()->json(['success'=> $team_wholescore >= $rank->min_score]);
                if($team_wholescore >= $rank->min_score){
                    $team->ranks()->attach($rank);
                    break;    
                }
            }

            // return response()->json(['success'=> $ranks]);
            return response()->json(['success'=> 'Игра завершена, ранги команд обновлены']);

            // $rank = Rank::where('min_score','<=',$team_wholescore)->orderBy('asc')->first();
            // $team->attach($rank);
        }

        return response()->json(['success'=> $request_data]);  
    }
     
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $game = Game::findOrFail($id);
        $game->update($input);

        $game->teams()->detach();

        if($request->has('teams')){
            $game->teams()->attach($request->teams);    
        }

        return redirect()->route('game.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        $game->teams()->detach();
        $game->rounds()->detach();
        $game->totalscores()->detach();
        $game->delete();
        return redirect()->route('game.index');
    }
}
