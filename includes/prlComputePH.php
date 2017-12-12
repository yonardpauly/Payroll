<?php
if (isset($_GET['PayrollID'])){
	$PayrollID = $_GET['PayrollID'];
} elseif (isset($_POST['PayrollID'])){
	$PayrollID = $_POST['PayrollID'];
} else {
	unset($PayrollID);
}
$FSMonthRow=GetPayrollRow($PayrollID, $db,5);
$FSYearRow=GetPayrollRow($PayrollID, $db,6);
$DeductPH = GetYesNoStr(GetPayrollRow($PayrollID, $db,9));
$Status = GetOpenCloseStr(GetPayrollRow($PayrollID, $db,11));
if ($Status=='Closed') {
   exit("Payroll is Closed. Re-open first...");
}
if (isset($_POST['submit'])) {
   exit("Contact Administrator...");
} else {
	$sql="DELETE FROM prlempphfile WHERE payrollid ='" . $PayrollID . "'";
	$Postdelph= DB_query($sql,$db);

	$sql = "UPDATE prlpayrolltrans SET	philhealth=0
				WHERE payrollid ='" . $PayrollID . "'";
	$RePostPH= DB_query($sql,$db);	
	
	if ($DeductPH=='Yes') {
		$sql = "SELECT counterindex,payrollid,employeeid,basicpay,absent,late,otpay,fsmonth,fsyear
				FROM prlpayrolltrans
				WHERE prlpayrolltrans.payrollid='" . $PayrollID . "'";
		$PayDetails = DB_query($sql,$db);
		if(DB_num_rows($PayDetails)>0)
		{
			while ($myrow = DB_fetch_array($PayDetails))
			{	
				$sql = "SELECT sum(grosspay) AS Gross
					FROM prlpayrolltrans
					WHERE prlpayrolltrans.employeeid='" . $myrow['employeeid'] . "'
					AND prlpayrolltrans.fsmonth='" . $FSMonthRow . "'
					AND prlpayrolltrans.fsyear='" . $FSYearRow . "'";
					$PHDetails = DB_query($sql,$db);
					if(DB_num_rows($PHDetails)>0)
					{	
						$phrow=DB_fetch_array($PHDetails);
						$PHGP=$phrow['Gross'];
						if ($PHGP>0 or $PHGP<>null) {
									 $myphrow = GetPHRow($PHGP, $db);
										$sql = "INSERT INTO prlempphfile (		
												payrollid,
												employeeid,
												grosspay,				
												rangefrom,
												rangeto,
												salarycredit,
												employerph,
												employerec,
												employeeph,
												total,
												fsmonth,
												fsyear)
												VALUES ('$PayrollID', 
													'" . $myrow['employeeid'] . "',
													'$PHGP',
													'". $myphrow['rangefrom'] ."',
													'". $myphrow['rangeto'] ."',
													'". $myphrow['salarycredit'] ."',
													'". $myphrow['employerph'] ."',
													'". $myphrow['employerec'] ."',
													'". $myphrow['employeeph'] ."',
													'". $myphrow['total'] ."',
													'" . $myrow['fsmonth'] . "',
													'" . $myrow['fsyear'] . "'
													)";
												$ErrMsg = _('Inserting PhilHealth File failed.');
												$InsPHRecords = DB_query($sql,$db,$ErrMsg);
						} //if sssgp>0
					} //dbnumross sssdetials>0	
			}  //end of while
		}  //dbnumrows paydetails > 0
	} //deduct sss=yes
	
	//posting to payroll trans for sss
	if ($DeductPH=='Yes') {
		$sql = "SELECT counterindex,payrollid,employeeid,basicpay,absent,late,otpay,fsmonth,fsyear
				FROM prlpayrolltrans
				WHERE prlpayrolltrans.payrollid='" . $PayrollID . "'";
		$PayDetails = DB_query($sql,$db);
		if(DB_num_rows($PayDetails)>0)
		{
			while ($myrow = DB_fetch_array($PayDetails))
			{	
			$sql = "SELECT employeeph
					FROM prlempphfile
			        WHERE prlempphfile.employeeid='" . $myrow['employeeid'] . "'
					AND prlempphfile.payrollid='" . $PayrollID . "'";		
					$PHDetails = DB_query($sql,$db);
					if(DB_num_rows($PHDetails)>0)
					{
					    $phrow=DB_fetch_array($PHDetails);
						$PHPayment=$phrow['employeeph'];
						$sql = 'UPDATE prlpayrolltrans SET philhealth='.$PHPayment.'
					     WHERE counterindex = ' . $myrow['counterindex'];
					    $PostPHPay = DB_query($sql,$db);
					}
			}
		}
	}
} //isset post submit
?>