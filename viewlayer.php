<?php
	require_once("./access_jsession.php");
	require_once("./custom_config.php");
	require_once("./connections/database.php");
	require_once("./base_functions.php");
	$prefix=$SESSION["PREFIX"];
	$user = $session->get( 'user' );
	$ID=$user->get('id');
	$USERNAME=$user->get('username');
	
	$roletype=$_SESSION['myrole'];	
	
	$todaydate=date("Y-m-d");
	
	$namequery="select concat(name,' ',middle_name,' ',last_name)as name from ".$prefix."users where id='".$ID."'";
	$nameres=mysql_query($namequery) or die(mysql_error());
	while($newrow=mysql_fetch_assoc($nameres))
	{
		 $updated_username=$newrow['name'];
	}
 
$user = $session->get( 'user' );
if (!$user->guest || $_POST['location']==="admin") 
{
	$roletype=getRoleId($prefix,$ID);
	if(!isset($_SESSION['agency_id']))
	{
		$agency_details=getUserAgencyDetails($prefix,$ID);
		$_SESSION['agency_id']=$agency_details["id"];
		if(!isset($_SESSION['agency_name']))
		{
			$_SESSION['agency_name']=$agency_details["name"];
		}
	}
	$agency_name=$_SESSION['agency_name'];
	$agency_id=$_SESSION['agency_id'];	

//Start: Viewlayer]

?>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.js"></script>
<script>

function divisionmes()
{	

var division=document.getElementById('division_name').value;

 if(division)
 {

  var name=document.getElementById('division_name').value;
  var agency=document.getElementById('agency').value;

  var divoldname="<?php echo $_POST['selname'];?>";
	
 var cuaagency="<?php echo $_SESSION['agency_id']?>";
 
	  $.ajax({
	  type: 'get',
	  url: 'div_sec_unit_ajax.php',
	  data: {
	   new_name:name,agency:agency,cuaagency:cuaagency,divoldname:divoldname,
	  },
	  success: function (response) {
	   $( '#selectedlist' ).html(response);
	   if(response=="")	
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

function checkall_div()
{
 var namehtml=document.getElementById("selectedlist").innerHTML; 

 if(namehtml =="")
 {
  return true;
 }
 else
 {
  return false;
 }
}

$(document).ready(function(){
$('#subitdivision').click(function(){
	var div=document.getElementById('division_name').value;
	var agency=document.getElementById('agency').value;
	if(agency=='')
	{
		alert('please select agency name');
		return false;
	}
	if (div=='')
	{
		alert('Please enter the division name');
		return false;
	}
	
	});
});


$(document).ready(function(){
$('#subitsection').click(function(){	
	var agency=document.getElementById('agency').value;
	if(agency=='')
	{
		alert('please select agency name');
		return false;
	}
	var div=document.getElementById('division').value;
	if (div=='')
	{
		alert('Please select division name');
		return false;
	}
	var sec=document.getElementById('sectionid').value;
	if (sec=='')
	{
		alert('Please enter the section name');
		return false;
	}
	});
});

$(document).ready(function(){
$('#submitunitids').click(function(){	
	var agency=document.getElementById('agency').value;
	if(agency=='')
	{
		alert('please select agency name');
		return false;
	}
	var div=document.getElementById('division').value;
	if (div=='')
	{
		alert('Please select division name');
		return false;
	}
	var sec=document.getElementById('section').value;
	if (sec=='')
	{
		alert('Please select section name');
		return false;
	}
	var unitsnme=document.getElementById('unitid').value;
	if (unitsnme=='')
	{
		alert('Please enter the unit name');
		return false;
	}
	});
});



function sectionmes()
{
	 var section=document.getElementById('sectionid').value;

 if(section)
 {
  var sectname=document.getElementById('sectionid').value;
  var divisionid=document.getElementById('division').value;
  var agency=document.getElementById('agency').value;
  
  var cuaagency="<?php echo $_SESSION['agency_id']?>";
  var sectionoldname="<?php echo $_POST['selname'];?>";
  
	  $.ajax({
	  type: 'get',
	  url: 'div_sec_unit_ajax.php',
	  data: {
	   newsec_name:sectname,agency:agency,sectionoldname:sectionoldname,divisionid:divisionid,cuaagency:cuaagency,
	  },
	  success: function (response) {
	   $( '#selectedlist' ).html(response);
	   if(response=="")	
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
function checkall_sec()
{
 var namehtml=document.getElementById("selectedlist").innerHTML; 

 if(namehtml =="")
 {
  return true;
 }
 else
 {
  return false;
 }
}
function unitnamesd()
{
	  var unitid=document.getElementById('unitid').value;

 if(unitid)
 {  
 
  var unitids=document.getElementById('unitid').value;
  var sectnameid=document.getElementById('section').value;
  var divisionid=document.getElementById('division').value;
  var agency=document.getElementById('agency').value;
	
  var cuaagency="<?php echo $_SESSION['agency_id']?>";

  var unitoldname="<?php echo $_POST['selname'];?>";
 
	  $.ajax({
	  type: 'get',
	  url: 'div_sec_unit_ajax.php',
	  data: {
	   newunitid:unitids,agency:agency,unitoldname:unitoldname,divisionid:divisionid,sectnameid:sectnameid,cuaagency:cuaagency,
	  },
	  success: function (response) {
	   $( '#selectedlist' ).html(response);
	   if(response=="")
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
function checkall_unit()
{
 var namehtml=document.getElementById("selectedlist").innerHTML; 

 if(namehtml =="")
 {
  return true;
 }
 else
 {
  return false;
 }
}
</script>


<?php
if(isset($_POST['actiontype']))
{
		
		if($_POST['actiontype']==="division_view" || $_POST['actiontype']==="archiveddiv")
		{
		
		if($_POST['actiontype']==="division_view")
		{
			if($roletype!=11)//Super Users(3,5) & DHS Admin (9)
			{
				 $query="Select count(id) from tbl_division where deleted=0";
						
			}
			else
			{
				$query="Select count(id) from tbl_division where agency_id='".$agency_id."' and deleted=0";	
					
			}
		}
		if($_POST['actiontype']==="archiveddiv")
		{
			if($roletype!=11)//Super Users(3,5) & DHS Admin (9)
			{
				 $query="Select count(id) from tbl_division where deleted!=0";
				
			}
			else
			{
				$query="Select count(id) from tbl_division where agency_id='".$agency_id."' and deleted!=0";
					
			}
		
		}
		$rs=mysql_query($query) or die(mysql_error);
		while($row=mysql_fetch_array($rs))
		{
			 $tot_users=$row['0'];
		}
		$tot_pages=ceil($tot_users/10);
		
		if(isset($_POST['page_index']) && $_POST['page_index']>1)
		{
			$offset=(htmlspecialchars($_POST['page_index'])-1)*10;
		}
		else
		{
			$offset=0;
		}
		
		if($roletype==3 || $roletype==5 || $roletype==9)//Super Users(3,5) & DHS Admin (9)
		{
			$query="Select d.id,d.division_name,a.agency_name,d.deleted,date_format(d.archive_date,'%m-%d-%Y')as archive_date,a.id from tbl_division d,tbl_agency a where a.id=d.agency_id and d.deleted=0 order by a.agency_name limit 10 offset ".$offset."";	
			$msg="<tr class='row_even'><th colspan='3' align='center'><img src='images/div.gif'/></th></tr>";
			$table_header="<tr class='text_color'><th>Division Name</th><th>Agency Name</th><th width='150px;'>Actions</th></tr>";
			$pg_index="<tr><td colspan='3' align='right'>";
		}
		if($roletype==21)//read-only admin
		{
			$query="Select d.id,d.division_name,a.agency_name,d.deleted,date_format(d.archive_date,'%m-%d-%Y')as archive_date,a.id from tbl_division d,tbl_agency a where a.id=d.agency_id and d.deleted=0 order by a.agency_name limit 10 offset ".$offset."";	
			$msg="<tr class='row_even'><th colspan='3' align='center'><img src='images/div.gif'/></th></tr>";
			$table_header="<tr class='text_color'><th>Division Name</th><th>Agency Name</th></tr>";
			$pg_index="<tr><td colspan='3' align='right'>";
		}
		if($roletype==11)//agency admin
		{
			$query="Select id,division_name,deleted,date_format(archive_date,'%m-%d-%Y')as archive_date from tbl_division where agency_id='".$agency_id."' and deleted=0 limit 10 offset ".$offset." ";		
			$msg="<tr class='row_even'><th colspan='2' align='center'><img src='images/div.gif'/></th></tr><tr><td>&nbsp;</td></tr>";
			$table_header="<tr class='text_color'><th>Division Name</th><th width='150px;'>Actions</th></tr>";
			$pg_index="<tr><td colspan='2' align='right'>";
		}

		if($_POST['actiontype']==="archiveddiv")
		{
			if($roletype==3 || $roletype==5 || $roletype==9)//Super Users(3,5) & DHS Admin (9)
			{
			$query="Select d.id,d.division_name,a.agency_name,d.deleted,date_format(d.archive_date,'%m-%d-%Y')as archive_date from tbl_division d,tbl_agency a 
					where a.id=d.agency_id and d.deleted!=0 order by a.agency_name,d.division_name asc limit 10 offset ".$offset."";
						
			$msg="<tr class='row_even'><th colspan='3' align='center'><img src='images/div.gif'/></th></tr>";
			$table_header="<tr class='text_color'><th>Division Name</th><th>Agency Name</th><th>Archived Date</th><th width='150px;'>Actions</th></tr>";
			
			$pg_index="<tr><td colspan='3' align='right'>";
			}
			if($roletype==21)//read-only admin
			{
			$query="Select d.id,d.division_name,a.agency_name,d.deleted,date_format(d.archive_date,'%m-%d-%Y')as archive_date from tbl_division d,tbl_agency a 
					where a.id=d.agency_id and d.deleted!=0 order by a.agency_name,d.division_name asc limit 10 offset ".$offset."";
						
			$msg="<tr class='row_even'><th colspan='3' align='center'><img src='images/div.gif'/></th></tr>";
			$table_header="<tr class='text_color'><th>Division Name</th><th>Agency Name</th><th>Archived Date</th></tr>";
			
			$pg_index="<tr><td colspan='3' align='right'>";
			}
			if($roletype==11)//agency admin
			{
			$query="Select id,division_name,deleted,date_format(archive_date,'%m-%d-%Y')as archive_date from tbl_division where agency_id='".$agency_id."' and deleted!=0 limit 10 offset ".$offset."";		
			$msg="<tr class='row_even'><th colspan='2' align='center'><img src='images/div.gif'/></th></tr><tr><td>&nbsp;</td></tr>";
			$table_header="<tr class='text_color'><th>Division Name</th><th>Archived Date</th><th width='150px;'>Actions</th></tr>";
			
			$pg_index="<tr><td colspan='2' align='right'>";
			}
		
		
		}
		
//		echo $query;
		$rs=mysql_query($query) or die(mysql_error);
		echo "<table width='60%' align='center'>";
		echo $msg;
		echo $table_header;
		$i=0;
		while($row=mysql_fetch_array($rs))
		{
			if($i%2==0)
			echo "<tr class='row-odd'>";	
			else
			echo "<tr class='row-even'>";
			if($_POST['actiontype']==="division_view")
		    {
			if($roletype!=11)//Super Users(3,5) & DHS Admin (9)
			{
				echo "<td>".$row['1']."</td><td>".$row['2']."</td>";
				$deleted=$row['3'];
			}
			else
			{
				echo "<td>".$row['1']."</td>";
				$deleted=$row['2'];
			}	
			}
			if($_POST['actiontype']==="archiveddiv")
		    {
			if($roletype!=11)//Super Users(3,5) & DHS Admin (9)
			{
				echo "<td>".$row['1']."</td><td>".$row['2']."</td><td>".$row['4']."</td>";
				$deleted=$row['3'];
			}
			else
			{
				echo "<td>".$row['1']."</td><td>".$row['3']."</td>";
				$deleted=$row['2'];
			}			
			}
if($roletype!=21)
{
				echo '<td align="center">
					<form action="viewlayer.php" target="_self" style="display:inline;text-align:right;" method="POST">
					<input type="hidden" name="selid" value="'.$row['0'].'"/>
					<input type="hidden" name="selname" value="'.$row['1'].'"/>
					<input type="hidden" name="divisionname" value="'.$row['1'].'"/>
					<input type="hidden" name="agencyname" value="'.$row['2'].'"/>
					<input type="hidden" name="action" value="deletediv"/>';
//				echo"	<input type='hidden' name='actiontype' value='".$_POST['actiontype']."'/>";
				echo '<input type="hidden" name="deleted" value="'.$deleted.'" />';	
				if(isset($_POST['page_index']))
				{		
					echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";
				}
				if($deleted==0)
				{
					?>																														
			<input type="submit" class="btn-archive-big big" value="" style="font-size: 11px;">
					<?php
				}
				else
				{
					echo "<input type='submit' class='btn-un-archive-big big' value='' style='font-size: 11px;'/>";
				}
				echo '</form>';
				
			if($_POST['action']=='viewlayer' || $_POST['actiontype']=='division_view')
			{
				echo'<form action="viewlayer.php" target="_self" style="display:inline;text-align:right;" method="POST">
					<input type="hidden" name="selid" value="'.$row['0'].'"/>
					<input type="hidden" name="selname" id="divisid" value="'.$row['1'].'" />	
					<input type="hidden" name="agency_id" id="agency_id" value="'.$row['id'].'"/>
					<input type="hidden" name="action" value="editdiv"/>';
//				echo "	<input type='hidden' name='actiontype' value='".$_POST['actiontype']."'/>";					
				if(isset($_POST['page_index']))
				{		
					echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";
				}
				echo "<input type='submit' class='btn-edit-big big' value='' style='font-size: 11px;'/>";
				echo "</form>";
				
				echo "</td>";
			}
}		}
			echo "</tr>";
			$i++;
	echo'<tr><td>&nbsp;&nbsp;</td></tr>';
		echo $pg_index;
		
		$current_page=1;
			if(isset($_POST['page_index']))
			{
				$current_page=$_POST['page_index'];
			}
		
		for($i=1;$i<$tot_pages||$i==$tot_pages;$i++)
		{
			echo "<form action='viewlayer.php' target='_self' method='POST' name='page".$i."' style='display:inline;'>";
			echo "<input type='hidden' name='action' value='".$_POST['action']."'/>
			 <input type='hidden' name='actiontype' value='".$_POST['actiontype']."'/>";
			echo "<input type='hidden' name='page_index' value='".$i."'/> </form>";
			$name="page".$i;	

	if($current_page==$i)
	{
?>		<a href='#' class="pagecol" onclick='javascript:document.<?php echo $name;?>.submit();'><?php echo $i;?></a> |


<?php }
	else{
?>
		<a href='#' class="not_active" onclick='javascript:document.<?php echo $name;?>.submit();'><?php echo $i;?></a> |
<?php
		}
	 }
	 
	echo "</td></tr></table>";
	echo "<center><form action=$SITE_ROOT/custom/home.php method=\"post\" style='display:inline;'>
			<input type=\"submit\" value=\"\" class=\"btn-go-back-big big\"/>
			</form></center>"; 
			
		if($roletype!=12 || $roletype!=13 || $roletype!=14 || $roletype!=15 || $roletype!=16)
		{
			if($_POST['actiontype']==="division_view")
			{
	?>
		<form action='viewlayer.php' name="divsionarchived"  method="post" target="_self"/>
		<input type="hidden" name="actiontype" value="archiveddiv"/>
		<a href='#' onclick='javascript:document.divsionarchived.submit();'>View Archive</a>
		</form>
		<?php } 
		}
		if($_POST['actiontype']==="archiveddiv")
			{
			?>
			<form action='viewlayer.php' name="divsionarchived"  method="post" target="_self"/>
			<input type="hidden" name="actiontype" value="division_view"/>
			<a href='#' onclick='javascript:document.divsionarchived.submit();'> Active </a>
			</form>
			
			<?php						
			}
		
		?>
	<?php
	}
	
//Section
	if($_POST['actiontype']==="section_view" || $_POST['actiontype']==="archivedsec")
	{
	
		
		if($roletype!=11)//Super Users(3,5) & DHS Admin (9)
		{
			//$query="Select count(id) from tbl_section where deleted=0";	
			$query="Select count(s.id) from tbl_section s,tbl_division d,tbl_agency a where a.id=s.agency_id and d.id=s.division_id and s.deleted=0";
		}
		else
		{
			$query="Select count(id) from tbl_section where agency_id='".$agency_id."' and deleted=0";	
			
		}	
		
		if($_POST['actiontype']==="archivedsec")
		{
			
			if($roletype!=11)//Super Users(3,5) & DHS Admin (9)
			{
				$query="Select count(id) from tbl_section where deleted!=0";	
			}
			else
			{
				$query="Select count(id) from tbl_section where agency_id='".$agency_id."' and deleted!=0";		
			}
		}
		
		$rs=mysql_query($query) or die(mysql_error);
		while($row=mysql_fetch_array($rs))
		{
			$tot_users=$row['0'];
		}
		$tot_pages=ceil($tot_users/10);
		if(isset($_POST['page_index']) && $_POST['page_index']>1)
		{
			$offset=(htmlspecialchars($_POST['page_index'])-1)*10;
		}
		else
		{
			$offset=0;
		}
		
		if($roletype==3 || $roletype==5 || $roletype==9)//Super Users(3,5) & DHS Admin (9)
		{
		  $query="Select s.id,s.section_name,d.division_name,a.agency_name,s.deleted,date_format(s.archive_date,'%m-%d-%Y')as archive_date,a.id,d.id from 
		 
				 	tbl_section s,tbl_division d,tbl_agency a where  a.id=s.agency_id and d.id=s.division_id and  s.deleted=0 order by
		 
		  				a.agency_name,d.division_name,s.section_name asc limit 10 offset ".$offset."";	
		  
			$msg="<tr class='row_even'><th colspan='4' align='center'><img src='images/sec.gif'/></th></tr>";
			$table_header="<tr class='text_color'><th>Section Name</th><th>Division Name</th><th>Agency Name</th><th width='150px;'>Actions</th></tr>";
			$pg_index="<tr><td colspan='4' align='right'>";
		}
		if($roletype==21)//read-only admin
		{
			$query="Select s.id,s.section_name,d.division_name,a.agency_name,s.deleted,date_format(s.archive_date,'%m-%d-%Y')as archive_date,a.id,d.id from tbl_section s,tbl_division d,tbl_agency a 
						where a.id=s.agency_id and d.id=s.division_id and s.deleted=0 order by a.agency_name,d.division_name,s.section_name asc limit 10 offset ".$offset."";	
			$msg="<tr class='row_even'><th colspan='4' align='center'><img src='images/sec.gif'/></th></tr>";
			$table_header="<tr class='text_color'><th>Section Name</th><th>Division Name</th><th>Agency Name</th></tr>";
			$pg_index="<tr><td colspan='4' align='right'>";
		}
		if($roletype==11)//agency admin
		{
			$query="Select s.id,s.section_name,d.division_name,s.deleted,s.deleted,date_format(s.archive_date,'%m-%d-%Y')as archive_date,s.agency_id,d.id from tbl_section s,tbl_division d where s.agency_id='".$agency_id."' 
					and d.id=s.division_id and s.deleted=0 order by d.division_name	limit 10 offset ".$offset."";		
			$msg="<tr class='row_even'><th colspan='4' align='center'><img src='images/sec.gif'/></th></tr><tr><td>&nbsp;</td></tr>";
			$table_header="<tr class='text_color'><th>Section Name</th><th>Division Name</th><th width='150px;'>Actions</th></tr>";
			$pg_index="<tr><td colspan='3' align='right'>";
		}
		
		if($_POST['actiontype']==="archivedsec")
		{
			if($roletype==3 || $roletype==5 || $roletype==9)//Super Users(3,5) & DHS Admin (9)
			{
				$query="Select s.id,s.section_name,d.division_name,a.agency_name,s.deleted,date_format(s.archive_date,'%m-%d-%Y')as archive_date,s.agency_id,s.division_id from tbl_section s,tbl_division d,tbl_agency a 
							where a.id=s.agency_id and d.id=s.division_id and s.deleted!=0 order by a.agency_name limit 10 offset ".$offset."";	
				$msg="<tr class='row_even'><th colspan='4' align='center'><img src='images/sec.gif'/></th></tr>";
				$table_header="<tr class='text_color'><th>Section Name</th><th>Division Name</th><th>Agency Name</th><th>Archived Date</th><th width='150px;'>Actions</th></tr>";
				$pg_index="<tr><td colspan='4' align='right'>";
			}
			if($roletype==21)//read-only admin
			{
				$query="Select s.id,s.section_name,d.division_name,a.agency_name,s.deleted,date_format(s.archive_date,'%m-%d-%Y')as archive_date,s.agency_id,s.division_id from tbl_section s,tbl_division d,tbl_agency a 
							where a.id=s.agency_id and d.id=s.division_id and s.deleted!=0 order by a.agency_name limit 10 offset ".$offset."";	
				$msg="<tr class='row_even'><th colspan='4' align='center'><img src='images/sec.gif'/></th></tr>";
				$table_header="<tr class='text_color'><th>Section Name</th><th>Division Name</th><th>Agency Name</th><th>Archived Date</th></tr>";
				$pg_index="<tr><td colspan='4' align='right'>";
			}
			if($roletype==11)//agency admin
			{
				$query="Select s.id,s.section_name,d.division_name,s.deleted,date_format(s.archive_date,'%m-%d-%Y')as archive_date,s.agency_id,s.division_id from tbl_section s,tbl_division d where s.agency_id='".$agency_id."' 
						and d.id=s.division_id and s.deleted!=0 order by d.division_name limit 10 offset ".$offset."";		
				$msg="<tr class='row_even'><th colspan='4' align='center'><img src='images/sec.gif'/></th></tr><tr><td>&nbsp;</td></tr>";
				$table_header="<tr class='text_color'><th>Section Name</th><th>Division Name</th><th>Archived Date</th><th width='150px;'>Actions</th></tr>";
				$pg_index="<tr><td colspan='3' align='right'>";
			}
						
		}
		$rs=mysql_query($query) or die(mysql_error());
		echo "<table width='70%' align='center'>";
		echo $msg;
		echo $table_header;
		$i=0;
		while($row=mysql_fetch_array($rs))
		{
			if($i%2==0)
			echo "<tr class='row-odd'>";	
			else
			echo "<tr class='row-even'>";
			if($_POST['actiontype']==="section_view")
			{
			if($roletype!=11)//Super Users(3,5) & DHS Admin (9)
			{
				echo "<td>".$row['1']."</td><td>".$row['2']."</td><td>".$row['3']."</td>";
				$deleted=$row['4'];
			}
			else
			{
				echo "<td>".$row['1']."</td><td>".$row['2']."</td>";
				$deleted=$row['3'];
			}	
			}
			if($_POST['actiontype']==="archivedsec")
			{
			if($roletype!=11)//Super Users(3,5) & DHS Admin (9)
			{
				echo "<td>".$row['1']."</td><td>".$row['2']."</td><td>".$row['3']."</td><td>".$row['5']."</td>";
				$deleted=$row['4'];
			}
			else
			{
				echo "<td>".$row['1']."</td><td>".$row['2']."</td><td>".$row['4']."</td>";
				$deleted=$row['3'];
			}	
			}
if($roletype!=21)
{				

				echo '<td align="center">
					<form action="viewlayer.php" target="_self" style="display:inline;text-align:right;" method="POST">
					<input type="hidden" name="selid" value="'.$row['0'].'"/>					
					<input type="hidden" name="selname" value="'.$row['1'].'"/>
					<input type="hidden" name="action" value="deletesec"/>';
					echo'<input type="hidden" name="agencyname" value="'.$row['3'].'"/>';
					
					echo'<input type="hidden" name="divisionname" value="'.$row['2'].'"/>
					<input type="hidden" name="unitname" value="'.$row['5'].'"/>
					<input type="hidden" name="sectionname" value="'.$row['1'].'"/>';
//				echo"	<input type='hidden' name='actiontype' value='".$_POST['actiontype']."'/>";
				echo '<input type="hidden" name="deleted" value="'.$deleted.'" />';	
				if(isset($_POST['page_index']))
				{		
					echo '<input type="hidden" name="page_index" value="'.$_POST['page_index'].'"/>';
				}
				if($deleted==0)
				{
					?>																														
						<input type="submit" class="btn-archive-big big" value="" style="font-size: 11px;">
					<?php
				}
				else
				{
					echo "<input type='submit' class='btn-un-archive-big big' value='' style='font-size: 11px;'/>";
				}
				echo '</form>';
			
			if($_POST['action']=='viewlayer' || $_POST['actiontype']=='section_view')
			{
				echo'<form action="viewlayer.php" target="_self" style="display:inline;text-align:right;" method="POST">
					<input type="hidden" name="selid" value="'.$row['0'].'"/>
					<input type="hidden" name="selname" value="'.$row['1'].'"/>	
					<input type="hidden" name="divid" value="'.$row['7'].'"/>
					<input type="hidden" name="agency_id" value="'.$row['6'].'"/>
					<input type="hidden" name="action" value="editsec"/>';
//				echo "	<input type='hidden' name='actiontype' value='".$_POST['actiontype']."'/>";					
				if(isset($_POST['page_index']))
				{		
					echo '<input type="hidden" name="page_index" value="'.$_POST['page_index'].'"/>';
				}
				echo "<input type='submit' class='btn-edit-big big' value='' style='font-size: 11px;'/>";
				echo "</form>";
			}
				
				echo"</td>";
}		}
			echo "</tr>";
			$i++;
	
	echo'<tr><td>&nbsp;&nbsp;</td></tr>';
	
		echo $pg_index;
		
	$current_page=1;
		if(isset($_POST['page_index']))
		{
			$current_page=$_POST['page_index'];
		}

		
		
		for($i=1;$i<$tot_pages||$i==$tot_pages;$i++)
		{
			echo "<form action='viewlayer.php' target='_self' method='POST' name='page".$i."' style='display:inline;'>";
			echo "<input type='hidden' name='action' value='".$_POST['action']."'/>
			 <input type='hidden' name='actiontype' value='".$_POST['actiontype']."'/>";
			echo "<input type='hidden' name='page_index' value='".$i."'/> </form>";
			$name="page".$i;	
	
	if($current_page==$i)
	{
?>		<a href='#' class="pagecol" onclick='javascript:document.<?php echo $name;?>.submit();'><?php echo $i;?></a> |


<?php }
	else{
?>
		<a href='#' class="not_active" onclick='javascript:document.<?php echo $name;?>.submit();'><?php echo $i;?></a> |
<?php
		}
	 }
	echo "</td></tr></table>";
	echo "<center><form action=$SITE_ROOT/custom/home.php method=\"post\" style='display:inline;'>
			<input type=\"submit\" value=\"\" class=\"btn-go-back-big big\"/>
			</form></center>"; 
	
	if($_POST['actiontype']==="archivedsec")
		{
	
	?>
			<form action='viewlayer.php' name="sectionarchived"  method="post" target="_self"/>
			<input type="hidden" name="actiontype" value="section_view"/>
			<a href='#' onclick='javascript:document.sectionarchived.submit();'>Active</a>
			</form>
	
	<?php } 
	if($roletype!=12 || $roletype!=13 || $roletype!=14 || $roletype!=15 || $roletype!=16)
	{
	if($_POST['actiontype']==="section_view")
		{
	
	?>
	
	<form action='viewlayer.php' name="sectionarchived"  method="post" target="_self"/>
			<input type="hidden" name="actiontype" value="archivedsec"/>
			<a href='#' onclick='javascript:document.sectionarchived.submit();'>View Archive</a>
			</form>
	
	<?php 
		}
		}
	}	
//unit
	if($_POST['actiontype']==="unit_view" || $_POST['actiontype']==="archivedunit")
	{
	
	 
		if($roletype!=11)//Super Users(3,5) & DHS Admin (9)
		{
			 		//$query="Select count(id) from tbl_unit where deleted=0";
			 
					$query= "Select count(u.id) from tbl_unit u,tbl_section s,tbl_division d,tbl_agency a 
							 where a.id=u.agency_id and d.id=u.division_id and s.id=u.section_id and u.deleted=0"; 	
		}
		else
		{
			$query="Select count(id) from tbl_unit where agency_id='".$agency_id."' and deleted=0";		
		}
		
		if($_POST['actiontype']==="archivedunit")
	 	{
			
			if($roletype!=11)//Super Users(3,5) & DHS Admin (9)
			{
				$query="Select count(id) from tbl_unit where deleted!=0";	
			}
			else
			{
				$query="Select count(id) from tbl_unit where agency_id='".$agency_id."' and deleted!=0";		
			}			
			
		}
		$rs=mysql_query($query) or die(mysql_error());
		while($row=mysql_fetch_array($rs))
		{
			$tot_users=$row['0'];
		}
		$tot_pages=ceil($tot_users/10);
		if(isset($_POST['page_index']) && $_POST['page_index']>1)
		{
			$offset=(htmlspecialchars($_POST['page_index'])-1)*10;
		}
		else
		{
			$offset=0;
		}
		
		if($roletype==3 || $roletype==5 || $roletype==9)//Super Users(3,5) & DHS Admin (9)
		{
			  $query="Select u.id,u.unit_name,s.section_name,d.division_name,a.agency_name,u.deleted,date_format(u.archive_date,'%m-%d-%Y')as 	
			  			archive_date,u.agency_id,u.division_id,u.section_id from tbl_unit u,tbl_section s,tbl_division d,tbl_agency a 
						where a.id=u.agency_id and d.id=u.division_id and s.id=u.section_id and u.deleted=0 order by a.agency_name,d.division_name,s.section_name,
						u.unit_name asc limit 10 offset ".$offset."";	
						
			$msg="<tr class='row_even'><th colspan='5' align='center'><img src='images/unit.gif'/></th></tr>";
			$table_header="<tr class='text_color'><th>Unit Name</th><th>Section Name</th><th>Division Name</th><th>Agency Name</th><th width='150px;'>Actions</th></tr>";
			$pg_index="<tr><td colspan='5' align='right'>";
		}
		if($roletype==21)//read-only admin
		{
			 $query="Select u.id,u.unit_name,s.section_name,d.division_name,a.agency_name,u.deleted,date_format(u.archive_date,'%m-%d-%Y')as 
			 			archive_date,u.agency_id,u.division_id,u.section_id from tbl_unit u,tbl_section s,tbl_division d,tbl_agency a 
						where a.id=u.agency_id and d.id=u.division_id and s.id=u.section_id and u.deleted=0 order by a.agency_name,d.division_name,s.section_name,
						u.unit_name asc limit 10 offset ".$offset."";	
						
			$msg="<tr class='row_even'><th colspan='5' align='center'><img src='images/unit.gif'/></th></tr>";
			$table_header="<tr class='text_color'><th>Unit Name</th><th>Section Name</th><th>Division Name</th><th>Agency Name</th></tr>";
			$pg_index="<tr><td colspan='5' align='right'>";
		}
		if($roletype==11)//agency admin
		{
			 $query="Select u.id,u.unit_name,s.section_name,d.division_name,u.deleted,date_format(u.archive_date,'%m-%d-%Y')as 
			 		archive_date,s.id,u.agency_id,u.division_id,u.section_id from tbl_unit u,tbl_section s,tbl_division d where u.agency_id='".$agency_id."' 
					and d.id=u.division_id and s.id=u.section_id and u.deleted=0 order by s.section_name,d.division_name limit 10 offset ".$offset."";		
					
			$msg="<tr class='row_even'><th colspan='4' align='center'><img src='images/unit.gif'/></th></tr><tr><td>&nbsp;</td></tr>";
			$table_header="<tr class='text_color'><th>Unit Name</th><th>Section Name</th><th>Division Name</th><th width='150px;'>Actions</th></tr>";
			$pg_index="<tr><td colspan='4' align='right'>";
		}
		
		
		
		if($_POST['actiontype']==="archivedunit")
	 	{
			if($roletype==3 || $roletype==5 || $roletype==9)//Super Users(3,5) & DHS Admin (9)
			{
				  $query="Select u.id,u.unit_name,s.section_name,d.division_name,a.agency_name,u.deleted,date_format(u.archive_date,'%m-%d-%Y')as 
				  			archive_date,u.agency_id,u.division_id,u.section_id from tbl_unit u,tbl_section s,tbl_division d,tbl_agency a 
						 where a.id=u.agency_id and d.id=u.division_id and s.id=u.section_id and u.deleted!=0 order by  a.agency_name limit 10  offset ".$offset."";	
				$msg="<tr class='row_even'><th colspan='5' align='center'><img src='images/unit.gif'/></th></tr>";
				$table_header="<tr class='text_color'><th>Unit Name</th><th>Section Name</th><th>Division Name</th><th>Agency Name</th><th>Archived Date</th><th width='150px;'>Actions</th></tr>";
				$pg_index="<tr><td colspan='5' align='right'>";
			}
			if($roletype==21)//read-only admin
			{
				  $query="Select u.id,u.unit_name,s.section_name,d.division_name,a.agency_name,u.deleted,date_format(u.archive_date,'%m-%d-%Y')as 	
				  		archive_date,u.agency_id,u.division_id,u.section_id from tbl_unit u,tbl_section s,tbl_division d,tbl_agency a 
						 where a.id=u.agency_id and d.id=u.division_id and s.id=u.section_id and u.deleted!=0 order by  a.agency_name limit 10  offset ".$offset."";	
				$msg="<tr class='row_even'><th colspan='5' align='center'><img src='images/unit.gif'/></th></tr>";
				$table_header="<tr class='text_color'><th>Unit Name</th><th>Section Name</th><th>Division Name</th><th>Agency Name</th><th>Archived Date</th></tr>";
				$pg_index="<tr><td colspan='5' align='right'>";
			}
			if($roletype==11)//agency admin
			{
				$query="Select u.id,u.unit_name,s.section_name,d.division_name,u.deleted,date_format(u.archive_date,'%m-%d-%Y')as 
						archive_date,u.agency_id,u.division_id,u.section_id from tbl_unit u,tbl_section s,tbl_division d where u.agency_id='".$agency_id."' 
						and d.id=u.division_id and s.id=u.section_id and u.deleted!=0 order by s.section_name,d.division_name limit 10 offset ".$offset."";		
				$msg="<tr class='row_even'><th colspan='4' align='center'><img src='images/unit.gif'/></th></tr><tr><td>&nbsp;</td></tr>";
				$table_header="<tr class='text_color'><th>Unit Name</th><th>Section Name</th><th>Division Name</th><th>Archived Date</th><th width='150px;'>Actions</th></tr>";
				$pg_index="<tr><td colspan='4' align='right'>";
			}		
			
		}

		$rs=mysql_query($query) or die(mysql_error);
		echo "<table width='80%' align='center'>";
		echo $msg;
		echo $table_header;
		$i=0;
		while($row=mysql_fetch_array($rs))
		{
			if($i%2==0)
			echo "<tr class='row-odd'>";	
			else
			echo "<tr class='row-even'>";
			if($_POST['actiontype']==="unit_view")
	 	    {
			if($roletype!=11)//Super Users(3,5) & DHS Admin (9)
			{
				echo "<td>".$row['1']."</td><td>".$row['2']."</td><td>".$row['3']."</td><td>".$row['4']."</td>";
				$deleted=$row['5'];
			}
			else
			{
				echo "<td>".$row['1']."</td><td>".$row['2']."</td><td>".$row['3']."</td>";
				$deleted=$row['4'];
			}
			}	
			if($_POST['actiontype']==="archivedunit")
	 	    {
			if($roletype!=11)//Super Users(3,5) & DHS Admin (9)
			{
				echo "<td>".$row['1']."</td><td>".$row['2']."</td><td>".$row['3']."</td><td>".$row['4']."</td><td>".$row['6']."</td>";
				$deleted=$row['5'];
			}
			else
			{
				echo "<td>".$row['1']."</td><td>".$row['2']."</td><td>".$row['3']."</td><td>".$row['5']."</td>";
				$deleted=$row['4'];
			}
		}	
if($roletype!=21)
{	
				echo '<td align="center">
					<form action="viewlayer.php" target="_self" style="display:inline;text-align:right;" method="POST">
					<input type="hidden" name="selid" value="'.$row['0'].'"/>
					<input type="hidden" name="selname" value="'.$row['1'].'"/>
					<input type="hidden" name="action" value="deleteunit"/>
					<input type="hidden" name="agencyname" value="'.$row['agency_id'].'"/>
					<input type="hidden" name="divisionname" value="'.$row['division_id'].'"/>
					<input type="hidden" name="sectionname" value="'.$row['section_id'].'"/>
					<input type="hidden" name="unitname" value="'.$row['1'].'"/>';
						
			//echo"<input type='hidden' name='actiontype' value='".$_POST['actiontype']."'/>";
				echo "<input type='hidden' name='deleted' value='".$deleted."' />";	
				if(isset($_POST['page_index']))
				{		
					echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";
				}
				if($deleted==0)
				{
				
					
				?>		
																																	
			<input type="submit" class="btn-archive-big big" value="" style="font-size: 11px;">

					<?php
					
				}
				else
				{
					echo "<input type='submit' class='btn-un-archive-big big' value='' style='font-size: 11px;'/>";
				}
				echo '</form>';
			
			if($_POST['action']=='viewlayer' || $_POST['actiontype']=='unit_view')
			{
				echo'<form action="viewlayer.php" target="_self" style="display:inline;text-align:right;" method="POST">
					<input type="hidden" name="selid" value="'.$row['0'].'"/>
					<input type="hidden" name="selname" value="'.$row['1'].'"/>	
					<input type="hidden" name="secid" value="'.$row['section_id'].'"/>
					<input type="hidden" name="divid" value="'.$row['division_id'].'"/>
					<input type="hidden" name="agency_id" value="'.$row['agency_id'].'"/>				
					<input type="hidden" name="action" value="editunit"/>';
//				echo "	<input type='hidden' name='actiontype' value='".$_POST['actiontype']."'/>";					
				if(isset($_POST['page_index']))
				{		
					echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";
				}
				
				echo "<input type='submit' class='btn-edit-big big' value='' style='font-size: 11px;'/>";
				
				echo "</form>";
			}
				echo"</td>";
}		}
			echo "</tr>";
			$i++;
	
	    echo'<tr><td>&nbsp;&nbsp;</td></tr>';
	
		echo $pg_index;
					
		$current_page=1;
			if(isset($_POST['page_index']))
			{
				$current_page=$_POST['page_index'];
			}
		
		for($i=1;$i<$tot_pages||$i==$tot_pages;$i++)
		{
			echo "<form action='viewlayer.php' target='_self' method='POST' name='page".$i."' style='display:inline;'>";
			echo "<input type='hidden' name='action' value='".$_POST['action']."'/>
			 <input type='hidden' name='actiontype' value='".$_POST['actiontype']."'/>";
			echo "<input type='hidden' name='page_index' value='".$i."'/> </form>";
			$name="page".$i;	

	if($current_page==$i)
	{
?>		<a href='#' class="pagecol" onclick='javascript:document.<?php echo $name;?>.submit();'><?php echo $i;?></a> |


<?php }
	else{
?>
		<a href='#' class="not_active" onclick='javascript:document.<?php echo $name;?>.submit();'><?php echo $i;?></a> |
<?php
		}
	 }
	echo "</td></tr></table>";
	echo "<center><form action=$SITE_ROOT/custom/home.php method=\"post\" style='display:inline;'>
			<input type=\"submit\" value=\"\" class=\"btn-go-back-big big\"/>
			</form></center>"; 
		if($roletype!=12 || $roletype!=13 || $roletype!=14 || $roletype!=15 || $roletype!=16)
		{	
			if($_POST['actiontype']==="unit_view")
			{
			
	?>		
			<form action='viewlayer.php' name="unitarchived"  method="post" target="_self"/>
			<input type="hidden" name="actiontype" value="archivedunit"/>
			<a href='#' onclick='javascript:document.unitarchived.submit();'>View Archive</a>
			</form>
			
			
			<?php
			}
			if($_POST['actiontype']==="archivedunit")
			{
			?>
			<form action='viewlayer.php' name="unitarchived"  method="post" target="_self"/>
			<input type="hidden" name="actiontype" value="unit_view"/>
			<a href='#' onclick='javascript:document.unitarchived.submit();'> Active</a>
			</form>
			
	<?php	
 		    }
			}
	}	
}
//Division Archive/Un- Archive
//var_dump($_POST);		
if(isset($_POST['action']) && $_POST['action']==="deletediv")
{
	$name="\"".mysql_real_escape_string($_POST['selname'])."\"";
			$query="select count(up.user_id) from ".$prefix."user_profiles up,".$prefix."lms_users lu where up.profile_value='".$name."' 
						and up.profile_key='profile.division' and lu.user_id=up.user_id and lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15)";
			$rs=mysql_query($query) or die(mysql_error);
			while($row=mysql_fetch_array($rs))
			{

				 $tot_users=$row['0'];
			}

			$tot_pages=ceil($tot_users/10);

			if(isset($_POST['move_page_index']) && $_POST['move_page_index']>1)

			{
				$offset=(htmlspecialchars($_POST['move_page_index'])-1)*10;

			}

			else
			{

				$offset=0;
			}
								
			$query="select up.user_id,concat(u.name,' ',u.middle_name,' ',u.last_name)as name from ".$prefix."user_profiles up,".$prefix."users u,".$prefix."lms_users lu

					where up.profile_value='".$name."' and up.profile_key='profile.division' and lu.user_id=up.user_id and 

					lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15) and up.user_id=u.id limit 10 offset ".$offset."";

			$rs=mysql_query($query) or die(mysql_error);

			$count=mysql_num_rows($rs);
			

  if($count==0 || $count>=0)
  {	

	if($_POST['deleted']==0)
		{
			echo "<p style='text-align:center; font-weight:bold;'>Are you sure you want to archive Division \"".$_POST['selname']."\"</p>";	
		}
		else
		{
			echo "<p style='text-align:center; font-weight:bold;'>Are you sure you want to un-archive Division \"".$_POST['selname']."\"</p>";	
		}
	
		
		echo '<center>
			<form action="viewlayer.php" target="_self" style="display:inline;text-align:center;" method="POST">
				<input type="hidden" name="name" value="'.$_POST['selname'].'"/>
				<input type="hidden" name="cnfrm_action" value="'.$_POST['action'].'"/>
				<input type="hidden" name="cnfrm_selid" value="'.$_POST['selid'].'"/>
				<input type="hidden" name="deleted" value="'.$_POST['deleted'].'"/>';
				echo'<input type="hidden" name="agencynamenew" value="'.$_POST['agencyname'].'"/>';
				echo'<input type="hidden" name="divisionname" value="'.$_POST['divisionname'].'"/>';
		echo "	<input type='submit' class='btn-yes-big big' value='' style='font-size: 11px;'/>
			</form>
			<form action='viewlayer.php' target='_self' style='display:inline;text-align:center;' method='POST'>
				<input type='hidden' name='action' value='viewlayer'/>
				<input type='hidden' name='actiontype' value='division_view'/>";				
		if(isset($_POST['page_index']))
		{		
			echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";
		}	
			echo "<input type='submit' class='btn-cancel-big big' value='' style='font-size: 11px;'/>
			</form>
			</center>
			";
}//count end

}

if(isset($_POST['actionyes']) && $_POST['actionyes']=="deletediv")
{

  if($_POST['deleted']==0)
	
	{
			 $agencynames=mysql_real_escape_string($_POST['agencynamenews']);
			 
			 $name="\"".mysql_real_escape_string($_POST['divisionnews'])."\"";
			 
			 /*$query="select count(up.user_id) from ".$prefix."user_profiles up,".$prefix."lms_users lu where up.profile_value='".$name."' 
						and up.profile_key='profile.agency' and lu.user_id=up.user_id and lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15)";*/

					
  $query="select count(up.user_id),concat(u.name,' ',u.middle_name,' ',u.last_name)as name from ".$prefix."user_profiles up,".$prefix."users u,".$prefix."lms_users lu where
		
		  up.profile_value='".$name."' and up.profile_key='profile.division' and lu.user_id=up.user_id and lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15) 
				 
			  and u.block='0' and up.user_id=u.id and  u.id in (select user_id from ".$prefix."user_profiles where profile_key='profile.agency' and 
			  
			  			profile_value like '%".$agencynames."%')";
					
			$rs=mysql_query($query) or die(mysql_error);			
			
			while($row=mysql_fetch_array($rs))
			{

				 $tot_users=$row['0'];
			}

			$tot_pages=ceil($tot_users/10);

			if(isset($_POST['page_index']) && $_POST['page_index']>1)
			{
				$offset=(htmlspecialchars($_POST['page_index'])-1)*10;

			}

			else
			{

				$offset=0;
			}
			
							
	  $query="select up.user_id,concat(u.name,' ',u.middle_name,' ',u.last_name)as name from ".$prefix."user_profiles up,".$prefix."users u,".$prefix."lms_users lu where
		
		  up.profile_value='".$name."' and up.profile_key='profile.division' and lu.user_id=up.user_id and lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15) 
				 
			  and u.block='0' and up.user_id=u.id and  u.id in (select user_id from ".$prefix."user_profiles where profile_key='profile.agency' and 
			  
			  			profile_value like '%".$agencynames."%') limit 10 offset ".$offset."";	

			$rs=mysql_query($query) or die(mysql_error);

			 $count=mysql_num_rows($rs);
			//$count_division=$count;
if($count>=0)
{

			echo "<table width='60%' align='center'><tr><th colspan='2' align='center'>Move Users from Division '".$_POST['selname']."'</th></tr>";
			
			echo "<tr class='text_color'><th>Name</th><th width='150px;' align='center'>Actions</th></tr>";
			
			$i=0;

			while($row=mysql_fetch_array($rs))
			{

				if($i%2==0)
				
				echo "<tr class='row-odd'>";
				else                     
				
				echo "<tr class='row-even'>";
				echo '<td>"'.$row['1'].'"</td>
				<td align="center"><form action="viewlayer.php" target="_self" style="display:inline;text-align:center;" method="POST">
					<input type="hidden" name="selid" value="'.$row['0'].'"/>
					<input type="hidden" name="selname" value="'.$row['1'].'"/>	
					<input type="hidden" name="divisionnames" value="'.$_POST['divisionnews'].'"/>					
					<input type="hidden" name="actiondiv" value="moveuser"/>';
				if(isset($_POST['page_index']))

				{		
					echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";
				}

				if(isset($_POST['move_page_index']))

				{	
					echo "<input type='hidden' name='move_page_index' value='".$_POST['move_page_index']."'/>";

				}

				echo "<input type='submit' class='btn-move-big big' value='' style='font-size: 11px;'/>";
				echo "</form></td>";

				echo "</tr>";
				$i++;

			}	
		
			echo "<tr><td colspan='2' align='right'>";
			
			$current_page=1;
			
				if(isset($_POST['page_index']))
				{
					$current_page=$_POST['page_index'];
				}
		
			for($i=1;$i<$tot_pages||$i==$tot_pages;$i++)
			{
			   echo "<form action='viewlayer.php' target='_self' method='POST' name='page".$i."' style='display:inline;'>";
						echo '<input type="hidden" name="selid" value="'.$_POST['selid'].'"/>
						<input type="hidden" name="actionyes" value="deletediv"/>					
						<input type="hidden" name="selname" value="'.$_POST['selname'].'"/>
						<input type="hidden" name="divisionnews" value="'.$_POST['divisionnews'].'"/>
						<input type="hidden" name="actionyest" value="0"/>
						<input type="hidden" name="agencynamenew" value="'.$_POST['agencynamenews'].'"/>';
						echo "<input type='hidden' name='page_index' value='".$i."'/> 
				</form>";
				$name="page".$i;	

if($current_page==$i)
	{
?>		<a href='#' class="pagecol" onclick='javascript:document.<?php echo $name;?>.submit();'><?php echo $i;?></a> |


<?php }
	else{
?>
		<a href='#' class="not_active" onclick='javascript:document.<?php echo $name;?>.submit();'><?php echo $i;?></a> |
<?php
		}
	 }
			echo "</td></tr></table>";
			
			echo "<center><table<td><form action='viewlayer.php' target='_self' style='display:inline;text-align:center;' method='POST'>";	

		echo"<input type='hidden' name='action' value='viewlayer'/>
				<input type='hidden' name='actiontype' value='division_view'/>";	

		if(isset($_POST['page_index']))
		{	
			echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";

		}
		echo "<input type='submit' class='btn-cancel-big big' value='' style='font-size: 11px;'/>

			</form></td></table></center>
			";
		}

			echo "<center>";//to align cancel button to center
			
		}
	}
//Section Archive/un-Archive
if(isset($_POST['action']) && $_POST['action']==="deletesec")
{
	$name="\"".mysql_real_escape_string($_POST['selname'])."\"";
			$query="select count(up.user_id) from ".$prefix."user_profiles up,".$prefix."lms_users lu where up.profile_value='".$name."' 
						and up.profile_key='profile.section' and lu.user_id=up.user_id and lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15)";
			$rs=mysql_query($query) or die(mysql_error);
			while($row=mysql_fetch_array($rs))
			{

				$tot_users=$row['0'];
			}

			$tot_pages=ceil($tot_users/10);

			if(isset($_POST['move_page_index']) && $_POST['move_page_index']>1)

			{
				$offset=(htmlspecialchars($_POST['move_page_index'])-1)*10;

			}

			else
			{

				$offset=0;
			}
								
			$query="select up.user_id,concat(u.name,' ',u.middle_name,' ',u.last_name)as name from ".$prefix."user_profiles up,".$prefix."users u,".$prefix."lms_users lu

					where up.profile_value='".$name."' and up.profile_key='profile.section' and lu.user_id=up.user_id and 

					lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15) and up.user_id=u.id limit 10 offset ".$offset."";

			$rs=mysql_query($query) or die(mysql_error);

			$count=mysql_num_rows($rs);
			

if($count==0 || $count>=0)
  {	

	if($_POST['deleted']==0)
		{
			echo "<p style='text-align:center; font-weight:bold;'>Are you sure you want to archive Section \"".$_POST['selname']."\"</p>";	
		}
		else
		{
			echo "<p style='text-align:center; font-weight:bold;'>Are you sure you want to un-archive Section \"".$_POST['selname']."\"</p>";	
		}
	
		
		echo '<center>
			<form action="viewlayer.php" target="_self" style="display:inline;text-align:center;" method="POST">
				<input type="hidden" name="name" value="'.$_POST['selname'].'"/>
				<input type="hidden" name="cnfrm_action" value="'.$_POST['action'].'"/>
				<input type="hidden" name="cnfrm_selid" value="'.$_POST['selid'].'"/>
				<input type="hidden" name="deleted" value="'.$_POST['deleted'].'"/>';
				echo'<input type="hidden" name="agencynamenew" value="'.$_POST['agencyname'].'"/>';
				echo'<input type="hidden" name="divisionname" value="'.$_POST['divisionname'].'"/>';
			 echo'<input type="hidden" name="sectionnamenew" value="'.$_POST['sectionname'].'"/>';
		echo "	<input type='submit' class='btn-yes-big big' value='' style='font-size: 11px;'/>
			</form>
			<form action='viewlayer.php' target='_self' style='display:inline;text-align:center;' method='POST'>
				<input type='hidden' name='action' value='viewlayer'/>
				<input type='hidden' name='actiontype' value='section_view'/>";				
		if(isset($_POST['page_index']))
		{		
			echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";
		}	
			echo "<input type='submit' class='btn-cancel-big big' value='' style='font-size: 11px;'/>
			</form>
			</center>
			";
}//count end

}
if(isset($_POST['sectionyes']) && $_POST['sectionyes']==="deletesec")
{


if($_POST['deleted']==0)
	
	{
			$name="\"".mysql_real_escape_string($_POST['sectionnews'])."\"";
			
			$agencynames=mysql_real_escape_string($_POST['agencynamenews']);
						 
 $query="select count(up.user_id),concat(u.name,' ',u.middle_name,' ',u.last_name)as name from ".$prefix."user_profiles up,".$prefix."users u,".$prefix."lms_users lu where
		
		  up.profile_value='".$name."' and up.profile_key='profile.section' and lu.user_id=up.user_id and lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15) 
				 
			  and u.block='0' and up.user_id=u.id and  u.id in (select user_id from ".$prefix."user_profiles where profile_key='profile.agency' and 
			  
			  			profile_value like '%".$agencynames."%')";

			$rs=mysql_query($query) or die(mysql_error);
			while($row=mysql_fetch_array($rs))
			{

				 $tot_users=$row['0'];
			}

			 $tot_pages=ceil($tot_users/10);

			if(isset($_POST['page_index']) && $_POST['page_index']>1)

			{
				$offset=(htmlspecialchars($_POST['page_index'])-1)*10;

			}

			else
			{

				$offset=0;
			}
								
		 $query="select up.user_id,concat(u.name,' ',u.middle_name,' ',u.last_name)as name from ".$prefix."user_profiles up,".$prefix."users u,".$prefix."lms_users lu where
		
		  up.profile_value='".$name."' and up.profile_key='profile.section' and lu.user_id=up.user_id and lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15) 
				 
			  and u.block='0' and up.user_id=u.id and  u.id in (select user_id from ".$prefix."user_profiles where profile_key='profile.agency' and 
			  
			  			profile_value like '%".$agencynames."%') limit 10 offset ".$offset."";

			$rs=mysql_query($query) or die(mysql_error);

			 $count=mysql_num_rows($rs);
			
if($count>=0)
{

			echo "<table width='60%' align='center'><tr><th colspan='2' align='center'>Move Users from Section '".$_POST['selname']."'</th></tr>";
			
			echo "<tr class='text_color'><th>Name</th><th width='150px;' align='center'>Actions</th></tr>";
			
			$i=0;

			while($row=mysql_fetch_array($rs))
			{

				if($i%2==0)

				echo "<tr class='row-odd'>";
				else                     

				echo "<tr class='row-even'>";
				echo '<td>"'.$row['1'].'"</td>
				<td align="center"><form action="viewlayer.php" target="_self" style="display:inline;text-align:center;" method="POST">
					<input type="hidden" name="selid" value="'.$row['0'].'"/>
					<input type="hidden" name="selname" value="'.$row['1'].'"/>	
					<input type="hidden" name="divisionnames" value="'.$_POST['divisionnews'].'"/>	
					<input type="hidden" name="sectionnames" value="'.$_POST['sectionnews'].'"/>	
					<input type="hidden" name="actionsec" value="moveuser"/>';
				if(isset($_POST['page_index']))

				{		
					echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";
				}

				if(isset($_POST['page_index']))

				{	
					echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";

				}

				echo "<input type='submit' class='btn-move-big big' value='' style='font-size: 11px;'/>";
				echo "</form></td>";

				echo "</tr>";
				$i++;

			}
	
		
			echo "<tr><td colspan='2' align='right'>";
			
			$current_page=1;
			
				if(isset($_POST['page_index']))
				{
					$current_page=$_POST['page_index'];
				}
			
			for($i=1;$i<$tot_pages||$i==$tot_pages;$i++)
			{

				echo "<form action='viewlayer.php' target='_self' method='POST' name='page".$i."' style='display:inline;'>";

				echo'<input type="hidden" name="selid" value="'.$_POST['selid'].'"/>					
					<input type="hidden" name="selname" value="'.$_POST['selname'].'"/>
					<input type="hidden" name="sectionyes" value="'.$_POST['sectionyes'].'"/>
					<input type="hidden" value="deletesec" name="sectionyes">';
					echo'<input type="hidden" name="agencynamenews" value="'.$_POST['agencynamenews'].'"/>';
					echo'<input type="hidden" name="divisionnews" value="'.$_POST['divisionnews'].'"/>';
			    echo'<input type="hidden" name="sectionnews" value="'.$_POST['sectionnews'].'"/>';

				echo "<input type='hidden' name='page_index' value='".$i."'/> </form>";
				 $name="page".$i;	

if($current_page==$i)
	{
?>		<a href='#' class="pagecol" onclick='javascript:document.<?php echo $name;?>.submit();'><?php echo $i;?></a> |


<?php }
	else{
?>
		<a href='#' class="not_active" onclick='javascript:document.<?php echo $name;?>.submit();'><?php echo $i;?></a> |
<?php
		}
	 }
			echo "</td></tr></table>";
			
			echo "<center><table<td><form action='viewlayer.php' target='_self' style='display:inline;text-align:center;' method='POST'>";	

		echo"<input type='hidden' name='action' value='viewlayer'/>
				<input type='hidden' name='actiontype' value='section_view'/>";	

		if(isset($_POST['page_index']))
		{	
			echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";

		}
		echo "<input type='submit' class='btn-cancel-big big' value='' style='font-size: 11px;'/>

			</form></td></table></center>
			";
		}

			echo "<center>";//to align cancel button to center
			
		}
	}
//Unit Archive/un-Archive
if(isset($_POST['action']) && $_POST['action']==="deleteunit")
{
	$name="\"".mysql_real_escape_string($_POST['selname'])."\"";
			$query="select count(up.user_id) from ".$prefix."user_profiles up,".$prefix."lms_users lu where up.profile_value='".$name."' 
						and up.profile_key='profile.unit' and lu.user_id=up.user_id and lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15)";
			$rs=mysql_query($query) or die(mysql_error);
			while($row=mysql_fetch_array($rs))
			{

				$tot_users=$row['0'];
			}

			$tot_pages=ceil($tot_users/10);

			if(isset($_POST['move_page_index']) && $_POST['move_page_index']>1)

			{
				$offset=(htmlspecialchars($_POST['move_page_index'])-1)*10;

			}

			else
			{

				$offset=0;
			}

			 $query="select up.user_id,concat(u.name,' ',u.middle_name,' ',u.last_name)as name from ".$prefix."user_profiles up,".$prefix."users u,".$prefix."lms_users lu

					where up.profile_value='".$name."' and up.profile_key='profile.unit' and lu.user_id=up.user_id and 

					lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15) and up.user_id=u.id limit 10 offset ".$offset."";

			$rs=mysql_query($query) or die(mysql_error);

			$count=mysql_num_rows($rs);
			

  if($count==0 || $count>=0)
  {	

	if($_POST['deleted']==0)
		{
			echo "<p style='text-align:center; font-weight:bold;'>Are you sure you want to archive Unit \"".$_POST['selname']."\"</p>";	
		}
		else
		{
			echo "<p style='text-align:center; font-weight:bold;'>Are you sure you want to un-archive Unit \"".$_POST['selname']."\"</p>";	
		}
	
		
		echo '<center>
			<form action="viewlayer.php" target="_self" style="display:inline;text-align:center;" method="POST">
				<input type="hidden" name="name" value="'.$_POST['selname'].'"/>
				<input type="hidden" name="cnfrm_action" value="'.$_POST['action'].'"/>
				<input type="hidden" name="cnfrm_selid" value="'.$_POST['selid'].'"/>
				<input type="hidden" name="deleted" value="'.$_POST['deleted'].'"/>';
		   echo'<input type="hidden" name="agencynamenew" value="'.$_POST['agencyname'].'"/>';
		    echo'<input type="hidden" name="divisionname" value="'.$_POST['divisionname'].'"/>';
			 echo'<input type="hidden" name="sectionnamenew" value="'.$_POST['sectionname'].'"/>';
			  echo'<input type="hidden" name="unitnamenew" value="'.$_POST['unitname'].'"/>';
		echo "	<input type='submit' class='btn-yes-big big' value='' style='font-size: 11px;'/>
			</form>
			<form action='viewlayer.php' target='_self' style='display:inline;text-align:center;' method='POST'>
				<input type='hidden' name='action' value='viewlayer'/>
				<input type='hidden' name='actiontype' value='unit_view'/>";				
		if(isset($_POST['page_index']))
		{		
			echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";
		}	
			echo "<input type='submit' class='btn-cancel-big big' value='' style='font-size: 11px;'/>
			</form>
			</center>
			";
}//count end

}
if(isset($_POST['actions']) && $_POST['unityes']==="deleteunit")
{

	
	
	if($_POST['deleted']==0)
	
	{
			$name="\"".mysql_real_escape_string($_POST['unitnews'])."\"";
			
			$agencynames=mysql_real_escape_string($_POST['agencynamenews']);
			/*$query="select count(up.user_id) from ".$prefix."user_profiles up,".$prefix."lms_users lu where up.profile_value='".$name."' 
						and up.profile_key='profile.agency'  and lu.user_id=up.user_id and lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15)";*/
	$query="select count(up.user_id),concat(u.name,' ',u.middle_name,' ',u.last_name)as name from ".$prefix."user_profiles up,".$prefix."users u,".$prefix."lms_users lu where
		
		  up.profile_value='".$name."' and up.profile_key='profile.unit' and lu.user_id=up.user_id and lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15) 
				 
			  and u.block='0' and up.user_id=u.id and  u.id in (select user_id from ".$prefix."user_profiles where profile_key='profile.agency' and 
			  
			  			profile_value like '%".$agencynames."%')";
			$rs=mysql_query($query) or die(mysql_error);
			while($row=mysql_fetch_array($rs))
			{

				$tot_users=$row['0'];
			}

			$tot_pages=ceil($tot_users/10);

			if(isset($_POST['page_index']) && $_POST['page_index']>1)

			{
				$offset=(htmlspecialchars($_POST['page_index'])-1)*10;

			}

			else
			{

				$offset=0;
			}

	 $query="select up.user_id,concat(u.name,' ',u.middle_name,' ',u.last_name)as name from ".$prefix."user_profiles up,".$prefix."users u,".$prefix."lms_users lu where
		
		  up.profile_value='".$name."' and up.profile_key='profile.unit' and lu.user_id=up.user_id and lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15) 
				 
			  and u.block='0' and up.user_id=u.id and  u.id in (select user_id from ".$prefix."user_profiles where profile_key='profile.agency' and 
			  
			  			profile_value like '%".$agencynames."%') limit 10 offset ".$offset."";

			$rs=mysql_query($query) or die(mysql_error);

			$count=mysql_num_rows($rs);
			
if($count>=0)
{

			echo "<table width='60%' align='center'><tr><th colspan='2' align='center'>Move Users from Unit '".$_POST['selname']."'</th></tr>";
			
			echo "<tr class='text_color'><th>Name</th><th width='150px;' align='center'>Actions</th></tr>";
			
			$i=0;

			while($row=mysql_fetch_array($rs))
			{

				if($i%2==0)

				echo "<tr class='row-odd'>";
				else                     

				echo "<tr class='row-even'>";
				echo '<td>"'.$row['1'].'"</td>
				<td align="center"><form action="viewlayer.php" target="_self" style="display:inline;text-align:center;" method="POST">
					<input type="hidden" name="selid" value="'.$row['0'].'"/>
					<input type="hidden" name="selname" value="'.$row['1'].'"/>	
					<input type="hidden" name="agencynames" value="'.$_POST['agencynamenews'].'"/>	
					<input type="hidden" name="divisionnames" value="'.$_POST['divisionnews'].'"/>	
					<input type="hidden" name="sectionnames" value="'.$_POST['sectionnews'].'"/>	
					<input type="hidden" name="unitnames" value="'.$_POST['unitnews'].'"/>	
					<input type="hidden" name="actionunit" value="moveuser"/>';
				if(isset($_POST['page_index']))

				{		
					echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";
				}

				if(isset($_POST['page_index']))

				{	
					echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";

				}

				echo "<input type='submit' class='btn-move-big big' value='' style='font-size: 11px;'/>";
				echo "</form></td>";

				echo "</tr>";
				$i++;

			}
	
		
			echo "<tr><td colspan='2' align='right'>";
			
			$current_page=1;
			
				if(isset($_POST['page_index']))
				{
					$current_page=$_POST['page_index'];
				}
			
			for($i=1;$i<$tot_pages||$i==$tot_pages;$i++)
			{

				echo "<form action='viewlayer.php' target='_self' method='POST' name='page".$i."' style='display:inline;'>";

				echo'<input type="hidden" name="selid" value="'.$_POST['selid'].'"/>					
					<input type="hidden" name="selname" value="'.$_POST['selname'].'"/>					
					<input type="hidden" name="unityes" value="deleteunit"/>
					<input type="hidden" name="actions" value="'.$_POST['actions'].'"/>';
			  echo'<input type="hidden" name="agencynamenews" value="'.$_POST['agencynamenews'].'"/>';
			   echo'<input type="hidden" name="divisionnews" value="'.$_POST['divisionnews'].'"/>';
			    echo'<input type="hidden" name="sectionnews" value="'.$_POST['sectionnews'].'"/>';
				 echo'<input type="hidden" name="unitnews" value="'.$_POST['unitnews'].'"/>';
				 
				echo "<input type='hidden' name='page_index' value='".$i."'/> </form>";
				$name="page".$i;	

if($current_page==$i)
	{
?>		<a href='#' class="pagecol" onclick='javascript:document.<?php echo $name;?>.submit();'><?php echo $i;?></a> |


<?php }
	else{
?>
		<a href='#' class="not_active" onclick='javascript:document.<?php echo $name;?>.submit();'><?php echo $i;?></a> |
<?php
		}
	 }
			echo "</td></tr></table>";
			
			echo "<center><table<td><form action='viewlayer.php' target='_self' style='display:inline;text-align:center;' method='POST'>";	

		echo"<input type='hidden' name='action' value='viewlayer'/>
				<input type='hidden' name='actiontype' value='unit_view'/>";	

		if(isset($_POST['page_index']))
		{	
			echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";

		}
		echo "<input type='submit' class='btn-cancel-big big' value='' style='font-size: 11px;'/>

			</form></td></table></center>
			";
		}

			echo "<center>";//to align cancel button to center
			
		}
	}

if(isset($_POST['cnfrm_action']) && $_POST['cnfrm_action']==="deletediv")
{
	if($_POST['deleted']==0)
	{
		$query="update tbl_division set deleted='1',archive_date='".$todaydate."' where division_name='".mysql_real_escape_string($_POST['name'])."' 
				and id='".$_POST['cnfrm_selid']."' and deleted='0'";
				
		$success_msg="<p align='center'>Division \"".$_POST['name']."\" has been archived</p>";
		$failure_msg="<p align='center'>Division \"".$_POST['name']."\" has not been archived</p>";
	}
	else
	{
		$query="update tbl_division set deleted='0' where division_name='".mysql_real_escape_string($_POST['name'])."' and id='".$_POST['cnfrm_selid']."' and deleted='1'";
		$success_msg="<p align='center'>Division \"".$_POST['name']."\" has been un-archived</p>";
		$failure_msg="<p align='center'>Division \"".$_POST['name']."\" has not been un-archived</p>";
	}
	$result=mysql_query($query) or die(mysql_error);
	if($result==1)
	{
		$_SESSION['action_message']=$success_msg;
	}
	else
	{
		$_SESSION['action_message']=$failure_msg;
	}
	$name="\"".mysql_real_escape_string($_POST['name'])."\"";
			 $query="select count(up.user_id) from ".$prefix."user_profiles up,".$prefix."lms_users lu where up.profile_value='".$name."' 
						and up.profile_key='profile.division' and lu.user_id=up.user_id and lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15)";
			$rs=mysql_query($query) or die(mysql_error);
			while($row=mysql_fetch_array($rs))
			{

				 $tot_users=$row['0'];
			}

			$tot_pages=ceil($tot_users/10);

			if(isset($_POST['move_page_index']) && $_POST['move_page_index']>1)

			{
				$offset=(htmlspecialchars($_POST['move_page_index'])-1)*10;

			}

			else
			{

				$offset=0;
			}
								
			 $query="select up.user_id,concat(u.name,' ',u.middle_name,' ',u.last_name)as name from ".$prefix."user_profiles up,".$prefix."users u,".$prefix."lms_users lu

					where up.profile_value='".$name."' and up.profile_key='profile.division' and lu.user_id=up.user_id and 

					lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15) and up.user_id=u.id limit 10 offset ".$offset."";

			$rs=mysql_query($query) or die(mysql_error);

			 $count=mysql_num_rows($rs);
 if($count>=0)
  {	

	if($_POST['deleted']==0)
		{
			echo "<p style='text-align:center; font-weight:bold;'>Do you want to Move Users from Division \"".$_POST['name']."\"</p>";	
		}
		else
		{
			echo "<p style='text-align:center; font-weight:bold;'>Do you want to Move Users from Division \"".$_POST['name']."\"</p>";	
		}
	
		
		echo '<center>
			<form action="viewlayer.php" target="_self" style="display:inline;text-align:center;" method="POST">			
				
				<input type="hidden" name="selid" value="'.$_POST['cnfrm_selid'].'"/>					
					<input type="hidden" name="selname" value="'.$_POST['name'].'"/>
					<input type="hidden" name="actionyest" value="'.$_POST['deleted'].'"/>
					<input type="hidden" name="actionyes" value="deletediv"/>';
					 echo'<input type="hidden" name="agencynamenews" value="'.$_POST['agencynamenew'].'"/>';
					 echo'<input type="hidden" name="divisionnews" value="'.$_POST['divisionname'].'"/>';
		echo "	<input type='submit' class='btn-yes-big big' value='' style='font-size: 11px;'/>
			</form>
			<form action='viewlayer.php' target='_self' style='display:inline;text-align:center;' method='POST'>
				<input type='hidden' name='action' value='viewlayer'/>
				<input type='hidden' name='actiontype' value='division_view'/>";				
		if(isset($_POST['page_index']))
		{		
			echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";
		}	
			echo "<input type='submit' class='btn-cancel-big big' value='' style='font-size: 11px;'/>
			</form>
			</center>
			";
   }//count end
}
if(isset($_POST['cnfrm_action']) && $_POST['cnfrm_action']==="deletesec")
{
	if($_POST['deleted']==0)
	{
		$query="update tbl_section set deleted='1',archive_date='".$todaydate."' where section_name='".mysql_real_escape_string($_POST['name'])."' 
					and id='".$_POST['cnfrm_selid']."' and deleted='0'";
					
		$success_msg="<p align='center'>Section \"".$_POST['name']."\" has been archived</p>";
		$failure_msg="<p align='center'>Section \"".$_POST['name']."\" has not been archived</p>";
	}
	else
	{
		$query="update tbl_section set deleted='0' where section_name='".mysql_real_escape_string($_POST['name'])."' and id='".$_POST['cnfrm_selid']."' and deleted='1'";
		$success_msg="<p align='center'>Section \"".$_POST['name']."\" has been un-archived</p>";
		$failure_msg="<p align='center'>Section \"".$_POST['name']."\" has not been un-archived</p>";
	}
	$result=mysql_query($query) or die(mysql_error);
	
	if($result==1)
	{
		$_SESSION['action_message']=$success_msg;
	}
	else
	{
		$_SESSION['action_message']=$failure_msg;
	}
			
			$name="\"".mysql_real_escape_string($_POST['selname'])."\"";
			$query="select count(up.user_id) from ".$prefix."user_profiles up,".$prefix."lms_users lu where up.profile_value='".$name."' 
						and up.profile_key='profile.section' and lu.user_id=up.user_id and lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15)";
			$rs=mysql_query($query) or die(mysql_error);
			while($row=mysql_fetch_array($rs))
			{

				$tot_users=$row['0'];
			}

			$tot_pages=ceil($tot_users/10);

			if(isset($_POST['move_page_index']) && $_POST['move_page_index']>1)

			{
				$offset=(htmlspecialchars($_POST['move_page_index'])-1)*10;

			}

			else
			{

				$offset=0;
			}
								
			$query="select up.user_id,concat(u.name,' ',u.middle_name,' ',u.last_name)as name from ".$prefix."user_profiles up,".$prefix."users u,".$prefix."lms_users lu

					where up.profile_value='".$name."' and up.profile_key='profile.section' and lu.user_id=up.user_id and 

					lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15) and up.user_id=u.id limit 10 offset ".$offset."";

			$rs=mysql_query($query) or die(mysql_error);

			$count=mysql_num_rows($rs);
	
  if($count>=0)
  {	

		if($_POST['deleted']==0)
		{
			echo "<p style='text-align:center; font-weight:bold;'>Do you want to Move Users from Section \"".$_POST['name']."\"</p>";	
		}
		else
		{
			echo "<p style='text-align:center; font-weight:bold;'>Do you want to Move Users from Section \"".$_POST['name']."\"</p>";	
		}	
		
		echo '<center>
			<form action="viewlayer.php" target="_self" style="display:inline;text-align:center;" method="POST">			
				
				<input type="hidden" name="selid" value="'.$_POST['cnfrm_selid'].'"/>					
					<input type="hidden" name="selname" value="'.$_POST['name'].'"/>
					<input type="hidden" name="sectionyes" value="'.$_POST['deleted'].'"/>
					<input type="hidden" name="sectionyes" value="deletesec"/>';
					echo'<input type="hidden" name="agencynamenews" value="'.$_POST['agencynamenew'].'"/>';
					echo'<input type="hidden" name="divisionnews" value="'.$_POST['divisionname'].'"/>';
			    echo'<input type="hidden" name="sectionnews" value="'.$_POST['sectionnamenew'].'"/>';
		echo "	<input type='submit' class='btn-yes-big big' value='' style='font-size: 11px;'/>
			</form>
			<form action='viewlayer.php' target='_self' style='display:inline;text-align:center;' method='POST'>
				<input type='hidden' name='action' value='viewlayer'/>
				<input type='hidden' name='actiontype' value='section_view'/>";
		if(isset($_POST['page_index']))
		{		
			echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";
		}	
			echo "<input type='submit' class='btn-cancel-big big' value='' style='font-size: 11px;'/>
			</form>
			</center>";
   }//count end

}
if(isset($_POST['cnfrm_action']) && $_POST['cnfrm_action']==="deleteunit")
{
	if($_POST['deleted']==0)
	{
		$query="update tbl_unit set deleted='1',archive_date='".$todaydate."' where unit_name='".mysql_real_escape_string($_POST['name'])."' and id='".$_POST['cnfrm_selid']."' and deleted='0'";
		$success_msg="<p align='center'>Unit \"".$_POST['name']."\" has been archived</p>";
		$failure_msg="<p align='center'>Unit \"".$_POST['name']."\" has not been archived</p>";
	}
	else
	{
		$query="update tbl_unit set deleted='0' where unit_name='".mysql_real_escape_string($_POST['name'])."' and id='".$_POST['cnfrm_selid']."' and deleted='1'";
		$success_msg="<p align='center'>Unit \"".$_POST['name']."\" has been un-archived</p>";
		$failure_msg="<p align='center'>Unit \"".$_POST['name']."\" has not been un-archived</p>";
	}
	$result=mysql_query($query) or die(mysql_error);
	
	if($result==1)
	{
		$_SESSION['action_message']=$success_msg;
	}
	else
	{
		$_SESSION['action_message']=$failure_msg;
	}
	
	$name="\"".mysql_real_escape_string($_POST['selname'])."\"";
			$query="select count(up.user_id) from ".$prefix."user_profiles up,".$prefix."lms_users lu where up.profile_value='".$name."' 
						and up.profile_key='profile.unit' and lu.user_id=up.user_id and lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15)";
			$rs=mysql_query($query) or die(mysql_error);
			while($row=mysql_fetch_array($rs))
			{

				$tot_users=$row['0'];
			}

			$tot_pages=ceil($tot_users/10);

			if(isset($_POST['move_page_index']) && $_POST['move_page_index']>1)

			{
				$offset=(htmlspecialchars($_POST['move_page_index'])-1)*10;

			}

			else
			{

				$offset=0;
			}

			$query="select up.user_id,concat(u.name,' ',u.middle_name,' ',u.last_name)as name from ".$prefix."user_profiles up,".$prefix."users u,".$prefix."lms_users lu

					where up.profile_value='".$name."' and up.profile_key='profile.unit' and lu.user_id=up.user_id and 

					lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15) and up.user_id=u.id limit 10 offset ".$offset."";

			$rs=mysql_query($query) or die(mysql_error);

			$count=mysql_num_rows($rs);
	 
  if($count>=0)
  {	

	if($_POST['deleted']==0)
		{
			echo "<p style='text-align:center; font-weight:bold;'>Do you want to Move Users from Unit \"".$_POST['name']."\"</p>";	
		}
		else
		{
			echo "<p style='text-align:center; font-weight:bold;'>Do you want to Move Users from Unit \"".$_POST['name']."\"</p>";	
		}
	
		
		echo '<center>
			<form action="viewlayer.php" target="_self" style="display:inline;text-align:center;" method="POST">			
				
				<input type="hidden" name="selid" value="'.$_POST['cnfrm_selid'].'"/>					
					<input type="hidden" name="selname" value="'.$_POST['name'].'"/>
					<input type="hidden" name="unityes" value="'.$_POST['deleted'].'"/>
					<input type="hidden" name="unityes" value="deleteunit"/>
					<input type="hidden" name="actions" value="'.$_POST['cnfrm_action'].'"/>';
			  echo'<input type="hidden" name="agencynamenews" value="'.$_POST['agencynamenew'].'"/>';
			   echo'<input type="hidden" name="divisionnews" value="'.$_POST['divisionname'].'"/>';
			    echo'<input type="hidden" name="sectionnews" value="'.$_POST['sectionnamenew'].'"/>';
				 echo'<input type="hidden" name="unitnews" value="'.$_POST['unitnamenew'].'"/>';
		echo "	<input type='submit' class='btn-yes-big big' value='' style='font-size: 11px;'/>
			</form>
			<form action='viewlayer.php' target='_self' style='display:inline;text-align:center;' method='POST'>
				<input type='hidden' name='action' value='viewlayer'/>
				<input type='hidden' name='actiontype' value='unit_view'/>";				
		if(isset($_POST['page_index']))
		{		
			echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";
		}	
			echo "<input type='submit' class='btn-cancel-big big' value='' style='font-size: 11px;'/>
			</form>
			</center>
			";
   }//count end 
}
if(isset($_SESSION['action_message']))
{
	echo "<b>".$_SESSION['action_message']."</b>";
	unset($_SESSION['action_message']);
	/*echo "<center>	<form action='".$SITE_ROOT."/custom/home.php' method='post' style='display:inline;'> 
			<input type='submit' value='' class='btn-go-back-big big'/>
			</form></center>";	*/
}


