<?php
/* $Revision: 1.0 $ */

$PageSecurity = 15;

include ('includes/session.inc.php');

$title = _('Pay Period Section');

include ('includes/header.inc.php');

if (isset($_GET['PayPeriodID'])){
	$PayPeriodID = $_GET['PayPeriodID'];
} elseif (isset($_POST['PayPeriodID'])){
	
	$PayPeriodID = $_POST['PayPeriodID'];
} else {
	unset($PayPeriodID);
}


if (isset($_POST['submit'])) {

	//initialise no input errors assumed initially before we test

	$InputError = 0;

	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */

	//first off validate inputs sensible

	if (strpos($_POST['PayPeriodName'],'&')>0 OR strpos($_POST['PayPeriodName'],"'")>0) {
		$InputError = 1;
		prnMsg( _('The Pay Period description cannot contain the character') . " '&' " . _('or the character') ." '",'error');
	}
	if (trim($_POST['PayPeriodName']) == '') {
		$InputError = 1;
		prnMsg( _('The Pay Period description may not be empty'), 'error');
	}
	
	if (strlen($PayPeriodID) == 0) {
		$InputError = 1;
		prnMsg(_('The Pay Period Code cannot be empty'),'error');
	}

	if ($InputError !=1) {
	
			if (!isset($_POST['New'])) {

			$sql = "UPDATE prlpayperiod SET payperioddesc='" . DB_escape_string($db, $_POST['PayPeriodName']) . "', 
							numberofpayday='" . DB_escape_string($db, $_POST['NumberOfPayday']) . "' 
						WHERE payperiodid = '$PayPeriodID'";

			$ErrMsg = _('The pay period could not be updated because');
			$DbgMsg = _('The SQL that was used to update the pay period but failed was');
			$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);
			prnMsg(_('The pay period master record for') . ' ' . $PayPeriodID . ' ' . _('has been updated'),'success');

		} else { //its a new pay period

			$sql = "INSERT INTO prlpayperiod (payperiodid, 
							payperioddesc, 
							numberofpayday)
					 VALUES ('$PayPeriodID', 
					 	'" .DB_escape_string($db, $_POST['PayPeriodName']) . "', 
						'" . DB_escape_string($db, $_POST['NumberOfPayday']) . "')";

			$ErrMsg = _('The pay period') . ' ' . $_POST['PayPeriodName'] . ' ' . _('could not be added because');
			$DbgMsg = _('The SQL that was used to insert the pay period but failed was');
			$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);

			prnMsg(_('A new pay period for') . ' ' . $_POST['PayPeriodName'] . ' ' . _('has been added to the database'),'success');

			unset ($PayPeriodID);
			unset($_POST['PayPeriodName']);
			unset($_POST['NumberOfPayday']);

		}
		
	} else {

		prnMsg(_('Validation failed') . _('no updates or deletes took place'),'warn');

	}

} elseif (isset($_POST['delete']) AND $_POST['delete'] != '') {

//the link to delete a selected record was clicked instead of the submit button

	$CancelDelete = 0;

// PREVENT DELETES IF DEPENDENT RECORDS IN 'SuppTrans' , PurchOrders, SupplierContacts
	if ($CancelDelete == 0) {
		$sql="DELETE FROM prlpayperiod WHERE payperiodid='$PayPeriodID'";
		$result = DB_query($sql, $db);
		prnMsg(_('Pay Period record for') . ' ' . $PayPeriodID . ' ' . _('has been deleted'),'success');
		unset($PayPeriodID);
		unset($_SESSION['PayPeriodID']);
	} //end if Delete paypayperiod
}


