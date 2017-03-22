<?php

/*

*	Even though the name suggests add_trainer.php, this file is used to

*	add user with these privileges

*	1->Trainer

*	2->Student

*	9->DHS Administrator

*  	11->Agency Administrator

*  	12->Supervisor

*/

	require_once("./access_jsession.php");

	require_once("./custom_config.php");

	require_once("./connections/database.php");

	require_once("./base_functions.php");

	$prefix=$SESSION["PREFIX"];

	$user = $session->get( 'user' );

	$ID=$user->get('id');

	$USERNAME=$user->get('username');

 	$fname=$user->get('name');

	$mname=$user->get('middle_name');

	$lname=$user->get('last_name');

    $fullname=$fname.' '.$mname.' '.$lname; // concating the first name,middle name, last name for the display
	
	$today_date=date('Y-m-d');
	
	$user = $session->get( 'user' );

if (!$user->guest || $_POST['location']==="admin") {

	$roletype=getRoleId($prefix,$ID);



	if($_POST['add_action']==='trainer_add')

	{

		//Step: 1	

	jimport( 'joomla.factory' );	

		$user 	      = clone(JFactory::getUser());

		$pathway 	      = & $mainframe->getPathway();

		$config	      = & JFactory::getConfig();

		$authorize	      = & JFactory::getACL();

		$document       = & JFactory::getDocument();

		$agency=$division=$section=$unit=$supervisor_email="";

//Step: 2		

		$usersConfig = &JComponentHelper::getParams( 'com_users' );

/*		if ($usersConfig->get('allowUserRegistration') == '0')

		{

			JError::raiseError( 403, JText::_( 'Access Forbidden' ));

			return;

		}

*/		

//Step: 3

		$newUsertype = $usersConfig->get( 'new_usertype' );

		if (!$newUsertype)

		{

			$newUsertype = 'Registered';

		}	

//Step: 4

		if (!$user->bind( JRequest::get('post'), 'usertype' ))

		{

			JError::raiseError( 500, $user->getError());

		}

//Step: 5

		$user->set('id', 0);

//		$user->set('usertype', '');

//		$user->set('gid', 2);//$authorize->get_group_id( '', $newUsertype, 'ARO' )

	

		$role_for_joomla=array("2");



/*

*	-DHS Administrator 15

*	-Agency Administrator 19

*	-Supervisor 20

*	Rest all user are of user group 'Registered' i.e. 2

*	Check table '".$prefix."usergroups'

*/

		if($_POST['adduser']==="dhsadmin")

		{

			$role_for_joomla=array("18");
			//$role_for_joomla=array("2");

		}

		if($_POST['adduser']==="agencyadmin")

		{
			$role_for_joomla=array("19");
			//$role_for_joomla=array("2");

		}

		if($_POST['adduser']==="execparent")

		{

			$role_for_joomla=array("2");

		}

		if($_POST['adduser']==="seniormanager")

		{

			$role_for_joomla=array("2");

		}
		
		
		if($_POST['adduser']==="dhsmanager")

		{

			$role_for_joomla=array("2");

		}

		if($_POST['adduser']==="manager")// Section Manger(Joomla) is Manager in PHP

		{

			$role_for_joomla=array("2");

		}

		if($_POST['adduser']==="supervisor")

		{

			$role_for_joomla=array("2");

		}

		if($_POST['adduser']==="trainer")

		{

			$role_for_joomla=array("2");

		}
		if($_POST['adduser']==="readonlyadministrator")

		{

			$role_for_joomla=array("2");

		}



		

/*		$user->set('usertype', $userType);

		$user->set('gid', $role_for_joomla);//$authorize->get_group_id( '', $newUsertype, 'ARO' )

*/		

		$user->set('groups',$role_for_joomla);



		$gender=$user->get('gender');

		$phone=$user->get('phone');

		$agency=$user->get('agency_name');

		if($agency==null)

		{

			$agency="";

		}

		if(isset($_POST['division_name']))

		{

			$division=getDivisionName($user->get('division_name'));	

		}

		if(isset($_POST['section_name']))

		{

			$section=getSectionName($user->get('section_name'));

		}

		if(isset($_POST['unit_name']))

		{

			$unit=getUnitName($user->get('unit_name'));

		}

		if(isset($_POST['supervisor']))

		{

			$sup_details=getUserDetails($prefix,"id",$user->get('supervisor'));

			$supervisor_email=$sup_details["email"];

			$supervisor_name=$sup_details["name"];

		}

		if($_POST['adduser']==="trainer")
		{

			$agency="";

		}
		
		if($_POST['adduser']==="dhsmanager")
		{

			$agency="DHS";

		}
		
		  $jobtitle  =$_POST['jobtitle'];	
		  $jobcode   =$_POST['jobcode'];
		  $race      =$_POST['race'];
		  $userhours =$_POST['userhours'];
		 // $dob       =$_POST['dob'];
		 // $dob      = date('Y-m-d',strtotime($dob));
		  $expertise =$_POST['expertise'];
		  $profile   =$_POST['profile'];
		  $ssn   	 =$_POST['SSN'];
		  $other   	 =$_POST['job'];
		  $highedu   =$_POST['heducation'];
		  $workerno  =$_POST['workno'];

/*dob date format start*/	 
	  
		     	if($_POST["month"]!=="0" && $_POST["day"]!=="0" && $_POST["year"]!=="0")
				{
					$month=$_POST["month"];
					$day=$_POST["day"];
					$year=$_POST["year"];
					$new_date=$year."-".$month."-".$day;
					$dob=$new_date." $timezone:00:00";//+5 hours as Timezone is newyork UTC-5:00
				}
				else
				{
					$dob="";
				}
					/*$temp_arr=explode('-',htmlspecialchars($_POST['dob']));
					$month=$temp_arr['0'];
					$day=$temp_arr['1'];
					$year=$temp_arr['2'];
					$new_date=$year."-".$month."-".$day;
					$dob=$new_date." $timezone:00:00";//+5 hours as Timezone is newyork UTC-5:00*/
					
				
/*dob date format end*/
		
		$user->set('profile' , array('gender' =>  $gender,'phone' => $phone,'agency'=>$agency,'division'=>$division,'section'=>$section,'unit'=>$unit,'supvisemail'=>$supervisor_email,'supvisename'=>$supervisor_name,'jobtitle'=>$jobtitle,'jobcode'=>$jobcode,'race'=>$race,'userhours'=>$userhours,'dob'=>$dob,'expertise'=>$expertise,
		'profile'=>$profile,'ssn'=>$ssn,'other'=>$other,'highedu'=>$highedu,'workerno'=>$workerno));

//Step: 6 

		$date =& JFactory::getDate();

		$user->set('registerDate', $date->toSQL());

		$user->set('lastvisitDate', '0000-00-00 00:00:00');

//Step: 7

		$useractivation = $usersConfig->get( 'useractivation' );

		$user->set('active', '0' );

		$user->set('block', '0');



		if ($useractivation == '1')

		{

		//	jimport('joomla.user.helper');

		//	$user->set('activation', md5( JUserHelper::genRandomPassword()) );

		//	$user->set('block', '1');

		}

//Step: 8

//	var_dump($_POST);	

		if (!$user->save())

        {                    

			$_SESSION['mail_id_exists']=1;

			$_SESSION['entered_data']=$_POST;

			echo "<script>window.self.location.href = 'add_trainer.php'; </script>";

        }

        else

        {   
			
			$db = JFactory::getDBO();

			$email=$user->get('email');
			
			$username=$user->get('username');
			
			
			
	/*START--> Rahul added new fields 07-feb-2017*/
			
            /*$db->setQuery("update #__users set email='$email' where username='$username'");*/

            $agency_id=$_POST['agency_name'];
			$division_id=$_POST['division_name'];
			$section_id=$_POST['section_name'];
			$unit_id=$_POST['unit_name']; 
			
			$db->setQuery('update #__users set email="'.$email.'",agency_id="'.$agency_id.'",division_id="'.$division_id.'",section_id="'.$section_id.'",unit_id="'.$unit_id.'",created_date="$today_date",created_userid="$ID",created_username="$fullname" where username="$username"');
			
	/*END--> Rahul added new fields 07-feb-2017*/
			
            $db->query();
		   
		 
                $db->setQuery("SELECT id FROM #__users WHERE email='$email'");

                $db->query();

                $newUserID = $db->loadResult();				

                $user = JFactory::getUser($newUserID);

				$adminmail=$config->get('mailfrom');
				
				$db->setQuery("SELECT concat(name,middle_name,last_name)as fullname FROM #__users WHERE id='$newUserID'");
				$db->query();
				$fullname =$db->loadReasult();	


                // Everything OK!               

                if ($user->id != 0)

                {

					if($_POST['adduser']!=="student")

					{

					$query="insert into tbl_trainer (trainer_name,middle_name,last_name,phone,email,expertise,profile,degree) values 
						('".htmlspecialchars($_POST['name'])."','".htmlspecialchars($_POST['middle_name'])."','".htmlspecialchars($_POST['last_name'])."',
						 '".htmlspecialchars($_POST['phone'])."','".htmlspecialchars($_POST['email'])."','".htmlspecialchars($_POST['expertise'])."',
						 '".htmlspecialchars($_POST['profile'])."','".htmlspecialchars($_POST['degree'])."')";

					$db->setQuery($query);
					$db->query();

					}

					 $query="insert into ".$prefix."lms_users (user_id,lms_usertype_id) values ('".$user->id."','".htmlspecialchars($_POST['role_id'])."')";//Value 1 is id of user type 'Teacher'

					$db->setQuery($query);

					$db->query();
					

if($_POST['role_id']==1)

{

	$type="Trainer";

}

if($_POST['role_id']==2)

{

	$type="Student";

}

if($_POST['role_id']==9)

{

	$type="DHS Administrator";

}

if($_POST['role_id']==11)

{

	$type="Agency Administrator";

}

if($_POST['role_id']==12)

{

	$type="Supervisor";

}

if($_POST['role_id']==13)

{

	$type="Manager";

}

if($_POST['role_id']==14)

{

	$type="Senior Manager";

}

if($_POST['role_id']==15)

{

	$type="Executive Parent";

}		

if($_POST['role_id']==16)

{

	$type="DHS Manager";	
	
}	
if($_POST['role_id']==21)

{

	$type="Read-Only Administrator";	
	
}		

    $fname=$user->get('name');

	$mname=$user->get('middle_name');

	$lname=$user->get('last_name');

 $fullnamess=$fname.' '.$lname; // concating the first name,middle name, last name for the display

                    if($useractivation == 0)

                    {

                        $emailSubject = 'Email Subject for registration successfully';

                        $emailBody = 'Email body for registration successfully';                       

                        $return = JFactory::getMailer()->sendMail($adminmail, 'DHSUniversityDev', $user->email, $emailSubject, $emailBody, $mode=0, $cc=null, $bcc='vmilara@performanceplusinc.net', $attachment=null, $replyto=$adminmail, $replytoname='DHSUniversityDev');

                         // Your code here...

                    }

                    //email subject,body changed by vinsilin 14-08-2015
	
                    else if($useractivation == 1)
                    {
					
						$mailer = JFactory::getMailer();
						$mailer -> setSender('info@dhsuniversity.org');
						$recipient=$email;
						$mailer->addRecipient($recipient);
						
						$bcc='vmilara@performanceplusinc.net';
						//$bcc='rahulmsc14@gmail.com';
						//$bcc='pratheesh@irissoftek.com';
						$bccc='subadra@si-tech-solutions.com';
						//$bcccc='kparrish@performanceplusinc.net';
					
					
					
                        $subject = 'DHSU LMS User Account Created';				
                        
						$body .='Dear '.$fname.','.PHP_EOL;
						
						$body .=''.PHP_EOL;
						
						$body .= "You have been granted access to DHS University's Learning Management System (LMS) as a ".$type.".".PHP_EOL;
						
						$body .=''.PHP_EOL;
						
						$body .= 'Your account information is:'.PHP_EOL;
						
						$body .= 'User Name: '.$user->get('username').PHP_EOL;
						$body .= 'Password: '.$_POST['password'].PHP_EOL;
						
						$body .=''.PHP_EOL;
						
						$body .= 'You can access DHS University at www.dhsuniversity.org.'.PHP_EOL;
						
						$body .=''.PHP_EOL;
												
						$body .='Thank You,'.PHP_EOL;
						
						$body .='DHS University'.PHP_EOL;
//						$user_activation_url = JURI::base().JRoute::_('index.php?option=com_users&task=registration.activate&token=' . $user->activation, false);  // Append this URL in your email body
						/*$return = JFactory::getMailer()->sendMail($adminmail, $user->email, $emailSubject, $emailBody, $mode=0, $cc=null, $bcc='vmilara@performanceplusinc.org', $attachment=null, $replyto=$adminmail, $replytoname='DHSUniversityDev');       */  
						
						$mailer->setSubject($subject);
						$mailer->setBody($body);
						$mailer->addBCC($bcc);
						$mailer->addBCC($bccc);
						$mailer->addBCC($bcccc);
						//$send = $mailer->Send();
						    
						                    
						$_SESSION['mail']=1;

						$fullname_new=trim($fullnamess,"'");
						 $_SESSION['tname']="$type ".$fullname_new." has been added.<br/>A mail has been sent to registered email with account details";
						echo "<script>window.self.location.href = 'home.php'; </script>";
					}
                }
             }
	}

?>

<html>



<head><title><?php echo $SITE_NAME?>Add User: Home</title>

<link href="css/style.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="js/dropscript.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="css/jquery-ui.js"></script>

<script type="text/javascript">

jQuery(document).ready(function() {

jQuery("#agency").change(function () {

	/*jQuery(this).after('<div id="loader"><img src="http://dhsuniversity.org/custom/loading (1).gif" alt="loading subcategory" /></div>');*/

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

jQuery(document).ready(function() {

jQuery("#section").change(function () {

	/*jQuery(this).after('<div id="loader"><img src="http://dhsuniversity.org/custom/loading (1).gif" alt="loading subcategory" /></div>');*/

	jQuery.get('load.php?jform_profile_section=' + jQuery(this).val(), function(data) {

	jQuery("#unit").html(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});	

});

});



jQuery(document).ready(function() {

jQuery("#unit").change(function () {

	var agencyname=$("#agency").val();	
	
	/*jQuery(this).after('<div id="loader"><img src="http://dhsuniversity.org/custom/loading (1).gif" alt="loading subcategory" /></div>');*/

	jQuery.get('load.php?jform_profile_unit=' + jQuery(this).val()+'&aid='+agencyname, function(data) {

	jQuery("#supervisor").html(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});	

});

});

//Select Executive Parent for Agency in case of creating Trainer

jQuery(document).ready(function() {

jQuery("#selagencyforexecparent").change(function () {

	/*jQuery(this).after('<div id="loader"><img src="http://dhsuniversity.org/custom/loading (1).gif" alt="loading subcategory" /></div>');*/

	jQuery.get('load.php?execparentbyagency=' + jQuery(this).val(), function(data) {

	jQuery("#selexecparent").html(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});	

});

});

//Display Supervisor Email in following disabled text box

jQuery(document).ready(function() {

jQuery("#selexecparent").change(function () {

	/*jQuery(this).after('<div id="loader"><img src="http://dhsuniversity.org/custom/loading (1).gif" alt="loading subcategory" /></div>');*/

	jQuery.get('load.php?supvsrmail=' + jQuery(this).val(), function(data) {

	jQuery("#supvisr_email").val(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});	

});

});

jQuery(document).ready(function() {

jQuery("#supervisor").change(function () {

	/*jQuery(this).after('<div id="loader"><img src="http://dhsuniversity.org/custom/loading (1).gif" alt="loading subcategory" /></div>');*/

	jQuery.get('load.php?supvsrmail=' + jQuery(this).val(), function(data) {

	jQuery("#supvisr_email").val(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});	

});

});

jQuery(document).ready(function() {

jQuery("#epfromagency").change(function () {

/*	jQuery(this).after('<div id="loader"><img src="http://dhsuniversity.org/custom/loading (1).gif" alt="loading subcategory" /></div>');*/

	jQuery.get('load.php?supvsrmail=' + jQuery(this).val(), function(data) {

	jQuery("#supvisr_email").val(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});	

});

});

jQuery(document).ready(function() {

jQuery("#mgrsupervisor").change(function () {

	/*jQuery(this).after('<div id="loader"><img src="http://dhsuniversity.org/custom/loading (1).gif" alt="loading subcategory" /></div>');*/

	jQuery.get('load.php?supvsrmail=' + jQuery(this).val(), function(data) {

	jQuery("#supvisr_email").val(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});	

});

});

jQuery(document).ready(function() {

jQuery("#supsupervisor").change(function () {

	/*jQuery(this).after('<div id="loader"><img src="http://dhsuniversity.org/custom/loading (1).gif" alt="loading subcategory" /></div>');*/

	jQuery.get('load.php?supvsrmail=' + jQuery(this).val(), function(data) {

	jQuery("#supvisr_email").val(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});	

});

});



//Select Executive Parent for Agency in case of creating Senior Manger

jQuery(document).ready(function() {

jQuery("#selepanddivagency").change(function () {

	/*jQuery(this).after('<div id="loader"><img src="http://dhsuniversity.org/custom/loading (1).gif" alt="loading subcategory" /></div>');*/

	jQuery.get('load.php?jform_profile_agency=' + jQuery(this).val(), function(data) {

	jQuery("#smdivision").html(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});	

});

jQuery("#selepanddivagency").change(function () {

	/*jQuery(this).after('<div id="loader"><img src="http://dhsuniversity.org/custom/loading (1).gif" alt="loading subcategory" /></div>');*/

	jQuery.get('load.php?execparentbyagency=' + jQuery(this).val(), function(data) {

	jQuery("#epfromagency").html(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});	

});

});



//Select Senior Manager for Division in case of creating Manager

jQuery(document).ready(function() {

jQuery("#mgragency").change(function () {

	/*jQuery(this).after('<div id="loader"><img src="http://dhsuniversity.org/custom/loading (1).gif" alt="loading subcategory" /></div>');*/

	jQuery.get('load.php?jform_profile_agency=' + jQuery(this).val(), function(data) {

	jQuery("#mgrdivision").html(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});	

});

});

jQuery(document).ready(function() {

jQuery("#mgrdivision").change(function () {

	/*jQuery(this).after('<div id="loader"><img src="http://dhsuniversity.org/custom/loading (1).gif" alt="loading subcategory" /></div>');*/

	jQuery.get('load.php?jform_profile_division=' + jQuery(this).val(), function(data) {

	jQuery("#mgrsection").html(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});

});

jQuery("#mgrdivision").change(function () {

	//alert('testing');
	var agencyname=$("#mgragency").val();	
	<!--jQuery(mgragency).val()-->
	/*jQuery(this).after('<div id="loader"><img src="http://dhsuniversity.org/custom/loading (1).gif" alt="loading subcategory" /></div>');*/
		
	jQuery.get('load.php?srmgrbydivision=' + jQuery(this).val()+'&aid='+agencyname, function(data) {

	jQuery("#mgrsupervisor").html(data);
	

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});	

});

});



//Select Manager for Section in case of creating supvsr

jQuery(document).ready(function() {

jQuery("#supagency").change(function () {

	/*jQuery(this).after('<div id="loader"><img src="http://dhsuniversity.org/custom/loading (1).gif" alt="loading subcategory" /></div>');*/

	jQuery.get('load.php?jform_profile_agency=' + jQuery(this).val(), function(data) {

	jQuery("#supdivision").html(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});	

});

});

jQuery(document).ready(function() {

jQuery("#supdivision").change(function () {

	/*jQuery(this).after('<div id="loader"><img src="http://dhsuniversity.org/custom/loading (1).gif" alt="loading subcategory" /></div>');*/

	jQuery.get('load.php?jform_profile_division=' + jQuery(this).val(), function(data) {

	jQuery("#supsection").html(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});	

});

});

jQuery(document).ready(function() {

jQuery("#supsection").change(function () {

	/*jQuery(this).after('<div id="loader"><img src="http://dhsuniversity.org/custom/loading (1).gif" alt="loading subcategory" /></div>');*/

	jQuery.get('load.php?jform_profile_section=' + jQuery(this).val(), function(data) {

	jQuery("#supunit").html(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});	

});

jQuery("#supsection").change(function () {

	var agencyname=$("#supagency").val();	
	
	/*jQuery(this).after('<div id="loader"><img src="http://dhsuniversity.org/custom/loading (1).gif" alt="loading subcategory" /></div>');*/

	jQuery.get('load.php?mgrbysection=' + jQuery(this).val()+'&aid='+agencyname, function(data) {

	jQuery("#supsupervisor").html(data);

	jQuery('#loader').slideUp(200, function() {

		jQuery(this).remove();

});

});	

});

});


jQuery(document).ready(function() {
$("#uname").blur(function(){
var usernames=$("#uname").val();
//alert(usernames);
    $.get("validation.php",{username:usernames}, function(data, status){
	//alert("Data: " + data + "\nStatus: " + status);
	var size=data;
	if(size==1)
	{
		//$("#uname").focus();
		$("#uname").val("");
		$("#showme").html("A user is already registered with this username").show().delay(800).fadeOut(2000);
	}
     if(size<1)
	{
		var msg='';
		$("#showme").html(msg);
		return false;
	}   
    });
}); 
});

jQuery(document).ready(function() {
$("#emailid").blur(function(){
var emails=$("#emailid").val();
//alert(emails);
    $.get("validation.php",{email:emails}, function(data, status){
	//alert("Data: " + data + "\nStatus: " + status);
	var size=data;
	if(size==1)
	{
		//$("#emailid").focus();
		$("#emailid").val("");
		//var msg='A user is already registered with this email';
		//$("#showme").html(msg);
		$("#showme").html("A user is already registered with this email").show().delay(800).fadeOut(2000);
	}
	if(size==3)
	{
		//$("#emailid").focus();
		$("#emailid").val("");
		$("#showme").html("Please enter a valid email").show().delay(800).fadeOut(2000);
	}
     if(size<1)
	{
		var msg='';
		$("#showme").html(msg);
		return false;
	}   
    });
}); 
});


function validateForm()

{

		if(document.forms['trainerform'].name.value.length==0)

		{

			alert('Name cannot be empty.');

			document.forms['trainerform'].name.focus();

			return false;

		}

		if(document.forms['trainerform'].username.value.length==0)

		{

			alert('Username cannot be empty.');

			document.forms['trainerform'].username.focus();

			return false;

		}

		if(document.forms['trainerform'].password.value.length==0)

		{

			alert('Password cannot be empty.');

			document.forms['trainerform'].password.focus();

			return false;

		}

		if(document.forms['trainerform'].password2.value.length==0)

		{

			alert('Confirm Password cannot be empty.');

			document.forms['trainerform'].password2.focus();

			return false;

		}

		if(document.forms['trainerform'].password.value!==document.forms['trainerform'].password2.value)

		{

			alert('Password Mismatch.');

			document.forms['trainerform'].password.value='';

			document.forms['trainerform'].password2.value='';

			document.forms['trainerform'].password.focus();

			return false;

		}

		if(document.forms['trainerform'].gender[0].checked==false && document.forms['trainerform'].gender[1].checked==false && document.forms['trainerform'].gender[2].checked==false)

		{

			alert('Select Gender');

			document.forms['trainerform'].gender[0].focus();

			return false;

		}

		/*if(document.forms['trainerform'].phone.value.length<12)

		{

			alert('Phone number must be atleast ten digit.');

			document.forms['trainerform'].phone.focus();

			return false;

		}*/
		/*if(document.forms['trainerform'].month.value.length==0)

		{

			alert('Please select month of your date of birth.');

			document.forms['trainerform'].month.focus();

			return false;

		}
		if(document.forms['trainerform'].day.value.length==0)

		{

			alert('Please select day of your date of birth.');

			document.forms['trainerform'].day.focus();

			return false;

		}
		if(document.forms['trainerform'].year.value.length==0)

		{

			alert('Please select year of your date of birth.');

			document.forms['trainerform'].year.focus();

			return false;

		}*/
		if(document.forms['trainerform'].email.value.length==0)

		{

			alert('Email cannot be empty.');

			document.forms['trainerform'].email.focus();

			return false;

		}
		
		
		
		var k = document.forms["trainerform"]["agency_name"].value;
   		if (k == null || k == "") {
        alert("Agency cannot be empty.");
        return false;
	}
	
	document.forms["trainerform"].submit();

}

function formatPhone()

{

	//alert('Hello');

	if(document.forms['trainerform'].phone.value.length==3 ||

	document.forms['trainerform'].phone.value.length==7)

	{

		var temp=document.forms['trainerform'].phone.value;

		document.forms['trainerform'].phone.value=temp.concat("-");

		document.forms['trainerform'].phone.focus();

	}

}

function formatDate()

{

	//alert('Hello');

	if(document.forms['trainerform'].dob.value.length==2 ||

	document.forms['trainerform'].dob.value.length==5)

	{

		var temp=document.forms['trainerform'].dob.value;

		document.forms['trainerform'].dob.value=temp.concat("-");

		document.forms['trainerform'].dob.focus();

	}

}

window.parent.document.getElementById('blockrandom').height = '420px';

$(function() {
    $( "#datepicker" ).datepicker({ dateFormat: "mm-dd-yy" });//changed from yy-mm-dd
  });


 function capitalize(textboxid, str) {
      // string with alteast one character
      if (str && str.length >= 1)
      {       
          var firstChar = str.charAt(0);
          var remainingStr = str.slice(1);
          str = firstChar.toUpperCase() + remainingStr;
      }
      document.getElementById(textboxid).value = str;
  }  
</script>

<script>
$(function(){
 
  $('#mytextbox1').keyup(function()
  {
    var yourInput = $(this).val();
    re = /[`~!@#$%^&*()|+\=?;:'",<>\{\}\[\]\\\/]/gi;
    var isSplChar = re.test(yourInput);
    if(isSplChar)
    {
      var no_spl_char = yourInput.replace(/[`~!@#$%^&*()|+\=?;:'",<>\{\}\[\]\\\/]/gi, '');
      $(this).val(no_spl_char);
    }
  });
 
});
$(function(){
 
  $('#mytextbox2').keyup(function()
  {
    var yourInput = $(this).val();
    re = /[`~!@#$%^&*()|+\=?;:'",<>\{\}\[\]\\\/]/gi;
    var isSplChar = re.test(yourInput);
    if(isSplChar)
    {
      var no_spl_char = yourInput.replace(/[`~!@#$%^&*()|+\=?;:'",<>\{\}\[\]\\\/]/gi, '');
      $(this).val(no_spl_char);
    }
  });
 
});
$(function(){
 
  $('#mytextbox3').keyup(function()
  {
    var yourInput = $(this).val();
    re = /[`~!@#$%^&*()|+\=?;:'",<>\{\}\[\]\\\/]/gi;
    var isSplChar = re.test(yourInput);
    if(isSplChar)
    {
      var no_spl_char = yourInput.replace(/[`~!@#$%^&*()|+\=?;:'",<>\{\}\[\]\\\/]/gi, '');
      $(this).val(no_spl_char);
    }
  });
 
});
$(function(){
 
  $('#uname').keyup(function()
  {
    var yourInput = $(this).val();
    re = /[`~!@#$%^&*()|+\=?;:'",<>\{\}\[\]\\\/]/gi;
    var isSplChar = re.test(yourInput);
    if(isSplChar)
    {
      var no_spl_char = yourInput.replace(/[`~!@#$%^&*()|+\=?;:'",<>\{\}\[\]\\\/]/gi, '');
      $(this).val(no_spl_char);
    }
  });
 
});

$(function(){
 
  $('#jform_profile_jobcode').keyup(function()
  {
    var yourInput = $(this).val();
    re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
    var isSplChar = re.test(yourInput);
    if(isSplChar)
    {
      var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
      $(this).val(no_spl_char);
    }
  });
 
});

 $(function(){
 
  $('#emailid').keyup(function()
  {
    var yourInput = $(this).val();
    re = /[`~!#$%^&*()|+\=?;:'",<>\{\}\[\]\\\/]/gi;
    var isSplChar = re.test(yourInput);
    if(isSplChar)
    {
      var no_spl_char = yourInput.replace(/[`~!#$%^&*()|+\=?;:'",<>\{\}\[\]\\\/]/gi, '');
      $(this).val(no_spl_char);
	  $("#showme").html("You can use only alphabets, numerals, '_', ' - ', or ' . ' in email name field").show().delay(1200).fadeOut(2000); 
    }
  });
 
});
 

 $(document).ready(function () {
  //called when key is pressed in textbox
  $("#workno").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#showme").html("Please enter the valid worker number").show().delay(1200).fadeOut(2000); 
               return false;
    }
   });
});

 $(document).ready(function () {
  //called when key is pressed in textbox
  $("#ssn").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#showme").html("Please enter the valid ssn").show().delay(1200).fadeOut(2000); 
               return false;
    }
   });
});

  $(document).ready(function () {
  //called when key is pressed in textbox
  $("#phones").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#showme").html("Please enter the valid phone number").show().delay(1200).fadeOut(2000); 
               return false;
    }
   });
});

 $(document).ready(function () {
  //called when key is pressed in textbox
  $("#trhour").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#showme").html("Please enter the valid training hour").show().delay(1200).fadeOut(2000); 
               return false;
    }
   });
});
 
</script>
</head>

<body class="font-for-all">

<div id="wrapper">

<div id="content">

<?php

if($_POST['add_action']!=='trainer_add')

{

	if(isset($_SESSION['entered_data']))

	{

		$old_data=$_SESSION['entered_data'];
		

		$name=$middle_name=$last_name=$username=$gender=$SSN=$workno=$employ=$jobcode=$job=$degree=$heducation=$userhours=$phone=
		$race=$email=$jobtitle=$expertise=$profile=$agency_name="";

		
		$name=$old_data["name"];
		
		$middle_name=$old_data["middle_name"];
		
		$last_name=$old_data["last_name"];

		$username=$old_data["username"];

		$gender=$old_data["gender"];

		$degree=$old_data["degree"];

		$phone=$old_data["phone"];

		$email=$old_data["email"];
		
		$SSN=$old_data["SSN"];
		
		$workno=$old_data["workno"];
		
		$employ=$old_data["employ"];
		
		$jobcode=$old_data["jobcode"];
		
		$job=$old_data["job"];
		
		$jobtitle=$old_data["jobtitle"];
		
		$race=$old_data["race"];
		
		$heducation=$old_data["heducation"];
		
		$userhours=$old_data["userhours"];

		$expertise=$old_data["expertise"];

		$profile=$old_data["profile"];

		$agency_name=$old_data["agency_name"];



		$_POST['type']=$old_data["add_type"];

		$_POST['action']=$old_data["add_action"];

		$_POST['adduser']=$old_data["adduser"];

		$_POST['role_id"']=$old_data["role_id"];

		$_POST['agency_name']=$old_data["agency_name"];

		$_POST['agency']=$old_data["agency_name"];

		unset($_SESSION['entered_data']);

	}

	if($_POST['adduser']==="dhsadmin")

	{

		$usertype="DHS Administrator";

		$roleid=9;

	}

	if($_POST['adduser']==="agencyadmin")

	{

		$usertype="Agency Administrator";	

		$roleid=11;

	}

	if($_POST['adduser']==="supervisor")

	{

		$usertype="Supervisor";	

		$roleid=12;

	}

	if($_POST['adduser']==="trainer")

	{

		$usertype="Trainer";

		$roleid=1;

	}

	if($_POST['adduser']==="student")

	{

		$usertype="Student";

		$roleid=2;

	}
	
	
	
	if($_POST['adduser']==="dhsmanager")

	{

		$usertype="DHS Manager";

		$roleid=16;

	}

	if($_POST['adduser']==="execparent")

	{

		$usertype="Executive Parent";

		$roleid=15;

	}

	if($_POST['adduser']==="seniormanager")

	{

		$usertype="Senior Manager";

		$roleid=14;

	}

	if($_POST['adduser']==="manager") // Section Manger(Joomla) is Manager in PHP

	{

		$usertype="Manager";

		$roleid=13;

	}

	if($_POST['adduser']==="readonlyadministrator")

	{

		$usertype="Read-Only Administrator";

		$roleid=21;

	}

	/*if(isset($_SESSION['mail_id_exists']))

	{

		echo '<center><font color=red>*A user is already registered with this email</font></center>';

		unset($_SESSION['mail_id_exists']);

	}*/

?>
<div id="showme" align="center" style="color:#FF0000"></div>
<form action="add_trainer.php" method="post" style='display:inline;' name='trainerform'>

<table align='center' width='80%'>

	<tr>

<?php
	if($_POST['adduser']==="readonlyadministrator")

	   {

		  echo "<tr ><th colspan='4' align='center'><font color='#13609F' size='+1'><b>ADD READ-ONLY ADMINISTRATOR</b></font></th></td></tr>";

	   }
	   
	if($_POST['adduser']==="dhsadmin")

	   {

		  echo "<tr ><th colspan='4' align='center'><img src='images/add_dhs.gif'/></font></th></td></tr>";

	   }

    if($_POST['adduser']==="agencyadmin")

	   {

		  echo "<tr ><th colspan='4' align='center'><img src='images/add_agency.gif'/></font></th></td></tr>";

	   }

	if($_POST['adduser']==="trainer")

	   {

		  echo "<tr ><th colspan='4' align='center'><img src='images/add_trainer.gif'/></font></th></td></tr>";

	   }
  
	if($_POST['adduser']==="execparent")
	
	  {
	
	 echo "<tr ><th colspan='4' align='center'><img src='images/exe_parent.gif'/></font></th></td></tr>";
	
      }
    
	if($_POST['adduser']==="seniormanager")
	
	  {
	
	 echo "<tr ><th colspan='4' align='center'><img src='images/sen_manager.gif'/></font></th></td></tr>";
	
      }
	  
	  if($_POST['adduser']==="dhsmanager")
	
	  {
	
	 echo "<tr ><th colspan='4' align='center'><img src='images/add_dhs_manager.gif'/></font></th></td></tr>";
	
      }
	  
	  

    if($_POST['adduser']==="manager")
	
	  {
	
	 echo "<tr ><th colspan='4' align='center'><img src='images/manager.gif'/></font></th></td></tr>";
	
      }
   
    if($_POST['adduser']==="supervisor")
	
	  {
	
	 echo "<tr ><th colspan='4' align='center'><img src='images/supervisor.gif'/></font></th></td></tr>";
	
      }
  
    if($_POST['adduser']==="student")
	
	  {
	
	 echo "<tr ><th colspan='4' align='center'><img src='images/student.gif'/></font></th></td></tr>";
	
      }
  	
?>

	<tr><td>&nbsp;</td></tr>
				
	<tr class="row-odd">

		<td>First Name</td>
		<?php 	echo ($name!==""? "<td><input type='text' name='name' value='$name' id='mytextbox1' onkeyup='javascript:capitalize(this.id, this.value);' class='input_class' autocomplete='off'/></td>" :"<td><input type='text' name='name' id='mytextbox1' onkeyup='javascript:capitalize(this.id, this.value);' class='input_class' autocomplete='off'/></td>");?>
		<td>Middle Name</td>
		

<?php 	echo ($middle_name!==""? "<td><input type='text' name='middle_name' value='$middle_name' id='mytextbox2' onkeyup='javascript:capitalize(this.id, this.value);' class='input_class' autocomplete='off'/></td>" :"<td><input type='text' name='middle_name' id='mytextbox2' onkeyup='javascript:capitalize(this.id, this.value);' class='input_class' autocomplete='off'/></td>");?>
</tr>
<tr class="row-even">


<td>Last Name</td>
		

<?php 	echo ($last_name!==""? "<td><input type='text' name='last_name' value='$last_name' id='mytextbox3' onkeyup='javascript:capitalize(this.id, this.value);' class='input_class' autocomplete='off'/></td>" :
							"<td><input type='text' name='last_name' id='mytextbox3' onkeyup='javascript:capitalize(this.id, this.value);' class='input_class' autocomplete='off'/></td>");?>
		<td>Username</td>

<?php 	echo ($username!==""? "<td><input type='text' name='username' value='$username' id='uname' class='input_class' autocomplete='off'/></td>" :
								"<td><input type='text' name='username' id='uname' class='input_class' autocomplete='off'/></td>");?>

	</tr>

	<tr class="row-even">

		<td>Password:</td>

		<td><input type='password' name='password' class='input_class'/></td>

		<td>Confirm Password:</td>

		<td><input type='password' name='password2' class='input_class'/></td>

	</tr>

<tr class="row-even">
<td>Date of Birth:</td>

<?php 	 

echo '<td>';

$months=array (1=> 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
echo'<select name="month">
<option selected="1" value="0">Month</option>';
foreach($months as $key=>$value)
{
echo"<option value=\"$key\">$value</option>\n";
}
echo'</select>';

echo'<select name="day">
<option selected="1" value="0">Day</option>';

for($day=1; $day<=31;$day++)
{
echo"<option value=\"$day\">$day</option>";
}
echo'</select>';

echo'<select name="year">
<option selected="1" value="0">Year</option>';

$year=date('Y');
while($year>=1940)
{
echo"<option value=\"$year\">$year</option>\n";
$year--;
}

echo'</select>';

echo '</td>';
?>
		<td>Gender:</td>

<?php 

if($_POST['adduser']!=="dhsadmin" && $_POST['adduser']!=="agencyadmin")

{		

 	echo ($gender!=="Female"? "<td><input type='radio' name='gender' value='Male' checked/>Male <input type='radio' name='gender' value='Female'/>Female <input type='radio' name='gender' value='Other'/>Other</td>" :"<td><input type='radio' name='gender' value='Male'/>Male <input type='radio' name='gender' value='Female' checked/>Female </td>");

}

else echo ($gender!=="Female"? "<td colspan='3' align='left'><input type='radio' name='gender' value='Male' checked/>Male <input type='radio' name='gender' value='Female'/>Female<input type='radio' name='gender' value='Other'/>Other</td>" :"<td><input type='radio' name='gender' value='Male'/>Male <input type='radio' name='gender' value='Female' checked/>Female </td>");
?>
</tr>

	<tr class="row-even">

		<td>Telephone:</td>

<?php 	echo ($phone!==""? "<td><input type='text' name='phone' class='input_class' value='$phone' onkeyup='formatPhone();' id='phones' maxlength='12' autocomplete='off'/></td>" :"<td><input type='text' name='phone' class='input_class' onkeyup='formatPhone();' maxlength='12' id='phones' autocomplete='off'/></td>");?>

		<td>Email:</td>

<?php 	echo ($email!==''? '<td><input type="text" name="email" id="emailid" class="input_class" value="'.$email.'" autocomplete="off"/></td>' :'<td><input type="text" id="emailid" name="email" class="input_class" autocomplete="off"/></td>');?>

	</tr>
	
	<tr class="row-odd">

		<td>SSN :</td>

<?php 	echo ($SSN!==""? "<td><input type='text' name='SSN' class='input_class' id='ssn' value='$SSN' maxlength='4' autocomplete='off'/></td>" :"<td><input type='text' name='SSN' class='input_class'  maxlength='12' id='ssn' autocomplete='off'/></td>");?>

		<td>Worker No:</td>

<?php 	echo ($workno!==""? "<td><input type='text' name='workno' id='workno' class='input_class' value='$workno' autocomplete='off'/></td>" :"<td><input type='text' id='workno' name='workno' class='input_class' autocomplete='off'/></td>");?>

	</tr>
	
	<tr class="row-even">

		<td>Country of Employment :</td>

<?php 	echo ($employ!==""? "<td><input type='text' name='employ' class='input_class' value='$employ' maxlength='12' autocomplete='off'/></td>" :"<td><input type='text' name='employ' class='input_class'  maxlength='12' autocomplete='off'/></td>");?>

		<td>Job Title:</td>

<?php /*?><?php 	echo ($job!==""? "<td><input type='text' name='jobtitle' id='job' class='input_class' value='$jobtitle'/></td>" :"<td><input type='text' id='job' name='jobtitle' class='input_class'/></td>");?><?php */?>


<td>
<!--<select id="job" name="jobtitle" class="input_class">-->
<select id="jform_profile_jobtitle" name="jobtitle" class="select_class">
			<option value="">N/A</option>
			
<?php		
	$query="SELECT concat(division,' ',job_title) as value,concat(division,' ',job_title) as jobtitle 
				FROM tbl_institution WHERE deleted='0' ORDER BY job_title  ASC";
	$rs=mysql_query($query) or die(mysql_error);
	while($row=mysql_fetch_array($rs))
	{
		$temp=$row['jobtitle'];	
		//echo $crosstemp=$row['value'];	
		
		 $temp2=$row['jobtitle'];
		 $mm=$temp;
		 $comp=strcmp((string)$temp1,(string)$temp2);	
		 
	$sn=strcmp($varm,$mm);
	if($sn==0)
		{
		echo 'true';
		}
		else
		{
		echo 'false';
		}
	
		//echo ($temp===$jobtitle? "<option value='".$row['0']."' selected='selected'>".$row['1']."</option>" :"<option value='".$row['0']."'>".$row['1']."</option>");
		?>
		<?php if($sn==0){ ?>
		<option value="<?php echo $temp; ?>" selected="selected"><?php echo $temp; ?></option>		
		<?php }?>
		<option value="<?php echo $temp; ?>" ><?php echo $temp; ?></option>
		
		
        <?php 
			
		
		
	}// end of while 
	?>
</select>
	</td>	
	</tr>
	
	<tr class="row-odd">

		<td>Job Code:</td>

<?php 	echo ($jobcode!==""? "<td><input type='text' name='jobcode' class='input_class' id='jform_profile_jobcode' value='$jobcode' maxlength='12' autocomplete='off'/></td>" :"<td><input type='text' name='jobcode' class='input_class'  maxlength='12' autocomplete='off'/></td>");?>


		<td>Other:</td>

<?php 	echo ($other!==""? "<td><input type='text' name='job' id='other' class='input_class' value='$job' autocomplete='off'/></td>" :"<td><input type='text' id='other' name='other' class='input_class' autocomplete='off'/></td>");?>

	</tr>
	
	<tr class="row-even">

		<td>Race:</td>

<?php /*?><?php 	echo ($race!==""? "<td><input type='text' name='race' class='input_class' value='$race' maxlength='12'/></td>" :"<td><input type='text' name='race' class='input_class'  maxlength='12'/></td>");?><?php */?>

<td>
			<select name="race" class="input_class">
			<option value="<?php echo $race;?>"><?php echo $race;?></option>
				<?php if ($race!='Black/African American') {?> 	
				<option value="Black/African American">Black/African American</option>
				<?php } ?>
				<?php if ($race!='White/Caucasian') {?> 	
				<option value="White/Caucasian">White/Caucasian</option>
				<?php } ?>
				<?php if ($race!='Asian') {?>
				<option value="Asian" >Asian</option>
				<?php } ?>
				<?php if ($race!='American Indian/Alaskan Native') {?>
				<option value="American Indian/Alaskan Native">American Indian/Alaskan Native</option>
				<?php } ?>
				<?php if ($race!='Native Hawaiin/Pacific Islander') {?>
				<option value="Native Hawaiin/Pacific Islander">Native Hawaiin/Pacific Islander</option>
				<?php } ?>
				<?php if ($race!='Hispanic/Latino') {?>
				<option value="Hispanic/Latino">Hispanic/Latino</option>
				<?php } ?>
				<?php if ($race!='Hispanic/Latino') {?>
				<option value="2 or more">2 or more</option>
				<?php } ?>
				<?php if ($race!='Other') {?>
				<option value="Other">Other</option>
				<?php } ?>
			</select>
</td>


		<td>Current Highest Education Degree:</td>

<?php 	echo ($heducation!==""? "<td><input type='text' name='heducation' id='heducation' class='input_class' value='$heducation' autocomplete='off'/></td>" :"<td><input type='text' id='heducation' name='heducation' class='input_class' autocomplete='off'/></td>");?>

	</tr>
	
	<tr class="row-odd">

		<td>Training Hours Needed:</td>

<?php 	echo ($userhours!==""? "<td><input type='text' name='userhours' id='trhour' class='input_class' value='$userhours' maxlength='12' autocomplete='off'/></td>" :"<td><input type='text' name='userhours' class='input_class'  maxlength='12' autocomplete='off' id='trhour'/></td>");?>

<?php

if($_POST['adduser']!=="dhsadmin" && $_POST['adduser']!=="agencyadmin"){

?>		

		<td>Degree:</td>

		<td><select name='degree' class='select_class'>

<?php		echo	($degree==1? "<option value='1' selected='selected'>Bachelors</option>" :"<option value='1'>Bachelors</option>");

			echo	($degree==2? "<option value='2' selected='selected'>Masters</option>" :"<option value='2'>Masters</option>");

			echo	($degree==3? "<option value='3' selected='selected'>Doctorate</option>" :"<option value='3'>Doctorate</option>");			

			echo	($degree==4? "<option value='4' selected='selected'>Less than high School</option>" :"<option value='4'>Less than high School</option>");

			echo	($degree==5? "<option value='5' selected='selected'>High School Diploma</option>" :"<option value='5'>High School Diploma</option>");

			echo	($degree==6? "<option value='6' selected='selected'>GED</option>" :"<option value='6'>GED</option>");

			echo	($degree==7? "<option value='7' selected='selected'>Associate</option>" :"<option value='7'>Associate</option>");

			?>			

			</select>

		</td>

<?}?>
   </tr>

<?php if($_POST['adduser']!=="dhsadmin" && $_POST['adduser']!=="agencyadmin"){ //added this as per suggestions on March 30?>	

	<tr class="row-odd">

<?php if($_POST['adduser']==="trainer"){?>

		<td>Area of Expertise:</td>

<?php 	echo ($expertise!==""? "<td><input type='text' name='expertise' class='input_class' value='$expertise'/></td>" :"<td><input type='text' name='expertise' class='input_class'/></td>");

}//Expertise only for trainer

?>		

		

		<td>Profile:</td>

<?php 	

if($_POST['adduser']==="trainer")

{

	echo ($profile!==""? "<td><textarea name='profile' rows='4' cols='30' class='textarea_class' >$profile</textarea></td>" :"<td><textarea name='profile' rows='4' cols='30' class='textarea_class'></textarea></td>");

}

else

echo ($profile!==""? "<td colspan='3' align='left'><textarea name='profile' rows='3' cols='30' class='textarea_class' style='width:632px;'>$profile</textarea></td>" :"<td colspan='3' align='left'><textarea name='profile' rows='3' cols='30' class='textarea_class'  style='width:632px;'></textarea></td>");?>	

	</tr>

<?php

} 

if($roletype==3 || $roletype==5 || $roletype==9 || $roletype==21)	//If logged in user is Superuser/DHS ADMIN he can add user to any agency

{

	if($_POST['adduser']==="dhsadmin")//If adding user is a admin, he should be in all agencies

	{

		echo "<input type='hidden' name='agency_name' value='ALL'/>";

	}

/*	else if($_POST['adduser']==="supervisor")//Displaying only agencies which do not have a supervisor

	{

		

		echo "<tr class='row-even'>	<td>Agency:</td><td colspan='3'> <select name='agency_name' class='select_class'>";

		$agency_array=getAgencyWithNoSupervisorDetails($prefix,$roleid);

		for($i=0,$j=count($agency_array);$i<$j;$i++)

		{

			echo "<option value='".$agency_array[$i]['agency_name']."'>".$agency_array[$i]['agency_name']."</option>";

		}

		echo "</td></tr>";

	}

*/	//Removal only after verification, should supervisor be one or many

	else if($_POST['adduser']==="agencyadmin" || $_POST['adduser']==="execparent" || $_POST['adduser']==="trainer")//added trainer

	{

		//Trainer Doesnot belong to any agency, so commented that part below

		if($_POST['adduser']==='trainer')

		{

	/*		echo "<tr class='row-even'>	<td>Agency:</td><td> <select name='agency_name' class='select_class' id='selagencyforexecparent'>";

			$agency_array=getAgencyDetailsExceptAll();

			for($i=0,$j=count($agency_array);$i<$j;$i++)

			{

				if($i==0)

				{

					echo "<option value='0'>--Select Agency--</option>";

				}

				echo "<option value='".$agency_array[$i]['agency_name']."'>".$agency_array[$i]['agency_name']."</option>";

			}

			echo "</td>

			<td>Reporting To:</td><td style='padding-top:15px;'><select name='supervisor' class='select_class' id='selexecparent'><option value='0'>--Select Supervisor--</option></select><br/><input type='text' id='supvisr_email' readonly='true' class='input_class no-border'></td></tr>";

	*/	}

		else

		{

			echo "<tr class='row-even'>	<td>Agency:</td><td colspan='3'> <select name='agency_name' class='select_class'>";

			$agency_array=getAgencyDetailsExceptAll();

			for($i=0,$j=count($agency_array);$i<$j;$i++)

			{

				if($i==0)

				{

					echo "<option value=''>--Select Agency--</option>";

				}

				echo "<option value='".$agency_array[$i]['agency_name']."'>".$agency_array[$i]['agency_name']."</option>";

			}

			echo "</td></tr>";

		}

	}

	else

	{

		if($_POST['adduser']==="student")// || $_POST['adduser']==="trainer"

		{

			echo "<tr class='row-even'>	<td>Agency:</td><td><select name='agency_name' class='select_class' id='agency'>";

			$agency_array=getAgencyDetailsExceptAll();

			for($i=0,$j=count($agency_array);$i<$j;$i++)

			{

				if($i==0)

				{

					echo "<option value=''>--Select Agency--</option>";

				}

				echo "<option value='".$agency_array[$i]['id']."'>".$agency_array[$i]['agency_name']."</option>";

			}

			echo "</td>

			<td>Reporting To:</td><td><select name='supervisor' class='select_class' id='supervisor'><option value='0'>--Select Supervisor--</option></select><br/><input type='text' id='supvisr_email' readonly='true' class='input_class no-border'></td></tr>";

			echo "<tr class='row-odd'><td>Division:</td><td colspan='3'><select name='division_name' class='select_class' id='division'><option value='0'>--Select Division--</option></select>";

			echo "<tr class='row-even'><td>Section:</td><td colspan='3'><select name='section_name' class='select_class' id='section'><option value='0'>--Select Section--</option></select></td></tr>";

			echo "<tr class='row-odd'><td>Unit:</td><td colspan='3'><select name='unit_name' class='select_class' id='unit'><option value='0'>--Select Unit--</option></select></td></tr>";		

		}

		else

		{

/*			echo "<tr class='row-even'>	<td>Agency:</td><td colspan='3'> <select name='agency_name' class='select_class' id='agency'>";

			$agency_array=getAgencyDetailsExceptAll();

			for($i=0,$j=count($agency_array);$i<$j;$i++)

			{

				if($i==0)

				{

					echo "<option value='0'>--Select Agency--</option>";

				}

				echo "<option value='".$agency_array[$i]['agency_name']."'>".$agency_array[$i]['agency_name']."</option>";

			}

			echo "</td></tr>";

			if($_POST['adduser']==="seniormanager")

			{

				echo "<tr class='row-odd'><td>Division:</td><td colspan='3'><select name='division_name' class='select_class' id='division'>";

			}

			else if($_POST['adduser']==="manager")

			{

				echo "<tr class='row-odd'><td>Division:</td><td colspan='3'><select name='division_name' class='select_class' id='division'>";

				echo "<tr class='row-even'><td>Section:</td><td colspan='3'><select name='section_name' class='select_class' id='section'/></td></tr>";

			}

			else

			{	

				echo "<tr class='row-odd'><td>Division:</td><td colspan='3'><select name='division_name' class='select_class' id='division'>";

				echo "<tr class='row-even'><td>Section:</td><td colspan='3'><select name='section_name' class='select_class' id='section'/></td></tr>";

				echo "<tr class='row-odd'><td>Unit:</td><td colspan='3'><select name='unit_name' class='select_class' id='unit'/></td></tr>";		

			}

*/		

function test()

{

	$agency_array=getAgencyDetailsExceptAll();

	for($i=0,$j=count($agency_array);$i<$j;$i++)

	{

		if($i==0)

		{

			echo "<option value=''>--Select Agency--</option>";

		}

		echo "<option value='".$agency_array[$i]['agency_name']."'>".$agency_array[$i]['agency_name']."</option>";

	}

}

		

			if($_POST['adduser']==="seniormanager")

			{

				echo "<tr class='row-even'>	<td>Agency:</td><td> <select name='agency_name' class='select_class' id='selepanddivagency'>";

				test();	

				echo "</td>

				<td>Reporting To:</td><td><select name='supervisor' class='select_class' id='epfromagency'><option value='0'>--Select Supervisor--</option></select><br/><input type='text' id='supvisr_email' readonly='true' class='input_class no-border'></td></tr>";

				echo "<tr class='row-odd'><td>Division:</td><td colspan='3'><select name='division_name' class='select_class' id='smdivision'>";

				

			}	

			if($_POST['adduser']==="manager")

			{

				echo "<tr class='row-even'>	<td>Agency:</td><td> <select name='agency_name' class='select_class' id='mgragency'>";

				test();

				echo "</td>

				<td>Reporting To:</td><td><select name='supervisor' class='select_class' id='mgrsupervisor'><option value='0'>--Select Supervisor--</option></select><br/><input type='text' id='supvisr_email' readonly='true' class='input_class no-border'></td></tr>";

				echo "<tr class='row-odd'><td>Division:</td><td colspan='3'><select name='division_name' class='select_class' id='mgrdivision'>";

				echo "<tr class='row-even'><td>Section:</td><td colspan='3'><select name='section_name' class='select_class' id='mgrsection'/></td></tr>";			
				


			}

			if($_POST['adduser']==="supervisor")

			{

				echo "<tr class='row-even'>	<td>Agency:</td><td> <select name='agency_name' class='select_class' id='supagency'>";

				test();

				echo "</td>

				<td>Reporting To:</td><td><select name='supervisor' class='select_class' id='supsupervisor'><option value='0'>--Select Supervisor--</option></select><br/><input type='text' id='supvisr_email' readonly='true' class='input_class no-border'></td></tr>";

				echo "<tr class='row-odd'><td>Division:</td><td colspan='3'><select name='division_name' class='select_class' id='supdivision'>";

				echo "<tr class='row-even'><td>Section:</td><td colspan='3'><select name='section_name' class='select_class' id='supsection'/></td></tr>";

				echo "<tr class='row-odd'><td>Unit:</td><td colspan='3'><select name='unit_name' class='select_class' id='supunit'/></td></tr>";		

			}

		}

	}

}

else	//If logged in user is Agency Administrator he can add user to only to his agency

{

	if($_POST['agency']!=="")

	{

		$agency=htmlspecialchars($_POST['agency']);

	}

	else

	{

		$agency=$agency_name;

	}

	echo "<input type='hidden' name='agency_name' value='".htmlspecialchars($_POST['agency'])."'/>";

	if($_POST['adduser']==="seniormanager")

	{

		$agency=htmlspecialchars($_POST['agency']);

		echo "<tr class='row-even'>	<td>Division:</td><td> <select name='division_name' class='select_class'>";

		$division_array=getDivisionByAgency($agency);

		for($i=0,$j=count($division_array);$i<$j;$i++)

		{

			if($i==0)

			{

				echo "<option value='0'>--Select Division--</option>";

			}

			echo "<option value='".$division_array[$i]['id']."'>".$division_array[$i]['division_name']."</option>";

		}

		echo "</td>

			<td>Reporting To:</td>

			<td><select name='supervisor' class='select_class' id='epfromagency'>";

		$_SESSION['srmgrselagency']=$agency;

		require("./load.php");

		unset($_SESSION['srmgrselagency']);

		echo"	</select><br/><input type='text' id='supvisr_email' readonly='true' class='input_class no-border'></td></tr>";

	}

	if($_POST['adduser']==="manager")

	{

		$agency=htmlspecialchars($_POST['agency']);
		?>
		<input type="hidden" name="agen" id="mgragency" value="<?php echo $agency?>"/>
		<?php
		echo "<tr class='row-even'>	<td>Division:</td><td> <select name='division_name' class='select_class' id='mgrdivision'>";

		$division_array=getDivisionByAgency($agency);

		for($i=0,$j=count($division_array);$i<$j;$i++)

		{

			if($i==0)

			{

				echo "<option value='0'>--Select Division--</option>";

			}

			echo "<option value='".$division_array[$i]['id']."'>".$division_array[$i]['division_name']."</option>";

		}

		echo "</td>

			<td>Reporting To:</td>

			<td><select name='supervisor' class='select_class' id='mgrsupervisor'><br/><input type='text' id='supvisr_email' readonly='true' class='input_class no-border'></td></tr>";

		echo "<tr  class='row-odd'><td>Section:</td><td colspan='3'><select name='section_name' class='select_class' id='mgrsection'/></td></tr>";

	}

	if($_POST['adduser']==="supervisor" || $_POST['adduser']==="student")//|| $_POST['adduser']==="trainer"

	{

		$agency=htmlspecialchars($_POST['agency']);

	if($_POST['adduser']==="supervisor")//|| $_POST['adduser']==="trainer"

	{	
	?>
		<input type="hidden" name="agen" id="supagency" value="<?php echo $agency?>"/>
	<?php
		echo "<tr class='row-even'>	<td>Division:</td><td><select name='division_name' class='select_class' id='supdivision'>";
		
		
		$division_array=getDivisionByAgency($agency);

		for($i=0,$j=count($division_array);$i<$j;$i++)

		{

			if($i==0)

			{

				echo "<option value='0'>--Select Division--</option>";

			}

			echo "<option value='".$division_array[$i]['id']."'>".$division_array[$i]['division_name']."</option>";

		}

		echo "</td>

		<td>Reporting To:</td><td><select name='supervisor' class='select_class' id='supsupervisor'><option value='0'>--Select Supervisor--</option></select><br/><input type='text' id='supvisr_email' readonly='true' class='input_class no-border'></td></tr>";

		echo "<tr class='row-odd'><td>Section:</td><td colspan='3'><select name='section_name' class='select_class' id='supsection'/></td></tr>";

		echo "<tr class='row-even'><td>Unit:</td><td colspan='3'><select name='unit_name' class='select_class' id='supunit'/></td></tr>";



	}

	else

	{
	?>
	<input type="hidden" name="agen" id="agency" value="<?php echo $agency?>"/>
	<?php
		echo "<tr class='row-even'>	<td>Division:</td><td><select name='division_name' class='select_class' id='division'>";

		$division_array=getDivisionByAgency($agency);

		for($i=0,$j=count($division_array);$i<$j;$i++)

		{

			if($i==0)

			{

				echo "<option value='0'>--Select Division--</option>";

			}

			echo "<option value='".$division_array[$i]['id']."'>".$division_array[$i]['division_name']."</option>";

		}

		echo "</td>

		<td>Reporting To:</td><td><select name='supervisor' class='select_class' id='supervisor'/><br/><input type='text' id='supvisr_email' readonly='true' class='input_class no-border'></td></tr>";

			echo "<tr class='row-odd'><td>Section:</td><td colspan='3'><select name='section_name' class='select_class' id='section'/></td></tr>";

		echo "<tr class='row-even'><td>Unit:</td><td colspan='3'><select name='unit_name' class='select_class' id='unit'/></td></tr>";



	}

	}

	//commented by John on 11 april 2015 - Trainer has no reporting authority 

	/*if($_POST['adduser']==="trainer")

	{

		echo "<tr class='row-even'><td>Reporting To:</td>

		<td colspan='3'><select name='supervisor' class='select_class' id='epfromagency'>";

		$_SESSION['srmgrselagency']=$agency;

		require("./load.php");

		unset($_SESSION['srmgrselagency']);

		echo"	</select></td></tr>";

	}*/

	

}

?>

<!--<tr><td colspan='4' align='center'><input type='submit' value='' class='btn-add-big big' onclick='return validateForm();'/>-->

<input type='hidden' name='add_type' value='<?php echo $_POST['type']?>' />

<input type='hidden' name='add_action' value='<?php echo $_POST['action']?>' />

<input type='hidden' name='adduser' value='<?php echo $_POST['adduser']?>' />

<input type='hidden' name='role_id' value='<?php echo $roleid;?>' />

</form>

<?php

echo "<tr><td colspan='4' align='center'><input type='submit' value='' class='btn-add-big big' onclick='return validateForm();'/>";

if($_POST['location']==="admin")

{

	echo "<form action=$SITE_ROOT/administrator/index.php?option=com_adminmenu method=\"post\" style='display:inline;'> 

			<input type=\"submit\" value=\"\" class=\"btn-cancel-big big\"/>

			</form>	";

}

else if($_POST['location']==="createuserhome")

{

	$agency=htmlspecialchars($_POST['agency']);

	echo "<form action=create_user_home.php method=\"post\" style='display:inline;'>

			<input type='hidden' name='agency' value='$agency'/>

			<input type=\"submit\" value=\"\" class=\"btn-cancel-big big\"/>

			</form>	";	

}

else

{

	echo "<form action=home.php method=\"post\" style='display:inline;'>

			<input type=\"submit\" value=\"\" class=\"btn-cancel-big big\"/>

			</form>	";

}

	echo "</td></tr></table>";

	}		

?>

</div></div>
<html>
<head><title><?php echo $SITE_NAME?>View Profile</title>
<link href="css/style.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="css/jquery-ui.js"></script>

<script>
window.parent.document.getElementById('blockrandom').height = '700px';
 
jQuery(document).ready(function() {
	if(jQuery("#jform_profile_jobtitle").val()=='Other')
	{
		jQuery('#jform_profile_other').attr('readonly', false);	
	}
jQuery("#jform_profile_jobtitle").change(function () {
	jQuery(this).after('<div id="loader"><img src="loading (1).gif" alt="loading subcategory" /></div>');
	jQuery.get('load.php?jform_profile_jobtitle=' + jQuery(this).val(), function(data) {
	if(jQuery("#jform_profile_jobtitle").val()=='Other')
	{
		jQuery("#jform_profile_jobcode").val('0');
		jQuery("#jform_profile_jobcode2").val('0');
		jQuery('#jform_profile_other').attr('readonly', false);
	}
	else
	{
		jQuery("#jform_profile_jobcode").val(data);
		jQuery("#jform_profile_jobcode2").val(data);
		jQuery("#jform_profile_other").val('');
		jQuery('#jform_profile_other').attr('readonly', true);
	}
	jQuery('#loader').slideUp(200, function() {
		jQuery(this).remove();
});
});	
});
});
  
</script>
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
 