if(isset($_POST['action']) && $_POST['action']==='moveuser' ||  $_POST['actiondiv']==='moveuser' || $_POST['actionsec']==='moveuser' || $_POST['actionunit']==='moveuser')
{

	$agency=$division=$section=$unit="";
	$query="select profile_key,profile_value from ".$prefix."user_profiles where user_id='".htmlspecialchars($_POST['selid'])."' 

		and profile_key in ('profile.agency','profile.division','profile.section','profile.unit','profile.supvisemail') ";

	$rs=mysql_query($query) or die(mysql_error);
	
	while($row=mysql_fetch_array($rs))
	{

		if($row['0']==="profile.agency")
		{
			$agency=trim($row['1'],"\"");
		}
		if($row['0']==="profile.division")
		{
			$division=trim($row['1'],"\"");

		}
		if($row['0']==="profile.section")
		{

			 $section=trim($row['1'],"\"");

		}
		if($row['0']==="profile.unit")
		{
			$unit=trim($row['1'],"\"");
		}
		if($row['0']==="profile.supvisemail")
		{
			$supvisemail=trim($row['1'],"\"");
		}
	}
	$unitname=$_POST['unitnames'];
	$sectionname=$_POST['sectionnames'];
	$divisionname=$_POST['divisionnames'];
	
	if(isset($_POST['action']) && $_POST['actionsec']==='moveuser')
	{
	echo "<table width='60%' align='center'>";
	echo "<tr class='text_color'><th colspan='4'>Move User</th></tr>";
	echo "<tr class='row-odd'><td><b>Name</b></td><td colspan='3'>".mysql_real_escape_string($_POST['selname'])."</td></tr>";
	echo "<tr class='row-even'><td width='20%'><b>Agency</b></td><td width='30%'>$agency</td><td width='20%'><b>Division</b></td><td width='30%'>$divisionname</td></tr>";
	echo "<tr class='row-odd'><td><b>Section</b></td><td>$sectionname</td><td><b>Unit</b></td><td>$unit</td></tr>";
	echo "<tr class='row-even'><td><b>Supervisor Email</b></td><td colspan='3'>$supvisemail</td></tr>";
	}
	
	if(isset($_POST['action']) && $_POST['actionunit']==='moveuser')
	{
	echo "<table width='60%' align='center'>";
	echo "<tr class='text_color'><th colspan='4'>Move User</th></tr>";
	echo "<tr class='row-odd'><td><b>Name</b></td><td colspan='3'>".mysql_real_escape_string($_POST['selname'])."</td></tr>";
	echo "<tr class='row-even'><td width='20%'><b>Agency</b></td><td width='30%'>$agency</td><td width='20%'><b>Division</b></td><td width='30%'>$divisionname</td></tr>";
	echo "<tr class='row-odd'><td><b>Section</b></td><td>$sectionname</td><td><b>unitname</b></td><td>$unitname</td></tr>";
	echo "<tr class='row-even'><td><b>Supervisor Email</b></td><td colspan='3'>$supvisemail</td></tr>";
	}
	
	echo "<table width='60%' align='center'>";
	echo "<tr class='text_color'><th colspan='4'>Move User</th></tr>";
	echo "<tr class='row-odd'><td><b>Name</b></td><td colspan='3'>".mysql_real_escape_string($_POST['selname'])."</td></tr>";
	echo "<tr class='row-even'><td width='20%'><b>Agency</b></td><td width='30%'>$agency</td><td width='20%'><b>Division</b></td><td width='30%'>$divisionname</td></tr>";
	echo "<tr class='row-odd'><td><b>Section</b></td><td>$section</td><td><b>unitname</b></td><td>$unit</td></tr>";
	echo "<tr class='row-even'><td><b>Supervisor Email</b></td><td colspan='3'>$supvisemail</td></tr>";
	echo "<tr class='row-odd'><th colspan='4' align='center'>Transfer To</th></tr></table>";
	echo "<table width='60%' align='center'>";
	echo "<form name='moveForm'  method='post' id='moveForm'>";
	echo "<tr class='row-even'><td>Select Division:</td><td colspan='3'><select name='division_name' class='select_class' id='division'>";
	echo "<option value='0'>--Select Division--</option>";
	$querys="SELECT id,agency_name FROM tbl_agency WHERE deleted='0' and agency_name='$agency' ORDER BY agency_name  ASC";

		$rst_details=mysql_query($querys) or die(mysql_error);
		while($rows=mysql_fetch_array($rst_details))
		{
			$ahencyid=$rows['id'];
		}		
		$query="SELECT id,division_name FROM tbl_division WHERE deleted='0' and agency_id='$ahencyid' ORDER BY division_name  ASC";

		$rs_details=mysql_query($query) or die(mysql_error);
		while($row=mysql_fetch_array($rs_details))
		{
			$division_array[]=array("id"=>$row['0'],"division_name"=>$row['1']);
		}		
	
	for($i=0,$j=count($division_array);$i<$j;$i++)
				
				{
					if($division_array[$i]['id']==$selected_division)
					{
					
						echo "<option value='".$division_array[$i]['id']."' selected='selected'>".$division_array[$i]['division_name']."</option>";
					}
					else
					{
						echo "<option value='".$division_array[$i]['id']."'>".$division_array[$i]['division_name']."</option>";
					}						
		
				}			
			echo"</select>";
	echo"</td></tr>
		
		<tr class='row-odd'><td>Select Section:</font></td><td><select name='section_name' class='select_class' id='section'>";
		
			//$division=$_SESSION['division_name'];		
			?>
			<option value="<?php echo $sectionname; ?>">--Select Section--</option>
			<?php
			$section_array=getSectionByDivision($selected_division);

			for($i=0,$j=count($section_array);$i<$j;$i++)
			
			{
				if($section_array[$i]['id']==$selected_section)
				{
					echo "<option value='".$section_array[$i]['id']."' selected='selected'>".$section_array[$i]['name']."</option>";
				}
				else
				{
				echo "<option value='".$section_array[$i]['id']."'>".$section_array[$i]['name']."</option>";
				}
			
			}
		?>
		</select>
		<?php
		
		echo"</td></tr>		
		
			<tr class='row-even'><td>Select Unit:</font></td><td><select name='unit_name' class='select_class' id='unit'>";
			$section_array=getSectionByDivision($selected_division);
			?>
			<option value="<?php echo $unitname; ?>">--Select Unit--</option>
			<?php
			for($i=0,$j=count($section_array);$i<$j;$i++)
			
			{
				if($section_array[$i]['id']==$selected_section)
				{
					echo "<option value='".$section_array[$i]['id']."' selected='selected'>".$section_array[$i]['name']."</option>";
				}
				else
				{
				echo "<option value='".$section_array[$i]['id']."'>".$section_array[$i]['name']."</option>";
				}
			
			}
			echo"</select>
			<tr><td><br></td></tr>";
				
	
	
	echo '<input type="hidden" name="old_division" value="'.$division.'" />
	<input type="hidden" name="old_agency" value="'.$agency.'" />
	<input type="hidden" name="old_section" value="'.$section.'" />
	<input type="hidden" name="old_unit" value="'.$unit.'" />
	<input type="hidden" name="action" value="moveuseraction" />	
	<input type="hidden" name="section_view" value="'.$_POST['actionsec'].'"/>
	<input type="hidden" name="unit_view" value="'.$_POST['actionunit'].'"/>
	
	<input type="hidden" name="division_view" value="'.$_POST['actiondiv'].'"/>
	
	<input type="hidden" name="selid" value="'.$_POST['selid'].'"/>
	<input type="hidden" name="selname" value="'.$_POST['selname'].'"/>
	<input type="hidden" name="supervisor" value="'.$supvisemail.'"/>
	<table width="60%" align="center">
	<center><input type="submit" value="" class="btn-submit-big big" style="display:inline;" />

	</form>';	
	
	if($_POST['actiondiv']=='moveuser')
	{
		echo"<form action=$SITE_ROOT/custom/viewlayer.php method=\"post\" style='display:inline;'>
		<input type='hidden' name='action' value='viewlayer'/>
				<input type='hidden' name='actiontype' value='division_view'/>

		<input type=\"submit\" value=\"\" class=\"btn-go-back-big big\"/>

		</form>	</td></tr></center>";	
	}
	
	if($_POST['actionsec']==='moveuser')
	{
		echo"<form action=$SITE_ROOT/custom/viewlayer.php method=\"post\" style='display:inline;'>
		<input type='hidden' value='viewlayer' name='action'>
		<input type='hidden' value='section_view' name='actiontype'>

		<input type=\"submit\" value=\"\" class=\"btn-go-back-big big\"/>

		</form>	</td></tr></center>";	
	}
	
	if($_POST['actionunit']==='moveuser')
	{
		echo"<form action=$SITE_ROOT/custom/viewlayer.php method=\"post\" style='display:inline;'>
		<input type='hidden' value='viewlayer' name='action'>
		<input type='hidden' value='unit_view' name='actiontype'>
		<input type=\"submit\" value=\"\" class=\"btn-go-back-big big\"/>

		</form>	</td></tr></center>";	
	}
}																	
if(isset($_POST['action']) && $_POST['action']==='moveuseraction' ||  $_POST['section_view']==='moveuseraction' ||  $_POST['division_view']==='moveuseraction' ||  $_POST['unit_view']==='moveuseraction')

