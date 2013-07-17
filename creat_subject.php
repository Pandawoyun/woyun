<?php include("includes/connection.php")?>
<?php require_once("includes/functions.php");?>
<?php 
	$menu_name=mysql_prep($_POST['menu_name']);
	$position=mysql_prep($_POST['position']);
	$visible=mysql_prep($_POST['visible']);
?>

<?php 
	$errors = array();
	
	if(!isset($_POST['menu_name']) || empty($_POST['menu_name'])){
		$errors[] = 'menu_name';
	}
	
	if(!empty($errors)){
		redirect_to("new_subject.php");
	}
?>

	
<?php
	$query = "INSERT INTO subjects 
				(menu_name,position,visible) VALUES
				('{$menu_name}','{$position}','{$visible}')";
	if(mysql_query($query,$connection)){
		//success
		redirect_to("content.php");
	}
	else{
		echo "<p> Subject creation failed</p>";
		echo "<p>" . mysql_error . "</p>";
	}
?>

<?php 
	mysql_close($connection);
?>
