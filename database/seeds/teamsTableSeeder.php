<?php

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Fixture;

class teamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        \DB::table('teams')->truncate();
        \DB::table('fixtures')->truncate();
        $number_of_teams=\Config::get('env.team_number');
        $group_teams=[];
        if(empty($number_of_teams)){
            print_r('Please specify number of teams');return;
        }
        for($i=1;$i<=$number_of_teams;$i++){
          if($i%2 != 0){
             $group="A"; 
          }else{
              $group="B";
          } 
          \DB::table('teams')->insert(['N'=>0,'L'=>0,'W'=>0,'points'=>0,'name'=>"Team ".$i,'strength'=>$i*10,'seed'=>$i,'group'=>$group]);  
        }
        $teams_by_group=[];
        $teams=Team::all();
        foreach($teams as $team){
            $teams_by_group[$team['group']][]=$team['id'];
        }
        foreach($teams_by_group as $k => $v){
           for($i=0;$i<count($v);$i++){
               $home_id=$v[$i];
               for($j=$i;$j<count($v);$j++){
                   if($v[$i] != $v[$j]){
                   $fixture=new Fixture();
                   $fixture->home_id=$v[$i];
                   $fixture->round=0;
                   $fixture->group=$k;
                   $fixture->type="round_robin";
                   $fixture->opponent_id=$v[$j];
                   $fixture->save();
                  }
                   
               }
                       
           }
        }
        
    }
}