{
$query="CREATE TABLE IF NOT EXISTS tbl_user_agency_history (

				id int NOT NULL AUTO_INCREMENT,

				user_id int(10),

				name varchar(50),

			   old_agency varchar(50),

				new_agency varchar(50),

				old_division varchar(50),

				new_division varchar(50),

				old_section varchar(50),

				new_section varchar(50),

				old_unit varchar(50),

				new_unit varchar(50),

				old_supviseid int(10),

				new_supviseid int(10),

				start_dt datetime NOT NULL default '0000-00-00 00:00:00',

				end_dt datetime NOT NULL default '0000-00-00 00:00:00',

				PRIMARY KEY (id));";

	mysql_query($query) or die(mysql_error);        		

	$query="select id from tbl_user_agency_history where user_id ='".htmlspecialchars($_POST['selid'])."'";

	$rs_temp=mysql_query($query) or die(mysql_error);

	$cnt=mysql_num_rows($rs_temp);

	if($cnt>0)

	{

		$query="select max(id) from tbl_user_agency_history where user_id ='".htmlspecialchars($_POST['selid'])."'";

		$rs=mysql_query($query) or die(mysql_error);

		while($row=mysql_fetch_array($rs))

		{

			$max_id=$row['0'];

		}

		$query="select end_dt from tbl_user_agency_history where user_id ='".htmlspecialchars($_POST['selid'])."' and id='".$max_id."'";

		$rs=mysql_query($query) or die(mysql_error);

		while($row=mysql_fetch_array($rs))

		{

			$start_dt_newentry=$row['0'];

		}

	}

	else

	{

		$query="select registerDate from ".$prefix."users where id ='".htmlspecialchars($_POST['selid'])."' ";

		$rs=mysql_query($query) or die(mysql_error);

		while($row=mysql_fetch_array($rs))

		{

			$start_dt_newentry=$row['0'];

		}

	}

	date_default_timezone_set('America/New_York');

	$end_dt_newentry=date('Y-m-d H:i:s');

	//Names We Are getting here OLD DETAILS

	 $old_agency=mysql_real_escape_string($_POST['old_agency']);

	 $old_division=mysql_real_escape_string($_POST['old_division']);
	 
	 $old_division_query = "SELECT division_name FROM tbl_division WHERE deleted='0' and id='".$old_division."'";
		$rs_user_query=mysql_query($old_division_query) or die(mysql_error) ;
		while($row=mysql_fetch_array($rs_user_query))
		{
			$old_division_details=$row['0'];                
		}

	$old_section=mysql_real_escape_string($_POST['old_section']);
	
	 $old_section_query = "SELECT section_name FROM tbl_section WHERE deleted='0' and id='".$old_section."'";
		$rs_user_query=mysql_query($old_section_query) or die(mysql_error) ;
		while($row=mysql_fetch_array($rs_user_query))
		{
			$old_section_details=$row['0'];                
		}

	 $old_unit=mysql_real_escape_string($_POST['old_unit']);
	 
	 $old_unit_query = "SELECT unit_name FROM tbl_unit WHERE deleted='0' and id='".$old_unit."'";
		$rs_user_query=mysql_query($old_unit_query) or die(mysql_error) ;
		while($row=mysql_fetch_array($rs_user_query))
		{
			$old_unit_details=$row['0'];                
		}

	$old_agency_id=getAgencyIdByName($prefix,mysql_real_escape_string($_POST['old_agency']));

	$query="SELECT id FROM tbl_division WHERE division_name like '".mysql_real_escape_string($_POST['old_division'])."' and agency_id='".$old_agency_id."'";

	$rs=mysql_query($query) or die(mysql_error);

	while($row=mysql_fetch_array($rs))

	{

		$old_division_id=$row['0'];
	}

   $query="SELECT id FROM tbl_section WHERE section_name='".mysql_real_escape_string($_POST['old_section'])."' and division_id='".$old_division_id."' and agency_id='".$old_agency_id."'"; 

	$rs=mysql_query($query) or die(mysql_error);

	while($row=mysql_fetch_array($rs))

	{

		$old_section_id=$row['0'];

	}

	 $old_agency=mysql_real_escape_string($_POST['old_agency']);

	 $new_agency=mysql_real_escape_string($_POST['agency_name']);

	 $new_division=mysql_real_escape_string($_POST['division_name']);
	
		$new_division = "SELECT division_name FROM tbl_division WHERE deleted='0' and id='".$new_division."'";
		$rs_user_query=mysql_query($new_division) or die(mysql_error) ;
		while($row=mysql_fetch_array($rs_user_query))
		{
			$new_divisiondetails=$row['0'];                
		}

	  $new_section=mysql_real_escape_string($_POST['section_name']);
	 
	 $section_query = "SELECT section_name FROM tbl_section WHERE deleted='0' and id='".$new_section."'";
		$rs_user_query=mysql_query($section_query) or die(mysql_error) ;
		while($row=mysql_fetch_array($rs_user_query))
		{
			$new_sectiondetails=$row['0'];                
		}

	 $new_unit=mysql_real_escape_string($_POST['unit_name']);
	 
	   $unit_query = "SELECT unit_name FROM tbl_unit WHERE deleted='0' and id='".$new_unit."'";
		$rs_user_query=mysql_query($unit_query) or die(mysql_error) ;
		while($row=mysql_fetch_array($rs_user_query))
		{
			$new_unitdetails=$row['0'];                
		}

	//ID New Details
