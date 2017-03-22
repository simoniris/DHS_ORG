<?php
require_once("/home/dhsorg/public_html/custom/connections/database.php");
require_once("./custom_config.php");
require_once("./base_functions.php");
$prefix=$SESSION["PREFIX"];

 ini_set('display_errors', '1');
    ini_set('error_reporting', E_ALL);

if(isset($_GET['jform_profile_agency']))
{
	echo $category = $_GET['jform_profile_agency'];
	echo $query = mysql_query("SELECT id,division_name from tbl_division WHERE agency_id=(select id from tbl_agency where id='".$category."'  
							and deleted='0' ) and deleted='0'  order by division_name asc ");
	echo "<option value=''>-----Select Division-----</option>";
	while($row = mysql_fetch_array($query)) 
	{
		echo "<option value='$row[id]'>$row[division_name]</option>";
	}
}

if(isset($_GET['jform_agency']))
{
	
	$category = $_GET['jform_agency'];
	echo "<option value=''>-----Select Division-----</option>";
	if(!empty($category))
	{
		$query = mysql_query("SELECT id,division_name from tbl_division WHERE agency_id='".$category."'  and deleted='0'");
		
		while($row = mysql_fetch_array($query)) 
		{
			echo "<option value='$row[id]'>$row[division_name]</option>";
		}
	}
}


if(isset($_GET['jform_profile_division']))
{
	
	//echo $category = $_GET['jform_profile_division']; April 27 Check comments
	 $category = $_GET['jform_profile_division'];
	 echo "<option value=''>--Select Section--</option>";
	if(!empty($category))
	{ 
	    $query = mysql_query("SELECT id,section_name from tbl_section WHERE division_id='".$category."'  and deleted='0' order by section_name asc")or die(mysql_error());
	
		while($row = mysql_fetch_array($query)) 
		{
			echo "<option value='$row[id]'>$row[section_name]</option>";
		}
	
	}
}
if(isset($_GET['jform_profile_agency1']))
{
	$category = $_GET['jform_profile_agency1'];
	$query = mysql_query("SELECT id,division_name from tbl_division WHERE agency_id=(select id from tbl_agency where agency_name='".$category."'  and deleted='0' )  and deleted='0'");
	echo "<option value=''>-----Select Division-----</option>";
	while($row = mysql_fetch_array($query)) 
	{
		echo "<option value='$row[id]'>$row[division_name]</option>";
	}
}
if(isset($_GET['jform_profile_division1']))
{
	 //echo $category = $_GET['jform_profile_division1']; April 27 Check comments
	 $category = $_GET['jform_profile_division1'];
	 //echo $category=htmlspecialchars($category);	
	 
	 	//echo  $roll="SELECT id from tbl_division WHERE division_name like '%".$category."%'  and deleted='0' ";
	  $query = mysql_query("SELECT id from tbl_division WHERE division_name like '%".$category."%'  and deleted='0' ");
	 while($row = mysql_fetch_array($query))
	 {
	 	 $division_id=$row['id'];
	 }
	
	   $roll="SELECT id,section_name from tbl_section WHERE division_id='".$category."'  and deleted='0' ";
	$query = mysql_query("SELECT id,section_name from tbl_section WHERE division_id='".$category."'  and deleted='0' ");
	echo "<option value=''>--Select Section--</option>";
	while($row = mysql_fetch_array($query)) 
	{
		echo "<option value='$row[section_name]'>$row[section_name]</option>";
	}
}

if(isset($_GET['jform_profile_division2']))
{
	 //echo $category = $_GET['jform_profile_division1']; April 27 Check comments
	 $category = $_GET['jform_profile_division2'];
	 //echo $category=htmlspecialchars($category);	
	 
	 	//echo  $roll="SELECT id from tbl_division WHERE division_name like '%".$category."%'  and deleted='0' ";
	  $query = mysql_query("SELECT id from tbl_division WHERE division_name like '%".$category."%'  and deleted='0' ");
	 while($row = mysql_fetch_array($query))
	 {
	 	 $division_id=$row['id'];
	 }
	
	   $roll="SELECT id,section_name from tbl_section WHERE division_id='".$category."'  and deleted='0' ";
	 $query = mysql_query("SELECT id,section_name from tbl_section WHERE division_id='".$category."'  and deleted='0' ");
	echo "<option value=''>--Select Section--</option>";
	while($row = mysql_fetch_array($query)) 
	{
		echo "<option value='$row[id]'>$row[section_name]</option>";
	}
}

