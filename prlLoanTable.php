<?php
/* $Revision: 1.0 $ */

$PageSecurity = 15;

include ('includes/session.inc.php');

$title = 'Loan Table Section';

include ('includes/header.inc.php');

if (isset($_GET['LoanTableID'])){
	$LoanTableID = $_GET['LoanTableID'];
} elseif (isset($_POST['LoanTableID'])){
	
	$LoanTableID = $_POST['LoanTableID'];
} else {
	unset($LoanTableID);
}


if (isset($_POST['submit'])) {

	//initialise no input errors assumed initially before we test

	$InputError = 0;

	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */

	//first off validate inputs sensible

	if (strpos($_POST['LoanTableDesc'],'&')>0 OR strpos($_POST['LoanTableDesc'],"'")>0) {
		$InputError = 1;
		prnMsg( _('The loan description cannot contain the character') . " '&' " . _('or the character') ." '",'error');
	}
	if (trim($_POST['LoanTableDesc']) == '') {
		$InputError = 1;
		prnMsg( _('The loan description may not be empty'), 'error');
	}
	
	if (strlen($LoanTableID) == 0) {
		$InputError = 1;
		prnMsg(_('The loan Code cannot be empty'),'error');
	}

	if ( $InputError != 1 ) {
	
			if (!isset($_POST['New'])) {

			$sql = "UPDATE prlloantable SET loantabledesc='" . DB_escape_string($db, $_POST['LoanTableDesc']) . "' 
						WHERE loantableid = '$LoanTableID'";

			$ErrMsg = _('The loan could not be updated because');
			$DbgMsg = _('The SQL that was used to update the loan table but failed was');
			$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);
			prnMsg(_('The loan table master record for') . ' ' . $LoanTableID . ' ' . _('has been updated'),'success');

		} else { //its a new loan record

			$sql = "INSERT INTO prlloantable (loantableid, 
							loantabledesc)
					 VALUES ('$LoanTableID', 
					 	'" .DB_escape_string($db, $_POST['LoanTableDesc']) . "')"; 

			$ErrMsg = _('The loan') . ' ' . $_POST['LoanTableDesc'] . ' ' . _('could not be added because');
			$DbgMsg = _('The SQL that was used to insert the loan table but failed was');
			$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);

			prnMsg(_('A new loan table for') . ' ' . $_POST['LoanTableDesc'] . ' ' . _('has been added to the database'),'success');

			unset ($LoanTableID);
			unset($_POST['LoanTableDesc']);
	
		}
		
	} else {

		prnMsg(_('Validation failed') . _('no updates or deletes took place'),'warn');

	}

} elseif (isset($_POST['delete']) AND $_POST['delete'] != '') {

//the link to delete a selected record was clicked instead of the submit button

	$CancelDelete = 0;

// PREVENT DELETES IF DEPENDENT RECORDS FOUND
	if ($CancelDelete == 0) {
		$sql="DELETE FROM prlloantable WHERE loantableid='$LoanTableID'";
		$result = DB_query($sql, $db);
		prnMsg(_('Loan table record for') . ' ' . $LoanTableID . ' ' . _('has been deleted'),'success');
		unset($LoanTableID);
		unset($_SESSION['LoanTableID']);
	} 
}


if (!isset($LoanTableID)) {

	echo "<FORM METHOD='post' ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "'>";

	echo "<INPUT TYPE='hidden' NAME='New' VALUE='Yes'>";

	echo '<CENTER><TABLE>';
	echo '<TR><TD>' . _('loan Code') . ":</TD><TD><INPUT TYPE='text' NAME='LoanTableID' SIZE=5 MAXLENGTH=4></TD></TR>";
	echo '<TR><TD>' . _('Pay Description') . ":</TD><TD><INPUT TYPE='text' NAME='LoanTableDesc' SIZE=41 MAXLENGTH=40></TD></TR>";
	echo "</SELECT></TD></TR></TABLE><p><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Insert New loan') . "'>";
	echo '</FORM>';
	
		$sql = "SELECT loantableid,
			loantabledesc
			FROM prlloantable
			ORDER BY loantableid";

	$ErrMsg = _('Could not get loan because');
	$result = DB_query($sql,$db,$ErrMsg);
	
	echo '<CENTER><table border=1>';
	echo "<tr>
		<td class='tableheader'>" . _('Loan Code') . "</td>
		<td class='tableheader'>" . _('Loan Description') . "</td>
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
		echo '<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&LoanTableID=' . $myrow[0] . '">' . _('Edit') . '</A></TD>';
		echo '<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&LoanTableID=' . $myrow[0] . '&delete=1">' . _('Delete') .'</A></TD>';
		echo '</TR>';

	} //END WHILE LIST LOOP
	echo '</table></CENTER><p>';


} else {

	echo "<FORM METHOD='post' ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "'>";
	echo '<CENTER><TABLE>';

	//if (!isset($_POST['New'])) {
	if (!isset($_POST['New'])) {
		$sql = "SELECT loantableid, 
				loantabledesc
			FROM prlloantable 
			WHERE loantableid = '$LoanTableID'";
				  
		$result = DB_query($sql, $db);
		$myrow = DB_fetch_array($result);
		
		$_POST['LoanTableDesc']  = $myrow['loantabledesc'];
		echo "<INPUT TYPE=HIDDEN NAME='LoanTableID' VALUE='$LoanTableID'>";

	} else {
	// its a new loan being added
		echo "<INPUT TYPE=HIDDEN NAME='New' VALUE='Yes'>";
		echo '<TR><TD>' . _('Loan Code') . ":</TD><TD><INPUT TYPE='text' NAME='LoanTableID' VALUE='$LoanTableID' SIZE=5 MAXLENGTH=4></TD></TR>";
	}
	echo "<TR><TD>" . _('Loan Description') . ':' . "</TD><TD><input type='Text' name='LoanTableDesc' SIZE=41 MAXLENGTH=40 value='" . $_POST['LoanTableDesc'] . "'></TD></TR>";
	echo '</SELECT></TD></TR>';

	if (isset($_POST['New'])) {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Add These New Loan Details') . "'></FORM>";
	} else {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Update Loan Table') . "'>";
		echo '<P><FONT COLOR=red><B>' . _('WARNING') . ': ' . _('There is no second warning if you hit the delete button below') . '. ' . _('However checks will be made to ensure before the deletion is processed') . '<BR></FONT></B>';
		echo "<INPUT TYPE='Submit' NAME='delete' VALUE='" . _('Delete Loan Table') . "' onclick=\"return confirm('" . _('Are you sure you wish to delete this loan?') . "');\"></FORM>";
	}

} // end of main ifs

include ('includes/footer.inc.php');
?>