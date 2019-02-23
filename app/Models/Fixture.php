<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AlgoCalculationGroup
 *
 * @author R2
 */
class Fixture extends Model {
    
    protected $connection = 'mysql';
    
    protected $table = 'fixtures';
    
    public function home(){
        return $this->hasOne('App\Models\Team','id','home_id');
    }
    public function opponent(){
        return $this->hasOne('App\Models\Team','id','opponent_id');
    }
     public function Winner(){
        return $this->hasOne('App\Models\Team','id','winner_id');
    }
}
