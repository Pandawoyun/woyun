<?php include("includes/connection.php")?>
<?php require_once("includes/functions.php");?>
<?php 
	find_selected();
?>
<?php include("includes/header.php");?>
        		<table id="structure">
        			<tr>
        				<td id="navigation">
        					<?php echo navigation($sel_page,$sel_pg,$sel_subj,$sel_subject);?>
        					<br />
        					<a href = "new_subject.php">+ ADD a new subject</a>
        				</td>
        				<td id="page">
        						<?php if(!is_null($sel_subject)) {?>
        						<h2><?php echo $sel_subject['menu_name'];?></h2>
        						<?php } elseif(!is_null($sel_pg)){?>
        						<h2><?php echo $sel_pg['menu_name'];?></h2>
        						<div>
        							<?php echo $sel_pg['content']."<br><a href=\"edit_page.php?page={$sel_pg['id']}\">edit page</a>";?>
        						</div>
        						<?php } else{ ?>
        							<h2>Select a thing to edit</h2>
        						<?php }?>
        					
        				</td>
        			</tr>
        		</table>
<?php include("includes/footer.php")?>