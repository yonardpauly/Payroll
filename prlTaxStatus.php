<?php

/* $Revision: 1.16 $ */

$PageSecurity = 5;

include ('includes/session.inc.php');

$title = _('Employee Maintenance');

include ('includes/header.inc.php');
include ('includes/SQL_CommonFunctions.inc.php');


if ( isset($_GET['TaxStatusID']) ){
	$TaxStatusID = strtoupper($_GET['TaxStatusID']);
} elseif ( isset($_POST['TaxStatusID']) ){
	$TaxStatusID = strtoupper( $_POST['TaxStatusID'] );
} else {
	unset($TaxStatusID);
} 

if ( isset($_POST['submit']) ) {

	//initialise no input errors assumed initially before we test
	$InputError = 0;

	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */

	//first off validate inputs sensible


	if ( $InputError != 1 ){

		if ( !isset($_POST['New']) ) {
	
			$sql = "UPDATE prltaxstatus SET
					taxstatusdescription='" . DB_escape_string($db, $_POST['TaxStatusDescription']) . "',
					personalexemption='" . DB_escape_string($db, $_POST['PersonalExemption']) . "',				
					additionalexemption='" . DB_escape_string($db, $_POST['AdditionalExemption']) . "',
					totalexemption='" . DB_escape_string($db, $_POST['TotalExemption']) . "'
                WHERE taxstatusid = '$TaxStatusID'";
			$ErrMsg = _('The tax status could not be updated because');
			$DbgMsg = _('The SQL that was used to update the tax status but failed was');
			$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);
			prnMsg(_('The tax status master record for') . ' ' . $TaxStatusID . ' ' . _('has been updated'),'success');

		} else { //its a new tax status
				$sql = "INSERT INTO prltaxstatus (		
					taxstatusid,
					taxstatusdescription,
					personalexemption,				
					additionalexemption,
					totalexemption)
				VALUES ('$TaxStatusID', 
					'" . DB_escape_string($db, $_POST['TaxStatusDescription']) ."',
					'" . DB_escape_string($db, $_POST['PersonalExemption']) ."',
					'" . DB_escape_string($db, $_POST['AdditionalExemption']) ."',
					'" . DB_escape_string($db, $_POST['TotalExemption']) . "'
					)";
			$ErrMsg = _('The tax status') . ' ' . $_POST['TaxStatusDescription'] . ' ' . _('could not be added because');
			$DbgMsg = _('The SQL that was used to insert the tax status but failed was');
			$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);

			prnMsg(_('A new tax status for') . ' ' . $_POST['TaxStatusDescription'] . ' ' . _('has been added to the database'),'success');

			unset ($TaxStatusID);
			unset($_POST['TaxStatusDescription']);
			unset($_POST['PersonalExemption']);
			unset($_POST['AdditionalExemption']);
			unset($_POST['TotalExemption']);
		}
		
	} else {

		prnMsg(_('Validation failed') . _('no updates or deletes took place'),'warn');

	}

} elseif (isset($_POST['delete']) AND $_POST['delete'] != '') {

//the link to delete a selected record was clicked instead of the submit button

	$CancelDelete = 0;

// PREVENT DELETES IF DEPENDENT RECORDS IN 'SuppTrans' , PurchOrders, SupplierContacts

	if ($CancelDelete == 0) {
		$sql="DELETE FROM prltaxstatus WHERE taxstatusid='$TaxStatusID'";
		$result = DB_query($sql, $db);
		prnMsg(_('Tax status record for') . ' ' . $TaxStatusID . ' ' . _('has been deleted'),'success');
		unset($TaxStatusID);
		unset($_SESSION['TaxStatusID']);
	} //end if Delete tax status
} //end of (isset($_POST['submit'])) 


