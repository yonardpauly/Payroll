<?php
/* $Revision: 1.0 $ */

$PageSecurity = 10;
include ('includes/session.inc.php');
$title = _('View Other Income Data');

include ('includes/header.inc.php');


	
if (isset($_GET['Counter'])){
	$Counter = $_GET['Counter'];
} elseif (isset($_POST['Counter'])){
	$Counter = $_POST['Counter'];
} else {
	unset($Counter);
}

	

if (isset($_GET['delete'])) {
//the link to delete a selected record was clicked instead of the submit button

	$CancelDelete = 0;

// PREVENT DELETES IF DEPENDENT RECORDS
	if ($CancelDelete == 0) {
		$sql="DELETE FROM prlothincfile WHERE counterindex='$Counter'";
		$result = DB_query($sql, $db);
		prnMsg(_('Other Income record for') . ' ' . $Counter . ' ' . _('has been deleted'),'success');
		unset($Counter);
		unset($_SESSION['Counter']);
	} //end if Delete paypayperiod
}
	

if (!isset($Counter)) {
	echo "<FORM METHOD='post' ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "'>";
	echo "<INPUT TYPE='hidden' NAME='New' VALUE='Yes'>";
	echo '<CENTER><TABLE>';

	$sql = "SELECT  	counterindex,
						employeeid,
						othdate,
						othincid,
						othincamount
		FROM prlothincfile
		ORDER BY counterindex";
	$ErrMsg = _('The ot could not be retrieved because');
	$result = DB_query($sql,$db,$ErrMsg);

	echo '<CENTER><table border=1>';
	echo "<tr>
		<td class='tableheader'>" . _('Index') . "</td>
		<td class='tableheader'>" . _('Emp ID') . "</td>
		<td class='tableheader'>" . _('Date') . "</td>
		<td class='tableheader'>" . _('OthInc ID') . "</td>
		<td class='tableheader'>" . _('Amount') . "</td>
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
		echo '<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&Counter=' . $myrow[0] . '&delete=1">' . _('Delete') .'</A></TD>';
		echo '</TR>';

	} //END WHILE LIST LOOP

	//END WHILE LIST LOOP
} //END IF SELECTED ACCOUNT


echo '</CENTER></TABLE>';
//end of ifs and buts!

include ('includes/footer.inc.php');
?>