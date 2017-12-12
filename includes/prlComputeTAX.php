<?php
if (isset($_GET['PayrollID'])){
	$PayrollID = $_GET['PayrollID'];
} elseif (isset($_POST['PayrollID'])){
	$PayrollID = $_POST['PayrollID'];
} else {
	unset($PayrollID);
}
$sql="DELETE FROM prlemptaxfile WHERE payrollid ='" . $PayrollID . "'";
$Postdeltax= DB_query($sql,$db);

$sql = "UPDATE prlpayrolltrans SET	tax=0
		WHERE payrollid ='" . $PayrollID . "'";
$RePostTAX= DB_query($sql,$db);	

$FSMonthRow=GetPayrollRow($PayrollID, $db,5);
$FSYearRow=GetPayrollRow($PayrollID, $db,6);
$FSPPID=GetPayrollRow($PayrollID, $db,2);
$NumberofPayday=GetPayPeriodRow(GetPayrollRow($PayrollID, $db,2),$db,2);

if (isset($_POST['submit'])) {
   exit("Contact Administrator...");
} else {
	//to determent number of payday this month
	if ($NumberofPayday>=12) {  //payroll for monthly to daily based on frequency of payday
		$sql = "SELECT payrollid
			FROM prlpayrollperiod
			WHERE prlpayrollperiod.payperiodid='" . $FSPPID . "'
			AND prlpayrollperiod.payclosed='1'
			AND prlpayrollperiod.fsmonth='" . $FSMonthRow . "'
			AND prlpayrollperiod.fsyear='" . $FSYearRow . "'";
		$PayPeriodRows = DB_query($sql,$db);
		$NumPaydaythisMos=DB_num_rows($PayPeriodRows)+1;  //closed payroll + current payroll
		$NumPaydayPerMos=$NumberofPayday/12;
		$UnPaidPDthisMos=$NumPaydayPerMos-$NumPaydaythisMos;
		$UnPaidPDthisYR=$UnPaidPDthisMos+((12-$FSMonthRow)*$NumPaydayPerMos);

		//list of employesse
   		$sql = "SELECT counterindex,payrollid,employeeid,othincome,grosspay,sss,hdmf,philhealth,fsmonth,fsyear
				FROM prlpayrolltrans
				WHERE prlpayrolltrans.payrollid='" . $PayrollID . "'";
		$PayDetails = DB_query($sql,$db);
		if(DB_num_rows($PayDetails)>0)
		{
			while ($myrow = DB_fetch_array($PayDetails))
			{
				$Ctaxable=$myrow['grosspay']-$myrow['sss']-$myrow['hdmf']-$myrow['philhealth'];
				if ($myrow['othincome']>0) {
							$sql = "SELECT othincid,othincamount
								FROM prlothincfile
								WHERE prlothincfile.employeeid='" . $myrow['employeeid'] . "'
								AND prlothincfile.othdate>='$FromPeriod'
								AND  prlothincfile.othdate<='$ToPeriod'
								ORDER BY OthDate";
								$OIDetails = DB_query($sql,$db);
								if(DB_num_rows($OIDetails)>0)
								{				
									while ($othrow = DB_fetch_array($OIDetails))
									{
										$OIIDDesc= GetOthIncRow($othrow['othincid'], $db,1);
										if ($OIIDDesc=='Non-Tax') {
											$Ctaxable-=$othro['othincamount'];
										}
									}
								}
				}
				
				$EstGrosstoEarn=$Ctaxable*$UnPaidPDthisYR;
				//grosspay and tax withheld for every employee
				$sql = "SELECT sum(taxableincome) AS Gross,sum(tax) AS Tax
					FROM prlemptaxfile
					WHERE prlemptaxfile.employeeid='" . $myrow['employeeid'] . "'
					AND prlemptaxfile.fsyear='" . $FSYearRow . "'";
					$GrossDetails = DB_query($sql,$db);
					if(DB_num_rows($GrossDetails)>0)
					{	
						$gprow=DB_fetch_array($GrossDetails);
						$GrossUpToDate=$gprow['Gross'];
						
						$TaxUpToDate=$gprow['Tax'];
					}
					//computer tax
					$MyEstGrossIncome=$GrossUpToDate+$EstGrosstoEarn+$Ctaxable;
					$MyExemption=GetTaxStatusRow(GetEmpRow($myrow['employeeid'],$db,35),$db,4);
					$MyEstTaxableIncome=$MyEstGrossIncome-$MyExemption;
					$MyEstTax=GetMyTax($MyEstTaxableIncome, $db);
							if ($UnPaidPDthisYR==0) {
								$MyTaxWithheld=$MyEstTax-$TaxUpToDate;
							} else {
								$MyTaxWithheld=($MyEstTax-$TaxUpToDate)/($UnPaidPDthisYR+1);	
							}							
								$sql = 'UPDATE prlpayrolltrans SET tax='.$MyTaxWithheld.'
									WHERE counterindex = ' . $myrow['counterindex'];
								$PostTaxPay = DB_query($sql,$db);
					if ($Ctaxable>0) {
						$sql = "INSERT INTO prlemptaxfile (		
								payrollid,
								employeeid,
								taxableincome,				
								tax,
								fsmonth,
								fsyear)
								VALUES ('$PayrollID', 
										'" . $myrow['employeeid'] . "',
										'$Ctaxable',
										'$MyTaxWithheld',
										'" . $myrow['fsmonth'] . "',
										'" . $myrow['fsyear'] . "'
										)";
										$ErrMsg = _('Inserting Tax File failed.');
										$InsTaxRecords = DB_query($sql,$db,$ErrMsg);
					} //end of if ($Ctaxable>0)
			}//end ofwhile ($myrow = DB_fetch_array($PayDetails)) list of employess
		}								
	} elseif ($NumberofPayday<12) {
		//tax quarterly, bi-annual,yearly
		$sql = "SELECT payrollid
			FROM prlpayrollperiod
				AND prlpayrollperiod.fsyear='" . $FSYearRow . "'";
		$PayPeriodRows = DB_query($sql,$db);
		$NumPaydaythisYR=DB_num_rows($PayPeriodRows);
	    $UnPaidPDthisYR=$NumberofPayday-$NumPaydaythisYR;
		
		//list of employesse
   		$sql = "SELECT counterindex,payrollid,employeeid,othincome,grosspay,sss,hdmf,fsmonth,fsyear
				FROM prlpayrolltrans
				WHERE prlpayrolltrans.payrollid='" . $PayrollID . "'";
		$PayDetails = DB_query($sql,$db);
		if(DB_num_rows($PayDetails)>0)
		{
			while ($myrow = DB_fetch_array($PayDetails))
			{
				$Ctaxable=$myrow['grosspay']-$myrow['sss']-$myrow['hdmf'];
				if ($myrow['othincome']>0) {
							$sql = "SELECT othincid,othincamount
								FROM prlothincfile
								WHERE prlothincfile.employeeid='" . $myrow['employeeid'] . "'
								AND prlothincfile.othdate>='$FromPeriod'
								AND  prlothincfile.othdate<='$ToPeriod'
								ORDER BY OthDate";
								$OIDetails = DB_query($sql,$db);
								if(DB_num_rows($OIDetails)>0)
								{				
									while ($othrow = DB_fetch_array($OIDetails))
									{
										$OIIDDesc= GetOthIncRow($othrow['othincid'], $db,1);
										if ($OIIDDesc=='Non-Tax') {
											$Ctaxable-=$othro['othincamount'];
										}
									}
								}
				}
				
				$EstGrosstoEarn=$Ctaxable*$UnPaidPDthisYR;
				//grosspay and tax withheld for every employee
				$sql = "SELECT sum(taxableincome) AS Gross,sum(tax) AS Tax
					FROM prlemptaxfile
					WHERE prlemptaxfile.employeeid='" . $myrow['employeeid'] . "'
					AND prlemptaxfile.fsyear='" . $FSYearRow . "'";
					$GrossDetails = DB_query($sql,$db);
					if(DB_num_rows($GrossDetails)>0)
					{	
						$gprow=DB_fetch_array($GrossDetails);
						$GrossUpToDate=$gprow['Gross'];
						
						$TaxUpToDate=$gprow['Tax'];
					}
					//computer tax
					$MyEstGrossIncome=$GrossUpToDate+$EstGrosstoEarn;
					$MyExemption=GetTaxStatusRow(GetEmpRow($myrow['employeeid'],$db,35),$db,4);
					$MyEstTaxableIncome=$MyEstGrossIncome-$MyExemption;
					$MyEstTax=GetMyTax($MyEstTaxableIncome, $db);
							if ($UnPaidPDthisYR==0) {
								$MyTaxWithheld=$MyEstTax-$TaxUpToDate;
							} else {
								$MyTaxWithheld=($MyEstTax-$TaxUpToDate)/($UnPaidPDthisYR+1);	
							}							
								$sql = 'UPDATE prlpayrolltrans SET tax='.$MyTaxWithheld.'
									WHERE counterindex = ' . $myrow['counterindex'];
								$PostTaxPay = DB_query($sql,$db);
					if ($Ctaxable>0) {
						$sql = "INSERT INTO prlemptaxfile (		
								payrollid,
								employeeid,
								taxableincome,				
								tax,
								fsmonth,
								fsyear)
								VALUES ('$PayrollID', 
										'" . $myrow['employeeid'] . "',
										'$Ctaxable',
										'$MyTaxWithheld',
										'" . $myrow['fsmonth'] . "',
										'" . $myrow['fsyear'] . "'
										)";
										$ErrMsg = _('Inserting Tax File failed.');
										$InsTaxRecords = DB_query($sql,$db,$ErrMsg);
					} //end of if ($Ctaxable>0)
			
			}//end ofwhile ($myrow = DB_fetch_array($PayDetails)) list of employess
		}								
	};
} //isset post submit
?>