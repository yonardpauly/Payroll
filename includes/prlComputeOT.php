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
	$sql = "UPDATE prlottrans SET	otamount=0
				WHERE payrollid ='" . $PayrollID . "'";
	$RePostOT= DB_query($sql,$db);
	$sql = "UPDATE prlpayrolltrans SET	otpay=0
				WHERE payrollid ='" . $PayrollID . "'";
	$RePostPT= DB_query($sql,$db);

	$sql = "SELECT counterindex,payrollid,employeeid,hourlyrate,otpay
			FROM prlpayrolltrans
			WHERE prlpayrolltrans.payrollid='" . $PayrollID . "'";
	$PayDetails = DB_query($sql,$db);
	if(DB_num_rows($PayDetails)>0)
	{
		while ($myrow = DB_fetch_array($PayDetails))
		{	
			$sql = "SELECT counterindex,overtimeid,employeeid,payrollid,othours,otamount 
					FROM prlottrans
			        WHERE prlottrans.employeeid='" . $myrow['employeeid'] . "'
					AND otdate>='$FromPeriod'
					AND  otdate<='$ToPeriod'
					ORDER BY OTDate";
					$OTDetails = DB_query($sql,$db);
					if(DB_num_rows($OTDetails)>0)
					{				
						while ($otrow = DB_fetch_array($OTDetails))
						{
							if (($otrow['payrollid']==$PayrollID) or ($otrow['payrollid']=='')){

								$sql = "SELECT overtimerate
								FROM prlovertimetable 
								WHERE overtimeid='" . $otrow['overtimeid'] . "'";
								$OTRateResult = DB_query($sql,$db);
								if(DB_num_rows($OTRateResult)>0)
								{
									$otraterow = DB_fetch_array($OTRateResult);								
									$OTRate=$otraterow['overtimerate']*$myrow['hourlyrate'];
									$sql = 'UPDATE prlottrans SET payrollid='.$PayrollID.', otamount=othours*'.$OTRate.'
									WHERE counterindex = ' . $otrow['counterindex'];
									$PostOT = DB_query($sql,$db);
								}
							}	
						}
					}	
		}	 
	}
	
	
	$sql = "SELECT counterindex,payrollid,employeeid,otpay
			FROM prlpayrolltrans
			WHERE prlpayrolltrans.payrollid='" . $PayrollID . "'";			
	$PayDetails = DB_query($sql,$db);	
	if(DB_num_rows($PayDetails)>0)
	{

		while ($myrow = DB_fetch_array($PayDetails))
		{	
			$sql = "SELECT sum(otamount) AS otpay
				FROM prlottrans
				WHERE prlottrans.employeeid='" . $myrow['employeeid'] . "'
				AND payrollid='" . $myrow['payrollid'] . "'
				ORDER BY OTDate";
				$OTDetails = DB_query($sql,$db);

				if(DB_num_rows($OTDetails)>0)
				{	
				   $otrow=DB_fetch_array($OTDetails);
				   $OTPayment=$otrow['otpay'];
				   if ($OTPayment>0 or $OTPayment<>null) {
						$sql = 'UPDATE prlpayrolltrans SET otpay='.$OTPayment.'
								WHERE counterindex = ' . $myrow['counterindex'];
						$PostOTPay = DB_query($sql,$db);
					}
				}	
		}	 
	}
	
}
?>