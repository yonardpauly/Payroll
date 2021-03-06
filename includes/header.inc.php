<?php

/* $Revision: 1.27 $ */
	// Titles and screen header
	// Needs the file config.php loaded where the variables are defined for
	//  $rootpath
	//  $title - should be defined in the page this file is included with

	if ( !headers_sent() ){
		header('Content-type: text/html; charset=' . _('ISO-8859-1'));
	}
	echo '<!DOCTYPE html>';
	echo '<HTML><HEAD><TITLE>' . $title . '</TITLE>';
	echo '<link REL="shortcut icon" HREF="'. $rootpath.'/favicon.ico">';
	echo '<link REL="icon" HREF="' . $rootpath.'/favicon.ico">';
	echo '<meta http-equiv="Content-Type" content="text/html; charset=' . _('ISO-8859-1') . '">';
	echo '<LINK HREF="'.$rootpath. '/css/'. $_SESSION['Theme'] .'/default.css" REL="stylesheet" TYPE="text/css">';
	/*
	echo '<script src="' . $rootpath .'/includes/num_date.js" language="JavaScript"></script>';
	*/
	
	echo '</HEAD>';

	echo '<BODY>';
	echo '<TABLE CLASS="callout_main" CELLPADDING="0" CELLSPACING="0">';
	echo '<TR>';
	echo '<TD COLSPAN="2" ROWSPAN="2">';

	echo '<TABLE CLASS="main_page" ALIGN="right" CELLPADDING="0" CELLSPACING="0">';
	echo '<TR>';
	echo '<TD>';
	echo '<TABLE WIDTH="100%" BORDER="1" CELLPADDING="0" CELLSPACING="0">';
	echo '<TR>';
	echo '<TD CLASS="quick_menu">';

	if ( $title AND substr( $title,0,4 ) != 'Help') {
		echo '<TABLE CELLPADDING="0" CELLSPACING="0">';
		echo '<TR>';
		echo '<TD ALIGN="left" WIDTH="100%" CLASS="quick_menu_left">';
		echo  $_SESSION['CompanyRecord']['coyname'] . ': <A HREF="'. $rootpath .'/UserSettings.php?' . SID . '">' . $_SESSION['UsersRealName'] .'</A>';
		echo '<BR>' . $title . '</TD>';
		echo '<TD ALIGN="right">';
		echo '<IMG SRC="' .$rootpath . '/css/' . $theme .'/images/menucurve.gif" WIDTH="30" HEIGHT="30" alt=""></TD>';
		echo '<TD CLASS="quick_menu_tabs">';
		echo '<TABLE><TR>';
		echo '<TD CLASS="quick_menu_tabs" ALIGN="center"><A ACCESSKEY="1" HREF="' .  $rootpath . '/index.php?' . SID . '"><U>1</U>. ' . _('Main  Menu') . '</A>&nbsp;&nbsp;</TD>';

		if (count($_SESSION['AllowedPageSecurityTokens'])>1){

			echo '<TD CLASS="quick_menu_tabs" ALIGN="center"><A ACCESSKEY="2" HREF="' .  $rootpath . '/prlSelectPayroll.php?' . SID . '"><U>2</U>. ' . _('Select Payroll') . '</A>&nbsp;&nbsp;</TD>';

			echo '<TD CLASS="quick_menu_tabs" ALIGN="center"><A ACCESSKEY="3" HREF="' .  $rootpath . '/prlSelectEmployee.php?' . SID . '"><U>3</U>. ' . _('Select Employee') . '</A>&nbsp;&nbsp;</TD>';

			echo '<TD CLASS="quick_menu_tabs" ALIGN="center"><A ACCESSKEY="4" HREF="' .  $rootpath . '/prlabout.php?' . SID . '"><U>4</U>. ' . _('About') . '</A>&nbsp;&nbsp;</TD>';

			echo '<TD CLASS="quick_menu_tabs" ALIGN="center"><A TARGET="_blank" ACCESSKEY="5" HREF="' .  $rootpath . '/doc/Manual/ManualContents.php?' . SID . '"><U>5</U>. ' . _('Manual') . '</A>&nbsp;&nbsp;</TD>';

		}

		echo "<TD CLASS=\"quick_menu_tabs\" ALIGN=\"center\"><A ACCESSKEY=\"0\" HREF=\"" . $rootpath . '/Logout.php?' . SID . "\" onclick=\"return confirm('" . _('Are you sure you wish to logout?') . "');\"><U>0</U> "  . _('Logout') . '</A></TD>'; 
		
		

		echo '</TR></TABLE>';
		echo '</TD></TR></TABLE>';

	}

echo '</TD>';
echo '</TR>';
echo '</TABLE>';

?>