//var_dump($_POST);
	$new_agency_id=getAgencyIdByName($prefix,mysql_real_escape_string($_POST['agency_name']));

	$new_division_id=mysql_real_escape_string($_POST['division_name']);

	$new_section_id=mysql_real_escape_string($_POST['section_name']);

	$new_unit_id=mysql_real_escape_string($_POST['unit_name']);

	$new_supervisor_email=getEmailById($prefix,htmlspecialchars($_POST['supervisor']));

	$old_supervisor_email=htmlspecialchars($_POST['old_supvisemail']);

	$new_supervisor_id=htmlspecialchars($_POST['supervisor']);

	$old_supervisor_id=getIdByEmail($prefix,$old_supervisor_email);
	
    $ins_query="insert into tbl_user_agency_history ( user_id, name, old_agency, new_agency, 

					old_division, new_division, old_section, new_section, old_unit, new_unit, 

					old_supviseid,new_supviseid,start_dt, end_dt) values ('".htmlspecialchars($_POST['selid'])."','".mysql_real_escape_string($_POST['selname'])."',
					
					'".mysql_real_escape_string($_POST['old_agency'])."','".$old_agency."',

					'".$old_division_details."','".$new_divisiondetails."','".$old_section_details."','".$new_sectiondetails."','".$old_unit_details."','".$new_unitdetails."',

					'".$old_supervisor_id."','".$new_supervisor_id."','".$start_dt_newentry."','".$end_dt_newentry."')";					

