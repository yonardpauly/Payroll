<?php
/* $Revision: 1.0 $ */

$PageSecurity = 15;

include ('includes/session.inc.php');

$title = _('PhilHealth Section');

include ('includes/header.inc.php');

if (isset($_GET['Bracket'])){
	$Bracket = $_GET['Bracket'];
} elseif (isset($_POST['Bracket'])){
	
	$Bracket = $_POST['Bracket'];
} else {
	unset($Bracket);
}


if (isset($_POST['submit'])) {

	//initialise no input errors assumed initially before we test

	$InputError = 0;

	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */

	//first off validate inputs sensible

	if (strlen($Bracket) == 0) {
		$InputError = 1;
		prnMsg(_('The Salary Bracket cannot be empty'),'error');
	}

	if ($InputError !=1) {
	
			if (!isset($_POST['New'])) {
			$sql = "UPDATE prlphilhealth SET 
					rangefrom='" .DB_escape_string($db, $_POST['RangeFr']) . "', 
					rangeto='" .DB_escape_string($db, $_POST['RangeTo']) . "', 
					salarycredit='" .DB_escape_string($db, $_POST['Credit']) . "', 
					employerph='" .DB_escape_string($db, $_POST['ERPH']) . "', 
					employeeph='" .DB_escape_string($db, $_POST['EEPH']) . "', 
					total='" . DB_escape_string($db, $_POST['Total']) . "'
						WHERE bracket='$Bracket'";

			$ErrMsg = _('The PhilHealth could not be updated because');
			$DbgMsg = _('The SQL that was used to update the PhilHealth but failed was');
			$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);
			prnMsg(_('The PhilHealth master record for') . ' ' . $Bracket . ' ' . _('has been updated'),'success');

		} else { //its a new PhilHealth
		$sql = "INSERT INTO prlphilhealth (bracket, 
					rangefrom,
					rangeto,
					salarycredit,
					employerph,
					employeeph,
					total)
				 VALUES ('$Bracket', 
					 	'" .DB_escape_string($db, $_POST['RangeFr']) . "', 
						'" .DB_escape_string($db, $_POST['RangeTo']) . "', 
						'" .DB_escape_string($db, $_POST['Credit']) . "', 
						'" .DB_escape_string($db, $_POST['ERPH']) . "', 
						'" .DB_escape_string($db, $_POST['EEPH']) . "', 
						'" . DB_escape_string($db, $_POST['Total']) . "')";
			$ErrMsg = _('The PhilHealth') . ' ' . $_POST['Credit'] . ' ' . _('could not be added because');
			$DbgMsg = _('The SQL that was used to insert the PhilHealth but failed was');
			$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);

			prnMsg(_('A new PhilHealth has been added to the database'),'success');

			unset ($Bracket);
			unset($_POST['RangeFr']);
			unset($_POST['RangeTo']);
			unset($_POST['Credit']);
			unset($_POST['ERPH']);
			unset($_POST['EEPH']);
			unset($_POST['Total']);
		}
		
	} else {

		prnMsg(_('Validation failed') . _('no updates or deletes took place'),'warn');

	}

} elseif (isset($_POST['delete']) AND $_POST['delete'] != '') {

//the link to delete a selected record was clicked instead of the submit button

	$CancelDelete = 0;
	
// PREVENT DELETES IF DEPENDENT RECORDS IN 'SuppTrans' , PurchOrders, SupplierContacts
	if ( $CancelDelete == 0 ) {
		$sql="DELETE FROM prlphilhealth WHERE bracket='$Bracket'";
		$result = DB_query($sql, $db);
		prnMsg(_('PhilHealth record for') . ' ' . $Bracket . ' ' . _('has been deleted'),'success');
		unset($Bracket);
		unset($_SESSION['Bracket']);
	} //end if Delete paypayperiod
}


