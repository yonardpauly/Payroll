<?php
/* $Revision: 1.0 $ */

$PageSecurity = 15;

include ('includes/session.inc.php');

$title = _('Employment Status Section');

include ('includes/header.inc.php');

if ( isset($_GET['SelectedStatusID']) )
	$SelectedStatusID = $_GET['SelectedStatusID'];
elseif (isset($_POST['SelectedStatusID']))
	$SelectedStatusID = $_POST['SelectedStatusID'];

if (isset($_POST['submit'])) {

	//initialise no input errors assumed initially before we test

	$InputError = 0;

	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */

	//first off validate inputs sensible

	if (strpos($_POST['EmploymentName'],'&')>0 OR strpos($_POST['EmploymentName'],"'")>0) {
		$InputError = 1;
		prnMsg( _('The employment description cannot contain the character') . " '&' " . _('or the character') ." '",'error');
	}
	if (trim($_POST['EmploymentName']) == '') {
		$InputError = 1;
		prnMsg( _('The employment description may not be empty'), 'error');
	}

	if ($_POST['SelectedStatusID']!='' AND $InputError !=1) {

		/*SelectedStatusID could also exist if submit had not been clicked this code would not run in this case cos submit is false of course  see the delete code below*/
		// Check the name does not clash
		$sql = "SELECT count(*) FROM prlemploymentstatus 
				WHERE employmentid <> " . $SelectedStatusID ."
				AND employmentdesc ".LIKE." '" . $_POST['EmploymentName'] . "'";
		$result = DB_query($sql,$db);
		$myrow = DB_fetch_row($result);
		if ( $myrow[0] > 0 ) {
			$InputError = 1;
			prnMsg( _('The employment description can not be renamed because another with the same name already exist.'),'error');
		} else {
			// Get the old name and check that the record still exist neet to be very carefull here
			// idealy this is one of those sets that should be in a stored procedure simce even the checks are 
			// relavant
			$sql = "SELECT employmentdesc FROM prlemploymentstatus 
				WHERE employmentid = " . $SelectedStatusID;
			$result = DB_query($sql,$db);
			if ( DB_num_rows($result) != 0 ) {
				// This is probably the safest way there is
				$myrow = DB_fetch_row($result);
				$OldEmploymentName = $myrow[0];
				$sql = array();
				$sql[] = "UPDATE prlemploymentstatus
					SET employmentdesc='" . DB_escape_string($db, $_POST['EmploymentName']) . "'
					WHERE employmentdesc ".LIKE." '".$OldEmploymentName."'";
				$sql[] = "UPDATE stockmaster
					SET units='" . DB_escape_string($db, $_POST['EmploymentName']) . "'
					WHERE units ".LIKE." '" . $OldEmploymentName . "'";
				$sql[] = "UPDATE contracts
					SET units='" . DB_escape_string($db, $_POST['EmploymentName']) . "'
					WHERE units ".LIKE." '" . $OldEmploymentName . "'";
			} else {
				$InputError = 1;
				prnMsg( _('The employment description no longer exist.'),'error');
			}
		}
		$msg = _('Employment description changed');
	} elseif ($InputError !=1) {
		/*SelectedStatusID is null cos no item selected on first time round so must be adding a record*/
		$sql = "SELECT count(*) FROM prlemploymentstatus 
				WHERE employmentdesc " .LIKE. " '".$_POST['EmploymentName'] ."'";
		$result = DB_query($sql,$db);
		$myrow = DB_fetch_row($result);
		if ( $myrow[0] > 0 ) {
			$InputError = 1;
			prnMsg( _('The employment description can not be created because another with the same name already exists.'),'error');
		} else {
			$sql = "INSERT INTO prlemploymentstatus (
						Employmentdesc )
				VALUES (
					'" . DB_escape_string($db, $_POST['EmploymentName']) ."'
					)";
		}
		$msg = _('New employment description added');
	}

	if ($InputError!=1){
		//run the SQL from either of the above possibilites
		if (is_array($sql)) {
			$result = DB_query('BEGIN',$db);
			$tmpErr = _('Could not update Employment description');
			$tmpDbg = _('The sql that failed was') . ':';
			foreach ($sql as $stmt ) {
				$result = DB_query($stmt,$db, $tmpErr,$tmpDbg,true);
				if(!$result) {
					$InputError = 1;
					break;
				}
			}
			if ($InputError!=1){
				$result = DB_query('COMMIT',$db);
			} else {
				$result = DB_query('ROLLBACK',$db);
			}
		} else {
			$result = DB_query($sql,$db);
		}
		prnMsg($msg,'success');
	}
	unset ($SelectedStatusID);
	unset ($_POST['SelectedStatusID']);
	unset ($_POST['EmploymentName']);

} elseif (isset($_GET['delete'])) {
//the link to delete a selected record was clicked instead of the submit button
// PREVENT DELETES IF DEPENDENT RECORDS IN 'stockmaster'
	// Get the original name of the employment status the ID is just a secure way to find the employment status
	$sql = "SELECT employmentdesc FROM prlemploymentstatus 
		WHERE employmentid = " . DB_escape_string($db, $SelectedStatusID);
	$result = DB_query($sql,$db);
	if ( DB_num_rows($result) == 0 ) {
		// This is probably the safest way there is
		prnMsg( _('Cannot delete this employment description because it no longer exist'),'warn');
	} else {
		$myrow = DB_fetch_row($result);
		$OldEmploymentName = $myrow[0];
		$sql= "SELECT COUNT(*) FROM stockmaster WHERE units ".LIKE." '" . DB_escape_string($db, $OldEmploymentName) . "'";
		$result = DB_query($sql,$db);
		$myrow = DB_fetch_row($result);
		if ($myrow[0]>0) {
			prnMsg( _('Cannot delete this employment description because inventory items have been created using this employment status'),'warn');
			echo '<br>' . _('There are') . ' ' . $myrow[0] . ' ' . _('inventory items that refer to this employment status') . '</FONT>';
		} else {
			$sql= "SELECT COUNT(*) FROM contracts WHERE units ".LIKE." '" . DB_escape_string($db, $OldEmploymentName) . "'";
			$result = DB_query($sql,$db);
			$myrow = DB_fetch_row($result);
			if ($myrow[0]>0) {
				prnMsg( _('Cannot delete this employment status because contracts have been created using this employment status'),'warn');
				echo '<br>' . _('There are') . ' ' . $myrow[0] . ' ' . _('contracts that refer to this employment status') . '</FONT>';
			} else {
				$sql="DELETE FROM prlemploymentstatus WHERE employmentdesc ".LIKE."'" . DB_escape_string($db, $OldEmploymentName) . "'";
				$result = DB_query($sql,$db);
				prnMsg( $OldEmploymentName . ' ' . _('employement status has been deleted') . '!','success');
			}
		}

	} //end if account group used in GL accounts
	unset ($SelectedStatusID);
	unset ($_GET['SelectedStatusID']);
	unset($_GET['delete']);
	unset ($_POST['SelectedStatusID']);
	unset ($_POST['StatusID']);
	unset ($_POST['EmploymentName']);
}

 if (!isset($SelectedStatusID)) {

/* An employment status could be posted when one has been edited and is being updated 
  or GOT when selected for modification
  SelectedStatusID will exist because it was sent with the page in a GET .
  If its the first time the page has been displayed with no parameters
  then none of the above are true and the list of account groups will be displayed with
  links to delete or edit each. These will call the same page again and allow update/input
  or deletion of the records*/

	$sql = "SELECT employmentid,
			employmentdesc
			FROM prlemploymentstatus
			ORDER BY employmentid";

	$ErrMsg = _('Could not get employment status because');
	$result = DB_query($sql,$db,$ErrMsg);

	echo "<CENTER><TABLE>
		<TR>
		<TD class='tableheader'>" . _('Employment Status') . "</TD>
		</TR>";

	$k=0; //row colour counter
	while ($myrow = DB_fetch_row($result)) {

		if ($k==1){
			echo "<TR BGCOLOR='#CCCCCC'>";
			$k=0;
		} else {
			echo "<TR BGCOLOR='#EEEEEE'>";
			$k++;
		}

		echo '<TD>' . $myrow[1] . '</TD>';
		echo '<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&SelectedStatusID=' . $myrow[0] . '">' . _('Edit') . '</A></TD>';
		echo '<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&SelectedStatusID=' . $myrow[0] . '&delete=1">' . _('Delete') .'</A></TD>';
		echo '</TR>';

	} //END WHILE LIST LOOP
	echo '</table></CENTER><p>';
} //end of ifs and buts!


