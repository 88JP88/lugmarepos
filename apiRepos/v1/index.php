<?php

require 'flight/Flight.php';

require 'database/db_users.php';

Flight::route('POST /post', function () {
    header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    $conectar=conn();
    //$uri = $_SERVER['REQUEST_URI'];


    $user=(Flight::request()->data->user);
    $pass=(Flight::request()->data->pass);
    $tittle=(Flight::request()->data->tittle);
    $keywords=(Flight::request()->data->keywords);
    $type=(Flight::request()->data->type);
    $public=(Flight::request()->data->public);
    $value=(Flight::request()->data->value);

    require('../../apiRepos/v1/model/modelSecurity/uuid/uuidd.php');
    $con=new generateUuid();
        $myuuid = $con->guidv4();
        $primeros_ocho = substr($myuuid, 0, 8);
    $query= mysqli_query($conectar,"SELECT repo_id FROM repo_one where repo_id='$primeros_ocho'");
    $nr=mysqli_num_rows($query);

    if($nr>=1){
        $info=[

            'data' => "ups! el id del repo está repetido , intenta nuevamente, gracias."
            
        ];
     echo json_encode(['info'=>$info]);
     //echo "ups! el id del repo está repetido , intenta nuevamente, gracias.";
    }else{

      
$keyword=$keywords." ".$user." ".$tittle." ".$type." ".$value." ";
   
    $query= mysqli_query($conectar,"INSERT INTO repo_one (repo_id,tittle,value,keywords,type,user_id,public) VALUES ('$primeros_ocho','$tittle','$value','$keyword','$type','$user','$public')");
       
    
   
    //echo $uri; // muestra "/mi-pagina.php?id=123"
        echo "false";
    }
});



Flight::route('POST /postLoged', function () {
    
    header('Access-Control-Allow-Origin: *');

    $conectar=conn();
   // $uri = $_SERVER['REQUEST_URI'];

    $username=(Flight::request()->data->username);
    $tittle=(Flight::request()->data->tittle);
    $keywords=(Flight::request()->data->keywords);
    $type=(Flight::request()->data->type);
    $public=(Flight::request()->data->public);
    $value=(Flight::request()->data->value);

    require('../../apiRepos/v1/model/modelSecurity/uuid/uuidd.php');
    $con=new generateUuid();
        $myuuid = $con->guidv4();
        $primeros_ocho = substr($myuuid, 0, 8);
    $query= mysqli_query($conectar,"SELECT repo_id FROM repo_one where repo_id='$primeros_ocho'");
    $nr=mysqli_num_rows($query);

    if($nr>=1){
        $info=[

            'data' => "ups! el id del repo está repetido , intenta nuevamente, gracias."
            
        ];
     echo json_encode(['info'=>$info]);
     //echo "ups! el id del repo está repetido , intenta nuevamente, gracias.";
    }else{

      

   $keyword=$keywords." ".$username." ".$tittle." ".$type." ".$value;
    $query= mysqli_query($conectar,"INSERT INTO repo_one (repo_id,tittle,value,keywords,type,user_id,public) VALUES ('$primeros_ocho','$tittle','$value','$keyword','$type','$username','$public')");
       
    
   // echo "nn";
   echo "true"; // muestra "/mi-pagina.php?id=123"

    }
});


Flight::route('POST /putLoged', function () {
    
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('content-type: application/json; charset=utf-8');

    $conectar=conn();
    $uri = $_SERVER['REQUEST_URI'];

    $username=(Flight::request()->data->username);
    $tittle=(Flight::request()->data->tittle);
    $keywords=(Flight::request()->data->keywords);
    $type=(Flight::request()->data->type);
    $public=(Flight::request()->data->public);
    $value=(Flight::request()->data->value);
    $repo=(Flight::request()->data->repo);

    
    
     //echo "ups! el id del repo está repetido , intenta nuevamente, gracias.";
   

   
    $query= mysqli_query($conectar,"UPDATE repo_one SET tittle='$tittle',value='$value',keywords='$keywords',type='$type',public='$public' WHERE user_id='$username' and repo_id='$repo'");
       
    
    
    echo "true"; // muestra "/mi-pagina.php?id=123"

    
});

Flight::route('POST /delLoged', function () {
    
    header('Access-Control-Allow-Origin: *');

    $conectar=conn();
    $uri = $_SERVER['REQUEST_URI'];

    $username=(Flight::request()->data->username);
    $repo=(Flight::request()->data->repo);

    
    
     //echo "ups! el id del repo está repetido , intenta nuevamente, gracias.";
   

   
    $query= mysqli_query($conectar,"DELETE FROM repo_one WHERE user_id='$username' and repo_id='$repo'");
       
    
    
    echo "true"; // muestra "/mi-pagina.php?id=123"

    
});
Flight::route('GET /get/@id', function ($id) {
    
    header("Access-Control-Allow-Origin: *");
    $conectar=conn();
    $uri = $_SERVER['REQUEST_URI'];


    $query= mysqli_query($conectar,"SELECT r.id,r.repo_id,r.tittle,r.value,r.user_id,r.type FROM repo_one r where r.keywords LIKE '%$id%' LIMIT 1000");
       

        $repos=[];
 
        while($row = $query->fetch_assoc())
        {
                $repo=[
                    'id' => $row['id'],
                    'repository' => $row['repo_id'],
                    'tittle' => $row['tittle'],
                    'info' => $row['value'],
                    'user' => $row['user_id'],
                    'type' => $row['type']
                ];
                
                array_push($repos,$repo);
                
        }
        $row=$query->fetch_assoc();
        //echo $repos;
        echo json_encode(['repos'=>$repos]);
       
  
  // echo $uri; // muestra "/mi-pagina.php?id=123"

       
   

});

Flight::start();