//	echo $ins_query;				
	mysql_query($ins_query) or die(mysql_error);
	$temp_profile=array("agency","division","section","unit");
	for($x=0,$y=count($temp_profile);$x<$y;$x++)
	{
		$curr_val="profile.".$temp_profile[$x];
	 $sel_query="select profile_key from ".$prefix."user_profiles where user_id='".htmlspecialchars($_POST['selid'])."' and profile_key='".$curr_val."' ";

		$rs=mysql_query($sel_query) or die(mysql_error);

		$count_profile=mysql_num_rows($rs);
		if($temp_profile[$x]==="agency")$varname=$old_agency;
		if($temp_profile[$x]==="division")$varname=$new_divisiondetails;
		if($temp_profile[$x]==="section")$varname=$new_sectiondetails;
		if($temp_profile[$x]==="unit")$varname=$new_unitdetails;
		//if($temp_profile[$x]==="supvisemail")$varname=$new_supervisor_email;
		if($count_profile>0)
		{
			$query="update ".$prefix."user_profiles set profile_value='\"".$varname."\"' where profile_key='".$curr_val."' and user_id='".htmlspecialchars($_POST['selid'])."'";	

		}

		else

		{

			$query="insert into ".$prefix."user_profiles (user_id,profile_key,profile_value) values ('".htmlspecialchars($_POST['selid'])."','".$curr_val."','".$varname."') ";

		}

//		echo $query."<br/>";
		 $rslts=mysql_query($query) or die(mysql_error());

	}


 
 echo "<center><h3>User Moved Successfully</h3></center>";	
 
