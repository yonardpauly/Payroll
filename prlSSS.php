<?php
/* $Revision: 1.0 $ */

$PageSecurity = 15;

include ('includes/session.inc.php');

$title = _('Social Security System Section');

include ('includes/header.inc.php');

if ( isset($_GET['Bracket']) ){
	$Bracket = $_GET['Bracket'];
} elseif ( isset($_POST['Bracket']) ){
	
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
			$sql = "UPDATE prlsstable SET 
					rangefrom='" .DB_escape_string($db, $_POST['RangeFr']) . "', 
					rangeto='" .DB_escape_string($db, $_POST['RangeTo']) . "', 
					salarycredit='" .DB_escape_string($db, $_POST['Credit']) . "', 
					employerss='" .DB_escape_string($db, $_POST['ERSS']) . "', 
					employerec='" .DB_escape_string($db, $_POST['EREC']) . "', 
					employeess='" .DB_escape_string($db, $_POST['EESS']) . "', 
					total='" . DB_escape_string($db, $_POST['Total']) . "'
						WHERE bracket='$Bracket'";

			$ErrMsg = _('The SSS could not be updated because');
			$DbgMsg = _('The SQL that was used to update the SSS but failed was');
			$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);
			prnMsg(_('The SSS master record for') . ' ' . $Bracket . ' ' . _('has been updated'),'success');

		} else { //its a new SSS
		$sql = "INSERT INTO prlsstable (bracket, 
					rangefrom,
					rangeto,
					salarycredit,
					employerss,
					employerec,
					employeess,
					total)
				 VALUES ('$Bracket', 
					 	'" .DB_escape_string($db, $_POST['RangeFr']) . "', 
						'" .DB_escape_string($db, $_POST['RangeTo']) . "', 
						'" .DB_escape_string($db, $_POST['Credit']) . "', 
						'" .DB_escape_string($db, $_POST['ERSS']) . "', 
						'" .DB_escape_string($db, $_POST['EREC']) . "', 
						'" .DB_escape_string($db, $_POST['EESS']) . "', 
						'" . DB_escape_string($db, $_POST['Total']) . "')";
			$ErrMsg = _('The SSS') . ' ' . $_POST['Credit'] . ' ' . _('could not be added because');
			$DbgMsg = _('The SQL that was used to insert the SSS but failed was');
			$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);

			prnMsg(_('A new SSS has been added to the database'),'success');

			unset ($Bracket);
			unset($_POST['RangeFr']);
			unset($_POST['RangeTo']);
			unset($_POST['Credit']);
			unset($_POST['ERSS']);
			unset($_POST['EREC']);
			unset($_POST['EESS']);
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
		$sql = "DELETE FROM prlsstable WHERE bracket = '$Bracket'";
		$result = DB_query($sql, $db);
		prnMsg(_('SSS record for') . ' ' . $Bracket . ' ' . _('has been deleted'),'success');
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
	echo '<TR><TD>' . _('Monthly Salary Credit') . ":</TD><TD><INPUT TYPE='text' NAME='Credit' SIZE=14 MAXLENGTH=12></TD></TR>";
	echo '<TR><TD>' . _('Employer SS') . ":</TD><TD><INPUT TYPE='text' NAME='ERSS' SIZE=14 MAXLENGTH=12></TD></TR>";
	echo '<TR><TD>' . _('Employer EC') . ":</TD><TD><INPUT TYPE='text' NAME='EREC' SIZE=14 MAXLENGTH=12></TD></TR>";
	echo '<TR><TD>' . _('Employee SS') . ":</TD><TD><INPUT TYPE='text' NAME='EESS' SIZE=14 MAXLENGTH=12></TD></TR>";
	echo '<TR><TD>' . _('Total') . ":</TD><TD><INPUT TYPE='text' NAME='Total' SIZE=14 MAXLENGTH=12></TD></TR>";
