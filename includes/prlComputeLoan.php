<?php
if (isset($_GET['PayrollID'])){
	$PayrollID = $_GET['PayrollID'];
} elseif (isset($_POST['PayrollID'])){
	$PayrollID = $_POST['PayrollID'];
} else {
	unset($PayrollID);
}

$Status = GetOpenCloseStr(GetPayrollRow($PayrollID, $db,11));
if ($Status == 'Closed') {
   exit( "Payroll is Closed. Re-open first..." );
}
if (isset($_POST['submit'])) {
   exit( "Contact Administrator..." );
} else {
   	$FromPeriod = GetPayrollRow($PayrollID, $db,3);
	$ToPeriod = GetPayrollRow($PayrollID, $db,4);
    //delete any previous posting for the same payrollid
	$sql="DELETE FROM prlloandeduction WHERE payrollid ='" . $PayrollID . "'";
	$Postdelloan= DB_query($sql,$db);
	
	$sql = "UPDATE prlpayrolltrans SET	loandeduction=0
				WHERE payrollid ='" . $PayrollID . "'";
	$Postrloan= DB_query($sql,$db);

	$sql = "SELECT counterindex,payrollid,employeeid,loandeduction
			FROM prlpayrolltrans
			WHERE prlpayrolltrans.payrollid='" . $PayrollID . "'";
	$PayDetails = DB_query($sql,$db);
	if(DB_num_rows($PayDetails)>0)
	{
		while ($myrow = DB_fetch_array($PayDetails))
		{	
			$sql = "SELECT loanfileid,loantableid,employeeid,amortization,startdeduction,loanbalance
					FROM prlloanfile
			        WHERE prlloanfile.employeeid='" . $myrow['employeeid'] . "'
					AND startdeduction<='$ToPeriod'
					ORDER BY LoanDate";
					$LoanDetails = DB_query($sql,$db);
					if(DB_num_rows($LoanDetails)>0)
					{
						while ($loanrow = DB_fetch_array($LoanDetails))
						{		
							if ($loanrow['loanbalance']>0) {
								if ($loanrow['loanbalance']<=$loanrow['amortization']) {
									$sql = "INSERT INTO prlloandeduction(employeeid,loantableid,amount)
										SELECT employeeid,loantableid,loanbalance
										FROM prlloanfile
										WHERE prlloanfile.loanfileid='" . $loanrow['loanfileid'] . "'"; 
									$ErrMsg = _('Inserting Loan File failed.');
									$InsLoanRecords = DB_query($sql,$db,$ErrMsg);								
								} else {
									$sql = "INSERT INTO prlloandeduction(employeeid,loantableid,amount)
										SELECT employeeid,loantableid,amortization
										FROM prlloanfile
										WHERE prlloanfile.loanfileid='" . $loanrow['loanfileid'] . "'"; 
									$ErrMsg = _('Inserting Loan File failed.');
									$InsLoanRecords = DB_query($sql,$db,$ErrMsg);
								}
							}
						}
					}
		}
							$sql = "UPDATE prlloandeduction SET
									payrollid='" . $PayrollID . "'
									WHERE payrollid = ''";
									$PostPrd = DB_query($sql,$db);
		
	} else	{
			//exit("No Loan Deduction..");
	}
	

	$sql = "SELECT counterindex,payrollid,employeeid,loandeduction
			FROM prlpayrolltrans
			WHERE prlpayrolltrans.payrollid='" . $PayrollID . "'";
	$PayDetails = DB_query($sql,$db);
	if(DB_num_rows($PayDetails)>0)
	{
		while ($myrow = DB_fetch_array($PayDetails))
		{
			$sql = "SELECT sum(amount) AS loanded
				FROM prlloandeduction
				WHERE prlloandeduction.employeeid='" . $myrow['employeeid'] . "'
				AND payrollid='" . $myrow['payrollid'] . "'";
				$LoanDetails = DB_query($sql,$db);
				if(DB_num_rows($LoanDetails)>0)
				{
				//$otrow=DB_fetch_array($OTDetails);
				   //$OTPayment=$otrow['otpay'];
					//$sql = 'UPDATE prlpayrolltrans SET otpay='.$OTPayment.'
					//			WHERE counterindex = ' . $myrow['counterindex'];
					//$PostOTPay = DB_query($sql,$db);					
					
				   $loanrow=DB_fetch_array($LoanDetails);
				   $LoanPayment=$loanrow['loanded'];
				   if ($LoanPayment>0 or $LoanPayment<>null) {
					$sql = 'UPDATE prlpayrolltrans SET loandeduction='.$LoanPayment.'
					     WHERE counterindex = ' . $myrow['counterindex'];
					$PostLoanPay = DB_query($sql,$db);					
					}
				}	
		}	 
	} else	{
		//echo "No Loan Deduction..";
	}
	
}
?>