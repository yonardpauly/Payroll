<?php
/* $Revision: 1.0 $ */

$PageSecurity = 10;
include ('includes/session.inc.php');
$title = _('View Payroll Data');

include ('includes/header.inc.php');


	
if (isset($_GET['Counter'])){
	$Counter = $_GET['Counter'];
} elseif (isset($_POST['Counter'])){
	$Counter = $_POST['Counter'];
} else {
	unset($Counter);
}

	
/*
if (isset($_GET['delete'])) {
//the link to delete a selected record was clicked instead of the submit button

	$CancelDelete = 0;
	
	$sql = "SELECT payrollid
				FROM prlpayrollperiod
				WHERE prlpayrollperiod.payrollid='" . $PayrollID . "'
				AND prlpayrollperiod.payclosed='1'";
		$PayDetails = DB_query($sql,$db);
		if(DB_num_rows($PayDetails)>0)
		{
		  $CancelDelete = 1;
		  prnMsg('Payroll is closed. Can not delete this record...','success');
		}


// PREVENT DELETES IF DEPENDENT RECORDSs
	if ($CancelDelete == 0) {
		$sql="DELETE FROM prlpayrolltrans WHERE counterindex='$Counter'";
		$result = DB_query($sql, $db);
		prnMsg(_('Payroll record ') . ' ' . $Counter . ' ' . _('has been deleted'),'success');
		unset($Counter);
		unset($_SESSION['Counter']);
	} //end of Delete 
}
*/
	

if (!isset($Counter)) {
	echo "<FORM METHOD='post' ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "'>";
	echo "<INPUT TYPE='hidden' NAME='New' VALUE='Yes'>";
	echo '<CENTER><TABLE>';

	$sql = "SELECT  	payrollid,
						employeeid,
						periodrate,
						hourlyrate,
						basicpay,
						othincome,
						absent,
						late,
						otpay,
						grosspay,
						loandeduction,
						sss,
						hdmf,
						philhealth,
						tax,
						netpay,
						fsmonth,
						fsyear
		FROM prlpayrolltrans
		ORDER BY counterindex";
	$ErrMsg = _('Payroll record could not be retrieved because');
	$result = DB_query($sql,$db,$ErrMsg);

	echo '<CENTER><table border=1>';
	echo "<tr>
		<td class='tableheader'>" . _('Pay ID ') . "</td>
		<td class='tableheader'>" . _('Emp ID') . "</td>
		<td class='tableheader'>" . _('Period Rate') . "</td>
		<td class='tableheader'>" . _('Hourly Rate') . "</td>
		<td class='tableheader'>" . _('Basic Pay') . "</td>
		<td class='tableheader'>" . _('Other Income') . "</td>
		<td class='tableheader'>" . _('Absent') . "</td>
		<td class='tableheader'>" . _('Late') . "</td>
		<td class='tableheader'>" . _('Overtime Pay') . "</td>
		<td class='tableheader'>" . _('Gross Pay') . "</td>
		<td class='tableheader'>" . _('Loan Deduction') . "</td>
		<td class='tableheader'>" . _('SSS') . "</td>
		<td class='tableheader'>" . _('HDMF') . "</td>
		<td class='tableheader'>" . _('PhilHealth') . "</td>
		<td class='tableheader'>" . _('Tax') . "</td>
		<td class='tableheader'>" . _('Net Pay') . "</td>
		<td class='tableheader'>" . _('Month') . "</td>
		<td class='tableheader'>" . _('Year') . "</td>		
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
		echo '<TD>' . $myrow[5] . '</TD>';
		echo '<TD>' . $myrow[6] . '</TD>';
		echo '<TD>' . $myrow[7] . '</TD>';
		echo '<TD>' . $myrow[8] . '</TD>';
		echo '<TD>' . $myrow[9] . '</TD>';
		echo '<TD>' . $myrow[10] . '</TD>';
		echo '<TD>' . $myrow[11] . '</TD>';
		echo '<TD>' . $myrow[12] . '</TD>';
		echo '<TD>' . $myrow[13] . '</TD>';
		echo '<TD>' . $myrow[14] . '</TD>';
		echo '<TD>' . $myrow[15] . '</TD>';
		echo '<TD>' . $myrow[16] . '</TD>';
		echo '<TD>' . $myrow[17] . '</TD>';
		//echo '<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&Counter=' . $myrow[0] . '&delete=1">' . _('Delete') .'</A></TD>';
		echo '</TR>';

	} //END WHILE LIST LOOP

	//END WHILE LIST LOOP
} //END IF SELECTED ACCOUNT


echo '</CENTER></TABLE>';
//end of ifs and buts!

include ('includes/footer.inc.php');
?>