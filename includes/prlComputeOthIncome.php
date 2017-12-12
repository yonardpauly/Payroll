<?php
if (isset($_GET['PayrollID'])){
	$PayrollID = $_GET['PayrollID'];
} elseif (isset($_POST['PayrollID'])){
	$PayrollID = $_POST['PayrollID'];
} else {
	unset($PayrollID);
}

if (isset($_POST['submit'])) {
   exit("Contact Administrator...");
} else {
   	$FromPeriod = GetPayrollRow($PayrollID, $db,3);
	$ToPeriod = GetPayrollRow($PayrollID, $db,4);
	$sql = "UPDATE prlpayrolltrans SET	othincome=0
				WHERE payrollid ='" . $PayrollID . "'";
	$RePostPT= DB_query($sql,$db);

	$sql = "SELECT counterindex,payrollid,employeeid,othincome
			FROM prlpayrolltrans
			WHERE prlpayrolltrans.payrollid='" . $PayrollID . "'";
	$PayDetails = DB_query($sql,$db);
	if(DB_num_rows($PayDetails)>0)
	{
		while ($myrow = DB_fetch_array($PayDetails))
		{	
			$sql = "SELECT sum(othincamount) AS OTHPay
					FROM prlothincfile
			        WHERE prlothincfile.employeeid='" . $myrow['employeeid'] . "'
					AND prlothincfile.othdate>='$FromPeriod'
					AND  prlothincfile.othdate<='$ToPeriod'
					ORDER BY OthDate";
					$OIDetails = DB_query($sql,$db);
					if(DB_num_rows($OIDetails)>0)
					{				
						$oirow=DB_fetch_array($OIDetails);
						$OTHPayment=$oirow['OTHPay'];
						if ($OTHPayment>0 or $OTPayment<>null) {
							$sql = 'UPDATE prlpayrolltrans SET othincome='.$OTHPayment.'
								WHERE counterindex = ' . $myrow['counterindex'];
						$PostOTPay = DB_query($sql,$db);
						}
					}	
		}	 
	}
}
?>