if(isset($_POST['action']) && $_POST['action']==='moveuseraction' ) 
{

echo "<center>

<form method='post' action='$SITE_ROOT/custom/viewlayer.php' style='display:inline'>";


if($_POST['division_view']==='moveuser')
{

//$divisionnames=$_POST['old_division'];
 $divisionnames="\"".mysql_real_escape_string($_POST['old_division'])."\"";
$agencynamesnt=mysql_real_escape_string($_POST['old_agency']);

   $query="select count(up.user_id),concat(u.name,' ',u.middle_name,' ',u.last_name)as name from ".$prefix."user_profiles up,".$prefix."users u,".$prefix."lms_users lu where
		
		  up.profile_value='$divisionnames' and up.profile_key='profile.division' and lu.user_id=up.user_id and lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15) 
				 
			  and u.block='0' and up.user_id=u.id and  u.id in (select user_id from ".$prefix."user_profiles where profile_key='profile.agency' and 
			  
			  			profile_value like '%".$agencynamesnt."%')";
						
			$rslts=mysql_query($query) or die(mysql_error);
   			//$test_row=mysql_fetch_array($rslts);
  			//var_dump($test_row);
			//echo $counts_division=mysql_num_rows($rslts);
			while($row=mysql_fetch_array($rslts))
			{
				$counts_division=$row['0'];
			}					

	 if($counts_division!=0)
	 {
	 ?>
		<input type="hidden" value="148" name="selid">
		<?php
		echo"<input type='hidden' value=$divisionnames name='selname'>";
		?>
		<input type="hidden" value="0" name="actionyest">
		<input type="hidden" value="deletediv" name="actionyes">
		<input type="hidden" value="<?php echo $_POST['old_agency']; ?>" name="agencynamenews">
		<input type="hidden" value="<?php echo $_POST['old_division']; ?>" name="divisionnews">
		
		<?php
	 }
	else
	{
	echo"<input type='hidden' value='viewlayer' name='action'>
	
	<input type='hidden' value='division_view' name='actiontype'>";
	}
}

