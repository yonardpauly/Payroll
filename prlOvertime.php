<?php
/* $Revision: 1.0 $ */

$PageSecurity = 15;

include ('includes/session.inc.php');

$title = _('Overtime Section');

include ('includes/header.inc.php');

if (isset($_GET['OverTimeID'])){
	$OverTimeID = $_GET['OverTimeID'];
} elseif (isset($_POST['OverTimeID'])){
	
	$OverTimeID = $_POST['OverTimeID'];
} else {
	unset($OverTimeID);
}


if (isset($_POST['submit'])) {

	//initialise no input errors assumed initially before we test

	$InputError = 0;

	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */

	//first off validate inputs sensible

	if (strpos($_POST['OverTimeDesc'],'&')>0 OR strpos($_POST['OverTimeDesc'],"'")>0) {
		$InputError = 1;
		prnMsg( _('The overtime description cannot contain the character') . " '&' " . _('or the character') ." '",'error');
	}
	if (trim($_POST['OverTimeDesc']) == '') {
		$InputError = 1;
		prnMsg( _('The overtime description may not be empty'), 'error');
	}
	
	if (strlen($OverTimeID) == 0) {
		$InputError = 1;
		prnMsg(_('The overtime Code cannot be empty'),'error');
	}

	if ($InputError !=1) {
	
			if (!isset($_POST['New'])) {

			$sql = "UPDATE prlovertimetable SET overtimedesc='" . DB_escape_string($db, $_POST['OverTimeDesc']) . "', 
							overtimerate='" . DB_escape_string($db, $_POST['OverTimeRate']) . "' 
						WHERE overtimeid = '$OverTimeID'";

			$ErrMsg = _('The overtime could not be updated because');
			$DbgMsg = _('The SQL that was used to update the overtime but failed was');
			$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);
			prnMsg(_('The overtime master record for') . ' ' . $OverTimeID . ' ' . _('has been updated'),'success');

		} else { //its a new overtime

			$sql = "INSERT INTO prlovertimetable (overtimeid, 
							overtimedesc, 
							overtimerate)
					 VALUES ('$OverTimeID', 
					 	'" .DB_escape_string($db, $_POST['OverTimeDesc']) . "', 
						'" . DB_escape_string($db, $_POST['OverTimeRate']) . "')";

			$ErrMsg = _('The overtime') . ' ' . $_POST['OverTimeDesc'] . ' ' . _('could not be added because');
			$DbgMsg = _('The SQL that was used to insert the overtime but failed was');
			$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);

			prnMsg(_('A new overtime for') . ' ' . $_POST['OverTimeDesc'] . ' ' . _('has been added to the database'),'success');

			unset ($OverTimeID);
			unset($_POST['OverTimeDesc']);
			unset($_POST['OverTimeRate']);

		}
		
	} else {

		prnMsg(_('Validation failed') . _('no updates or deletes took place'),'warn');

	}

} elseif (isset($_POST['delete']) AND $_POST['delete'] != '') {

//the link to delete a selected record was clicked instead of the submit button

	$CancelDelete = 0;

// PREVENT DELETES IF DEPENDENT RECORDS IN 'SuppTrans' , PurchOrders, SupplierContacts
	if ($CancelDelete == 0) {
		$sql="DELETE FROM prlovertimetable WHERE overtimeid='$OverTimeID'";
		$result = DB_query($sql, $db);
		prnMsg(_('Overtime record for') . ' ' . $OverTimeID . ' ' . _('has been deleted'),'success');
		unset($OverTimeID);
		unset($_SESSION['OverTimeID']);
	} //end if Delete paypayperiod
}


