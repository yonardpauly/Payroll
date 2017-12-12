<?php
/* $Revision: 1.0 $ */

$PageSecurity = 2;

if (isset($_POST['PrintPDF'])
	AND isset($_POST['PayrollID'])) {

	include ('config.php');
	include ('includes/PDFStarter.php');
	include ('includes/ConnectDB.inc.php');
	include ('includes/DateFunctions.inc.php');
	include ('includes/prlFunctions.php');

	$FontSize=12;
	$pdf->addinfo('Title',_('Over the Counter'));
	$pdf->addinfo('Subject',_('Over the Counter'));

	$PageNumber=0;
	$line_height=12;
	
	$PayDesc = GetPayrollRow($_POST['PayrollID'], $db,1);
   	$FromPeriod = GetPayrollRow($_POST['PayrollID'], $db,3);
	$ToPeriod = GetPayrollRow($_POST['PayrollID'], $db,4);

	$FontSize = 10;
	$line_height = 12;
			$FullName ='';
			$ATM='';
			$PayAmount = 0;
	$PayAmountTotal = 0;
	include ('includes/PDFCashPageHeader.inc.php');
	
	$sql = "SELECT employeeid,netpay
			FROM prlpayrolltrans
			WHERE prlpayrolltrans.payrollid='" .$_POST['PayrollID']. "'";
	$PayResult = DB_query($sql,$db);
	if( DB_num_rows($PayResult) > 0 )
	{
		while ($myrow = DB_fetch_array($PayResult)) {
		    $EmpID =$myrow['employeeid'];
			$FullName=GetName($EmpID, $db);
			$ATM=GetEmpRow($EmpID, $db,19);
			$PayAmount =$myrow['netpay'];
				if (($PayAmount>0) and ($ATM=='')) {
					$PayAmountTotal += $PayAmount;
					$FontSize = 8;
					$pdf->selectFont('./fonts/Helvetica.afm');
										$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,150,$FontSize,$FullName);
										$LeftOvers = $pdf->addTextWrap($Left_Margin+410,$YPos,50,$FontSize,number_format($PayAmount,2),'right');
										$YPos -= $line_height;
										if ($YPos < ($Bottom_Margin)){		
											include('includes/PDFCashPageHeader.inc.php');
										}
				}
		}
	}	
	$LeftOvers = $pdf->line($Page_Width-$Right_Margin, $YPos,$Left_Margin, $YPos);
	$YPos -= (2 * $line_height);
	$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,150,$FontSize,'Grand Total');
	$LeftOvers = $pdf->addTextWrap($Left_Margin+410,$YPos,50,$FontSize,number_format($PayAmountTotal,2),'right');
	$LeftOvers = $pdf->line($Page_Width-$Right_Margin, $YPos,$Left_Margin, $YPos);
	
	$buf = $pdf->output();
	$len = strlen($buf);

	header('Content-type: application/pdf');
	header("Content-Length: $len");
	header('Content-Disposition: inline; filename=CashListing.pdf');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');

	$pdf->stream();

} elseif (isset($_POST['ShowPR'])) {
		include ('includes/session.inc.php');
		$title=_('Bank Transmittal Listing');
		include ('includes/header.inc.php');
	   echo 'Use PrintPDF instead';
	   echo "<BR><A HREF='" .$rootpath ."/index.php?" . SID . "'>" . _('Back to the menu') . '</A>';
	   include ('includes/footer.inc.php');
	   exit;
} else { /*The option to print PDF was not hit */

	include ('includes/session.inc.php');
	$title=_('Over the Counter Listing');
	include ('includes/header.inc.php');
	
			echo '<FORM METHOD="POST" ACTION="' . $_SERVER['PHP_SELF'] . '?' . SID . '">';
		echo '<CENTER><TABLE><TR><TD>' . _('Select Payroll:') . '</TD><TD><SELECT Name="PayrollID">';
		DB_data_seek($result, 0);
		$sql = 'SELECT payrollid, payrolldesc FROM prlpayrollperiod';
		$result = DB_query($sql, $db);
		while ($myrow = DB_fetch_array($result)) {
			if ($myrow['payrollid'] == $_POST['PayrollID']) {  
				echo '<OPTION SELECTED VALUE=';
			} else {
				echo '<OPTION VALUE=';
			}
			echo $myrow['payrollid'] . '>' . $myrow['payrolldesc'];
		} //end while loop
	echo '</SELECT></TD></TR>';
	echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='ShowPR' VALUE='" . _('Show Over the Counter Listing') . "'>";
	echo "<P><CENTER><INPUT TYPE='Submit' NAME='PrintPDF' VALUE='" . _('PrintPDF') . "'>";

	include ('includes/footer.inc.php');;
} /*end of else not PrintPDF */

	
?>