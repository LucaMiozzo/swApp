<?php
	require_once './db/dbswApp_dbManager.php';
	
/*
 * SCHEMA DB Role
 * 
	{
		description: {
			type: 'String'
		},
		name: {
			type: 'String', 
			required : true
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

	
//CRUD - REMOVE

$app->delete('/roles/:id',	function ($id) use ($app){
	
	$params = array (
		'id'	=> $id,
	);

	makeQuery("DELETE FROM role WHERE _id = :id LIMIT 1", $params);

});
	
//CRUD - GET ONE
	
$app->get('/roles/:id',	function ($id) use ($app){
	$params = array (
		'id'	=> $id,
	);
	
	$obj = makeQuery("SELECT * FROM role WHERE _id = :id LIMIT 1", $params, false);
	
	
	
	echo json_encode($obj);
	
});
	
	
//CRUD - GET LIST

$app->get('/roles',	function () use ($app){
	makeQuery("SELECT * FROM role");
});


//CRUD - EDIT

$app->post('/roles/:id',	function ($id) use ($app){

	$body = json_decode($app->request()->getBody());
	
	$params = array (
		'id'	=> $id,
		'description'	    => isset($body->description)?$body->description:'',
		'name'	    => $body->name
	);

	$obj = makeQuery("UPDATE role SET  description = :description,  name = :name   WHERE _id = :id LIMIT 1", $params, false);
    
	
	echo json_encode($body);
    	
});


/*
 * CUSTOM SERVICES
 *
 *	These services will be overwritten and implemented in  Custom.js
 */

			
?>