if(isset($_GET['jform_profile_section1']))
{
	$category = $_GET['jform_profile_section1'];
	$query = mysql_query("SELECT id from tbl_section WHERE section_name='".$category."'  and deleted='0' ");
	 while($row = mysql_fetch_array($query))
	 {
	 	$section_id=$row['id'];
	 }
	$query = mysql_query("SELECT id,unit_name from tbl_unit WHERE section_id='".$section_id."' and deleted='0' ");
	echo "<option value=''>--Select Unit--</option>";
	while($row = mysql_fetch_array($query)) 
	{
		echo "<option value='$row[unit_name]'>$row[unit_name]</option>";
	}
}
if(isset($_GET['jform_profile_section']))
{
	//echo $category = $_GET['jform_profile_section']; April 27 Check comments
	$category = $_GET['jform_profile_section'];
	echo "<option value=''>--Select Unit--</option>";
	if(!empty($category))
	{
		$query = mysql_query("SELECT id,unit_name from tbl_unit WHERE section_id='".$category."' and deleted='0' order by unit_name asc ");		
		while($row = mysql_fetch_array($query)) 
		{
			echo "<option value='$row[id]'>$row[unit_name]</option>";
		}
	}	
}

if(isset($_GET['jform_profile_unit']))
{
	$category = $_GET['jform_profile_unit'];
	 $agency=$_GET['aid'];
	 $agency='"'.$agency.'"';
	$query1 ="SELECT concat('\"',unit_name,'\"') from tbl_unit WHERE id='".$category."' and deleted='0' ";
	$rs=mysql_query($query1);
	while($row = mysql_fetch_array($rs)) 
	{
		$unit_name=$row['0'];
	}
	
	/*echo $sup_id_query="select lu.user_id from ".$prefix."lms_users lu,".$prefix."user_profiles up where lu.lms_usertype_id='12' and 
					up.profile_value like '%".$unit_name."%' and up.profile_key='profile.unit'
						and up.user_id=lu.user_id";*/
		
	 $sup_id_query="select lu.user_id from ".$prefix."lms_users lu,".$prefix."user_profiles up where lu.lms_usertype_id in('12','13','14','15','16') and 
					up.profile_value = '".$agency."' and up.profile_key='profile.agency'
						and up.user_id=lu.user_id";					
	$rs=mysql_query($sup_id_query)or die(mysql_error());
	$sup_ids_temp="";
	while($row=mysql_fetch_array($rs))
	{
		$sup_ids_temp=$sup_ids_temp.$row['user_id'].",";
	}
	$sup_ids=trim($sup_ids_temp,",");
	
	$query = mysql_query("select id,concat(name,' ',middle_name,' ',last_name)as name from ".$prefix."users where block='0' and id in (".$sup_ids.") order by last_name asc");
	echo "<option value='0'>--Select Supervisor--</option>";
	while($row = mysql_fetch_array($query)) 
	{
		echo "<option value='$row[id]'>$row[name]</option>";
	}
}
if(isset($_GET['new_agency']))
{
	$category = $_GET['new_agency'];
	//$query = mysql_query("SELECT lms_admin from tbl_agency WHERE id='".$category."' ");
	$query = mysql_query("SELECT lms_admin from tbl_agency WHERE agency_name='".$category."' ");
	while($row = mysql_fetch_array($query)) 
	{
		echo "<option value='$row[lms_admin]'>$row[lms_admin]</option>";
	}
}
if(!empty($_GET['jform_profile_jobtitle']))
{
	$category = $_GET['jform_profile_jobtitle'];
	$array=explode(" ",$category);
	$div=$array[0];
	$title=$array[1];
	$query = mysql_query("SELECT code from tbl_institution WHERE job_title='".$title."' and division='".$div."' ");
	while($row = mysql_fetch_array($query)) 
	{
		echo "$row[code]";
	}
}
if(isset($_GET['execparentbyagency']) || isset($_SESSION['srmgrselagency']))
{
	if(isset($_SESSION['srmgrselagency']))
	{
		$agency = $_SESSION['srmgrselagency'];	
	}
	else
	$agency = $_GET['execparentbyagency'];
	
	$ep_id_query="select lu.user_id from ".$prefix."lms_users lu,".$prefix."user_profiles up where lu.lms_usertype_id in ('15','16') and 
					up.profile_value like '%".$agency."%' and up.profile_key='profile.agency'
						and up.user_id=lu.user_id";
	$rs=mysql_query($ep_id_query);
	$sup_ids_temp="";
	while($row=mysql_fetch_array($rs))
	{
		$sup_ids_temp=$sup_ids_temp.$row['user_id'].",";
	}
	$sup_ids=trim($sup_ids_temp,",");
	
	$query = mysql_query("select id,concat(name,' ',middle_name,' ',last_name)as name from ".$prefix."users where id in (".$sup_ids.") order by last_name asc");
	echo "<option value='0'>--Select Supervisor--</option>";
	while($row = mysql_fetch_array($query)) 
	{
		echo "<option value='$row[id]'>$row[name]</option>";
	}
}
if(isset($_GET['srmgrbydivision']))
{
	$division = getDivisionName($_GET['srmgrbydivision']);
	 $agency = $_GET['aid'];
	/* $ep_id_query="select lu.user_id from ".$prefix."lms_users lu,".$prefix."user_profiles up where lu.lms_usertype_id in ('14','15') and 
					up.profile_value like '%".$division."%' and up.profile_key='profile.division'
						and up.user_id=lu.user_id ";*/
	 $ep_id_query="select lu.user_id from ".$prefix."lms_users lu,".$prefix."user_profiles up where lu.lms_usertype_id in ('14','15','16') 
	 			   and up.profile_value like '%".$agency."%' and up.profile_key='profile.agency' and up.user_id=lu.user_id";					
						
	$rs=mysql_query($ep_id_query)or die(mysql_error());
	$sup_ids_temp="";
	while($row=mysql_fetch_array($rs))
	{
		$sup_ids_temp=$sup_ids_temp.$row['user_id'].",";
	}
	$sup_ids=trim($sup_ids_temp,",");
	
	$query = mysql_query("select id,concat(name,' ',middle_name,' ',last_name)as name from ".$prefix."users where id in (".$sup_ids.") order by last_name asc");
	echo "<option value='0'>--Select Supervisor--</option>";
	while($row = mysql_fetch_array($query)) 
	{
		echo "<option value='$row[id]'>$row[name]</option>";
	}
}
if(isset($_GET['mgrbysection']))
{
	$section = getSectionName($_GET['mgrbysection']);
	 $agency = $_GET['aid'];
	$ep_id_query="select lu.user_id from ".$prefix."lms_users lu,".$prefix."user_profiles up where lu.lms_usertype_id in('13','14','15','16') and 
					up.profile_value like '%".$agency."%' and up.profile_key='profile.agency'
						and up.user_id=lu.user_id";
	$rs=mysql_query($ep_id_query)or die(mysql_error());
	$sup_ids_temp="";
	while($row=mysql_fetch_array($rs))
	{
		$sup_ids_temp=$sup_ids_temp.$row['user_id'].",";
	}
	$sup_ids=trim($sup_ids_temp,",");
	
	$query = mysql_query("select id,concat(name,' ',middle_name,' ',last_name)as name from ".$prefix."users where id in (".$sup_ids.") order by last_name asc");
	echo "<option value='0'>--Select Supervisor--</option>";
	while($row = mysql_fetch_array($query)) 
	{
		echo "<option value='$row[id]'>$row[name]</option>";
	}
}
if(isset($_GET['supvsrmail']))
{
	$category = $_GET['supvsrmail'];
	$query = mysql_query("SELECT email from ".$prefix."users WHERE id='".$category."' ");
	while($row = mysql_fetch_array($query)) 
	{
	//	echo "<option value='$row[email]'>$row[email]</option>";
		echo "$row[email]";
	}
}
if(isset($_GET['selusers']))
{
	$category = $_GET['selusers'];
	// $query1 ="SELECT concat('\"',unit_name,'\"') from tbl_unit WHERE id='".$category."' and deleted='0' ";
	$query1 ="SELECT concat('\"',dis.unit_name,'\"'),ag.agency_name from tbl_unit dis,tbl_agency ag WHERE dis.id='".$category."' and dis.deleted='0'
	 			and ag.id=dis.agency_id";
	$rs=mysql_query($query1);
	while($row = mysql_fetch_array($rs)) 
	{
		$unit_name=$row['0'];
		$agency_name_temp=$row['1'];
	}
	//Check This Query
	 /*$sup_id_query="select lu.user_id from ".$prefix."lms_users lu,".$prefix."user_profiles up where lu.lms_usertype_id not in ('1','3','5','9','11','12','13','14','15') and 
					up.profile_value like '%".$unit_name."%' and up.profile_key='profile.unit'
						and up.user_id=lu.user_id";*/
						
	$sup_id_query="select user_id from ".$prefix."user_profiles where user_id in 
					(select user_id from ".$prefix."user_profiles where profile_value like '%".$agency_name_temp."%' and profile_key='profile.agency')   
					and profile_key='profile.unit' and profile_value like '%".$unit_name."%' and
					 user_id not in (select user_id from ".$prefix."lms_users where lms_usertype_id in ('1','3','5','9','11','21'))";
						
	$rs=mysql_query($sup_id_query);
	$sup_ids_temp="";
	while($row=mysql_fetch_array($rs))
	{
		$sup_ids_temp=$sup_ids_temp.$row['user_id'].",";
	}
	$sup_ids=trim($sup_ids_temp,",");
	
	$query = mysql_query("select id,concat(name,' ',middle_name,' ',last_name)as name from ".$prefix."users where id in (".$sup_ids.") and block=0 order by last_name asc");
	echo "<option value='0'>--Select User--</option>";
	echo "<option value='9999'>--ALL--</option>";//9999 indicates All Users
	while($row = mysql_fetch_array($query)) 
	{
		echo "<option value='$row[id]'>$row[name]</option>";
	}
}
if(isset($_GET['agency_selusers']))
{
	$category = $_GET['agency_selusers'];
	$unit_name='"'.$category.'"';
	//Check This Query
	$sup_id_query="select lu.user_id from ".$prefix."lms_users lu,".$prefix."user_profiles up where lu.lms_usertype_id not in ('1','3','5','9','11','12','13','14','15','21') and 
					up.profile_value like '%".$unit_name."%' and up.profile_key='profile.agency'
						and up.user_id=lu.user_id";
	$rs=mysql_query($sup_id_query);
	$sup_ids_temp="";
	while($row=mysql_fetch_array($rs))
	{
		$sup_ids_temp=$sup_ids_temp.$row['user_id'].",";
	}
	$sup_ids=trim($sup_ids_temp,",");
	
	echo $query = mysql_query("select id,concat(name,' ',middle_name,' ',last_name)as name from ".$prefix."users where id in (".$sup_ids.") and block=0 order by last_name asc");
	echo "<option value='0'>--Select User--</option>";
	echo "<option value='9999'>--ALL--</option>";//9999 indicates All Users
	while($row = mysql_fetch_array($query)) 
	{
		echo "<option value='$row[id]'>$row[name]</option>";
	}
}

