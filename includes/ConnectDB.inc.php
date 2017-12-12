<?php
/* $Revision: 1.19 $ */

if ( !isset($_SESSION['DatabaseName']) ){
	if ( isset($_POST['CompanyNameField']) ){ 
		$_SESSION['DatabaseName'] = $_POST['CompanyNameField'];
		include_once ($PathPrefix . 'includes/ConnectDB_' . $dbType . '.inc.php');
	} 
} else {
 	include_once ( $PathPrefix .'includes/ConnectDB_' . $dbType . '.inc.php' );
}

?>
