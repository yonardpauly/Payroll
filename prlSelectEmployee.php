<?php
/* $Revision: 1.0 $ */

$PageSecurity = 10;
include ('includes/session.inc.php');
$title = _('Employee Master Maintenance');

include ('includes/header.inc.php');



    echo "<CENTER><TABLE WIDTH=30% BORDER=2><TR></TR>";		
	echo '<TR><TD WIDTH=100%>';
	//echo '<CENTER><a href="' . $rootpath . '/prlEmployeeMaster.php">' . _('Add employee records') . '</a><BR>';
    echo '<CENTER><a href="' . $rootpath . '/prlEmployeeMaster.php?SelectedAccountr=' . $_SESSION[''] . '">' . _('Add employee records') . '</a><BR>';
	echo '</TD><TD WIDTH=100%>';
    echo '</TD></TR></TABLE><BR></CENTER>';

if ( isset($_GET['EmployeeID']) )
	$EmployeeID = $_GET['EmployeeID'];
elseif (isset($_POST['EmployeeID']))
	$EmployeeID = $_POST['EmployeeID'];
	
	
	
if (isset($_GET['delete']))
 {
//the link to delete a selected record was clicked instead of the submit button
	// Get the original name of the marital status the ID is just a secure way to find the marital status
	//$sql = "SELECT employeemaster.employeeid FROM employeemaster
	//	WHERE employeemaster.employeeid = " . DB_escape_string($SelectedEmployeeID);
	//$result = DB_query($sql,$db);
	//if ( DB_num_rows($result) == 0 ) {
		// This is probably the safest way there is
	//	prnMsg( _('Cannot delete this marital description because it no longer exist'),'warn');
	//} else {
    //    $myrow = DB_fetch_row($result);
	//	$OldEmployeeID = $myrow[0];
				$sql="DELETE FROM prlemployeemaster WHERE employeeid ".LIKE."'" . DB_escape_string($SelectedEmployeeID) . "'";
				$result = DB_query($sql,$db);
				prnMsg( 'employee id has been deleted' . '!','success');
	//}
	//end if account group used in GL accounts
	unset ($EmployeeID);
	unset ($_GET['EmployeeID']);
	unset($_GET['delete']);
	unset ($_POST['EmployeeID']);
	//unset ($_POST['EmployeeID']);
 }	

if (!isset($EmployeeID)) {
/* It could still be the second time the page has been run and a record has been selected for modification - SelectedAccount will exist because it was sent with the new call. If its the first time the page has been displayed with no parameters
then none of the above are true and the list of ChartMaster will be displayed with
links to delete or edit each. These will call the same page again and allow update/input
or deletion of the records*/

	$sql = "SELECT employeeid,
			lastname,
			firstname,
			paytype,
			marital,
			periodrate,
			birthdate,
			active,
			payperiodid
		FROM prlemployeemaster
		ORDER BY employeeid";
	$ErrMsg = _('The employee master could not be retrieved because');
	$result = DB_query($sql,$db,$ErrMsg);

	echo '<CENTER><table border=1>';
	echo "<tr>
		<td class='tableheader'>" . _('Employee ID') . "</td>
		<td class='tableheader'>" . _('Last Name ') . "</td>
		<td class='tableheader'>" . _('First Name') . "</td>
		<td class='tableheader'>" . _('Pay Type  ') . "</td>
		<td class='tableheader'>" . _('Marital Status') . "</td>
		<td class='tableheader'>" . _('Basic Pay ') . "</td>
		<td class='tableheader'>" . _('Birth Day') . "</td>
		<td class='tableheader'>" . _('Active   ') . "</td>
		<td class='tableheader'>" . _('PayPeriod') . "</td>
	
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
		echo '<TD>' . $myrow[7] . '</TD>';
		echo '<TD>' . $myrow[8] . '</TD>';
		echo '<TD><A HREF="'. $rootpath . '/prlEmployeeMaster.php?' . SID . '&EmployeeID=' . $myrow[0] . '">' . _('Edit/Delete') . '</A></TD>';
		//echo '<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&EmployeeID=' . $myrow[0] . '&delete=1">' . _('Delete') .'</A></TD>';		
		echo '</TR>';

	} //END WHILE LIST LOOP

	//END WHILE LIST LOOP
} //END IF SELECTED ACCOUNT


echo '</CENTER></TABLE>';
//end of ifs and buts!

include ('includes/footer.inc.php');
?>