if($_POST['section_view']==='moveuser')
{

	$section_name="\"".mysql_real_escape_string($_POST['old_section'])."\"";
	
	$agencynames=mysql_real_escape_string($_POST['old_agency']);
	
 $query="select count(up.user_id),concat(u.name,' ',u.middle_name,' ',u.last_name)as name from ".$prefix."user_profiles up,".$prefix."users u,".$prefix."lms_users lu where
		
		  up.profile_value='".$section_name."' and up.profile_key='profile.section' and lu.user_id=up.user_id and lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15) 
				 
			  and u.block='0' and up.user_id=u.id and  u.id in (select user_id from ".$prefix."user_profiles where profile_key='profile.agency' and 
			  
			  			profile_value like '%".$agencynames."%')";
						
			$rsltsvins=mysql_query($query) or die(mysql_error());

			//echo $counts=mysql_num_rows($rsltsvins);
			while($row=mysql_fetch_array($rsltsvins))
			{
				$counts_section=$row['0'];
			}	
			
 if($counts_section!=0)
 {
 ?>
		<input type="hidden" value="159" name="selid">
		<?php
		echo"<input type='hidden' value=$section_name name='selname'>";
		?>
		<input type="hidden" value="0" name="sectionyes">
		<input type="hidden" value="deletesec" name="sectionyes">
		<input type="hidden" value="<?php echo $_POST['old_agency']; ?>" name="agencynamenews">
		<input type="hidden" value="<?php echo $_POST['old_division']; ?>" name="divisionnews">
		<input type="hidden" value="<?php echo $_POST['old_section']; ?>" name="sectionnews">
<?php
 }
	else
	{	

		echo"<input type='hidden' value='viewlayer' name='action'>
		<input type='hidden' value='section_view' name='actiontype'>";
		
	}
}


if($_POST['unit_view']==='moveuser')
{
	 $unit_name="\"".mysql_real_escape_string($_POST['old_unit'])."\"";
	
	$agency_old=mysql_real_escape_string($_POST['old_agency']);
	
	 $query="select up.user_id,concat(u.name,' ',u.middle_name,' ',u.last_name)as name from ".$prefix."user_profiles up,".$prefix."users u,".$prefix."lms_users lu where
		
		  up.profile_value='".$unit_name."' and up.profile_key='profile.unit' and lu.user_id=up.user_id and lu.lms_usertype_id not in (1,3,5,9,11,12,13,14,15) 
				 
			  and u.block='0' and up.user_id=u.id and  u.id in (select user_id from ".$prefix."user_profiles where profile_key='profile.agency' and 
			  
			  			profile_value like '%".$agency_old."%')";

			$rsltsvins=mysql_query($query) or die(mysql_error());

			//$counts=mysql_num_rows($rsltsvins);
			while($row=mysql_fetch_array($rsltsvins))
			{
				$counts_unit=$row['0'];
			}	
	 if($counts_unit!=0)
	 {
	 ?>
			<input type="hidden" value="235" name="selid">
			<?php
			echo"<input type='hidden' value=$unit_name name='selname'>";
			?>
			<input type="hidden" value="0" name="unityes">
			<input type="hidden" value="deleteunit" name="unityes">
			<input type="hidden" value="deleteunit" name="actions">		
			<input type="hidden" value="<?php echo $_POST['old_agency']; ?>" name="agencynamenews">
			<input type="hidden" value="<?php echo $_POST['old_division']; ?>" name="divisionnews">
			<input type="hidden" value="<?php echo $_POST['old_section']; ?>" name="sectionnews">
			<input type="hidden" value="<?php echo $_POST['old_unit']; ?>" name="unitnews">

	<?php
	}
	else
	{
	echo"<input type='hidden' value='viewlayer' name='action'>
	<input type='hidden' value='unit_view' name='actiontype'>";
	}
}

echo"<input type='submit' value='' class='big btn-go-back-big' style=''/>
</form>
</center>";
}


}



//EDIT 
if($_POST['action'] && $_POST['action']==="editdiv")
{
		echo "<center>
			<form action='viewlayer.php' target='_self' style='display:inline;text-align:center;' onSubmit='return checkall_div();' method='POST'>
			<table border='0' align='center'>";
			echo"<tr><td colspan='2'><img src='images/edit_div.gif'</td></tr>";
			?>
			<div align='center' id='selectedlist' style="color:#000000; font-family:arial; font-size:17px;"></div>
			<div id="showme" align="center" style="color:#FF0000"></div>
			<?php
		echo"<tr><td>&nbsp;</td></tr>";
			if($roletype!=11)
			{
				echo"<tr><td>Select Agency</font></td><td><select name='agency_id' class='select_class' id='agency'><option value=''>--Select Agency--</option>";
				$agency_array=getAllAgencyDetails();
				for($i=0,$j=count($agency_array);$i<$j;$i++)
				
				{
					$selected_agency=$_POST['agency_id'];
					if($agency_array[$i]['id']!=1)
					{
						if($agency_array[$i]['id']==$selected_agency)
						{
							echo "<option value='".$agency_array[$i]['id']."' selected='selected'>".$agency_array[$i]['agency_name']."</option>";
						}
						else
						{
							echo "<option value='".$agency_array[$i]['id']."'>".$agency_array[$i]['agency_name']."</option>";
						}
					}	
				
				}
					echo"</td></tr>";
			}	
			$agency_name=$_SESSION['agency_name'];
			if($roletype==11)
			{
				
			echo '<tr><td>Agency Name </td> <td><input type="text" id="agency" class="select_class" disabled="true" name="new_name"  value="'.$agency_name.'"/></td>';
		
			}
			echo'<tr><td>Divison Name </td> <td><input type="text" class="select_class" id="division_name" name="new_name" onKeyUp="divisionmes();" value="'.$_POST['selname'].'"/>
			</td>
			</table>
			 <br/><br/>
				<input type="hidden" name="old_name" value="'.$_POST['selname'].'"/>
				<input type="hidden" name="cnfrm_action" value="'.$_POST['action'].'"/>
				<input type="hidden" name="cnfrm_selid" value="'.$_POST['selid'].'"/>';
		echo "	<input type='submit' class='btn-submit-big big' id='subitdivision' value='' style='font-size: 11px;'/>
			</form>
			<form action='viewlayer.php' target='_self' style='display:inline;text-align:center;' method='POST'>
				<input type='hidden' name='action' value='viewlayer'/>";
		if($_POST['action']==="editdiv")		
		echo "	<input type='hidden' name='actiontype' value='division_view'/>";				
		if($_POST['action']==="editsec")
		echo "	<input type='hidden' name='actiontype' value='section_view'/>";
		if($_POST['action']==="editunit")
		echo "	<input type='hidden' name='actiontype' value='unit_view'/>";
		if(isset($_POST['page_index']))
		{		
			echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";
		}	
			echo "<input type='submit' class='btn-cancel-big big' value='' style='font-size: 11px;'/>
			</form>
			</center>
			";
}

if($_POST['action']&& $_POST['action']==="editsec")
{
		echo "<center>
			<form action='viewlayer.php' target='_self' style='display:inline;text-align:center;' onSubmit='return checkall_sec();' method='POST'>
		<table border='0' align='center'>";
		echo"<tr><td colspan='2'><img src='images/edit_section.gif'</td></tr>";
		?>
		<div align='center' id='selectedlist' style="color:#000000; font-family:arial; font-size:17px;"></div>
		<div id="showme" align="center" style="color:#FF0000"></div>
		<?php
		echo"<tr><td>&nbsp;</td></tr>";
		if($roletype!=11)
			{
				echo"<tr><td>Select Agency</font></td><td><select name='agency_id' class='select_class' id='agency'><option value=''>--Select Agency--</option>";
				$agency_array=getAllAgencyDetails();
				$selected_agency=$_POST['agency_id'];
				for($i=0,$j=count($agency_array);$i<$j;$i++)
				
				{
					if($agency_array[$i]['id']!=1)
					{
						if($agency_array[$i]['id']==$selected_agency)
						{
							echo "<option value='".$agency_array[$i]['id']."' selected='selected'>".$agency_array[$i]['agency_name']."</option>";
						}
						else
						{
							echo "<option value='".$agency_array[$i]['id']."'>".$agency_array[$i]['agency_name']."</option>";
						}	
					}	
				
				}
					echo"</td></tr>";
			}		
			$agency_name=$_SESSION['agency_name'];
			if($roletype==11)
			{
				
			echo '<tr><td>Agency Name </td> <td><input type="text" class="select_class" id="agency" disabled="true" name="new_name"  value="'.$agency_name.'"/></td>';
		
			}
		echo"<tr><td><font style='Arial'  size='4'>Select Division</font></td><td><select name='division_id' class='select_class' id='division'>";	

			session_start();

			 $division=$_SESSION['division_name'];
			 $agency_name=$_SESSION['agency_name'];
			 
			
			/**
			*	For agency admin
			*
			*
			*/
			$selected_agency=$_POST['agency_id'];
			$selected_division=$_POST['divid'];
			
			
			if($roletype==11 || $roletype==3 || $roletype==5 || $roletype==9)
			{
				$division_array=getDivisionByAgenyId($selected_agency);
			}
			

			for($i=0,$j=count($division_array);$i<$j;$i++)
			
			{
				if($division_array[$i]['id']==$selected_division)
				{
					echo "<option value='".$division_array[$i]['id']."' selected='selected'>".$division_array[$i]['division_name']."</option>";
				}
				else
				{
				echo "<option value='".$division_array[$i]['id']."'>".$division_array[$i]['division_name']."</option>";
				}
			
			}
			
			/**
			*	For super admin for roletype 3,5,9
			*
			*
			*/

		echo'</td></tr>
			<tr><td><font style="Arial"  size="4">Section Name </td>
				<td><input type="text"  class="select_class" name="new_name" id="sectionid" onKeyUp="sectionmes();"  value="'.$_POST['selname'].'"/></td></tr>
			</table>
			<br/><br/>
				<input type="hidden" name="old_name" value="'.$_POST['selname'].'"/>
				<input type="hidden" name="cnfrm_action" value="'.$_POST['action'].'"/>
				<input type="hidden" name="cnfrm_selid" value="'.$_POST['selid'].'"/>';
		echo "	<input type='submit' class='btn-submit-big big' id='subitsection' value='' onclick='return sectionme();' style='font-size: 11px;'/>
			</form>
			<form action='viewlayer.php' target='_self' style='display:inline;text-align:center;' method='POST'>
				<input type='hidden' name='action' value='viewlayer'/>";
		if($_POST['action']==="editdiv")		
		echo "	<input type='hidden' name='actiontype' value='division_view'/>";				
		if($_POST['action']==="editsec")
		echo "	<input type='hidden' name='actiontype' value='section_view'/>";
		if($_POST['action']==="editunit")
		echo "	<input type='hidden' name='actiontype' value='unit_view'/>";
		if(isset($_POST['page_index']))
		{		
			echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";
		}	
			echo "<input type='submit' class='btn-cancel-big big' value='' style='font-size: 11px;'/>
			</form>
			</center>
			";
}

