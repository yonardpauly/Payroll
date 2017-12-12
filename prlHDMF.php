<?php
/* $Revision: 1.0 $ */

$PageSecurity = 15;

include ('includes/session.inc.php');

$title = _('Pag-ibig Section');

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
			
			$sql = "UPDATE prlhdmftable SET 
					rangefrom='" .DB_escape_string($db, $_POST['RangeFr']) . "', 
					rangeto='" .DB_escape_string($db, $_POST['RangeTo']) . "', 
					dedtypeer='" .$_POST['DedTypeER']. "',  
					employershare='" .DB_escape_string($db, $_POST['ERHDMF']) . "', 
					dedtypeee='" .$_POST['DedTypeEE']. "', 
					employeeshare='" .DB_escape_string($db, $_POST['EEHDMF']) . "'
						WHERE bracket='$Bracket'";

			$ErrMsg = _('The Pag-ibig could not be updated because');
			$DbgMsg = _('The SQL that was used to update the Pag-ibig but failed was');
			$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);
			prnMsg(_('The Pag-ibig master record for') . ' ' . $Bracket . ' ' . _('has been updated'),'success');

		} else { //its a new Pag-ibig
		$sql = "INSERT INTO prlhdmftable (bracket, 
					rangefrom,
					rangeto,
					dedtypeer,
					employershare,
					dedtypeee,
					employeeshare)
				 VALUES ('$Bracket', 
					 	'" .DB_escape_string($db, $_POST['RangeFr']) . "', 
						'" .DB_escape_string($db, $_POST['RangeTo']) . "', 
						'" .$_POST['DedTypeER']. "', 
						'" .DB_escape_string($db, $_POST['ERHDMF']) . "', 
						'" .$_POST['DedTypeEE']. "', 
						'" .DB_escape_string($db, $_POST['EEHDMF']) . "')"; 
			$ErrMsg = _('The Pag-ibig could not be added because');
			$DbgMsg = _('The SQL that was used to insert the Pag-ibig but failed was');
			$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);

			prnMsg(_('A new Pag-ibig has been added to the database'),'success');

			unset ($Bracket);
			unset($_POST['RangeFr']);
			unset($_POST['RangeTo']);
			unset($_POST['DedTypeER']);
			unset($_POST['ERHDMF']);
			unset($_POST['DedTypeEE']);
			unset($_POST['EEHDMF']);
		}
		
	} else {

		prnMsg(_('Validation failed') . _('no updates or deletes took place'),'warn');

	}

} elseif (isset($_POST['delete']) AND $_POST['delete'] != '') {

//the link to delete a selected record was clicked instead of the submit button

	$CancelDelete = 0;
	
// PREVENT DELETES IF DEPENDENT RECORDS found
	if ($CancelDelete == 0) {
		$sql="DELETE FROM prlhdmftable WHERE bracket='$Bracket'";
		$result = DB_query($sql, $db);
		prnMsg(_('Pag-ibig record for') . ' ' . $Bracket . ' ' . _('has been deleted'),'success');
		unset($Bracket);
		unset($_SESSION['Bracket']);
	} 
}


