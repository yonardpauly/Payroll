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
   	$FromPeriod = GetPayrollRow( $PayrollID, $db, 3 );
	$ToPeriod = GetPayrollRow($PayrollID, $db,4);
	$sql = "UPDATE prlpayrolltrans SET	basicpay=0
				WHERE prlpayrolltrans.payrollid ='" . $PayrollID . "'";
	$RePostBPay= DB_query($sql,$db);	
	$sql = "UPDATE prldailytrans SET	regamt=0
				WHERE prldailytrans.payrollid ='" . $PayrollID . "'";
	$RePostRA= DB_query($sql,$db);
	
	$sql = "SELECT counterindex,payrollid,employeeid,periodrate,hourlyrate
			FROM prlpayrolltrans
			WHERE prlpayrolltrans.payrollid='" . $PayrollID . "'";
	$PayDetails = DB_query($sql,$db);
	if( DB_num_rows($PayDetails) > 0 )
	{
		while ($myrow = DB_fetch_array($PayDetails))
		{	
			$sql = "SELECT counterindex,payrollid,employeeid,reghrs,regamt
					FROM prldailytrans
			        WHERE prldailytrans.employeeid='" . $myrow['employeeid'] . "'
					AND rtdate>='$FromPeriod'
					AND  rtdate<='$ToPeriod'
					ORDER BY RTDate";
					$RTDetails = DB_query($sql,$db);
					if(DB_num_rows($RTDetails)>0)
					{				
						while ($rtrow = DB_fetch_array($RTDetails))
						{
							if (($rtrow['payrollid']==$PayrollID) or ($rtrow['payrollid']=='')){
									$PayType=GetPayTypeDesc(GetEmpRow($rtrow['employeeid'], $db,29));
									if ($PayType=='Hourly') {
										$HRRate=$myrow['hourlyrate'];
										$sql = 'UPDATE prldailytrans SET payrollid='.$PayrollID.', regamt=reghrs*'.$HRRate.'
											WHERE counterindex = ' . $rtrow['counterindex'];
										$PostBPay = DB_query($sql,$db);
									}									
							}	
						}
					}	
		}	 
	}
	
	$sql = "SELECT counterindex,payrollid,employeeid,periodrate
			FROM prlpayrolltrans
			WHERE prlpayrolltrans.payrollid='" . $PayrollID . "'";
	$PayDetails = DB_query($sql,$db);
	if(DB_num_rows($PayDetails)>0)
	{
		while ($myrow = DB_fetch_array($PayDetails))
		{	
			$PayType=GetPayTypeDesc(GetEmpRow($myrow['employeeid'], $db,29));
			if ($PayType=='Hourly') {
				$sql = "SELECT sum(regamt) AS BasicPay
					FROM prldailytrans
					WHERE prldailytrans.employeeid='" . $myrow['employeeid'] . "'
					AND payrollid='" . $myrow['payrollid'] . "'
					ORDER BY RTDate";
					$RTDetails = DB_query($sql,$db);
					if(DB_num_rows($RTDetails)>0)
					{
						$bprow=DB_fetch_array($RTDetails);
						$RTPayment=$bprow['BasicPay'];
						if ($RTPayment>0) {
							$sql = 'UPDATE prlpayrolltrans SET basicpay='.$RTPayment.'
								WHERE counterindex = ' . $myrow['counterindex'];
							$PostRTPay = DB_query($sql,$db);
						}
					}
			} elseif ($PayType=='Salary')	{
							$RTPayment=$myrow['periodrate'];
							$sql = 'UPDATE prlpayrolltrans SET basicpay='.$RTPayment.'
								WHERE counterindex = ' . $myrow['counterindex'];
							$PostRTPay = DB_query($sql,$db);
			}
		}
	}	
}
?>