if(isset($_GET['division_selusers']))
{
	$category = $_GET['division_selusers'];
	// $query1 ="SELECT concat('\"',division_name,'\"') from tbl_division WHERE id='".$category."' and deleted='0' ";
	 $query1 ="SELECT concat('\"',dis.division_name,'\"'),ag.agency_name from tbl_division dis,tbl_agency ag WHERE dis.id='".$category."' and dis.deleted='0'
	 			and ag.id=dis.agency_id";
	$rs=mysql_query($query1);
	while($row = mysql_fetch_array($rs)) 
	{
		$division_name=$row['0'];
		$agency_name_temp=$row['1'];
	}

	//Check This Query
	/*echo $sup_id_query="select lu.user_id from ".$prefix."lms_users lu,".$prefix."user_profiles up where lu.lms_usertype_id not in ('1','3','5','9','11','12','13','14','15') and
					up.profile_value like '%".$unit_name."%' and up.profile_key='profile.division'
						and up.user_id=lu.user_id";*/
	 $sup_id_query="select user_id from ".$prefix."user_profiles where user_id in 
					(select user_id from ".$prefix."user_profiles where profile_value like '%".$agency_name_temp."%' and profile_key='profile.agency')   
					and profile_key='profile.division' and profile_value like '%".$division_name."%' and
					 user_id not in (select user_id from ".$prefix."lms_users where lms_usertype_id in ('1','3','5','9','11','21'))";					
	$rs=mysql_query($sup_id_query);
	$sup_ids_temp="";
	while($row=mysql_fetch_array($rs))
	{
		$sup_ids_temp=$sup_ids_temp.$row['user_id'].",";
	}
	$sup_ids=trim($sup_ids_temp,",");
	
	$query = mysql_query("select id,concat(name,' ',middle_name,' ',last_name)as name from ".$prefix."users where id in (".$sup_ids.")  and block=0 order by last_name asc ");
	echo "<option value='0'>--Select User--</option>";
	echo "<option value='9999'>--ALL--</option>";//9999 indicates All Users
	while($row = mysql_fetch_array($query)) 
	{
		echo "<option value='$row[id]'>$row[name]</option>";
	}
}

