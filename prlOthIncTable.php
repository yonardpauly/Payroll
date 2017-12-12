<?php
/* $Revision: 1.0 $ */

$PageSecurity = 15;

include ('includes/session.inc.php');

$title = _('Other Income Section');

include ('includes/header.inc.php');

if (isset($_GET['OthIncID'])){
	$OthIncID = $_GET['OthIncID'];
} elseif (isset($_POST['OthIncID'])){
	
	$OthIncID = $_POST['OthIncID'];
} else {
	unset($OthIncID);
}


if (isset($_POST['submit'])) {

	//initialise no input errors assumed initially before we test

	$InputError = 0;

	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */

	//first off validate inputs sensible

	if (strpos($_POST['OthIncDesc'],'&')>0 OR strpos($_POST['OthIncDesc'],"'")>0) {
		$InputError = 1;
		prnMsg( _('The Other Income description cannot contain the character') . " '&' " . _('or the character') ." '",'error');
	}
	if (trim($_POST['OthIncDesc']) == '') {
		$InputError = 1;
		prnMsg( _('The Other Income description may not be empty'), 'error');
	}
	
	if (strlen($OthIncID) == 0) {
		$InputError = 1;
		prnMsg(_('The Other Income Code cannot be empty'),'error');
	}

	if ($InputError !=1) {
	
			if (!isset($_POST['New'])) {

			$sql = "UPDATE prlothinctable SET othincdesc='" . DB_escape_string($db, $_POST['OthIncDesc']) . "', 
							taxable='" . DB_escape_string($db, $_POST['Taxable']) . "' 
						WHERE othincid = '$OthIncID'";

			$ErrMsg = _('The other income could not be updated because');
			$DbgMsg = _('The SQL that was used to update the other income but failed was');
			$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);
			prnMsg(_('The other income master record for') . ' ' . $OthIncID . ' ' . _('has been updated'),'success');

		} else { //its a new other income

			$sql = "INSERT INTO prlothinctable (othincid, 
							othincdesc, 
							taxable)
					 VALUES ('$OthIncID', 
					 	'" .DB_escape_string($db, $_POST['OthIncDesc']) . "', 
						'" . DB_escape_string($db, $_POST['Taxable']) . "')";

			$ErrMsg = _('The other income') . ' ' . $_POST['OthIncDesc'] . ' ' . _('could not be added because');
			$DbgMsg = _('The SQL that was used to insert the other income but failed was');
			$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);

			prnMsg(_('A new other income for') . ' ' . $_POST['OthIncDesc'] . ' ' . _('has been added to the database'),'success');

			unset ($OthIncID);
			unset($_POST['OthIncDesc']);
			unset($_POST['Taxable']);

		}
		
	} else {

		prnMsg(_('Validation failed') . _('no updates or deletes took place'),'warn');

	}

} elseif (isset($_POST['delete']) AND $_POST['delete'] != '') {

//the link to delete a selected record was clicked instead of the submit button

	$CancelDelete = 0;

// PREVENT DELETES IF DEPENDENT RECORDS IN 'SuppTrans' , PurchOrders, SupplierContacts
	if ($CancelDelete == 0) {
		$sql="DELETE FROM prlothinctable WHERE othincid='$OthIncID'";
		$result = DB_query($sql, $db);
		prnMsg(_('Other Income record for') . ' ' . $OthIncID . ' ' . _('has been deleted'),'success');
		unset($OthIncID);
		unset($_SESSION['OthIncID']);
	} //end if Delete paypayperiod
}


