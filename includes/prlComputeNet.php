<?php
if (isset($_GET['PayrollID'])){
	$PayrollID = $_GET['PayrollID'];
} elseif (isset($_POST['PayrollID'])){
	$PayrollID = $_POST['PayrollID'];
} else {
	unset($PayrollID);
}

$Status = GetOpenCloseStr(GetPayrollRow($PayrollID, $db,11));
if ($Status=='Closed') {
   exit("Payroll is Closed. Re-open first...");
}
if (isset($_POST['submit'])) {
   exit("Contact Administrator...");
} else {
	$sql = "UPDATE prlpayrolltrans SET	netpay=0
				WHERE payrollid ='" . $PayrollID . "'";
	$RePostNPay= DB_query($sql,$db);	
	
	$sql = "SELECT counterindex,payrollid,employeeid,grosspay,loandeduction,sss,hdmf,philhealth,tax
			FROM prlpayrolltrans
			WHERE prlpayrolltrans.payrollid='" . $PayrollID . "'";
	$PayDetails = DB_query($sql,$db);
	if(DB_num_rows($PayDetails)>0)
	{
		while ($myrow = DB_fetch_array($PayDetails))
		{	
				$NetPay=$myrow['grosspay']-$myrow['loandeduction']-$myrow['sss']-$myrow['hdmf']-$myrow['philhealth']-$myrow['tax'];
				$sql = 'UPDATE prlpayrolltrans SET netpay='.$NetPay.'
						WHERE counterindex = ' . $myrow['counterindex'];
				$PostNPay = DB_query($sql,$db);
		}	 
	}
echo "Finished processing payroll...";
}
?>