if(isset($_GET['section_selusers']))
{
	$category = $_GET['section_selusers'];
	//$query1 ="SELECT concat('\"',section_name,'\"') from tbl_section WHERE id='".$category."' and deleted='0' ";
	 $query1 ="SELECT concat('\"',dis.section_name,'\"'),ag.agency_name from tbl_section dis,tbl_agency ag WHERE dis.id='".$category."' and dis.deleted='0'
	 			and ag.id=dis.agency_id";
	$rs=mysql_query($query1);
	while($row = mysql_fetch_array($rs)) 
	{
		$section_name=$row['0'];
		$agency_name_temp=$row['1'];
	}

	//Check This Query
	/*$sup_id_query="select lu.user_id from ".$prefix."lms_users lu,".$prefix."user_profiles up where lu.lms_usertype_id not in ('1','3','5','9','11','12','13','14','15') and 
					up.profile_value like '%".$unit_name."%' and up.profile_key='profile.section'
						and up.user_id=lu.user_id";*/
		
	 $sup_id_query="select user_id from ".$prefix."user_profiles where user_id in 
					(select user_id from ".$prefix."user_profiles where profile_value like '%".$agency_name_temp."%' and profile_key='profile.agency')   
					and profile_key='profile.section' and profile_value like '%".$section_name."%' and
					 user_id not in (select user_id from ".$prefix."lms_users where lms_usertype_id in ('1','3','5','9','11','21'))";						
						
	$rs=mysql_query($sup_id_query);
	$sup_ids_temp="";
	while($row=mysql_fetch_array($rs))
	{
		$sup_ids_temp=$sup_ids_temp.$row['user_id'].",";
	}
	$sup_ids=trim($sup_ids_temp,",");
	
	$query = mysql_query("select id,concat(name,' ',middle_name,' ',last_name)as name from ".$prefix."users where id in (".$sup_ids.") and block=0  order by last_name asc");
	echo "<option value='0'>--Select User--</option>";
	echo "<option value='9999'>--ALL--</option>";//9999 indicates All Users
	while($row = mysql_fetch_array($query)) 
	{
		echo "<option value='$row[id]'>$row[name]</option>";
	}
}

