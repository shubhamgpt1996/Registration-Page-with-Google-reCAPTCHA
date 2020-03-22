<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\MongoDB;

class UserModel extends Model
{
    //
    private $mongo_inst;

    public function __construct(){
    	$this->mongo_inst = new MongoDB();
    }

    public function insertUser($data){
    	$collection = $this->mongo_inst->__get(env("MONGODB_DATABASE"))->{env("USER_COLLECTION")};

    	$res = $collection->insertOne($data);
    }

    public function checkIfUserExists($input){
    	$collection = $this->mongo_inst->__get(env("MONGODB_DATABASE"))->{env("USER_COLLECTION")};

    	$data = $collection->find([
    		'email' => $input['email']
    	])->toArray();

    	if(empty($data))
    		return false;
    	else
    		return true;

    	// dd($data);


    }

    public function checkIpCount(){
    	$source_ip = $_SERVER['REMOTE_ADDR'];
    	// dd($source_ip);
    	$today_date = date('Y-m-d 00:00:00');
    	// dd($today_date);

    	$collection = $this->mongo_inst->__get(env("MONGODB_DATABASE"))->{env("USER_COLLECTION")};

    	// dd($today_date);

    	$data = $collection->find([
    		'ip' => $source_ip,
    		'created_date' => [
    			// '$gte' => new \MongoDB\BSON\UTCDateTime(strtotime($today_date)*1000)
    			'$gte' => $today_date
    		]
    	])->toArray();

    	// dd($data);

    	return count($data);



    	// dd($data);

    }
}