if (isset($SelectedStatusID)) {
	echo '<CENTER><A HREF=' . $_SERVER['PHP_SELF'] . '?' . SID .'>' . _('Review Employment Status') . '</a></Center>';
}

echo '<P>';

if (! isset($_GET['delete'])) {

	echo "<FORM METHOD='post' action=" . $_SERVER['PHP_SELF'] . '?' . SID . '>';

	if (isset($SelectedStatusID)) {
		//editing an existing section

		$sql = "SELECT employmentid,
				employmentdesc
				FROM prlemploymentstatus
				WHERE employmentid=" . DB_escape_string($db, $SelectedStatusID);

		$result = DB_query($sql, $db);
		if ( DB_num_rows($result) == 0 ) {
			prnMsg( _('Could not retrieve the requested employment status, please try again.'),'warn');
			unset($SelectedStatusID);
		} else {
			$myrow = DB_fetch_array($result);

			$_POST['StatusID'] = $myrow['employmentid'];
			$_POST['EmploymentName']  = $myrow['employmentdesc'];

			echo "<INPUT TYPE=HIDDEN NAME='SelectedStatusID' VALUE='" . $_POST['StatusID'] . "'>";
			echo "<CENTER><TABLE>";
		}

	}  else {
		$_POST['EmploymentName']='';
		echo "<CENTER><TABLE>";
	}
	echo "<TR>
		<TD>" . _('Employment Status') . ':' . "</TD>
		<TD><input type='Text' name='EmploymentName' SIZE=30 MAXLENGTH=30 value='" . $_POST['EmploymentName'] . "'></TD>
		</TR>";
	echo '</TABLE>';

	echo '<CENTER><input type=Submit name=submit value=' . _('Enter Information') . '>';

	echo '</FORM>';

} //end if record deleted no point displaying form to add record

include ('includes/footer.inc.php');
?>