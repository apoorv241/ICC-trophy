<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Input;
use App\Models\Team;
use App\Models\Fixture;
use Redirect;

class ICCcontroller extends BaseController
{
    
    public function getIndex(){
       $inputs=Input::all();
       $teams=\DB::table('teams')->orderBy('strength','DESC')->get();
        $fixtures=Fixture::orderBy('round')->with(['home','opponent','winner'])->where('round','!=',0)->get();
       $groups=[];
       if(!empty($teams) && count($teams)>0){
          foreach($teams as $key=>$team){
              $groups[$team->group][]=$team;
          }
        }
       return view('index',compact('groups','fixtures')); 
        
    }
    
    public function Play(){
        $inputs=Input::all();
        $teams_by_group=[];
        $teams=Team::all();
        foreach($teams as $team){
            $teams_by_group[$team['group']][]=$team['id'];
        }
        foreach($teams_by_group as $key => $val){
            self::fixturesandResults($key,$val);
        }
       return Redirect::to('/'); 
    }
    
    public static function fixturesandResults($group,$teams){
            $recent_round=Fixture::where('group',$group)->pluck('round');
            if(!empty($recent_round)){
               $recent_round=$recent_round->toArray(); 
            }
            $already_run=[];
            $recent_round=max($recent_round);
            foreach($teams as $t_id){
            $fixture_ids=Fixture::where('group',$group)->whereNotIn('opponent_id',$already_run)->whereNotIn('home_id',$already_run)->where('home_id',$t_id)->orwhere('opponent_id',$t_id)->where('winner_id','=',0)->where('round','=',0)->pluck('id');
            if(!empty($fixture_ids)){
            $fixture_ids=$fixture_ids->toArray();
            $k=array_rand($fixture_ids);
            $e=array_get($fixture_ids,$k,0);
            if(!empty($e)){
            $fixture=Fixture::with(['home','opponent'])->where('id',$e)->first();
            $ways_to_win=['runs','wickets'];
            $match_won_by=$ways_to_win[array_rand($ways_to_win)];
            $margin= rand(1, 200);
            if(($fixture['home']['strength']-$fixture['opponent']['strength']) > $margin){
                $fixture->winner_id=$fixture['home']['id'];
                $winner=Team::find($fixture['home']['id']);
                $loser=Team::find($fixture['opponent']['id']);
            }else{
                $fixture->winner_id=$fixture['opponent']['id'];
                $loser=Team::find($fixture['home']['id']);
                $winner=Team::find($fixture['opponent']['id']);
            }
            $winner->points=$winner->points+3;
            $winner->W=$winner->W+1;
            $loser->L=$winner->L+1;
            $winner->save();
            $loser->save();
            if($match_won_by == "wickets"){
                $fixture->loss_margin_wickets=rand(1,10);
            }else{
             
               $fixture->loss_margin_score=rand(20,310); 
            }
            $fixture->round=$recent_round+1;
            $fixture->save();
            $already_run[]=$fixture['home']['id'];
            $already_run[]=$fixture['opponent']['id'];
           }
         }
            
        }

        
    }
    
}