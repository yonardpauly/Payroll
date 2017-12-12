<?php

if (isset($_GET['PayrollID'])){
	$PayrollID = $_GET['PayrollID'];
} elseif (isset($_POST['PayrollID'])){
	$PayrollID = $_POST['PayrollID'];
} else {
	unset($PayrollID);
}
$FSMonthRow = GetPayrollRow($PayrollID, $db,5);
$FSYearRow = GetPayrollRow($PayrollID, $db,6);
$DeductHDMF = GetYesNoStr(GetPayrollRow($PayrollID, $db,8));
$Status = GetOpenCloseStr(GetPayrollRow($PayrollID, $db,11));
if ($Status == 'Closed') {
   exit("Payroll is Closed. Re-open first...");
}
if ( isset($_POST['submit']) ) {
   exit("Contact Administrator...");
} else {
	$sql="DELETE FROM prlemphdmffile WHERE payrollid ='" . $PayrollID . "'";
	$Postdelhdmf = DB_query($sql,$db);

	$sql = "UPDATE prlpayrolltrans SET	hdmf = 0
				WHERE payrollid ='" . $PayrollID . "'";
	$RePostHDMF = DB_query($sql,$db);	
	
	if ( $DeductHDMF=='Yes' ) {
		$sql = "SELECT counterindex,payrollid,employeeid,basicpay,absent,late,otpay,fsmonth,fsyear
				FROM prlpayrolltrans
				WHERE prlpayrolltrans.payrollid='" . $PayrollID . "'";
		$PayDetails = DB_query($sql,$db);
		if( DB_num_rows($PayDetails) > 0 )
		{
			while ( $myrow = DB_fetch_array($PayDetails) )
			{	
				$sql = "SELECT sum(grosspay) AS Gross
					FROM prlpayrolltrans
					WHERE prlpayrolltrans.employeeid='" . $myrow['employeeid'] . "'
					AND prlpayrolltrans.fsmonth='" . $FSMonthRow . "'
					AND prlpayrolltrans.fsyear='" . $FSYearRow . "'";
					$HDMFDetails = DB_query($sql,$db);
					if(DB_num_rows($HDMFDetails)>0)
					{	
						$hdmfrow = DB_fetch_array($HDMFDetails);
						$HDMFGP = $hdmfrow['Gross'];
						if ($HDMFGP > 0 or $HDMFGP <> null) {
							$HFMFER = GetHDMFER($HDMFGP, $db);
							$HFMFEE = GetHDMFEE($HDMFGP, $db);
							$HDMFTOT = $HFMFEE + $HFMFER;
										$sql = "INSERT INTO prlemphdmffile (		
												payrollid,
												employeeid,
												grosspay,				
												employerhdmf,
												employeehdmf,
												total,
												fsmonth,
												fsyear)
												VALUES ('$PayrollID', 
													'" . $myrow['employeeid'] . "',
													'$HDMFGP',
													'$HFMFER',
													'$HFMFEE',
													'$HDMFTOT',
													'" . $myrow['fsmonth'] . "',
													'" . $myrow['fsyear'] . "'
													)";
												$ErrMsg = _('Inserting HDMF File failed.');
												$InsSSSRecords = DB_query($sql,$db,$ErrMsg);
						} //if sssgp>0
					} //dbnumross sssdetials>0	
			}  //end of while
		}  //dbnumrows paydetails > 0
	} //deduct sss=yes
	
	//posting to payroll trans for hdmf
	if ( $DeductHDMF == 'Yes' ) {
		$sql = "SELECT counterindex,payrollid,employeeid,basicpay,absent,late,otpay,fsmonth,fsyear
				FROM prlpayrolltrans
				WHERE prlpayrolltrans.payrollid = '" . $PayrollID . "'";
		$PayDetails = DB_query( $sql, $db );
		if( DB_num_rows($PayDetails) > 0 )
		{
			while ( $myrow = DB_fetch_array($PayDetails) )
			{	
			$sql = "SELECT employeehdmf
					FROM prlemphdmffile
			        WHERE prlemphdmffile.employeeid='" . $myrow['employeeid'] . "'
					AND prlemphdmffile.payrollid='" . $PayrollID . "'";		
					$HDMFDetails = DB_query($sql,$db);
					if(DB_num_rows($HDMFDetails)>0)
					{
					    $hdmfrow=DB_fetch_array($HDMFDetails);
						$HDMFPayment=$hdmfrow['employeehdmf'];
						$sql = 'UPDATE prlpayrolltrans SET hdmf='.$HDMFPayment.'
					     WHERE counterindex = ' . $myrow['counterindex'];
					    $PostHDMFPay = DB_query($sql,$db);
					}
			}
		}
	}
} //isset post submit
?>