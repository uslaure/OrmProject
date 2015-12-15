<?php

	$dbo = Database::getInstance();
	$dbo->connect('localhost', 'root', '', 'orm');
	
	// Ajouter un user dans la base de données
	
	$person = new Person();
	$data = array('name'=>'Tommy','age'=>'20','citizenship'=>'American');

	$person->bind($data);
	$person->add();

	// Select les users par l'âge et l'id
	 
    $person = new Person();
    $person->age = '20';
    // $person->id='558';
	
	$personlist = $person->loadMultiple();
	foreach ($personlist as $person)
	{	
		var_dump("{$person->name} {$person->age} {$person->citizenship} \r\n");
	}
	
	
	
	 // Pour filtrer les recherches
	 
	$dbo->select('id','name','age')->from('person')->where('age=20')->limit(2)->result();
	$personlist = $dbo->loadObjectList();
	foreach ($personlist as $person)
	{
		echo "<br><br>";
		echo " Username: {$person['name']} <br>  Age: {$person['age']} <br> Id: {$person['id']} ";
	}

	$dbo->orderby('id');

	// Remplace le USER dans la base de données par un autre
	$person = new Person();
	$person->age = '20';
	$person->load();
	$data = array('name'=>'Laure-Ashley','age'=>'21','citizenship'=>'french');
	$person->bind($data);
	$person->update();
	
	//Supprimer un user par l'id 
	$person = new Person();
	$person->id= '611';	
	$person->remove();
	