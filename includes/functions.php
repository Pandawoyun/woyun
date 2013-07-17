<?php  
	function mysql_prep($value){
		$magic = get_magic_quotes_gpc();
		$new = function_exists("mysql_real_escape_string");
		if($new){
			if($magic){
				$value = stripslashes($value);
			}
			$value = mysql_real_escape_string($value);
		}
		else{
			if($magic){
				$value = addslashes($value);
			}
		}
		return $value;
	}
	
	function redirect_to($L){
		header("Location:".$L);
		exit;
	}
	
	function confirm_query($result_set){
		if(!$result_set){
			die("Database query failed:".mysql_error());
		}
	}
	
	function get_subject_by_id($subject_id){
			global $connection;
			$query = "SELECT * ";
   			$query .= "FROM subjects ";
   			$query .= "WHERE id=".$subject_id;
   			$result_set = mysql_query($query,$connection); 
   			confirm_query($result_set);
   			// if no row is in there the fetch array will return false!;
   			if($subject = mysql_fetch_array($result_set)){
   				return $subject;
   			}
   			else{
   				return NULL;
   			}
   			
   			
	}
	
	function get_page_by_id($page_id){
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE id=".$page_id;
		$result_set = mysql_query($query,$connection);
		confirm_query($result_set);
		// if no row is in there the fetch array will return false!;
		if($page = mysql_fetch_array($result_set)){
			return $page;
		}
		else{
			return NULL;
		}
	
	
	}
	
	function find_selected(){
		global $sel_subj;
		global $sel_page;
		global $sel_pg;
		global $sel_subject;
		
		if(isset($_GET['subj'])){
			$sel_subj=$_GET['subj'];
			$sel_subject= get_subject_by_id($_GET['subj']);
			$sel_pg = NULL;
			$sel_page = NULL;
		}
		elseif(isset($_GET['page'])){
			$sel_page = $_GET['page'];
			$sel_pg= get_page_by_id($_GET['page']);
			$sel_subject = NULL;
			$sel_subj = NULL;
		
		}
		else{
			$sel_subj = NULL;
			$sel_subject = NULL;
			$sel_pg = NULL;
			$sel_page = NULL;
		}
	}
	
	function navigation($sel_subject,$sel_subj,$sel_pg,$sel_page){
		$output = "<ul class=\"subjects\">";
		$query = "SELECT *
										 FROM subjects
										ORDER BY position ASC";
		$subject_set = mysql_query($query);
		if(!$subject_set){
			die("WTF with the subjects".mysql_error());
		}
		while($subject=mysql_fetch_array($subject_set)){
			$output .= "<li";
			 
			if($sel_subj == $subject["id"]){
				$output .= " class=\"selected\"";
			}
			$output .= "><a href=\"edit_subject.php?subj=". urlencode($subject["id"])."\">{$subject["menu_name"]}</a></li>";
			$page_set = mysql_query("SELECT * FROM pages WHERE subject_id = {$subject["id"]} ORDER BY position ASC");
			if(!$page_set){
				die("WTF with the pages".mysql_error());
			}
			$output .= "<ul class= \"pages\">";
			while($page=mysql_fetch_array($page_set)){
				$output .= "<li";
				if($page['id']==$sel_page){
					$output .= " class=\"selected\">";
				}
				else{
					$output .= ">";
				}
				$output .= "<a href=\"content.php?page=". urlencode($page["id"])."\">{$page["menu_name"]}</a></li>";
			}
			$output .= "</ul>";
		
		}
		$output .= "</ul>";
		
		return $output;
	}
	
	function get_all_subjects(){
		global $connection;
		$query = "SELECT *
				 FROM subjects
				ORDER BY position ASC";
		$subject_set = mysql_query($query,$connection);
		return $subject_set;
	}
	?>
