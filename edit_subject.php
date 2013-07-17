<?php include("includes/connection.php")?>
<?php require_once("includes/functions.php");?>
<?php 
	find_selected();
?>

<?php 
	if(intval($_GET['subj']) == 0){
		redirect_to("content.php");
	}
	if(isset($_POST["submit"])){
		
		$errors = array();
		$n = 0;
		$not_empty = array('menu_name','position','visible');
		foreach($not_empty as $not){
			if(empty($_POST[$not]) || !isset($_POST[$not])){
				$n++;
				$errors[] = $not;
			}
		}
		
		if(empty($errors)){
			//perform update
			$id = mysql_prep($_GET['subj']);
			$menu_name=mysql_prep($_POST['menu_name']);
			$position=mysql_prep($_POST['position']);
			$visible=mysql_prep($_POST['visible']);
			
			$query = "UPDATE subjects SET 
						menu_name = '{$menu_name}', 
						position = {$position},
						visible = {$visible} 
					WHERE id = {$id}";
			$result = mysql_query($query,$connection);
			if(mysql_affected_rows()==1){
				//success
				redirect_to("content.php");
			}
			else{
				//failed
				$message = "<p>". mysql_error() ."</p>";
			}
						
		}
		else{
			//error occured
			$message = "<p>there were {$n} errors</p><br>";
			$message .= "<p>they are";
			foreach($errors as $e){
				$message .= $e . " ";	
			} 
			$message .= "</p>";
		}
		

		
		
	}//end:if(isset($_POST["submit"]))
?>

<?php include("includes/header.php");?>
        		<table id="structure">
        			<tr>
        				<td id="navigation">
        					<?php echo navigation($sel_page,$sel_pg,$sel_subj,$sel_subject);?>
        				</td>
        				<td id="page">
        				<h2>Edit subjects: <?php echo $sel_subject['menu_name'];?></h2><br>
        				<?php if(isset($message)){echo $message;}
        				?>
        				<form action="edit_subject.php?subj=<?php echo urlencode($sel_subject['id']);?>" method="post">
        					<p>subject name:
        						<input type="text" name="menu_name" value=<?php echo $sel_subject['menu_name']; ?> id="menu_name" />
        					</p>
        					
        					<p>position:
        						<select name="position">
        							<?php 
        								$subject_set = get_all_subjects();
        								$subject_count = mysql_num_rows($subject_set);
        								for($count = 1;$count<= $subject_count + 1; $count++){
        									$output = "<option value=\"{$count}\" ";
        									if($sel_subject['position'] == $count){
        										 $output .= "selected";
        									}
        									$output .= ">{$count}</option>";
        									echo $output;
        								}
        							?>
        							
        						</select>
        					</p>
        					<p>Visible
        						<input type="radio" name="visible" value="0" <?php if($sel_subject['visible']==0){
        							echo "CHECKED";
        						}?>>NO
        						&nbsp;
        						<input type="radio" name="visible" value="1" <?php if($sel_subject['visible']==1){
        							echo "CHECKED";
        						}?>>Yes
        					</p>
        					<input type="submit" name="submit" value="Edit subject" />
        				</form>
        				<a href="delete_subject.php?subj=<?php echo urlencode($sel_subject['id']);?>">Delete</a>
        				
        				<br />
        				
        				<a href="content.php">Cancel</a>
        				</td>
        			</tr>
        		</table>
<?php include("includes/footer.php");?>