if($_POST['action']&& $_POST['action']==="editunit" )
{
		echo "<center>
			<form action='viewlayer.php' target='_self' style='display:inline;text-align:center;' onSubmit='return checkall_unit();' method='POST'>
		<table border='0' align='center'>";
		echo"<tr colspan='2'><img src='images/edit_unit.gif'</tr>";
		?>
		<div align='center' id='selectedlist' style="color:#000000; font-family:arial; font-size:17px;"></div>
		<div id="showme" align="center" style="color:#FF0000"></div>
		<?php
		echo"<tr><td>&nbsp;</td></tr>";
		
			if($roletype!=11)
			{
				echo"<tr><td>Select Agency</font></td><td><select name='agency_id' class='select_class' id='agency'>";
				$agency_array=getAllAgencyDetails();
				$selected_agency=$_POST['agency_id'];
				for($i=0,$j=count($agency_array);$i<$j;$i++)
				
				{
					if($agency_array[$i]['id']!=1)
					{
						if($agency_array[$i]['id']==$selected_agency)
						{
							echo "<option value='".$agency_array[$i]['id']."' selected='selected'>".$agency_array[$i]['agency_name']."</option>";
						}
						else
						{
							echo "<option value='".$agency_array[$i]['id']."'>".$agency_array[$i]['agency_name']."</option>";
						}	
					}	
				
				}
					echo"</td></tr>";
			}	
			$agency_name=$_SESSION['agency_name'];
			if($roletype==11)
			{
				
			echo '<tr><td>Agency Name </td> <td><input type="text" class="select_class" id="agency" disabled="true" name="new_name"  value="'.$agency_name.'"/></td>';
		
			}
		echo"<tr><td>Select Division</font></td><td><select name='division_id' class='select_class' id='division'>";	

			session_start();

			$division=$_SESSION['division_name'];
			$agency_name=$_SESSION['agency_name'];
			
			$selected_agency=$_POST['agency_id'];
			$selected_division=$_POST['divid'];
			$selected_section=$_POST['secid'];
			
			if($roletype==11 || $roletype==3 || $roletype==5 || $roletype==9)
			{
				$division_array=getDivisionByAgenyId($selected_agency);
			}					
			
			
				for($i=0,$j=count($division_array);$i<$j;$i++)
				
				{
					if($division_array[$i]['id']==$selected_division)
					{
						echo "<option value='".$division_array[$i]['id']."' selected='selected'>".$division_array[$i]['division_name']."</option>";
					}
					else
					{
						echo "<option value='".$division_array[$i]['id']."'>".$division_array[$i]['division_name']."</option>";
					}
				}
			
			
			
			
		echo"</td></tr>
		<tr><td>Select Section</font></td><td><select name='section_id' class='select_class' id='section'>";
		
		
			// for the division array
			/* for the array */
			//$division=$_SESSION['division_name'];		
			
			$section_array=getSectionByDivision($selected_division);

			for($i=0,$j=count($section_array);$i<$j;$i++)			
			{
			
				if($section_array[$i]['id']==$selected_section)
				{
					echo "<option value='".$section_array[$i]['id']."' selected='selected'>".$section_array[$i]['name']."</option>";
				}
				else
				{
				echo "<option value='".$section_array[$i]['id']."'>".$section_array[$i]['name']."</option>";
				}
			
			}
		
		
		echo'</td></tr>
			<tr><td>Unit Name</td><td><input type="text" class="select_class" id="unitid" name="new_name" onKeyUp="unitnamesd();" value="'.$_POST['selname'].'"/></td></tr>
			</table>
			<br/><br/>
				<input type="hidden" name="old_name" value="'.$_POST['selname'].'"/>
				<input type="hidden" name="cnfrm_action" value="'.$_POST['action'].'"/>
				<input type="hidden" name="cnfrm_selid" value="'.$_POST['selid'].'"/>';
		echo "	<input type='submit' class='btn-submit-big big' id='submitunitids' value='' onclick='return unitme();' style='font-size: 11px;'/>
			</form>
			<form action='viewlayer.php' target='_self' style='display:inline;text-align:center;' method='POST'>
				<input type='hidden' name='action' value='viewlayer'/>";
		if($_POST['action']==="editdiv")		
		echo "	<input type='hidden' name='actiontype' value='division_view'/>";				
		if($_POST['action']==="editsec")
		echo "	<input type='hidden' name='actiontype' value='section_view'/>";
		if($_POST['action']==="editunit")
		echo "	<input type='hidden' name='actiontype' value='unit_view'/>";
		if(isset($_POST['page_index']))
		{		
			echo "<input type='hidden' name='page_index' value='".$_POST['page_index']."'/>";
		}	
			echo "<input type='submit' class='btn-cancel-big big' value='' style='font-size: 11px;'/>
			</form>
			</center>
			";
}


if(isset($_POST['cnfrm_action']) && ($_POST['cnfrm_action']==="editdiv" || $_POST['cnfrm_action']==="editsec" || $_POST['cnfrm_action']==="editunit"))
{
	$old_name="\"".mysql_real_escape_string($_POST['old_name'])."\"";
	$new_name="\"".mysql_real_escape_string($_POST['new_name'])."\"";
	$agency_id=$_POST['agency_id'];
	
	
	
	if($_POST['cnfrm_action']==="editdiv")
	{
		//start get old agency id
		$gettuery="select id,agency_id from tbl_division where id='".$_POST['cnfrm_selid']."' and deleted='0'";
		$reses=mysql_query($gettuery) or die(mysql_error());
		while($roqwe=mysql_fetch_array($reses))
		{
			 $agency_id_old=$roqwe['agency_id'];
		}
		//end get old agency id
		
		$query="update tbl_division set division_name='".mysql_real_escape_string($_POST['new_name'])."',agency_id='".htmlspecialchars($_POST['agency_id'])."',
				updated_userid='".$ID."',updated_username='".$updated_username."'
				where division_name='".mysql_real_escape_string($_POST['old_name'])."' and id='".$_POST['cnfrm_selid']."'";
		
		if($roletype==11)
		{
			$query="update tbl_division set division_name='".mysql_real_escape_string($_POST['new_name'])."',
			updated_userid='".$ID."',updated_username='".$updated_username."' where division_name='".mysql_real_escape_string($_POST['old_name'])."'
		 	and id='".$_POST['cnfrm_selid']."'";
		}
		
		$result=mysql_query($query) or die(mysql_error());
		
		$success_msg="<p align='center'>Division \"".$_POST['new_name']."\" has been updated from \"".$_POST['old_name']."\"</p>";
		$failure_msg="<p align='center'>Division \"".$_POST['new_name']."\" has not been updated from \"".$_POST['old_name']."\"</p>";
		
		/*rahul start userprofile updates 11-03-17*/
		if($agency_id==$agency_id_old)
		{
			$gettquery="select id,agency_name from tbl_agency where id='".$agency_id_old."' and deleted='0'";
			$rees=mysql_query($gettquery) or die(mysql_error());
			while($rowe=mysql_fetch_array($rees))
			{
				$agen_name=$rowe['agency_name'];
				$agen_namess="\"".$agen_name."\"";
				
				$selquery="select up.user_id from ".$prefix."user_profiles up,".$prefix."users u where profile_key='profile.agency' and up.profile_value='".$agen_namess."' 
				and u.block='0' and u.id=up.user_id and id not in(select user_id from ".$prefix."lms_users where lms_usertype_id in('3','5','9','11','21') )";
				$selres=mysql_query($selquery) or die(mysql_error());
				$selcount=mysql_num_rows($selres);
				if($selcount!=0)
				{
					while($rowwe=mysql_fetch_array($selres))
					{
						$agen_users=$rowwe['user_id'];
						
						$user_update="update ".$prefix."user_profiles set profile_value='".$new_name."' where profile_value='".$old_name."' and
									 profile_key='profile.division'	 and user_id='".$agen_users."' ";
									 
						$user_update_ress=mysql_query($user_update) or die(mysql_error());
									 
					}
				}	
			}
		}
			/*rahul end userprofile updates 11-03-17*/
	}
	if($_POST['cnfrm_action']==="editsec")
	{
		//start get old agency id
		$gettuery="select id,agency_id from tbl_section where id='".$_POST['cnfrm_selid']."' and deleted='0'";
		$reses=mysql_query($gettuery) or die(mysql_error());
		while($roqwe=mysql_fetch_array($reses))
		{
			 $agency_id_old=$roqwe['agency_id'];
		}
		//end get old agency id
		
		$query="update tbl_section set section_name='".mysql_real_escape_string($_POST['new_name'])."',agency_id='".htmlspecialchars($_POST['agency_id'])."',
		division_id='".htmlspecialchars($_POST['division_id'])."',updated_userid='".$ID."',updated_username='".$updated_username."'
		 where section_name='".mysql_real_escape_string($_POST['old_name'])."' and id='".$_POST['cnfrm_selid']."'";
		
		if($roletype==11)
		{
			$query="update tbl_section set section_name='".mysql_real_escape_string($_POST['new_name'])."',division_id='".htmlspecialchars($_POST['division_id'])."',
			 updated_userid='".$ID."',updated_username='".$updated_username."'
			 where section_name='".mysql_real_escape_string($_POST['old_name'])."' and id='".$_POST['cnfrm_selid']."'";
		}
		
		$result=mysql_query($query) or die(mysql_error());
		
		$success_msg="<p align='center'>Section \"".$_POST['new_name']."\" has been updated from \"".$_POST['old_name']."\"</p>";
		$failure_msg="<p align='center'>Section \"".$_POST['new_name']."\" has not been updated from \"".$_POST['old_name']."\"</p>";
		
		/*rahul start userprofile updates 11-03-17*/
		if($agency_id==$agency_id_old)
		{
		
			$gettquery="select id,agency_name from tbl_agency where id='".$agency_id_old."' and deleted='0'";
			$rees=mysql_query($gettquery) or die(mysql_error());
			while($rowe=mysql_fetch_array($rees))
			{
				$agen_name=$rowe['agency_name'];
				$agen_namess="\"".$agen_name."\"";
				
				$selquery="select up.user_id from ".$prefix."user_profiles up,".$prefix."users u where profile_key='profile.agency' and up.profile_value='".$agen_namess."'
				 and u.block='0' and u.id=up.user_id and id not in(select user_id from ".$prefix."lms_users where lms_usertype_id in('3','5','9','11','21') )";
				$selres=mysql_query($selquery) or die(mysql_error());
				$selcount=mysql_num_rows($selres);
				if($selcount!=0)
				{
					while($rowwe=mysql_fetch_array($selres))
					{
						$agen_users=$rowwe['user_id'];
						
						$user_update="update ".$prefix."user_profiles set profile_value='".$new_name."' where profile_value='".$old_name."' and
									 profile_key='profile.section' and user_id='".$agen_users."' ";
									 
						$user_update_ress=mysql_query($user_update) or die(mysql_error());
									 
					}
				}
				
			}
		}
				/*rahul end userprofile updates 11-03-17*/
	}
	if($_POST['cnfrm_action']==="editunit")
	{
		//start get old agency id
		$gettuery="select id,agency_id from tbl_unit where id='".$_POST['cnfrm_selid']."' and deleted='0'";
		$reses=mysql_query($gettuery) or die(mysql_error());
		while($roqwe=mysql_fetch_array($reses))
		{
			 $agency_id_old=$roqwe['agency_id'];
		}
		//end get old agency id
		
		$query="update tbl_unit set unit_name='".mysql_real_escape_string($_POST['new_name'])."',agency_id='".htmlspecialchars($_POST['agency_id'])."',
		division_id='".htmlspecialchars($_POST['division_id'])."',section_id='".htmlspecialchars($_POST['section_id'])."',
		updated_userid='".$ID."',updated_username='".$updated_username."' 
		where unit_name='".mysql_real_escape_string($_POST['old_name'])."' and id='".$_POST['cnfrm_selid']."'";
		
		if($roletype==11)
		{
			$query="update tbl_unit set unit_name='".mysql_real_escape_string($_POST['new_name'])."',division_id='".htmlspecialchars($_POST['division_id'])."',
			section_id='".htmlspecialchars($_POST['section_id'])."',updated_userid='".$ID."',updated_username='".$updated_username."'
			 where unit_name='".mysql_real_escape_string($_POST['old_name'])."' and id='".$_POST['cnfrm_selid']."'";
		}
		
		$result=mysql_query($query) or die(mysql_error());
		
		
		$success_msg="<p align='center'>Unit \"".$_POST['new_name']."\" has been updated from \"".$_POST['old_name']."\"</p>";
		$failure_msg="<p align='center'>Unit \"".$_POST['new_name']."\" has not been updated from \"".$_POST['old_name']."\"</p>";
		
		/*rahul start userprofile updates 11-03-17*/
		if($agency_id==$agency_id_old)
		{
		
			$gettquery="select id,agency_name from tbl_agency where id='".$agency_id_old."' and deleted='0'";
			$rees=mysql_query($gettquery) or die(mysql_error());
			while($rowe=mysql_fetch_array($rees))
			{
				$agen_name=$rowe['agency_name'];
				$agen_namess="\"".$agen_name."\"";
				
				$selquery="select up.user_id from ".$prefix."user_profiles up,".$prefix."users u where profile_key='profile.agency' and up.profile_value='".$agen_namess."' and u.block='0' and u.id=up.user_id and id not in(select user_id from ".$prefix."lms_users where lms_usertype_id in('3','5','9','11','21') )";
				$selres=mysql_query($selquery) or die(mysql_error());
				$selcount=mysql_num_rows($selres);
				if($selcount!=0)
				{
					while($rowwe=mysql_fetch_array($selres))
					{
						$agen_users=$rowwe['user_id'];
						
						$user_update="update ".$prefix."user_profiles set profile_value='".$new_name."' where profile_value='".$old_name."' and
									 profile_key='profile.unit' and user_id='".$agen_users."' ";
									 
						$user_update_ress=mysql_query($user_update) or die(mysql_error());
									 
					}
				}
				
			}
		}
					/*rahul end userprofile updates 11-03-17*/
	}	
//	echo "Here<br/>";
//	echo $query;

	/*$result=mysql_query($query) or die(mysql_error());*/
	/*mysql_query($user_update) or die(mysql_error());*/
	
	if($result==1)
	{
		$_SESSION['action_message']=$success_msg;
	}
	else
	{
		$_SESSION['action_message']=$failure_msg;
	}
}

if(isset($_SESSION['action_message']))
{
	echo "<b>".$_SESSION['action_message']."</b>";
	unset($_SESSION['action_message']);
	echo "<center>	<form action='".$SITE_ROOT."/custom/home.php' method='post' style='display:inline;'> 
			<input type='submit' value='' class='btn-go-back-big big'/>
			</form></center>";	
}



?>
<html>
<head><title><?php echo $SITE_NAME?>Move Archive: Home</title>
<link href="css/style.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
</head>
<body class="font-for-all">
<div id="wrapper">
<div id="content">
</div></div>
<?
require_once("./connections/database_close.php");
}
else
{
		echo "<center>Your session expired. <a href='$SITE_ROOT' target='_top'>Click Here</a> to login again</center>";
}
?>
<style>
a.pagecol
{
color:#000;
font-weight: bold;
text-decoration:none;

}
.pagecol:hover {
color:#33CCFF;
}

a.not_active
{
	color: #8a8a8a;
	text-decoration:none;
}

</style>

<script type="text/javascript">

jQuery(document).ready(function() {

jQuery("#agency").change(function () {

<!--	jQuery(this).after('<div id="loader"><img src="http://www.dhsuniversity.net/custom/loading (1).gif" alt="loading subcategory" /></div>');
-->	
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

	jQuery(this).after('<div id="loader"><img src="loading (1).gif" alt="loading subcategory" /></div>');

	jQuery.get('load.php?jform_profile_division=' + jQuery(this).val(), function(data) {

	jQuery("#section").html(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});	

});

});
jQuery(document).ready(function() {
jQuery("#section").change(function () {
	jQuery(this).after('<div id="loader"><img src="loading (1).gif" alt="loading subcategory" /></div>');

	jQuery.get('load.php?jform_profile_section=' + jQuery(this).val(), function(data) {
	jQuery("#unit").html(data);
	jQuery('#loader').slideUp(200, function() {
		jQuery(this).remove();

});
});

});

});

jQuery(document).ready(function() {

jQuery("#agency").change(function () {

	jQuery(this).after('<div id="loader"><img src="loading (1).gif" alt="loading subcategory" /></div>');

	jQuery.get('load.php?jform_agency=' + jQuery(this).val(), function(data) {

	jQuery("#division").html(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});	

});

});

$(function(){
 
  $('#division_name').keyup(function()
  {
    var yourInput = $(this).val();
    re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
    var isSplChar = re.test(yourInput);
    if(isSplChar)
    {
      var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
       $(this).val(no_spl_char);
	  $("#showme").html("Special Characters can not be added to division name field").show().delay(1200).fadeOut(2000); 
    }
  });
 
});

$(function(){
 
  $('#sectionid').keyup(function()
  {
    var yourInput = $(this).val();
    re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
    var isSplChar = re.test(yourInput);
    if(isSplChar)
    {
      var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
       $(this).val(no_spl_char);
	  $("#showme").html("Special Characters can not be added to section name field").show().delay(1200).fadeOut(2000); 
    }
  });
 
});

$(function(){
 
  $('#unitid').keyup(function()
  {
    var yourInput = $(this).val();
    re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
    var isSplChar = re.test(yourInput);
    if(isSplChar)
    {
      var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
       $(this).val(no_spl_char);
	  $("#showme").html("Special Characters can not be added to unit name field").show().delay(1200).fadeOut(2000); 
    }
  });
 
});

</script>