if (!isset($TaxStatusID)) {
/*If the page was called without $EmployeeID passed to page then assume a new employee is to be entered show a form 
with a Employee Code field other wise the form showing the fields with the existing entries against the employee will 
show for editing with only a hidden EmployeeID field*/
	echo "<FORM METHOD='post' ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "'>";
	echo "<INPUT TYPE='hidden' NAME='New' VALUE='Yes'>";
	echo '<CENTER><TABLE>';
	//echo "me her";
	echo '<TR><TD>' . _('Tax Status ID') . ":</TD>
	     <TD><INPUT TYPE='text' NAME='TaxStatusID' SIZE=11 MAXLENGTH=10></TD></TR>";
	echo '<TR><TD>' . _('Tax Status Description') . ":</TD>
		<TD><input type='Text' name='TaxStatusDescription' SIZE=41 MAXLENGTH=40></TD></TR>";
	echo '<TR><TD>' . _('Personal Exemption') . ":</TD>
		<TD><input type='Text' name='PersonalExemption' SIZE=13 MAXLENGTH=12></TD></TR>";		
	echo '<TR><TD>' . _('Additional Exemption') . ":</TD>
		<TD><input type='TotalExemptionText' name='AdditionalExemption' SIZE=13 MAXLENGTH=12></TD></TR>";
	echo '<TR><TD>' . _('Total Exemption') . ":</TD>
		<TD><input type='Text' name='TotalExemption' SIZE=13 MAXLENGTH=12></TD></TR>";		
	//echo'</TABLE>';
	echo "</SELECT></TD></TR></TABLE><p><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Insert New Tax Status') . "'>";
	echo '</FORM>';

} else {
//SupplierID exists - either passed when calling the form or from the form itself
	echo "<FORM METHOD='post' action='" . $_SERVER['PHP_SELF'] . '?' . SID ."'>";
	echo '<CENTER><TABLE>';
	
		if (!isset($_POST['New'])) {
		
		$sql = "SELECT  taxstatusid,
						taxstatusdescription,
						personalexemption,				
						additionalexemption,
						totalexemption
			FROM prltaxstatus
			WHERE taxstatusid = '$TaxStatusID'";
			$result = DB_query($sql, $db);
			$myrow = DB_fetch_array($result);
			$_POST['TaxStatusDescription'] = $myrow['taxstatusdescription'];
			$_POST['PersonalExemption'] = $myrow['personalexemption'];	
			$_POST['AdditionalExemption']  = $myrow['additionalexemption'];
			$_POST['TotalExemption']  = $myrow['totalexemption'];
		
		echo "<INPUT TYPE=HIDDEN NAME='TaxStatusID' VALUE='$TaxStatusID'>";
	} else {
	// its a new supplier being added
		echo "<INPUT TYPE=HIDDEN NAME='New' VALUE='Yes'>";
		echo '<TR><TD>' . _('Tax Status ID') . ":</TD><TD><INPUT TYPE='text' NAME='TaxStatusID' VALUE='$TaxStatusID' SIZE=12 MAXLENGTH=10></TD></TR>";
	}
	echo'<TR><TD>' . _('Tax Status Description') . ":</TD>
		<TD><input type='Text' name='TaxStatusDescription' value='" . $_POST['TaxStatusDescription'] . "' SIZE=42 MAXLENGTH=40></TD></TR>";
	echo '<TR><TD>' . _('Personal Exemption') . ":</TD>
		<TD><input type='Text' name='PersonalExemption' value='" . $_POST['PersonalExemption'] . "' SIZE=13 MAXLENGTH=12></TD></TR>";
	echo '<TR><TD>' . _('Additional Exemption') . ":</TD>
		<TD><input type='Text' name='AdditionalExemption' SIZE=13 MAXLENGTH=12 value='" . $_POST['AdditionalExemption'] . "'></TD></TR>";
	echo '<TR><TD>' . _('Total Exemption') . ":</TD>
		<TD><input type='Text' name='TotalExemption' SIZE=13 MAXLENGTH=12 value='" . $_POST['TotalExemption'] . "'></TD></TR>";
	
	if (isset($_POST['New'])) {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Add These New Tax Status Details') . "'></FORM>";
	} else {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Update Tax Status') . "'>";
		echo '<P><FONT COLOR=red><B>' . _('WARNING') . ': ' . _('There is no second warning if you hit the delete button below') . '. ' . _('However checks will be made to ensure there are no outstanding purchase orders or existing accounts payable transactions before the deletion is processed') . '<BR></FONT></B>';
		echo "<INPUT TYPE='Submit' NAME='delete' VALUE='" . _('Delete Employee') . "' onclick=\"return confirm('" . _('Are you sure you wish to delete this tax status?') . "');\"></FORM>";
		//echo "<BR><CENTER><A HREF='$rootpath/SupplierContacts.php?" . SID . "SupplierID=$SupplierID'>" . _('Review Contact Details') . '</A></CENTER>';
	}

} // end of main ifs

include 'includes/footer.inc.php';
?>