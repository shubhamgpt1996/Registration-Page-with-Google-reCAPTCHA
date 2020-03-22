<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\MongoDB;
use App\Helpers\ValidationConstants;
use App\UserModel;


class UserController extends Controller
{
	// private $mongo_inst;
	private $user_model;
    //
    public function __construct(){
    	// $this->mongo_inst = new MongoDB();
    	$this->user_model = new UserModel();

    }

    public function registerUser(Request $request){
    	$inputRequest = $request->all();
    	// dd($inputRequest);

    	// dd($_SERVER['REMOTE_ADDR']);

    	// $collection = $this->mongo_inst->__get(env("MONGODB_DATABASE"))->{env("USER_COLLECTION")};

    	$data['name'] = $inputRequest['name'];
    	$data['email'] = $inputRequest['email'];
    	$data['password'] = $inputRequest['password'];
    	$data['ip'] = $_SERVER['REMOTE_ADDR'];
    	// $data['created_date'] = new \MongoDB\BSON\UTCDateTime(strtotime(date('Y-m-d H:i:s'))*1000);
    	$data['created_date'] = date('Y-m-d H:i:s');
    	// dd($data);
    	// dd($collection);
    	// unset($inputRequest['_token']);
    	$this->user_model->insertUser($data);
    	// $res = $collection->insertOne($data);

    	return view('welcome', ['name' => $data['name']]);
    	// dd($res);
    	// echo "Done";
    }

    private function captchaVerification(){
    	// dd($_POST);
    	$success = false;
    	$msg = '';

    	if(empty($_POST['g-recaptcha-response']))
		 {
		  $msg = 'Captcha is required';
		 }
		 else
		 {
		  // $secret_key = '6Ldv2bcUAAAAAFXUKdLW_qljFd9FpxNguf06DHhp';
		  $secret_key = '6LcR9-IUAAAAAEfWWAxpMTg4o14WaDdFWnC3nsCB';
		  // $secret_key = env("RECAPTCHA_SECRET_KEY");

		  $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);

		  $response_data = json_decode($response);

		  // dd($response_data);

		  if(!$response_data->success)
		  {
		   $msg = 'Captcha verification failed';
		  }
		  else
		  	$success = true;
		 }

		 return ['success' => $success, 'msg' => $msg];
    }

    public function validateUser(){
    	$input = $_POST;

    	$success = false;
    	$count = 0;
    	// dd($input);

    	$validator = Validator::make($input, ValidationConstants::USER_VALIDATION);

	    if($validator->fails()){

	    	$msg = json_encode($validator->errors());
	    	// dd($msg);
	      // return Redirect::back()->withErrors($validator->errors())->withInput();
	    }
	    elseif($this->user_model->checkIfUserExists($input)){

	    	// $this->checkIfUserExists();

	    	$success = false;
	    	$msg = 'User Already Exists!';
	    }
	    elseif(!empty($input['ip_count'])){
	    	$res = $this->captchaVerification();

	    	$success = $res['success'];
	    	$msg = $res['msg'];
	    }
	    else{

	    	$count = $this->user_model->checkIpCount();

	    	$success = true;
	    	$msg = 'User Validated!';

	    	// if($count > 3)

	    	// dd($count);

	    	// $this->checkIfUserExists();

	    	// $success = false;
	    	// $msg = 'User Already Exists';
	    }

	    return ['success' => $success, 'msg' => $msg, 'count' => $count];

    	// dd($validator->fails());
    }

    // private function checkIfUserExists($input){
    // 	$collection = $this->mongo_inst->__get(env("MONGODB_DATABASE"))->{env("USER_COLLECTION")};

    // 	$data = $collection->find([
    // 		'email' => $input['email']
    // 	])->toArray();

    // 	if(empty($data))
    // 		return false;
    // 	else
    // 		return true;

    // 	// dd($data);


    // }

    // private function checkIpCount(){
    // 	$source_ip = $_SERVER['REMOTE_ADDR'];
    // 	$today_date = date('Y-m-d 00:00:00');

    // 	$collection = $this->mongo_inst->__get(env("MONGODB_DATABASE"))->{env("USER_COLLECTION")};

    // 	// dd($today_date);

    // 	$data = $collection->find([
    // 		'ip' => $source_ip,
    // 		'created_date' => [
    // 			'$gte' => new \MongoDB\BSON\UTCDateTime(strtotime($today_date)*1000)
    // 		]
    // 	])->toArray();

    // 	return count($data);



    // 	// dd($data);

    // }
}
