<?php
/* $Revision: 1.0 $ */

$PageSecurity = 10;
include ('includes/session.inc.php');
$title = _('View Payroll Deductions');

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

// PREVENT DELETES IF DEPENDENT RECORDS IN 'SuppTrans' , PurchOrders, SupplierContacts
	if ($CancelDelete == 0) {
		$sql="DELETE FROM prlloandeduction WHERE counterindex='$Counter'";
		$result = DB_query($sql, $db);
		prnMsg(_('Deduction record for') . ' ' . $Counter . ' ' . _('has been deleted'),'success');
		unset($Counter);
		unset($_SESSION['Counter']);
	} //end if Delete paypayperiod
}
	

if (!isset($Counter)) {
/* It could still be the second time the page has been run and a record has been selected for modification - SelectedAccount will exist because it was sent with the new call. If its the first time the page has been displayed with no parameters
then none of the above are true and the list of ChartMaster will be displayed with
links to delete or edit each. These will call the same page again and allow update/input
or deletion of the records*/
	echo "<FORM METHOD='post' ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "'>";
	echo "<INPUT TYPE='hidden' NAME='New' VALUE='Yes'>";
	echo '<CENTER><TABLE>';

	$sql = "SELECT  	counterindex,
						payrollid,
						employeeid,
						loantableid,
						amount
		FROM prlloandeduction
		ORDER BY counterindex";
	$ErrMsg = _('The ot could not be retrieved because');
	$result = DB_query($sql,$db,$ErrMsg);

	echo '<CENTER><table border=1>';
	echo "<tr>
		<td class='tableheader'>" . _('Index') . "</td>
		<td class='tableheader'>" . _('Pay ID ') . "</td>
		<td class='tableheader'>" . _('Emp ID') . "</td>
		<td class='tableheader'>" . _('Loan ID') . "</td>
		<td class='tableheader'>" . _('Amount') . "</td>
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
		echo '<TD>' . $myrow[2] . '</TD>';
		echo '<TD>' . $myrow[3] . '</TD>';
		echo '<TD>' . $myrow[4] . '</TD>';
		echo '<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&Counter=' . $myrow[0] . '&delete=1">' . _('Delete') .'</A></TD>';		
		echo '</TR>';

	} //END WHILE LIST LOOP

	//END WHILE LIST LOOP
} //END IF SELECTED ACCOUNT


echo '</CENTER></TABLE>';
//end of ifs and buts!

include ('includes/footer.inc.php');
?>