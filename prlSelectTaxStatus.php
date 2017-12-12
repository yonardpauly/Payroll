<?php
/* $Revision: 1.0 $ */

$PageSecurity = 10;
include ('includes/session.inc.php');
$title = _('Employee Tax Status Maintenance');

include ('includes/header.inc.php');



    echo "<CENTER><TABLE WIDTH=30% BORDER=2><TR></TR>";		
	echo '<TR><TD WIDTH=100%>';
    echo '<CENTER><a href="' . $rootpath . '/prlTaxStatus.php?SelectedAccountr=' . $_SESSION[''] . '">' . _('Add tax status records') . '</a><BR>';
	echo '</TD><TD WIDTH=100%>';
    echo '</TD></TR></TABLE><BR></CENTER>';

if (isset($_GET['TaxStatusID'])){
	$TaxStatusID = strtoupper($_GET['TaxStatusID']);
} elseif (isset($_POST['TaxStatusID'])){
	$TaxStatusID = strtoupper($_POST['TaxStatusID']);
} else {
	unset($TaxStatusID);
} 
	
	
	
if (isset($_GET['delete']))
 {
//the link to delete a selected record was clicked instead of the submit button
				$sql="DELETE FROM prltaxstatus WHERE taxstatusid ".LIKE."'" . DB_escape_string($TaxStatusID) . "'";
				$result = DB_query($sql,$db);
				prnMsg( 'employee id has been deleted' . '!','success');
	//}
	//end if account group used in GL accounts
	unset ($TaxStatusID);
	unset ($_GET['TaxStatusID']);
	unset($_GET['delete']);
	unset ($_POST['TaxStatusID']);
	//unset ($_POST['EmployeeID']);
 }	

if (!isset($TaxStatusID)) {
/* It could still be the second time the page has been run and a record has been selected for modification - SelectedAccount will exist because it was sent with the new call. If its the first time the page has been displayed with no parameters
then none of the above are true and the list of ChartMaster will be displayed with
links to delete or edit each. These will call the same page again and allow update/input
or deletion of the records*/

	$sql = "SELECT taxstatusid,
			taxstatusdescription
		FROM prltaxstatus
		ORDER BY taxstatusid";
	$ErrMsg = _('The tax status master could not be retrieved because');
	$result = DB_query($sql,$db,$ErrMsg);

	echo '<CENTER><table border=1>';
	echo "<tr>
		<td class='tableheader'>" . _('Tax Status ID') . "</td>
		<td class='tableheader'>" . _('Tax Status Description ') . "</td>
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
		echo '<TD><A HREF="'. $rootpath . '/prlTaxStatus.php?' . SID . '&TaxStatusID=' . $myrow[0] . '">' . _('Edit/Delete') . '</A></TD>';
		echo '</TR>';

	} //END WHILE LIST LOOP

	//END WHILE LIST LOOP
} //END IF SELECTED ACCOUNT


echo '</CENTER></TABLE>';
//end of ifs and buts!

include ('includes/footer.inc.php');
?>