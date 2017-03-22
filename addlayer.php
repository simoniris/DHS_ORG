<?php

	require_once("./access_jsession.php");

	require_once("./custom_config.php");

	require_once("./connections/database.php");

	require_once("./base_functions.php");

	$prefix=$SESSION["PREFIX"];

	$user = $session->get( 'user' );

	echo $ID=$user->get('id');

	$USERNAME=$user->get('username');

	 $user = $session->get( 'user' );


	$namequery="select concat(name,' ',middle_name,' ',last_name)as name from ".$prefix."users where id='".$ID."'";
	$nameres=mysql_query($namequery) or die(mysql_error());
	while($newrow=mysql_fetch_assoc($nameres))
	{
		 $created_username=$newrow['name'];
	}
	   

if (!$user->guest || $_POST['location']==="admin") 

{
	$roletype=getRoleId($prefix,$ID);
?>

<html>

<head><title><?php echo $SITE_NAME?>Add Layer: Home</title>

<link href="css/style.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>

<script type="text/javascript">

jQuery(document).ready(function() {

jQuery("#agency").change(function () {

	jQuery(this).after('<div id="loader"><img src="loading (1).gif" alt="loading subcategory" /></div>');

	jQuery.get('load.php?jform_profile_agency=' + jQuery(this).val(), function(data) {

	jQuery("#division").html(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});

});

});

jQuery(document).ready(function() {

jQuery("#division").change(function () {

	/*jQuery(this).after('<div id="loader"><img src="http://dhsuniversity.org/custom/loading (1).gif" alt="loading subcategory" /></div>');*/

	jQuery.get('load.php?jform_profile_division=' + jQuery(this).val(), function(data) {

	jQuery("#section").html(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});

});

});

window.parent.document.getElementById('blockrandom').height = '320px';

</script>

<script>

$(function(){
		 
		  $('#division').keyup(function()
		  {
			var yourInput = $(this).val();
			re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
			var isSplChar = re.test(yourInput);
			if(isSplChar)
			{
			  var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
			  $(this).val(no_spl_char);
			  $("#mseg").html("Special characters can not be added to division name field").show().delay(1200).fadeOut(2000); 
			}
		  });
		 
		});
$(function(){
		 
		  $('#section').keyup(function()
		  {
			var yourInput = $(this).val();
			re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
			var isSplChar = re.test(yourInput);
			if(isSplChar)
			{
			  var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
			  $(this).val(no_spl_char);
			  $("#mseg").html("Special characters can not be added to section name field").show().delay(1200).fadeOut(2000); 
			}
		  });
		 
		});
$(function(){
		 
		  $('#unit').keyup(function()
		  {
			var yourInput = $(this).val();
			re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
			var isSplChar = re.test(yourInput);
			if(isSplChar)
			{
			  var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
			  $(this).val(no_spl_char);
			  $("#mseg").html("Special characters can not be added to unit name field").show().delay(1200).fadeOut(2000); 
			}
		  });
		 
		});
function divisionme()
{	
	var division=document.getElementById('division').value;
	
	if(division=='')
	{
		alert('Please enter the division name');
		return false;
	}
	else	
	{
		document.addDivisionForm.submit();		
		return false;

	}
	
 if(division)
 {
  $.ajax({
  type: 'get',
  url: 'div_sec_unit_ajax.php',
  data: {
   new_name:name,
  },
  success: function (response) {
   $( '#selectedlist' ).html(response);
   if(response=="Group name available.")	
   {
    return true;	
   }
   else
   {
    return false;	
   }
  }
  });
 }
 else
 {
  $( '#selectedlist' ).html("");
  return false;
 }

}

function checksection()
{
	var x=document.getElementById('agency').value;
	 if(x=='')
	 {
	 	alert('Please select agency name');
	 	return false;
	 }
	 
	 $division=document.getElementById('division').value;
	
	if($division=='')
	{
		alert('Please select division name');
		return false;
	}

	$section=document.getElementById('section').value;

	if($section=='')
	{

	  alert('enter your section name'); 
	  return false;

	 }
	 else
	 {

	 	document.addSectionForm.submit();
		return true;

	}	

}

function checkunit()
{

 	 var x=document.getElementById('agency').value;
	 if(x=='')
	 {
	 	alert('Please select agency name');
	 	return false;
	 }
	 
	 
	$division=document.getElementById('division').value;
	
	if($division=='')
	{
		alert('Please select division name');
		return false;
	}	
	
	 var y=document.getElementById('section').value;
	 if(y=='')
	 {
	 	alert('Please select section name');
	 	return false;
	 }
	 

	$unit=document.getElementById('unit').value;

	if($unit=='')
	{
	  alert('Enter your unit name');
	  return false;
	}
	else
	{
		  document.addUnitForm.submit();
		  return true;
	
	}

}

</script>

</head>

<body class="font-for-all">

<div id="wrapper">

<div id="content">

<!--<h4 align='center'>Under Development</h4>-->

<?php

//Start:Add Layer Division,Section,Unit

if(isset($_POST['actiontype']))

{
?><div align='center' id='mseg' style="color:#FF0000; font-family:arial; font-size:17px;"></div><?php
	if($_POST['actiontype']==="division_add")

	{

		echo "<form name='addDivisionForm' method='post'><table width='40%' align='center'><tr><th colspan='2'><b><img src='images/add_div.gif'/></th></tr>"; 

		echo "<tr><td>&nbsp;</td></tr>";
		?>
		<div align='center' id='selectedlist' style="color:#000000; font-family:arial; font-size:17px;"></div>
		
		<?php
		if($roletype!=11)

		{

			echo "<tr class='row-odd'>	<td><font style='Arial'  size='4'>Select Agency</font></td><td> <select name='agency_name' class='select_class'>";

			//$agency_array=getAllAgencyDetails();//Commented to not add layer to dummy agency 'ALL'

			session_start();

			 $agency=$_SESSION['agency_name'];

			$agency_array=getAgencyDetailsExceptAll();

			for($i=0,$j=count($agency_array);$i<$j;$i++)

			{

				echo "<option value='".$agency_array[$i]['id']."'>".$agency_array[$i]['agency_name']."</option>";

			}

			echo "</td></tr>";

		}

		else

		{

		session_start();

		$agency_name=$_SESSION['agency_name'];

		$agency_id=$_SESSION['agency_id'];

		echo "<tr><td><font style='Arial'  size='4'>Agency</font></td>";?>

		<td><input type='text' name='agency_name' id='agency' readonly="readonly" value="<?php echo $agency_name;?>" /></td></tr>

		<input type='hidden' name='agency_id' id='agency_id'  value="<?php echo $agency_id;?>" />

		<?php 

		}	

		echo "<tr><td><font style='Arial'  size='4'>Division Name</font></td><td><input type='text' name='division_name' id='division'/></td></tr></table>

		<input type='hidden' name='inserttype' value='division' />

		</form>";

		echo "<table width='40%' align='center'><tr><td align='right'><button class='btn-add-big big' onclick='return divisionme();' style='display:inline;'/></td>

				<td align='left'><form action=home.php method=\"post\" style='display:inline;'>

				<input type=\"submit\" value=\"\" class=\"btn-cancel-big big\"/>

			</form>	</td>

			</td></tr></table>";

	}

	if($_POST['actiontype']==="section_add")

	{  

		echo "<form name='addSectionForm'  method='post'><table width='40%' align='center'><tr><th colspan='2'><img src='images/add_sec.gif'/></th></tr>";

		echo "<tr><td>&nbsp;</td></tr>";

		if($roletype!=11)

		{

			echo "<tr class='row-odd'>	<td><font style='Arial'  size='4'>Select Agency</font></td><td> <select name='agency_name' class='select_class' id='agency'>";

			echo "<option value=''> -----Select Agency----- </option>";
		
			session_start();

			 $agency=$_SESSION['agency_name'];

			$agency_array=getAgencyDetailsExceptAll();
			
			for($i=0,$j=count($agency_array);$i<$j;$i++)

			{
				
				echo "<option value='".$agency_array[$i]['agency_name']."'>".$agency_array[$i]['agency_name']."</option>";
			}

			echo "</td></tr>";		

			echo "<tr><td><font style='Arial'  size='4'>Select Division</font></td><td><select name='division_name' class='select_class' id='division'>";	

			session_start();

			 $division=$_SESSION['division_name'];
			
			echo"<option value=''>-----Select Division-----</option>";
			
			$division_array=getDivisionByAgency($division);

			for($i=0,$j=count($division_array);$i<$j;$i++)
			
			{
			
			echo "<option value='".$division_array[$i]['id']."'>".$division_array[$i]['division_name']."</option>";
			
			}

		echo"</td></tr>";
		
		}
		
		if($roletype==11)

		{	
			session_start();

			$agency=$_SESSION['agency_name'];

			echo "<tr><td><font style='Arial'  size='4'>Agency</font></td>";
		?>
			<td><input type='text' name='agency_name' id='agency' readonly="readonly" value="<?php echo $agency;?>" /></td></tr>


			<input type='hidden' name='agency_id' id='agency_id'  value="<?php echo $agency_id;?>" />

		<?php


		echo "<tr><td><font style='Arial'  size='4'>Select Division</font></td><td><select name='division_name' class='select_class' id='division'/>";	

			$division_array=getDivisionByAgency($agency);
			
			echo"<option value=''>-----Select Division-----</option>";
			
			for($i=0,$j=count($division_array);$i<$j;$i++)

			{

				echo "<option value='".$division_array[$i]['id']."'>".$division_array[$i]['division_name']."</option>";

			}

		echo"</td></tr>";

		}

		echo "<tr><td><font style='Arial'  size='4'>Section Name</font></td><td><input type='text' name='section_name' id='section'/></td></tr></table>

		<input type='hidden' name='inserttype' value='section' />

		</form>";

		echo "<table width='40%' align='center'><tr><td align='right'><button class='btn-add-big big' onclick='return checksection();' style='display:inline;'/></td>

				<td align='left'><form action=home.php method=\"post\" style='display:inline;'> 

				<input type=\"submit\" value=\"\" class=\"btn-cancel-big big\"/>

			</form>	</td>

			</td></tr></table>"; 

	}

	if($_POST['actiontype']==="unit_add")

	{

		echo "<form name='addUnitForm'  method='post'><table width='40%' align='center'><tr><th colspan='2'><img src='images/add_unit.gif'/></th></tr>";

		echo "<tr><td>&nbsp;</td></tr>";

		if($roletype!=11)

		{

			echo "<tr class='row-odd'>	<td><font style='Arial'  size='4'>Select Agency</font></td><td> <select name='agency_name' class='select_class' id='agency'>";

			//$agency_array=getAllAgencyDetails();//Commented to not add layer to dummy agency 'ALL'
			
			session_start();
			
			 $agency=$_SESSION['agency_name'];

			$agency_array=getAgencyDetailsExceptAll();	

			echo"<option value=''>-----Select Agency-----</option>";
			
			for($i=0,$j=count($agency_array);$i<$j;$i++)
			{
			
				echo "<option value='".$agency_array[$i]['agency_name']."'>".$agency_array[$i]['agency_name']."</option>";

			}

			echo "</td></tr>";

		}

		if($roletype==11)

		{	

			session_start();

			 $agency=$_SESSION['agency_name'];

			echo "<tr><td><font style='Arial'  size='4'>Agency</font></td>";

		?>
			<td><input type='text' name='agency_name' id='agency' readonly="readonly" value="<?php echo $agency;?>" /></td></tr>

			<input type='hidden' name='agency_id' id='agency_id'  value="<?php echo $agency_id;?>" />

		<?php		
			echo "<tr><td><font style='Arial'  size='4'>Select Division</font></td><td><select name='division_name' class='select_class' id='division'/>";	

				$mysection=0;		

				echo"<option value=''>-----Select Division-----</option>";
								
				$division_array=getDivisionByAgency($agency);

				for($i=0,$j=count($division_array);$i<$j;$i++)

				{
					echo "<option value='".$division_array[$i]['id']."'>".$division_array[$i]['division_name']."</option>";

					 $mysection=$division_array[0]['id'];

				}

			echo"</select></td></tr>";

			echo "<tr><td><font style='Arial'  size='4'>Select Section</font></td><td><select name='section_name' class='select_class' id='section'/>";

				 $mysection; /* array element 0 of division array */

				echo"<option value=''>Select Section</option>";
				
				$section_array=getSectionByDivision($mysection);
				
				for($i=0,$j=count($section_array);$i<$j;$i++)

				{

					echo "<option value='".$section_array[$i]['id']."'>".$section_array[$i]['name']."</option>";

				}

			echo"</td></tr>";
			
		}

		if($roletype!=11)

		{

			echo "<tr><td><font style='Arial'  size='4'>Select Division</font></td><td><select name='division_name' class='select_class' id='division'/></td></tr>";

			echo "<tr><td><font style='Arial'  size='4'>Select Section</font></td><td><select name='section_name' class='select_class' id='section'/></td></tr>";

		}

		echo "<tr><td><font style='Arial'  size='4'>Unit Name</font></td><td><input type='text' name='unit_name' id='unit'/></td></tr></table>

		<input type='hidden' name='inserttype' value='unit' />		
		
		</form>";

		echo "<table width='40%' align='center'><tr><td align='right'><button class='btn-add-big big' onclick='return checkunit();' style='display:inline;'/></td>

				<td align='left'><form action=home.php method=\"post\" style='display:inline;'>

				<input type=\"submit\" value=\"\" class=\"btn-cancel-big big\"/>

			</form>	</td>

			</td></tr></table>";

	}

}

//End:Add Layer Division,Section,Unit

//Start:Insert Layer Division,Section,Unit

if(isset($_POST['inserttype']))
{

	if($roletype!=11)
	{

		if($_POST['inserttype']==="division")
		{
			$agency_id=htmlspecialchars($_POST['agency_name']);
		}
		else		
		{
			$agency_id=getAgencyIdByName($prefix,htmlspecialchars($_POST['agency_name']));	
		}
  }
  else
  {
   	$agency_id=$_SESSION['agency_id'];
  }

	if($_POST['inserttype']==="division")
	{
		$eixstquery="select division_name from tbl_division where agency_id ='".$agency_id."' and division_name = '".mysql_real_escape_string($_POST['division_name'])."'";

		$resexist=mysql_query($eixstquery) or die(mysql_error);

		$count=mysql_num_rows($resexist);
		
		if($count==0)
		{

			$insert_query="insert into tbl_division (division_name,agency_id,created_userid,created_username) values 

							('".mysql_real_escape_string($_POST['division_name'])."','".$agency_id."','".$ID."','".$created_username."')";

			$success_msg="<p align='center'>Division '".$_POST['division_name']."' has been added successfully</p>";

			$failure_msg="<p align='center'>Division '".$_POST['division_name']."' has not been added successfully</p>";

		}
		else
		{

			$failure_msg="<p align='center'>Division '".$_POST['division_name']."' already exists.</p>";

		}

	}

	if($_POST['inserttype']==="section")

	{
	
		$eixstquery="select section_name from tbl_section where agency_id ='".$agency_id."' and division_id='".htmlspecialchars($_POST['division_name'])."' and 

		             section_name='".mysql_real_escape_string($_POST['section_name'])."'";

		$resexist=mysql_query($eixstquery) or die(mysql_error);

		$count=mysql_num_rows($resexist);

		if($count==0)
		
		{

		$insert_query="insert into tbl_section (section_name,division_id,agency_id,created_userid,created_username) values 

							('".mysql_real_escape_string($_POST['section_name'])."','".mysql_real_escape_string($_POST['division_name'])."','".$agency_id."','".$ID."','".$created_username."')";

			$success_msg="<p align='center'>Section '".$_POST['section_name']."' has been added successfully</p>";

			$failure_msg="<p align='center'>Section '".$_POST['section_name']."' has not been added successfully</p>";

		}

		else

		{

			$failure_msg="<p align='center'>Section '".$_POST['section_name']."' already exists.</p>";

		}

	}

	if($_POST['inserttype']==="unit")

	{

		 $eixstquery="select unit_name from tbl_unit where agency_id ='".$agency_id."' and division_id='".htmlspecialchars($_POST['division_name'])."' and section_id='".		                     htmlspecialchars($_POST['section_name'])."' and unit_name ='".mysql_real_escape_string($_POST['unit_name'])."'";

		$resexist=mysql_query($eixstquery) or die(mysql_error);

		$count=mysql_num_rows($resexist);

		if($count==0)

		{

			$insert_query="insert into tbl_unit (unit_name,section_id,division_id,agency_id,created_userid,created_username) values 

							('".mysql_real_escape_string($_POST['unit_name'])."','".mysql_real_escape_string($_POST['section_name'])."','".mysql_real_escape_string($_POST['division_name'])."','".$agency_id."','".$ID."','".$created_username."')";

			$success_msg="<p align='center'>Unit '".$_POST['unit_name']."' has been added successfully</p>";

			$failure_msg="<p align='center'>Unit '".$_POST['unit_name']."' has not been added successfully</p>";

		}	
		
		else
		{

			$failure_msg="<p align='center'>Unit '".$_POST['unit_name']."' already exists.</p>";

		}
	}

//echo 	$insert_query;

if($count==0)
{

	$result=mysql_query($insert_query) or die(mysql_error);

	$_SESSION['action_message']=$success_msg;

}

if($count!=0)
{

	$_SESSION['action_message']=$failure_msg;

}	

/*	if($result==="true")
	{

		$_SESSION['action_message']=$success_msg;

	}
	else
	{

		$_SESSION['action_message']=$failure_msg;

	}

*/	$_SESSION['type']=$_POST['inserttype'];

//	echo "<script>window.self.location.href = '".$SITE_ROOT."/custom/addlayer.php';";

}

if(isset($_SESSION['action_message']))
{
	echo "<b>".$_SESSION['action_message']."</b>";
	unset($_SESSION['action_message']);

	if(isset($_SESSION['type']))
	{

		if($_SESSION['type']==="division")
		{
		
			$type="division_add";

		}

		if($_SESSION['type']==="section")
		{

			$type="section_add";
		}

		if($_SESSION['type']==="unit")
		{

			$type="unit_add";
		}

		unset($_SESSION['type']);

	}
	
	echo "<center>	<form action='addlayer.php' method='post' style='display:inline;'> 

<input type='hidden' name='actiontype' value='$type'/>

	<input type='submit' value='' class='btn-go-back-big big'/>

			</form></center>";	

}

//End:Insert Layer Division,Section,Unit
?>

</div></div>
<?php

require_once("./connections/database_close.php");
}

else
{

		echo "<center>Your session expired. <a href='$SITE_ROOT' target='_top'>Click Here</a> to login again</center>";
}

?>