if (!isset($Bracket)) {

/*If the page was called without $SupplierID passed to page then assume a new supplier is to be entered show a form with a Supplier Code field other wise the form showing the fields with the existing entries against the supplier will show for editing with only a hidden SupplierID field*/

	echo "<FORM METHOD='post' ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "'>";

	echo "<INPUT TYPE='hidden' NAME='New' VALUE='Yes'>";

	echo '<CENTER><TABLE>';
	echo '<TR><TD>' . _('Salary Bracket') . ":</TD><TD><INPUT TYPE='text' NAME='Bracket' SIZE=5 MAXLENGTH=4></TD></TR>";
	echo '<TR><TD>' . _('Range From') . ":</TD><TD><INPUT TYPE='text' NAME='RangeFr' SIZE=14 MAXLENGTH=12></TD></TR>";
	echo '<TR><TD>' . _('Range To') . ":</TD><TD><INPUT TYPE='text' NAME='RangeTo' SIZE=14 MAXLENGTH=12></TD></TR>";
	echo '<TR><TD>' . _('Salary Base') . ":</TD><TD><INPUT TYPE='text' NAME='Credit' SIZE=14 MAXLENGTH=12></TD></TR>";
	echo '<TR><TD>' . _('Employer Share') . ":</TD><TD><INPUT TYPE='text' NAME='ERPH' SIZE=14 MAXLENGTH=12></TD></TR>";
	echo '<TR><TD>' . _('Employee Share') . ":</TD><TD><INPUT TYPE='text' NAME='EEPH' SIZE=14 MAXLENGTH=12></TD></TR>";
	echo '<TR><TD>' . _('Total') . ":</TD><TD><INPUT TYPE='text' NAME='Total' SIZE=14 MAXLENGTH=12></TD></TR>";
//	echo '</SELECT></TD></TR>';
	echo "</SELECT></TD></TR></TABLE><p><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Insert New PhilHealth') . "'>";
	echo '</FORM>';
	
		$sql = "SELECT bracket,
					rangefrom,
					rangeto,
					salarycredit,
					employerph,
					employeeph,
					total
				FROM prlphilhealth
				ORDER BY bracket";

	$ErrMsg = _('Could not get PhilHealth because');
	$result = DB_query($sql,$db,$ErrMsg);
	
	echo '<CENTER><table border=1>';
	echo "<tr>
		<td class='tableheader'>" . _('Salary Bracket') . "</td>
		<td class='tableheader'>" . _('Range From') . "</td>
		<td class='tableheader'>" . _('Range To') . "</td>
		<td class='tableheader'>" . _('Salary Base') . "</td>
		<td class='tableheader'>" . _('Employer Share') . "</td>
		<td class='tableheader'>" . _('Employee Share') . "</td>
		<td class='tableheader'>" . _('Total') . "</td>
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
		echo '<TD>' . $myrow[3] . '</TD>';
		echo '<TD>' . $myrow[4] . '</TD>';
		echo '<TD>' . $myrow[5] . '</TD>';
		echo '<TD>' . $myrow[6] . '</TD>';
		echo '<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&Bracket=' . $myrow[0] . '">' . _('Edit') . '</A></TD>';
		echo '<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&Bracket=' . $myrow[0] . '&delete=1">' . _('Delete') .'</A></TD>';
		echo '</TR>';

	} //END WHILE LIST LOOP
	echo '</table></CENTER><p>';


} else {
//Bracket exists - either passed when calling the form or from the form itself

	echo "<FORM METHOD='post' ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "'>";
	echo '<CENTER><TABLE>';

	//if (!isset($_POST['New'])) {
	if (!isset($_POST['New'])) {
			$sql = "SELECT bracket,
					rangefrom,
					rangeto,
					salarycredit,
					employerph,
					employeeph,
					total
				FROM prlphilhealth
				WHERE bracket='$Bracket'";
		$result = DB_query($sql, $db);
		$myrow = DB_fetch_array($result);
		
		$_POST['RangeFr']  = $myrow['rangefrom'];
		$_POST['RangeTo']  = $myrow['rangeto'];
		$_POST['Credit']  = $myrow['salarycredit'];
		$_POST['ERPH']  = $myrow['employerph'];
		$_POST['EEPH']  = $myrow['employeeph'];
		$_POST['Total']  = $myrow['total'];
		echo "<INPUT TYPE=HIDDEN NAME='Bracket' VALUE='$Bracket'>";

	} else {
	// its a new PhilHealth being added
		echo "<INPUT TYPE=HIDDEN NAME='New' VALUE='Yes'>";
		echo '<TR><TD>' . _('PhilHealth Code') . ":</TD><TD><INPUT TYPE='text' NAME='Bracket' VALUE='$Bracket' SIZE=5 MAXLENGTH=4></TD></TR>";
	}
	
	echo '<TR><TD>' . _('Range From') . ":</TD><TD><INPUT TYPE='text' NAME='RangeFr' SIZE=14 MAXLENGTH=12 value='" . $_POST['RangeFr'] . "'></TD></TR>";
	echo '<TR><TD>' . _('Range To') . ":</TD><TD><INPUT TYPE='text' NAME='RangeTo' SIZE=14 MAXLENGTH=12 value='" . $_POST['RangeTo'] . "'></TD></TR>";
	echo '<TR><TD>' . _('Salary Base') . ":</TD><TD><INPUT TYPE='text' NAME='Credit' SIZE=14 MAXLENGTH=12 value='" . $_POST['Credit'] . "'></TD></TR>";
	echo '<TR><TD>' . _('Employer Share') . ":</TD><TD><INPUT TYPE='text' NAME='ERPH' SIZE=14 MAXLENGTH=12 value='" . $_POST['ERPH'] . "'></TD></TR>";
	echo '<TR><TD>' . _('Employee Share') . ":</TD><TD><INPUT TYPE='text' NAME='EEPH' SIZE=14 MAXLENGTH=12 value='" . $_POST['EEPH'] . "'></TD></TR>";
	echo '<TR><TD>' . _('Total') . ":</TD><TD><INPUT TYPE='text' NAME='Total' SIZE=14 MAXLENGTH=12 value='" . $_POST['Total'] . "'></TD></TR>";
	echo '</SELECT></TD></TR>';

	if (isset($_POST['New'])) {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Add These New PhilHealth Details') . "'></FORM>";
	} else {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Update PhilHealth') . "'>";
		echo '<P><FONT COLOR=red><B>' . _('WARNING') . ': ' . _('There is no second warning if you hit the delete button below') . '. ' . _('However checks will be made to ensure before the deletion is processed') . '<BR></FONT></B>';
		echo "<INPUT TYPE='Submit' NAME='delete' VALUE='" . _('Delete PhilHealth') . "' onclick=\"return confirm('" . _('Are you sure you wish to delete this PhilHealth?') . "');\"></FORM>";
	}

} // end of main ifs

include ('includes/footer.inc.php');
?>