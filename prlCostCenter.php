<?php
/* $Revision: 1.0 $ */

$PageSecurity = 15;

include ('includes/session.inc.php');

$title = 'Loan Table Section';

include ('includes/header.inc.php');

if ( isset($_GET['CostCenterID']) ){
	$CostCenterID = $_GET['CostCenterID'];
} elseif ( isset($_POST['CostCenterID']) ){
	
	$CostCenterID = $_POST['CostCenterID'];
} else {
	unset($CostCenterID);
}


if (isset($_POST['submit'])) {

	//initialise no input errors assumed initially before we test

	$InputError = 0;

	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */

	//first off validate inputs sensible

	if (strpos($_POST['CostCenterDesc'],'&')>0 OR strpos($_POST['CostCenterDesc'],"'")>0) {
		$InputError = 1;
		prnMsg('The cost center description cannot contain the character' . " '&' " . 'or the character' ." '",'error');
	}
	if (trim( $_POST['CostCenterDesc']) == '' ) {
		$InputError = 1;
		prnMsg('The cost center description may not be empty', 'error');
	}
	
	if (strlen($CostCenterID) == 0) {
		$InputError = 1;
		prnMsg('The cost center Code cannot be empty','error');
	}

	if ( $InputError != 1 ) {
	
			if ( !isset($_POST['New']) ) {

			$sql = "UPDATE workcentres SET description='" . DB_escape_string($db, $_POST['CostCenterDesc']) . "' 
						WHERE code = '$CostCenterID'";

			$ErrMsg = 'The cost center could not be updated because';
			$DbgMsg = 'The SQL that was used to update the cost center table but failed was';
			$result = DB_query( $sql, $db, $ErrMsg, $DbgMsg );
			prnMsg('The cost center table master record for' . ' ' . $CostCenterID . ' ' . 'has been updated', 'success');

		} else { //its a new cost center record

			$sql = "INSERT INTO workcentres (code, 
							description)
					 VALUES ('$CostCenterID', 
					 	'" .DB_escape_string($db, $_POST['CostCenterDesc']) . "')"; 

			$ErrMsg = 'The cost center' . ' ' . $_POST['CostCenterDesc'] . ' ' . 'could not be added because';
			$DbgMsg = 'The SQL that was used to insert the cost center table but failed was';
			$result = DB_query( $sql, $db, $ErrMsg, $DbgMsg );

			prnMsg('A new cost center table for' . ' ' . $_POST['CostCenterDesc'] . ' ' . 'has been added to the database','success');

			unset ($CostCenterID);
			unset($_POST['CostCenterDesc']);
	
		}
		
	} else {

		prnMsg('Validation failed' . 'no updates or deletes took place','warn');

	}

} elseif ( isset($_POST['delete']) AND $_POST['delete'] != '' ) {

//the link to delete a selected record was clicked instead of the submit button

	$CancelDelete = 0;

// PREVENT DELETES IF DEPENDENT RECORDS FOUND
	if ( $CancelDelete == 0 ) {
		$sql = "DELETE FROM workcentres WHERE code = '$CostCenterID'";
		$result = DB_query( $sql, $db );
		prnMsg('cost center table record for' . ' ' . $CostCenterID . ' ' . 'has been deleted','success');
		unset( $CostCenterID );
		unset( $_SESSION['CostCenterID'] );
	} 
}


if ( !isset($CostCenterID) ) {

	echo "<FORM METHOD='post' ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "'>";

	echo "<INPUT TYPE='hidden' NAME='New' VALUE='Yes'>";

	echo '<CENTER><TABLE>';
	echo '<TR><TD>' . _('Cost Center Code') . ":</TD><TD><INPUT TYPE='text' NAME='CostCenterID' SIZE=5 MAXLENGTH=4></TD></TR>";
	echo '<TR><TD>' . _('Pay Description') . ":</TD><TD><INPUT TYPE='text' NAME='CostCenterDesc' SIZE=41 MAXLENGTH=40></TD></TR>";
	echo "</SELECT></TD></TR></TABLE><p><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Insert New Cost Center') . "'>";
	echo '</FORM>';
	
		$sql = "SELECT code,
			description
			FROM workcentres
			ORDER BY code";

	$ErrMsg = 'Could not get cost center because';
	$result = DB_query( $sql, $db, $ErrMsg );
	
	echo '<CENTER><table border=1>';
	echo "<tr>
		<td class='tableheader'>" . _('cost center Code') . "</td>
		<td class='tableheader'>" . _('cost center Description') . "</td>
	</tr>";

		
	$k=0; //row colour counter
	while ($myrow = DB_fetch_row($result)) {

		if ( $k == 1 ){
			echo "<TR BGCOLOR='#CCCCCC'>";
			$k = 0;
		} else {
			echo "<TR BGCOLOR='#EEEEEE'>";
			$k++;
		}
		echo '<TD>' . $myrow[0] . '</TD>';
		echo '<TD>' . $myrow[1] . '</TD>';
		echo '<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&CostCenterID=' . $myrow[0] . '">' . _('Edit') . '</A></TD>';
		echo '<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&CostCenterID=' . $myrow[0] . '&delete=1">' . _('Delete') .'</A></TD>';
		echo '</TR>';

	} //END WHILE LIST LOOP
	echo '</table></CENTER><p>';


} else {

	echo "<FORM METHOD='post' ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "'>";
	echo '<CENTER><TABLE>';

	//if (!isset($_POST['New'])) {
	if ( !isset($_POST['New']) ) {
		$sql = "SELECT code, 
				description
			FROM workcentres 
			WHERE code = '$CostCenterID'";
				  
		$result = DB_query( $sql, $db );
		$myrow = DB_fetch_array($result);
		
		$_POST['CostCenterDesc']  = $myrow['description'];
		echo "<INPUT TYPE=HIDDEN NAME='CostCenterID' VALUE='$CostCenterID'>";

	} else {
	// its a new cost center being added
		echo "<INPUT TYPE=HIDDEN NAME='New' VALUE='Yes'>";
		echo '<TR><TD>' . _('Cost Center Code') . ":</TD><TD><INPUT TYPE='text' NAME='CostCenterID' VALUE='$CostCenterID' SIZE=5 MAXLENGTH=4></TD></TR>";
	}
	echo "<TR><TD>" . _('Cost Center Description') . ':' . "</TD><TD><input type='Text' name='CostCenterDesc' SIZE=41 MAXLENGTH=40 value='" . $_POST['CostCenterDesc'] . "'></TD></TR>";
	echo '</SELECT></TD></TR>';

	if (isset($_POST['New'])) {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Add These New cost center Details') . "'></FORM>";
	} else {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Update cost center Table') . "'>";
		echo '<P><FONT COLOR=red><B>' . _('WARNING') . ': ' . _('There is no second warning if you hit the delete button below') . '. ' . _('However checks will be made to ensure before the deletion is processed') . '<BR></FONT></B>';
		echo "<INPUT TYPE='Submit' NAME='delete' VALUE='" . _('Delete cost center Table') . "' onclick=\"return confirm('" . _('Are you sure you wish to delete this cost center?') . "');\"></FORM>";
	}

} // end of main ifs

include ('includes/footer.inc.php');
?>