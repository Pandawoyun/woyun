<?php include("includes/connection.php")?>
<?php require_once("includes/functions.php");?>


<?php 
	if(intval($_GET['subj']) == 0){
		redirect_to("content.php?notvalids");
	}
	
	$id = mysql_prep($_GET['subj']);
	if($subject = get_subject_by_id($id)){
		$query = "DELETE FROM subjects WHERE id={$id} LIMIT 1";
	
		$result = mysql_query($query,$connection);
		
		if(mysql_affected_rows()==1){
			redirect_to("content.php?should");
		}
		
		else{
			echo "there is a error related to database: " . mysql_error();
		}
	}
	else{
		redirect_to("content.php?notexist");
	}
	
?>

<?php include("includes/footer.php");?>