//	echo '</SELECT></TD></TR>';
	echo "</SELECT></TD></TR></TABLE><p><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Insert New SSS') . "'>";
	echo '</FORM>';
	
		$sql = "SELECT bracket,
					rangefrom,
					rangeto,
					salarycredit,
					employerss,
					employerec,
					employeess,
					total
				FROM prlsstable
				ORDER BY bracket";

	$ErrMsg = _('Could not get SSS because');
	$result = DB_query($sql,$db,$ErrMsg);
	
	echo '<CENTER><table border=1>';
	echo "<tr>
		<td class='tableheader'>" . _('Salary Bracket') . "</td>
		<td class='tableheader'>" . _('Range From') . "</td>
		<td class='tableheader'>" . _('Range To') . "</td>
		<td class='tableheader'>" . _('Salary Credit') . "</td>
		<td class='tableheader'>" . _('Employer SS') . "</td>
		<td class='tableheader'>" . _('Employer EC') . "</td>
		<td class='tableheader'>" . _('Employee SS') . "</td>
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
		echo '<TD>' . $myrow[7] . '</TD>';
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
			$sql = "SELECT rangefrom,
					rangeto,
					salarycredit,
					employerss,
					employerec,
					employeess,
					total
				FROM prlsstable
				WHERE bracket='$Bracket'";
		$result = DB_query($sql, $db);
		$myrow = DB_fetch_array($result);
		
		$_POST['RangeFr']  = $myrow['rangefrom'];
		$_POST['RangeTo']  = $myrow['rangeto'];
		$_POST['Credit']  = $myrow['salarycredit'];
		$_POST['ERSS']  = $myrow['employerss'];
		$_POST['EREC']  = $myrow['employerec'];
		$_POST['EESS']  = $myrow['employeess'];
		$_POST['Total']  = $myrow['total'];
		echo "<INPUT TYPE=HIDDEN NAME='Bracket' VALUE='$Bracket'>";

	} else {
	// its a new SSS being added
		echo "<INPUT TYPE=HIDDEN NAME='New' VALUE='Yes'>";
		echo '<TR><TD>' . _('SSS Code') . ":</TD><TD><INPUT TYPE='text' NAME='Bracket' VALUE='$Bracket' SIZE=5 MAXLENGTH=4></TD></TR>";
	}
	
	echo '<TR><TD>' . _('Range From') . ":</TD><TD><INPUT TYPE='text' NAME='RangeFr' SIZE=14 MAXLENGTH=12 value='" . $_POST['RangeFr'] . "'></TD></TR>";
	echo '<TR><TD>' . _('Range To') . ":</TD><TD><INPUT TYPE='text' NAME='RangeTo' SIZE=14 MAXLENGTH=12 value='" . $_POST['RangeTo'] . "'></TD></TR>";
	echo '<TR><TD>' . _('Monthly Salary Credit') . ":</TD><TD><INPUT TYPE='text' NAME='Credit' SIZE=14 MAXLENGTH=12 value='" . $_POST['Credit'] . "'></TD></TR>";
	echo '<TR><TD>' . _('Employer SS') . ":</TD><TD><INPUT TYPE='text' NAME='ERSS' SIZE=14 MAXLENGTH=12 value='" . $_POST['ERSS'] . "'></TD></TR>";
	echo '<TR><TD>' . _('Employer EC') . ":</TD><TD><INPUT TYPE='text' NAME='EREC' SIZE=14 MAXLENGTH=12 value='" . $_POST['EREC'] . "'></TD></TR>";
	echo '<TR><TD>' . _('Employee SS') . ":</TD><TD><INPUT TYPE='text' NAME='EESS' SIZE=14 MAXLENGTH=12 value='" . $_POST['EESS'] . "'></TD></TR>";
	echo '<TR><TD>' . _('Total') . ":</TD><TD><INPUT TYPE='text' NAME='Total' SIZE=14 MAXLENGTH=12 value='" . $_POST['Total'] . "'></TD></TR>";
	echo '</SELECT></TD></TR>';

	if (isset($_POST['New'])) {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Add These New SSS Details') . "'></FORM>";
	} else {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Update SSS') . "'>";
		echo '<P><FONT COLOR=red><B>' . _('WARNING') . ': ' . _('There is no second warning if you hit the delete button below') . '. ' . _('However checks will be made to ensure before the deletion is processed') . '<BR></FONT></B>';
		echo "<INPUT TYPE='Submit' NAME='delete' VALUE='" . _('Delete SSS') . "' onclick=\"return confirm('" . _('Are you sure you wish to delete this SSS?') . "');\"></FORM>";
	}

} // end of main ifs

include ('includes/footer.inc.php');
?>