<?php 
namespace App\Helpers;
use MongoDB\Client as Mongo;
use MongoDB\Driver\Manager as MongoManager;

Class MongoDB extends Mongo{
    private $mongodbConnectionURI;
    private $manager;

    public function __construct()
    {
      // dd('sdfsd');
        if ( 
            !is_null(env("MONGODB_HOST")) && !empty(env("MONGODB_HOST")) 
            && !is_null(env("MONGODB_PORT")) && !empty(env("MONGODB_PORT")) 
            && !is_null(env("MONGODB_USERNAME")) && !empty(env("MONGODB_USERNAME")) 
            && !is_null(env("MONGODB_PASSWORD")) && !empty(env("MONGODB_PASSWORD")) 
            ) 
        {
            parent::__construct("mongodb://". env("MONGODB_HOST"). ":". env("MONGODB_PORT"),
                   [
                       'username' => env("MONGODB_USERNAME"),
                       'password' => env("MONGODB_PASSWORD"),
                       'authSource' => env("MONGODB_AUTH")
                   ]
            );
        }
        else
        {
            parent::__construct();
        }
    }

}
