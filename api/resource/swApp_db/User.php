<?php
	require_once './db/dbswApp_dbManager.php';
	
/*
 * SCHEMA DB User
 * 
	{
		mail: {
			type: 'String', 
			required : true
		},
		name: {
			type: 'String'
		},
		password: {
			type: 'String', 
			required : true
		},
		roles: {
			type: 'String'
		},
		surname: {
			type: 'String'
		},
		username: {
			type: 'String', 
			required : true,
			unique : true, 
		},
		//RELAZIONI
		
		
		//RELAZIONI ESTERNE
		
		user_role: [{
			type: Schema.ObjectId, 
			required : true,
			ref : "User"
		}],
		
	}
 * 
 */


//CRUD METHODS


//CRUD - CREATE


$app->post('/Users',	function () use ($app){

	$body = json_decode($app->request()->getBody());
	
	$params = array (
		'mail'	=> $body->mail,
		'name'	=> isset($body->name)?$body->name:'',
		'password'	=> $body->password,
		'roles'	=> isset($body->roles)?$body->roles:'',
		'surname'	=> isset($body->surname)?$body->surname:'',
		'username'	=> $body->username,
		
	);

	$obj = makeQuery("INSERT INTO user (_id, mail, name, password, roles, surname, username )  VALUES ( null, :mail, :name, :password, :roles, :surname, :username   )", $params, false);
    
    
	// Delete not in array
	$in = " and id_Role NOT IN (:user_role)";
	$sql = "DELETE FROM User_user_role WHERE id_User=:id_User ";
		
	$params = array (
		'id_User'	=> $obj['id']
	);
	
	if (isset($body->user_role) && $body->user_role != null && sizeOf($body->user_role) > 0) {
		$sql = $sql.$in;
		$params['user_role'] = join("', '", $body->user_role);
	}
	
	makeQuery($sql, $params, false);
	
	
	// Get actual
	$sql="SELECT id_Role FROM User_user_role WHERE id_User=:id";
	$params = array (
		'id'	=> $obj['id'],
	);
    $actual = makeQuery($sql, $params, false);
	$actualArray=[];
	foreach ($actual as $val) {
		array_push($actualArray, $val->id_Role);
	}

	// Insert new
	if (isset($body->user_role)) {
    	foreach ($body->user_role as $id_Role) {
    		if (!in_array($id_Role, $actualArray)){
    			$sql = "INSERT INTO User_user_role (_id, id_User, id_Role ) VALUES (null, :id_User, :id_Role)";
    
    			$params = array (
    				'id_User'	=> $obj['id'],
    				'id_Role'	=> $id_Role
    			);
        		makeQuery($sql, $params, false);
    		}
    	}
	}
	
	
	
	echo json_encode($body);
	
});
	
//CRUD - REMOVE

$app->delete('/Users/:id',	function ($id) use ($app){
	
	$params = array (
		'id'	=> $id,
	);

	makeQuery("DELETE FROM user WHERE _id = :id LIMIT 1", $params);

});
	
//CRUD - GET ONE
	
$app->get('/Users/:id',	function ($id) use ($app){
	$params = array (
		'id'	=> $id,
	);
	
	$obj = makeQuery("SELECT * FROM user WHERE _id = :id LIMIT 1", $params, false);
	
	
	$list_user_role = makeQuery("SELECT id_Role FROM User_user_role WHERE id_User = :id", $params, false);
	$list_user_role_Array=[];
	foreach ($list_user_role as $val) {
		array_push($list_user_role_Array, $val->id_Role);
	}
	$obj->user_role = $list_user_role_Array;
	
	
	
	echo json_encode($obj);
	
});
	
	
//CRUD - GET LIST

$app->get('/Users',	function () use ($app){
	makeQuery("SELECT * FROM user");
});


//CRUD - EDIT

$app->post('/Users/:id',	function ($id) use ($app){

	$body = json_decode($app->request()->getBody());
	
	$params = array (
		'id'	=> $id,
		'mail'	    => $body->mail,
		'name'	    => isset($body->name)?$body->name:'',
		'password'	    => $body->password,
		'roles'	    => isset($body->roles)?$body->roles:'',
		'surname'	    => isset($body->surname)?$body->surname:'',
		'username'	    => $body->username
	);

	$obj = makeQuery("UPDATE user SET  mail = :mail,  name = :name,  password = :password,  roles = :roles,  surname = :surname,  username = :username   WHERE _id = :id LIMIT 1", $params, false);
    
	// Delete not in array
	$in = " and id_Role NOT IN (:user_role)";
	$sql = "DELETE FROM User_user_role WHERE id_User=:id_User ";
	
	$params = array (
		'id_User'	=> $body->_id
	);
	
	if (isset($body->user_role) && $body->user_role != null && sizeOf($body->user_role) > 0) {
		$sql = $sql.$in;
		$params['user_role'] = join("', '", $body->user_role);
	}
	
	makeQuery($sql, $params, false);
	
	
	// Get actual
	$sql="SELECT id_Role FROM User_user_role WHERE id_User=:id";
	$params = array (
		'id'	=> $body->_id,
	);
    $actual = makeQuery($sql, $params, false);
	$actualArray=[];
	foreach ($actual as $val) {
		array_push($actualArray, $val->id_Role);
	}

	// Insert new
	if (isset($body->user_role)) {
    	foreach ($body->user_role as $id_Role) {
    		if (!in_array($id_Role, $actualArray)){
    			$sql = "INSERT INTO User_user_role (_id, id_User, id_Role ) VALUES (null, :id_User, :id_Role)";
    
    			$params = array (
    				'id_User'	=> $body->_id,
    				'id_Role'	=> $id_Role
    			);
        		makeQuery($sql, $params, false);
    		}
    	}
	}
	
	
	
	echo json_encode($body);
    	
});


/*
 * CUSTOM SERVICES
 *
 *	These services will be overwritten and implemented in  Custom.js
 */


/*
 Name: changePassword
 Description: Change password of user from admin
 Params: 
 */
$app->post('/Users/:id/changePassword',	function ($key) use ($app){	
	makeQuery("SELECT 'ok' FROM DUAL");
});
	
			
?>