if(isset($_GET['myagency_selusers']))
{
	$category = $_GET['myagency_selusers'];
	$unit_name='"'.$category.'"';
	//Check This Query
	 $sup_id_query="select lu.user_id from ".$prefix."lms_users lu,".$prefix."user_profiles up where lu.lms_usertype_id not in ('1','3','5','9','11','21') and 
					up.profile_value like '%".$unit_name."%' and up.profile_key='profile.agency'
						and up.user_id=lu.user_id";
	$rs=mysql_query($sup_id_query);
	$sup_ids_temp="";
	while($row=mysql_fetch_array($rs))
	{
		//secho $row['user_id'];echo'</br>';
		$sup_ids_temp=$sup_ids_temp.$row['user_id'].",";
	}
	$sup_ids=trim($sup_ids_temp,",");
	
	 $R="select id,concat(name,' ',middle_name,' ',last_name)as name from ".$prefix."users where id in (".$sup_ids.") and block=0 order by name asc";
	 $query = mysql_query("select id,concat(name,' ',middle_name,' ',last_name)as name from ".$prefix."users where id in (".$sup_ids.") and block=0 order by last_name asc");
	echo "<option value=''>--Select User--</option>";	
	while($row = mysql_fetch_array($query)) 
	{
		echo "<option value='$row[id]'>$row[name]</option>";
	}
}


require_once("/home/dhsorg/public_html/custom/connections/database_close.php"); 
?>
