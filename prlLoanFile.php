<?php

/* $Revision: 1.16 $ */

$PageSecurity = 5;

include ('includes/session.inc.php');

$title = _('Employee Loan Maintenance');

include ('includes/header.inc.php');
include ('includes/SQL_CommonFunctions.inc.php');



if (isset($_GET['LoanFileId'])){
	$LoanFileId = strtoupper($_GET['LoanFileId']);
} elseif (isset($_POST['LoanFileId'])){
	$LoanFileId = strtoupper($_POST['LoanFileId']);
} else {
	unset($LoanFileId);
}





if (isset($_POST['submit'])) {

	//initialise no input errors assumed initially before we test
	$InputError = 0;
	$LoanBal=$_POST['LoanAmount'] - $_POST['YTDDeduction'];
	if ($LoanBal<0) 
	{
	  $InputError = 1;
	  prnMsg(_('Can not post. Total Deduction is greater that Loan Amount by') . ' ' . $LoanBal);
	}

	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */

	//first off validate inputs sensible


	if ($InputError != 1){

		$SQL_LoanDate = FormatDateForSQL($_POST['LoanDate']);
		$SQL_StartDeduction = FormatDateForSQL($_POST['StartDeduction']);
		if (!isset($_POST['New'])) {
			$sql = "UPDATE prlloanfile SET
					loanfiledesc='" . DB_escape_string($db, $_POST['LoanFileDesc']) . "',
					employeeid='" . DB_escape_string($db, $_POST['EmployeeID']) . "',				
					loandate='$SQL_LoanDate',
					loantableid='" . DB_escape_string($db, $_POST['LoanTableID']) . "',
					loanamount='" . DB_escape_string($db, $_POST['LoanAmount']) ."',
					amortization='" . DB_escape_string($db, $_POST['Amortization']) . "',
					startdeduction='$SQL_StartDeduction',
					amortization='" . DB_escape_string($db, $_POST['Amortization']) . "',
					loanbalance='$LoanBal',
					accountcode='" . DB_escape_string($db, $_POST['AccountCode']) . "'
                WHERE loanfileid = '$LoanFileId'";
			$ErrMsg = _('The employee loan could not be updated because');
			$DbgMsg = _('The SQL that was used to update the employee loan but failed was');
			$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);
			prnMsg(_('The employee loan master record for') . ' ' . $LoanFileId . ' ' . _('has been updated'),'success');

		} else { //its a new employee
				$sql = "INSERT INTO prlloanfile (		
					loanfileid,
					loanfiledesc,
					employeeid,
					loandate,
					loantableid,
					loanamount,
					amortization,
					startdeduction,
					loanbalance,
					accountcode)
				VALUES ('$LoanFileId', 
					'" . DB_escape_string($db, $_POST['LoanFileDesc']) ."',
					'" . DB_escape_string($db, $_POST['EmployeeID']) ."',
					'" . $SQL_LoanDate . "',
					'" . DB_escape_string($db, $_POST['LoanTableID']) . "',
					'" . DB_escape_string($db, $_POST['LoanAmount']) . "',
					'" . DB_escape_string($db, $_POST['Amortization']) . "',			
					'" . $SQL_StartDeduction . "',
					'" . DB_escape_string($db, $_POST['LoanAmount']) . "',
					'" . DB_escape_string($db, $_POST['AccountCode']) . "'
					)";

			$ErrMsg = _('The employee loan') . ' ' . $_POST['LoanFileDesc'] . ' ' . _('could not be added because');
			$DbgMsg = _('The SQL that was used to insert the employee loan but failed was');
			$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);

			prnMsg(_('A new employee loan for') . ' ' . $_POST['LoanFileDesc'] . ' ' . _('has been added to the database'),'success');

			unset ($LoanFileId);
			unset($_POST['LoanFileDesc']);
			unset($_POST['EmployeeID']);
			unset($_POST['LoanDate']);
			unset($_POST['LoanTableID']);
			unset($_POST['LoanAmount']);
			unset($_POST['Amortization']);
			unset($_POST['StartDeduction']);
			unset($_POST['AccountCode']);
		}
		
	} else {

		prnMsg(_('Validation failed') . _('no updates or deletes took place'),'warn');

	}

} elseif (isset($_POST['delete']) AND $_POST['delete'] != '') {

//the link to delete a selected record was clicked instead of the submit button

	$CancelDelete = 0;

// PREVENT DELETES IF DEPENDENT RECORDS IN 'SuppTrans' , PurchOrders, SupplierContacts

	if ($CancelDelete == 0) {
		$sql="DELETE FROM prlloanfile WHERE loanfileid='$LoanFileId'";
		$result = DB_query($sql, $db);
		prnMsg(_('Employee loan record for') . ' ' . $LoanFileId . ' ' . _('has been deleted'),'success');
		unset($LoanFileId);
		unset($_SESSION['LoanFileId']);
	} //end if Delete employee
} //end of (isset($_POST['submit'])) 