if (!isset($PayPeriodID)) {

/*If the page was called without $SupplierID passed to page then assume a new supplier is to be entered show a form with a Supplier Code field other wise the form showing the fields with the existing entries against the supplier will show for editing with only a hidden SupplierID field*/

	echo "<FORM METHOD='post' ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "'>";

	echo "<INPUT TYPE='hidden' NAME='New' VALUE='Yes'>";

	echo '<CENTER><TABLE>';
	echo '<TR><TD>' . _('Pay Period Code') . ":</TD><TD><INPUT TYPE='text' NAME='PayPeriodID' SIZE=5 MAXLENGTH=4></TD></TR>";
	echo '<TR><TD>' . _('Pay Description') . ":</TD><TD><INPUT TYPE='text' NAME='PayPeriodName' SIZE=16 MAXLENGTH=15></TD></TR>";
	echo '<TR><TD>' . _('Number of Pay Day') . ":</TD><TD><INPUT TYPE='text' NAME='NumberOfPayday' SIZE=12 MAXLENGTH=11></TD></TR>";
//	echo '</SELECT></TD></TR>';
	echo "</SELECT></TD></TR></TABLE><p><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Insert New Pay Period') . "'>";
	echo '</FORM>';
	
		$sql = "SELECT payperiodid,
			payperioddesc,
			numberofpayday
			FROM prlpayperiod
			ORDER BY payperiodid";

	$ErrMsg = _('Could not get pay period because');
	$result = DB_query($sql,$db,$ErrMsg);
	
	echo '<CENTER><table border=1>';
	echo "<tr>
		<td class='tableheader'>" . _('Pay Code') . "</td>
		<td class='tableheader'>" . _('Pay Description') . "</td>
		<td class='tableheader'>" . _('Number of Payday') . "</td>
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
		echo '<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&PayPeriodID=' . $myrow[0] . '">' . _('Edit') . '</A></TD>';
		echo '<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&PayPeriodID=' . $myrow[0] . '&delete=1">' . _('Delete') .'</A></TD>';
		echo '</TR>';

	} //END WHILE LIST LOOP
	echo '</table></CENTER><p>';


} else {

//PayPeriodID exists - either passed when calling the form or from the form itself

	echo "<FORM METHOD='post' ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "'>";
	echo '<CENTER><TABLE>';

	//if (!isset($_POST['New'])) {
	if (!isset($_POST['New'])) {
		$sql = "SELECT payperiodid, 
				payperioddesc, 
				numberofpayday
			FROM prlpayperiod 
			WHERE payperiodid = '$PayPeriodID'";
				  
		$result = DB_query($sql, $db);
		$myrow = DB_fetch_array($result);
		
		$_POST['PayPeriodName']  = $myrow['payperioddesc'];
		$_POST['NumberOfPayday']  = $myrow['numberofpayday'];
		echo "<INPUT TYPE=HIDDEN NAME='PayPeriodID' VALUE='$PayPeriodID'>";

	} else {
	// its a new supplier being added
		echo "<INPUT TYPE=HIDDEN NAME='New' VALUE='Yes'>";
		echo '<TR><TD>' . _('Pay Period Code') . ":</TD><TD><INPUT TYPE='text' NAME='PayPeriodID' VALUE='$PayPeriodID' SIZE=5 MAXLENGTH=4></TD></TR>";
	}
	echo "<TR><TD>" . _('Pay Description') . ':' . "</TD><TD><input type='Text' name='PayPeriodName' SIZE=16 MAXLENGTH=15 value='" . $_POST['PayPeriodName'] . "'></TD></TR>";
	echo "<TR><TD>" . _('Number of Pay Day') . ':' . "</TD><TD><input type='Text' name='NumberOfPayday' SIZE=12 MAXLENGTH=11 value='" . $_POST['NumberOfPayday'] . "'></TD></TR>";
	echo '</SELECT></TD></TR>';

	if (isset($_POST['New'])) {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Add These New Pay Period Details') . "'></FORM>";
	} else {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Update Pay Period') . "'>";
		echo '<P><FONT COLOR=red><B>' . _('WARNING') . ': ' . _('There is no second warning if you hit the delete button below') . '. ' . _('However checks will be made to ensure before the deletion is processed') . '<BR></FONT></B>';
		echo "<INPUT TYPE='Submit' NAME='delete' VALUE='" . _('Delete Pay Period') . "' onclick=\"return confirm('" . _('Are you sure you wish to delete this pay period?') . "');\"></FORM>";
	}

} // end of main ifs

include ('includes/footer.inc.php');
?>