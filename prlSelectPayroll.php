<?php
/* $Revision: 1.0 $ */

$PageSecurity = 10;
include ('includes/session.inc.php');
$title = _('Payroll Master Maintenance');

include ('includes/header.inc.php');



    echo "<CENTER><TABLE WIDTH=30% BORDER=2><TR></TR>";		
	echo '<TR><TD WIDTH=100%>';
    echo '<CENTER><a href="' . $rootpath . '/prlEditPayroll.php?SelectedAccountr=' . $_SESSION[''] . '">' . _('Create Payroll Period') . '</a><BR>';
	echo '</TD><TD WIDTH=100%>';
    echo '</TD></TR></TABLE><BR></CENTER>';

if (isset($_GET['PayrollID'])){
	$PayrollID = $_GET['PayrollID'];
} elseif (isset($_POST['PayrollID'])){
	$PayrollID = $_POST['PayrollID'];
}

	
if (isset($_GET['delete']))
 {
//the link to delete a selected record was clicked instead of the submit button
				$sql="DELETE FROM prlemployeemaster WHERE employeeid ".LIKE."'" . DB_escape_string($SelectedEmployeeID) . "'";
				$result = DB_query($sql,$db);
				prnMsg( 'employee id has been deleted' . '!','success');
	//}
	//end if account group used in GL accounts
	unset ($PayrollID);
	unset ($_GET['PayrollID']);
	unset($_GET['select']);
	unset ($_POST['PayrollID']);

 }	

if (!isset($PayrollID)) {
/* It could still be the second time the page has been run and a record has been selected for modification - SelectedAccount will exist because it was sent with the new call. If its the first time the page has been displayed with no parameters
then none of the above are true and the list of ChartMaster will be displayed with
links to delete or edit each. These will call the same page again and allow update/input
or deletion of the records*/

	$sql = "SELECT payrollid,
            payrolldesc,	
			fsmonth,
			fsyear,
			startdate,
			enddate,
			payperiodid
		FROM prlpayrollperiod
		ORDER BY payrollid";
	$ErrMsg = _('The payroll record could not be retrieved because');
	$result = DB_query($sql,$db,$ErrMsg);

	echo '<CENTER><table border=1>';
	echo "<tr>
		<td class='tableheader'>" . _('Payroll ID') . "</td>
		<td class='tableheader'>" . _('Desciption') . "</td>
		<td class='tableheader'>" . _('FS Month') . "</td>
		<td class='tableheader'>" . _('FS Year') . "</td>
		<td class='tableheader'>" . _('Start Date') . "</td>
		<td class='tableheader'>" . _('End Date') . "</td>
		<td class='tableheader'>" . _('Pay Period ') . "</td>
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
		echo '<TD><A HREF="'. $rootpath . '/prlCreatePayroll.php?' . SID . '&PayrollID=' . $myrow[0] . '">' . _('Select') . '</A></TD>';
		echo '</TR>';

	} //END WHILE LIST LOOP

	//END WHILE LIST LOOP
} //END IF SELECTED ACCOUNT


echo '</CENTER></TABLE>';
//end of ifs and buts!

include ('includes/footer.inc.php');
?>