if (!isset($Bracket)) {

/*new hdmf*/

	echo "<FORM METHOD='post' ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "'>";

	echo "<INPUT TYPE='hidden' NAME='New' VALUE='Yes'>";

	echo '<CENTER><TABLE>';
	echo '<TR><TD>' . _('Salary Bracket') . ":</TD><TD><INPUT TYPE='text' NAME='Bracket' SIZE=5 MAXLENGTH=4></TD></TR>";
	echo '<TR><TD>' . _('Range From') . ":</TD><TD><INPUT TYPE='text' NAME='RangeFr' SIZE=14 MAXLENGTH=12></TD></TR>";
	echo '<TR><TD>' . _('Range To') . ":</TD><TD><INPUT TYPE='text' NAME='RangeTo' SIZE=14 MAXLENGTH=12></TD></TR>";
	echo '</SELECT></TD></TR><TR><TD>' . _('Employer Share') . ":</TD><TD><SELECT NAME='DedTypeER'>";	
	echo '<OPTION VALUE="Fixed">' . _('Fixed');
	echo '<OPTION VALUE="Percentage">' . _('Percentage');
	echo "<TD><INPUT TYPE='text' NAME='ERHDMF' SIZE=14 MAXLENGTH=12></TD>";
	echo '</SELECT></TD></TR><TR><TD>' . _('Employee Share') . ":</TD><TD><SELECT NAME='DedTypeEE'>";
	echo '<OPTION VALUE="Fixed">' . _('Fixed');
	echo '<OPTION VALUE="Percentage">' . _('Percentage');
	echo "<TD><INPUT TYPE='text' NAME='EEHDMF' SIZE=14 MAXLENGTH=12></TD>";
	echo "</SELECT></TD></TR></TABLE><p><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Insert New Pag-ibig') . "'>";
	echo '</FORM>';
	
		$sql = "SELECT bracket,
					rangefrom,
					rangeto,
					dedtypeer,
					employershare,
					dedtypeee,
					employeeshare
				FROM prlhdmftable
				ORDER BY bracket";

	$ErrMsg = _('Could not get Pag-ibig because');
	$result = DB_query($sql,$db,$ErrMsg);
	
	echo '<CENTER><table border=1>';
	echo "<tr>
		<td class='tableheader'>" . _('Salary Bracket') . "</td>
		<td class='tableheader'>" . _('Range From') . "</td>
		<td class='tableheader'>" . _('Range To') . "</td>
		<td class='tableheader'>" . _('Employer Share') . "</td>
		<td class='tableheader'>" . _('Employer Share') . "</td>
		<td class='tableheader'>" . _('Employee Share') . "</td>
		<td class='tableheader'>" . _('Employee Share') . "</td>
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
					dedtypeer,
					employershare,
					dedtypeee,
					employeeshare
				FROM prlhdmftable
				WHERE bracket='$Bracket'";
		$result = DB_query($sql, $db);
		$myrow = DB_fetch_array($result);
		
		$_POST['RangeFr']  = $myrow['rangefrom'];
		$_POST['RangeTo']  = $myrow['rangeto'];
		$_POST['DedTypeER']  = $myrow['dedtypeer'];
		$_POST['ERHDMF']  = $myrow['employershare'];
		$_POST['DedTypeEE']  = $myrow['dedtypeee'];
		$_POST['EEHDMF']  = $myrow['employeeshare'];
		echo "<INPUT TYPE=HIDDEN NAME='Bracket' VALUE='$Bracket'>";

	} else {
	// its a new Pag-ibig being added
		echo "<INPUT TYPE=HIDDEN NAME='New' VALUE='Yes'>";
		echo '<TR><TD>' . _('Bracket') . ":</TD><TD><INPUT TYPE='text' NAME='Bracket' VALUE='$Bracket' SIZE=5 MAXLENGTH=4></TD></TR>";
	}
	echo '<TR><TD>' . _('Range From') . ":</TD><TD><INPUT TYPE='text' NAME='RangeFr' SIZE=14 MAXLENGTH=12 value='" . $_POST['RangeFr'] . "'></TD></TR>";
	echo '<TR><TD>' . _('Range To') . ":</TD><TD><INPUT TYPE='text' NAME='RangeTo' SIZE=14 MAXLENGTH=12 value='" . $_POST['RangeTo'] . "'></TD></TR>";
	echo '</SELECT></TD></TR><TR><TD>' . _('Employer Share') . ":</TD><TD><SELECT NAME='DedTypeER'>";	
	if ($_POST['DedTypeER'] == 'Fixed'){
		echo '<OPTION SELECTED VALUE="Fixed">' . _('Fixed');
		echo '<OPTION VALUE="Percentage">' . _('Percentage');
	} elseif ($_POST['DedTypeER'] == 'Percentage') {
		echo '<OPTION SELECTED VALUE="Percentage">' . _('Percentage');
		echo '<OPTION VALUE="Fixed">' . _('Fixed');
	} else {
		echo '<OPTION SELECTED VALUE="">' . _('Select One');
		echo '<OPTION VALUE="Fixed">' . _('Fixed');
	    echo '<OPTION VALUE="Percentage">' . _('Percentage');
	}
	echo "<TD><INPUT TYPE='text' NAME='ERHDMF' SIZE=14 MAXLENGTH=12 value='" . $_POST['ERHDMF'] . "'></TD>";
	
	echo '</SELECT></TD></TR><TR><TD>' . _('Employee Share') . ":</TD><TD><SELECT NAME='DedTypeEE'>";	
	if ($_POST['DedTypeEE'] == 'Fixed'){
		echo '<OPTION SELECTED VALUE="Fixed">' . _('Fixed');
		echo '<OPTION VALUE="Percentage">' . _('Percentage');
	} elseif ($_POST['DedTypeEE'] == 'Percentage') {
		echo '<OPTION SELECTED VALUE="Percentage">' . _('Percentage');
		echo '<OPTION VALUE="Fixed">' . _('Fixed');
	} else {
		echo '<OPTION SELECTED VALUE="">' . _('Select One');
		echo '<OPTION VALUE="Fixed">' . _('Fixed');
	    echo '<OPTION VALUE="Percentage">' . _('Percentage');
	}
	echo "<TD><INPUT TYPE='text' NAME='EEHDMF' SIZE=14 MAXLENGTH=12 value='" . $_POST['EEHDMF'] . "'></TD>";
	
	if (isset($_POST['New'])) {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Add These New Pag-ibig Details') . "'></FORM>";
	} else {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Update Pag-ibig') . "'>";
		echo '<P><FONT COLOR=red><B>' . _('WARNING') . ': ' . _('There is no second warning if you hit the delete button below') . '. ' . _('However checks will be made to ensure before the deletion is processed') . '<BR></FONT></B>';
		echo "<INPUT TYPE='Submit' NAME='delete' VALUE='" . _('Delete Pag-ibig') . "' onclick=\"return confirm('" . _('Are you sure you wish to delete this Pag-ibig?') . "');\"></FORM>";
	}

} // end of main ifs

include ('includes/footer.inc.php');
?>