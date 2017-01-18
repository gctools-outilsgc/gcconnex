<?php
$db_prefix = elgg_get_config('dbprefix');
function requirements_check2()
{
	global $CONFIG;

	$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
	if (mysqli_connect_errno($connection)) elgg_log("cyu - Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
    
    $query = "SELECT * FROM contact_list";
	$result = mysqli_query($connection,$query);
    
    if(empty($result)){

        $query = "CREATE TABLE IF NOT EXISTS contact_list (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id), english char(255), francais char(255))";
        
    $result = mysqli_query($connection,$query);
      //baseText_check2(); stop populate the database
    
    }
      
	mysqli_close($connection);

	return true;
}

function baseText_check2()
{
	global $CONFIG;

	$query = "INSERT IGNORE INTO contact_list (english, francais) VALUES ('Log in credentials','Information de connexions'), (' Bugs/errors ','Bogues/Erreurs'), (' Group-related', 'Relatif aux groupes'), ('Training', 'Formation'), (' Jobs Marketplace','Carrefour d\’emploi'),(' Enhancement','Amélioration'),('Flag content or behaviour','Signaler un contenu ou comportement'),('Other','Autres')";

	$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
	if (mysqli_connect_errno($connection)) elgg_log("cyu - Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
	$result = mysqli_query($connection,$query);
	mysqli_close($connection);
	return $result;
}

function getExtension2() 
{
	global $CONFIG;

	$query = "SELECT * FROM contact_list";

	$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
	if (mysqli_connect_errno($connection)) elgg_log("cyu - Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
	$result = mysqli_query($connection,$query);
	mysqli_close($connection);
	return $result;
}

function addExtension2($english, $french)
{
	global $CONFIG;
    
    $eng = mysql_real_escape_string($english);
    $fr = mysql_real_escape_string($french);

	$query = "INSERT INTO contact_list (english, francais) VALUES ('".$eng."','".$fr."')";

	$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
	if (mysqli_connect_errno($connection)) elgg_log("cyu - Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
	$result = mysqli_query($connection,$query);
	mysqli_close($connection);
	return $result;
}

function deleteExtension2($id)
{
	global $CONFIG;

	$query = "DELETE FROM contact_list WHERE id=".$id;

	$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
	if (mysqli_connect_errno($connection)) elgg_log("cyu - Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
	$result = mysqli_query($connection,$query);
	mysqli_close($connection);
	return $result;
}