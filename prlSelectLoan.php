<?php
/* $Revision: 1.0 $ */

$PageSecurity = 10;
include ('includes/session.inc.php');
$title = _('Employee Loan Maintenance');

include ('includes/header.inc.php');



    echo "<CENTER><TABLE WIDTH=30% BORDER=2><TR></TR>";		
	echo '<TR><TD WIDTH=100%>';
    echo '<CENTER><a href="' . $rootpath . '/prlLoanFile.php?SelectedAccountr=' . $_SESSION[''] . '">' . _('Add Employee Loan Records') . '</a><BR>';
	echo '</TD><TD WIDTH=100%>';
    echo '</TD></TR></TABLE><BR></CENTER>';

if ( isset($_GET['LoanFileId']) )
	$LoanFileId = $_GET['LoanFileId'];
elseif (isset($_POST['LoanFileId']))
	$LoanFileId = $_POST['LoanFileId'];
	
	
	
if (isset($_GET['delete']))
 {
				$sql="DELETE FROM prlloanfile WHERE loanfileid ".LIKE."'" . DB_escape_string($SelectedLoanFileId) . "'";
				$result = DB_query($sql,$db);
				prnMsg( 'employee id has been deleted' . '!','success');
	unset ($LoanFileId);
	unset ($_GET['LoanFileId']);
	unset($_GET['delete']);
	unset ($_POST['LoanFileId']);
 }	

if (!isset($LoanFileId)) {
/* It could still be the second time the page has been run and a record has been selected for modification - SelectedAccount will exist because it was sent with the new call. If its the first time the page has been displayed with no parameters
then none of the above are true and the list of ChartMaster will be displayed with
links to delete or edit each. These will call the same page again and allow update/input
or deletion of the records*/

	$sql = "SELECT loanfileid,
			loanfiledesc,
			employeeid,
			loantableid,
			loanamount,
			amortization
		FROM prlloanfile
		ORDER BY loanfileid";
	$ErrMsg = _('The employee master could not be retrieved because');
	$result = DB_query($sql,$db,$ErrMsg);

	echo '<CENTER><table border=1>';
	echo "<tr>
		<td class='tableheader'>" . _('Loan ID') . "</td>
		<td class='tableheader'>" . _('Loan Description ') . "</td>
		<td class='tableheader'>" . _('Employee ID') . "</td>
		<td class='tableheader'>" . _('Loan Type') . "</td>
		<td class='tableheader'>" . _('Amount') . "</td>
		<td class='tableheader'>" . _('Amortization') . "</td>
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
		echo '<TD><A HREF="'. $rootpath . '/prlLoanFile.php?' . SID . '&LoanFileId=' . $myrow[0] . '">' . _('Edit/Delete') . '</A></TD>';
		echo '</TR>';

	} //END WHILE LIST LOOP

	//END WHILE LIST LOOP
} //END IF SELECTED ACCOUNT


echo '</CENTER></TABLE>';
//end of ifs and buts!

include ('includes/footer.inc.php');
?>