if (!isset($OthIncID)) {

/*If the page was called without $SupplierID passed to page then assume a new supplier is to be entered show a form with a Supplier Code field other wise the form showing the fields with the existing entries against the supplier will show for editing with only a hidden SupplierID field*/

	echo "<FORM METHOD='post' ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "'>";

	echo "<INPUT TYPE='hidden' NAME='New' VALUE='Yes'>";

	echo '<CENTER><TABLE>';
	echo '<TR><TD>' . _('Other Income ID') . ":</TD><TD><INPUT TYPE='text' NAME='OthIncID' SIZE=5 MAXLENGTH=4></TD></TR>";
	echo '<TR><TD>' . _('Other Income Description') . ":</TD><TD><INPUT TYPE='text' NAME='OthIncDesc' SIZE=41 MAXLENGTH=40></TD></TR>";
	echo '</SELECT></TD></TR><TR><TD width=200 height=20>' . _('Taxable Income ?') . ":</TD><TD><SELECT NAME='Taxable'>";	
	echo '<OPTION VALUE="Taxable">' . _('Taxable');
	echo '<OPTION VALUE="Non-Tax">' . _('Non-Taxable');
	echo '</SELECT></TD></TR>';		

//	echo '</SELECT></TD></TR>';
	echo "</SELECT></TD></TR></TABLE><p><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Insert New other income') . "'>";
	echo '</FORM>';
	
		$sql = "SELECT othincid,
			othincdesc,
			taxable
			FROM prlothinctable
			ORDER BY othincid";

	$ErrMsg = _('Could not get other income because');
	$result = DB_query($sql,$db,$ErrMsg);
	
	echo '<CENTER><table border=1>';
	echo "<tr>
		<td class='tableheader'>" . _('Other Income ID') . "</td>
		<td class='tableheader'>" . _('Other Income Description') . "</td>
		<td class='tableheader'>" . _('Taxable Income') . "</td>
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
		echo '<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&OthIncID=' . $myrow[0] . '">' . _('Edit') . '</A></TD>';
		echo '<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&OthIncID=' . $myrow[0] . '&delete=1">' . _('Delete') .'</A></TD>';
		echo '</TR>';

	} //END WHILE LIST LOOP
	echo '</table></CENTER><p>';


} else {
//OthIncID exists - either passed when calling the form or from the form itself

	echo "<FORM METHOD='post' ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "'>";
	echo '<CENTER><TABLE>';

	//if (!isset($_POST['New'])) {
	if (!isset($_POST['New'])) {
		$sql = "SELECT othincid, 
				othincdesc, 
				taxable
			FROM prlothinctable 
			WHERE othincid = '$OthIncID'";
				  
		$result = DB_query($sql, $db);
		$myrow = DB_fetch_array($result);
		
		$_POST['OthIncDesc']  = $myrow['othincdesc'];
		$_POST['Taxable']  = $myrow['taxable'];
		echo "<INPUT TYPE=HIDDEN NAME='OthIncID' VALUE='$OthIncID'>";

	} else {
	// its a new other income being added
		echo "<INPUT TYPE=HIDDEN NAME='New' VALUE='Yes'>";
		echo '<TR><TD>' . _('Other Income Code') . ":</TD><TD><INPUT TYPE='text' NAME='OthIncID' VALUE='$OthIncID' SIZE=5 MAXLENGTH=4></TD></TR>";
	}
	echo "<TR><TD>" . _('Other Income Description') . ':' . "</TD><TD><input type='Text' name='OthIncDesc' SIZE=41 MAXLENGTH=40 value='" . $_POST['OthIncDesc'] . "'></TD></TR>";
	echo '</SELECT></TD></TR><TR><TD width=200 height=20>' . _('Taxable Income ?') . ":</TD><TD><SELECT NAME='Taxable'>";		
	if ($_POST['Taxable'] == 'Taxable'){
		echo '<OPTION SELECTED VALUE="Taxable">' . _('Taxable');
		echo '<OPTION VALUE="Non-Tax">' . _('Non-Taxable');
	} else {
		echo '<OPTION VALUE="Taxable">' . _('Taxable');
		echo '<OPTION SELECTED VALUE="Non-Tax">' . _('Non-Taxable');
	}
	echo '</SELECT></TD></TR>';
	if (isset($_POST['New'])) {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Add These New Other Income Record') . "'></FORM>";
	} else {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Update Other Income Record') . "'>";
		echo '<P><FONT COLOR=red><B>' . _('WARNING') . ': ' . _('There is no second warning if you hit the delete button below') . '. ' . _('However checks will be made to ensure before the deletion is processed') . '<BR></FONT></B>';
		echo "<INPUT TYPE='Submit' NAME='delete' VALUE='" . _('Delete this record') . "' onclick=\"return confirm('" . _('Are you sure you wish to delete this other income record?') . "');\"></FORM>";
	}

} // end of main ifs

include ('includes/footer.inc.php');
?>