if (!isset($OverTimeID)) {

/*If the page was called without $SupplierID passed to page then assume a new supplier is to be entered show a form with a Supplier Code field other wise the form showing the fields with the existing entries against the supplier will show for editing with only a hidden SupplierID field*/

	echo "<FORM METHOD='post' ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "'>";

	echo "<INPUT TYPE='hidden' NAME='New' VALUE='Yes'>";

	echo '<CENTER><TABLE>';
	echo '<TR><TD>' . _('Overtime Code') . ":</TD><TD><INPUT TYPE='text' NAME='OverTimeID' SIZE=5 MAXLENGTH=4></TD></TR>";
	echo '<TR><TD>' . _('Pay Description') . ":</TD><TD><INPUT TYPE='text' NAME='OverTimeDesc' SIZE=41 MAXLENGTH=40></TD></TR>";
	echo '<TR><TD>' . _('Overtime Rate') . ":</TD><TD><INPUT TYPE='text' NAME='OverTimeRate' SIZE=7 MAXLENGTH=6></TD></TR>";
//	echo '</SELECT></TD></TR>';
	echo "</SELECT></TD></TR></TABLE><p><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Insert New Overtime') . "'>";
	echo '</FORM>';
	
		$sql = "SELECT overtimeid,
			overtimedesc,
			overtimerate
			FROM prlovertimetable
			ORDER BY overtimeid";

	$ErrMsg = _('Could not get overtime because');
	$result = DB_query($sql,$db,$ErrMsg);
	
	echo '<CENTER><table border=1>';
	echo "<tr>
		<td class='tableheader'>" . _('Overtime Code') . "</td>
		<td class='tableheader'>" . _('Overtime Description') . "</td>
		<td class='tableheader'>" . _('Overtime Rate') . "</td>
	</tr>";

		
	$k=0; //row colour counter
	while ($myrow = DB_fetch_row($result)) {

		if ($k==1){
			echo "<TR BGCOLOR='#CCCCCC'>";
			$k=0;
		} else {
			echo "<TR BGCOLOR='#EEEEEE'>";
			$k++;
		}
		echo '<TD>' . $myrow[0] . '</TD>';
		echo '<TD>' . $myrow[1] . '</TD>';
		echo '<TD>' . $myrow[2] . '</TD>';
		echo '<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&OverTimeID=' . $myrow[0] . '">' . _('Edit') . '</A></TD>';
		echo '<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&OverTimeID=' . $myrow[0] . '&delete=1">' . _('Delete') .'</A></TD>';
		echo '</TR>';

	} //END WHILE LIST LOOP
	echo '</table></CENTER><p>';


} else {
//OverTimeID exists - either passed when calling the form or from the form itself

	echo "<FORM METHOD='post' ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "'>";
	echo '<CENTER><TABLE>';

	//if (!isset($_POST['New'])) {
	if (!isset($_POST['New'])) {
		$sql = "SELECT overtimeid, 
				overtimedesc, 
				overtimerate
			FROM prlovertimetable 
			WHERE overtimeid = '$OverTimeID'";
				  
		$result = DB_query($sql, $db);
		$myrow = DB_fetch_array($result);
		
		$_POST['OverTimeDesc']  = $myrow['overtimedesc'];
		$_POST['OverTimeRate']  = $myrow['overtimerate'];
		echo "<INPUT TYPE=HIDDEN NAME='OverTimeID' VALUE='$OverTimeID'>";

	} else {
	// its a new overtime being added
		echo "<INPUT TYPE=HIDDEN NAME='New' VALUE='Yes'>";
		echo '<TR><TD>' . _('Overtime Code') . ":</TD><TD><INPUT TYPE='text' NAME='OverTimeID' VALUE='$OverTimeID' SIZE=5 MAXLENGTH=4></TD></TR>";
	}
	echo "<TR><TD>" . _('Overtime Description') . ':' . "</TD><TD><input type='Text' name='OverTimeDesc' SIZE=41 MAXLENGTH=40 value='" . $_POST['OverTimeDesc'] . "'></TD></TR>";
	echo "<TR><TD>" . _('Overtime Rate') . ':' . "</TD><TD><input type='Text' name='OverTimeRate' SIZE=4 MAXLENGTH=6 value='" . $_POST['OverTimeRate'] . "'></TD></TR>";
	echo '</SELECT></TD></TR>';

	if (isset($_POST['New'])) {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Add These New overtime Details') . "'></FORM>";
	} else {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Update overtime') . "'>";
		echo '<P><FONT COLOR=red><B>' . _('WARNING') . ': ' . _('There is no second warning if you hit the delete button below') . '. ' . _('However checks will be made to ensure before the deletion is processed') . '<BR></FONT></B>';
		echo "<INPUT TYPE='Submit' NAME='delete' VALUE='" . _('Delete overtime') . "' onclick=\"return confirm('" . _('Are you sure you wish to delete this overtime?') . "');\"></FORM>";
	}

} // end of main ifs

include ('includes/footer.inc.php');
?>