if (!isset($LoanFileId)) {
/*If the page was called without $LoanFileId passed to page then assume a new employee is to be entered show a form 
with a Employee Code field other wise the form showing the fields with the existing entries against the employee will 
show for editing with only a hidden LoanFileId field*/
	echo "<FORM METHOD='post' ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "'>";
	echo "<INPUT TYPE='hidden' NAME='New' VALUE='Yes'>";
	echo '<CENTER><TABLE>';
	//echo "me her";
	echo '<TR><TD>' . _('Loan Ref') . ":</TD>
	     <TD><INPUT TYPE='text' NAME='LoanFileId' SIZE=11 MAXLENGTH=10></TD></TR>";
	echo '<TR><TD>' . _('Description') . ":</TD>
		<TD><input type='Text' name='LoanFileDesc' SIZE=42 MAXLENGTH=40></TD></TR>";
	echo '<TR><TD>' . _('Employee Name') . ":</TD><TD><SELECT NAME='EmployeeID'>";		
	DB_data_seek($result, 0);
	$sql = 'SELECT employeeid, lastname, firstname FROM prlemployeemaster';
	$result = DB_query($sql, $db);
	while ($myrow = DB_fetch_array($result)) {
		if ($_POST['EmployeeID'] == $myrow['employeeid']){
			echo '<OPTION SELECTED VALUE=' . $myrow['employeeid'] . '>' . $myrow['lastname'] . ',' . $myrow['firstname'];
		} else {
			echo '<OPTION VALUE=' . $myrow['employeeid'] . '>' . $myrow['lastname'] . ',' . $myrow['firstname'];
		}
	} //end while loop
	$DateString = Date($_SESSION['DefaultDateFormat']);	
	echo '<TR><TD>' . _('Loan Date') . ' (' . $_SESSION['DefaultDateFormat'] . "):</TD><TD><input type='Text' name='LoanDate' value=$DateString SIZE=12 MAXLENGTH=10></TD></TR>";
	echo '<TR><TD>' . _('Loan Type') . ":</TD><TD><SELECT NAME='LoanTableID'>";		
	DB_data_seek($result, 0);
	$sql = 'SELECT loantableid, loantabledesc FROM prlloantable';
	$result = DB_query($sql, $db);
	while ($myrow = DB_fetch_array($result)) {
		if ($_POST['LoanTableID'] == $myrow['loantableid']){
			echo '<OPTION SELECTED VALUE=' . $myrow['loantableid'] . '>' . $myrow['loantabledesc'];
		} else {
			echo '<OPTION VALUE=' . $myrow['loantableid'] . '>' . $myrow['loantabledesc'];
		}
	} //end while loop
	echo '<TR><TD>' . _('LoanAmount') . "</TD>
		<TD><input type='Text' name='LoanAmount' SIZE=14 MAXLENGTH=12></TD></TR>";
	echo '<TR><TD>' . _('Amortization') . ":</TD>
		<TD><input type='Text' name='Amortization' SIZE=14 MAXLENGTH=12></TD></TR>";		
	echo '<TR><TD>' . _('Start of deduction') . ' (' . $_SESSION['DefaultDateFormat'] . "):</TD><TD><input type='Text' name='StartDeduction' value=$DateString SIZE=12 MAXLENGTH=10></TD></TR>";		
	echo '<TR><TD>' . _('Account Code') . ":</TD><TD><SELECT NAME='AccountCode'>";		
	DB_data_seek($result, 0);
	$sql = 'SELECT accountcode, accountname FROM chartmaster';
	$result = DB_query($sql, $db);
	while ($myrow = DB_fetch_array($result)) {
		if ($_POST['AccountCode'] == $myrow['accountcode']){
			echo '<OPTION SELECTED VALUE=' . $myrow['accountcode'] . '>' . $myrow['accountname'];
		} else {
			echo '<OPTION VALUE=' . $myrow['accountcode'] . '>' . $myrow['accountname'];
		}
	} //end while loop	
	echo "</SELECT></TD></TR></TABLE><p><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Insert New Employee Loan') . "'>";
	echo '</FORM>';

} else {
//SupplierID exists - either passed when calling the form or from the form itself
	echo "<FORM METHOD='post' action='" . $_SERVER['PHP_SELF'] . '?' . SID ."'>";
	echo '<CENTER><TABLE>';
		if (!isset($_POST['New'])) {
		$sql = "SELECT  loanfileid,
						loanfiledesc,
						employeeid,
						loandate,
						loantableid,
						loanamount,
						amortization,
						startdeduction,
						ytddeduction,
						accountcode
			FROM prlloanfile
			WHERE loanfileid = '$LoanFileId'";
			$result = DB_query($sql, $db);
			$myrow = DB_fetch_array($result);
		$_POST['LoanFileDesc'] = $myrow['loanfiledesc'];
		$_POST['EmployeeID'] = $myrow['employeeid'];	
		$_POST['LoanDate'] = ConvertSQLDate($myrow['loandate']);	
		$_POST['LoanTableID']  = $myrow['loantableid'];
		$_POST['LoanAmount']  = $myrow['loanamount'];
		$_POST['Amortization']  = $myrow['amortization'];
		$_POST['StartDeduction']  = ConvertSQLDate($myrow['startdeduction']);
		$_POST['YTDDeduction']  = $myrow['ytddeduction'];
		$_POST['AccountCode']  = $myrow['accountcode'];
		echo "<INPUT TYPE=HIDDEN NAME='LoanFileId' VALUE='$LoanFileId'>";
	} else {
	// its a new supplier being added
		echo "<INPUT TYPE=HIDDEN NAME='New' VALUE='Yes'>";
		echo '<TR><TD>' . _('Loan Ref') . ":</TD><TD><INPUT TYPE='text' NAME='LoanFileId' VALUE='$LoanFileId' SIZE=12 MAXLENGTH=10></TD></TR>";
	}
	echo '<TR><TD>' . _('Description') . ":</TD>
		<TD><input type='Text' name='LoanFileDesc' value='" . $_POST['LoanFileDesc'] . "' SIZE=42 MAXLENGTH=40></TD></TR>";
	echo '<TR><TD>' . _('Employee Name') . ":</TD><TD><SELECT NAME='EmployeeID'>";		
	DB_data_seek($result, 0);
	$sql = 'SELECT employeeid, lastname, firstname FROM prlemployeemaster';
	$result = DB_query($sql, $db);
	while ($myrow = DB_fetch_array($result)) {
		if ($myrow['employeeid'] == $_POST['EmployeeID']) {
			echo '<OPTION SELECTED VALUE=';
		} else {
			echo '<OPTION VALUE=';
		}
		echo $myrow['employeeid'] . '>' . $myrow['lastname'] . ',' . $myrow['firstname'];		
	} //end while loop
echo '</SELECT></TD></TR><TR><TD>' . _('Loan Date:') . ' (' . $_SESSION['DefaultDateFormat'] . "):</TD>	
	<TD><input type='Text' name='LoanDate' SIZE=12 MAXLENGTH=10 value=" . $_POST['LoanDate'] . '></TD></TR>';
	echo '<TR><TD>' . _('Loan Type') . ":</TD><TD><SELECT NAME='LoanTableID'>";
	DB_data_seek($result, 0);
	$sql = 'SELECT loantableid, loantabledesc FROM prlloantable';
	$result = DB_query($sql, $db);
	while ($myrow = DB_fetch_array($result)) {
		if ($myrow['loantableid'] == $_POST['LoanTableID']) {
			echo '<OPTION SELECTED VALUE=';
		} else {
			echo '<OPTION VALUE=';
		}
		echo $myrow['loantableid'] . '>' . $myrow['loantabledesc'];
	} //end while loop
	echo '<TR><TD>' . _('Loan Amount') . ":</TD>
		<TD><input type='Text' name='LoanAmount' SIZE=14 MAXLENGTH=12 value='" . $_POST['LoanAmount'] . "'></TD></TR>";
	echo '<TR><TD>' . _('Amortization') . ":</TD>
		<TD><input type='Text' name='Amortization' SIZE=14 MAXLENGTH=12 value='" . $_POST['Amortization'] . "'></TD></TR>";
	echo '</SELECT></TD></TR><TR><TD>' . _('Start Deduction') . ' (' . $_SESSION['DefaultDateFormat'] . "):</TD>	
	<TD><input type='Text' name='StartDeduction' SIZE=12 MAXLENGTH=10 value=" . $_POST['StartDeduction'] . '></TD></TR>';
	echo '<TR><TD>' . _('Account Code') . ":</TD><TD><SELECT NAME='AccountCode'>";
	DB_data_seek($result, 0);
	$sql = 'SELECT accountcode, accountname FROM chartmaster';
	$result = DB_query($sql, $db);
	while ($myrow = DB_fetch_array($result)) {
		if ($myrow['accountcode'] == $_POST['AccountCode']) {
			echo '<OPTION SELECTED VALUE=';
		} else {
			echo '<OPTION VALUE=';
		}
		echo $myrow['accountcode'] . '>' . $myrow['accountname'];
	} //end while loop

	if (isset($_POST['New'])) {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Add These New Employee Loan Details') . "'></FORM>";
	} else {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Update Employee Loan') . "'>";
		echo '<P><FONT COLOR=red><B>' . _('WARNING') . ': ' . _('There is no second warning if you hit the delete button below') . '. ' . _('However checks will be made to ensure there are no outstanding purchase orders or existing accounts payable transactions before the deletion is processed') . '<BR></FONT></B>';
		echo "<INPUT TYPE='Submit' NAME='delete' VALUE='" . _('Delete Employee Loan') . "' onclick=\"return confirm('" . _('Are you sure you wish to delete this employee loan?') . "');\"></FORM>";
		//echo "<BR><CENTER><A HREF='$rootpath/SupplierContacts.php?" . SID . "SupplierID=$SupplierID'>" . _('Review Contact Details') . '</A></CENTER>';
	}

} // end of main ifs

include ('includes/footer.inc.php');
?>