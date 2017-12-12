<?php
$PageSecurity = 2;

if (isset($_POST['PrintPDF'])
	AND isset($_POST['PayrollID'])) {
	
	include ('config.php');
	include ('includes/PDFStarter.php');
	include ('includes/ConnectDB.inc.php');
	include ('includes/DateFunctions.inc.php');
	include ('includes/prlFunctions.php');

	/* A4_Landscape */

	$Page_Width=842;
	$Page_Height=595;
	$Top_Margin=20;
	$Bottom_Margin=20;
	$Left_Margin=25;
	$Right_Margin=22;

	$PageSize = array(0,0,$Page_Width,$Page_Height);
	$pdf = new Cpdf($PageSize);

	$PageNumber = 0;

	$pdf->selectFont('./fonts/Helvetica.afm');

/* Standard PDF file creation header stuff */
	$pdf->addinfo('Title', _('Payroll Register') );
	$pdf->addinfo('Subject', _('Payroll Register') );


	$PageNumber=1;
	$line_height=12;
	
	$PayDesc = GetPayrollRow($_POST['PayrollID'], $db,1);
   	$FromPeriod = GetPayrollRow($_POST['PayrollID'], $db,3);
	$ToPeriod = GetPayrollRow($_POST['PayrollID'], $db,4);
	$PageNumber = 0;
	$FontSize = 10;
	$pdf->addinfo('Title', _('Payroll Register') );
	$pdf->addinfo('Subject', _('Payroll Register') );
	$line_height = 12;
		    $EmpID ='';
			$Basic = 0;
			$OthInc = 0;
			$Lates = 0;
			$Absent = 0;
			$OT = 0;
			$Gross = 0;
			$SSS = 0;
			$HDMF ='';
			$PhilHealt = 0;
			$Loan = 0;
			$Tax = 0;
			$Net = 0;
	include ('includes/PDFPayRegisterPageHeader.inc.php');
	$k=0; //row colour counter
	$sql = "SELECT employeeid,basicpay,othincome,absent,late,otpay,grosspay,loandeduction,sss,hdmf,philhealth,tax,netpay
			FROM prlpayrolltrans
			WHERE prlpayrolltrans.payrollid='" .$_POST['PayrollID']. "'";
	$PayResult = DB_query($sql,$db);
	if(DB_num_rows($PayResult)>0)
	{
		while ($myrow=DB_fetch_array($PayResult)) {
		    $EmpID =$myrow['employeeid'];
			$FullName=GetName($EmpID, $db);
			$Basic =$myrow['basicpay'];
			$OthInc = $myrow['othincome'];
			$OT =$myrow['otpay'];
			$Gross =$myrow['grosspay'];
			$SSS =$myrow['sss'];
			$HDMF =$myrow['hdmf'];
			$PhilHealth = $myrow['philhealth'];
			$Loan =$myrow['loandeduction'];
			$Tax = $myrow['tax'];
			$Net =$myrow['netpay'];

			$GTBasic +=$myrow['basicpay'];
			$GTOthInc += $myrow['othincome'];
			$GTOT +=$myrow['otpay'];
			$GTGross +=$myrow['grosspay'];
			$GTSSS +=$myrow['sss'];
			$GTHDMF +=$myrow['hdmf'];
			$GTPhilHealth += $myrow['philhealth'];
			$GTLoan +=$myrow['loandeduction'];
			$GTTax += $myrow['tax'];
			$GTNet +=$myrow['netpay'];
			
			//$YPos -= (2 * $line_height);  //double spacing
			$FontSize = 8;
			$pdf->selectFont('./fonts/Helvetica.afm');
			$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,50,$FontSize,$EmpID);
			$LeftOvers = $pdf->addTextWrap(100,$YPos,120,$FontSize,$FullName,'left');
			$LeftOvers = $pdf->addTextWrap(221,$YPos,50,$FontSize,number_format($Basic,2),'right');
			$LeftOvers = $pdf->addTextWrap(272,$YPos,50,$FontSize,number_format($OthInc,2),'right');
			$LeftOvers = $pdf->addTextWrap(313,$YPos,50,$FontSize,number_format($Lates,2),'right');
			$LeftOvers = $pdf->addTextWrap(354,$YPos,50,$FontSize,number_format($Absent,2),'right');		
			$LeftOvers = $pdf->addTextWrap(395,$YPos,50,$FontSize,number_format($OT,2),'right');
			$LeftOvers = $pdf->addTextWrap(446,$YPos,50,$FontSize,number_format($Gross,2),'right');
			$LeftOvers = $pdf->addTextWrap(487,$YPos,50,$FontSize,number_format($SSS,2),'right');
			$LeftOvers = $pdf->addTextWrap(528,$YPos,50,$FontSize,number_format($HDMF,2),'right');
			$LeftOvers = $pdf->addTextWrap(569,$YPos,50,$FontSize,number_format($PhilHealth,2),'right');
			$LeftOvers = $pdf->addTextWrap(610,$YPos,50,$FontSize,number_format($Loan,2),'right');
			$LeftOvers = $pdf->addTextWrap(671,$YPos,50,$FontSize,number_format($Tax,2),'right');
			$LeftOvers = $pdf->addTextWrap(722,$YPos,50,$FontSize,number_format($Net,2),'right');
			$YPos -= $line_height;
			if ($YPos < ($Bottom_Margin)){		
				include ('includes/PDFPayRegisterPageHeader.inc.php');
			}
		}
		
	}//end of loop
	
			$LeftOvers = $pdf->line($Page_Width-$Right_Margin, $YPos,$Left_Margin, $YPos);
			$YPos -= (2 * $line_height);
			$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,150,$FontSize,'Grand Total');
			$LeftOvers = $pdf->addTextWrap(221,$YPos,50,$FontSize,number_format($GTBasic,2),'right');
			$LeftOvers = $pdf->addTextWrap(221,$YPos,50,$FontSize,number_format($GTBasic,2),'right');
			$LeftOvers = $pdf->addTextWrap(272,$YPos,50,$FontSize,number_format($GTOthInc,2),'right');
			$LeftOvers = $pdf->addTextWrap(313,$YPos,50,$FontSize,number_format($GTLates,2),'right');
			$LeftOvers = $pdf->addTextWrap(354,$YPos,50,$FontSize,number_format($GTAbsent,2),'right');		
			$LeftOvers = $pdf->addTextWrap(395,$YPos,50,$FontSize,number_format($GTOT,2),'right');
			$LeftOvers = $pdf->addTextWrap(446,$YPos,50,$FontSize,number_format($GTGross,2),'right');
			$LeftOvers = $pdf->addTextWrap(487,$YPos,50,$FontSize,number_format($GTSSS,2),'right');
			$LeftOvers = $pdf->addTextWrap(528,$YPos,50,$FontSize,number_format($GTHDMF,2),'right');
			$LeftOvers = $pdf->addTextWrap(569,$YPos,50,$FontSize,number_format($GTPhilHealth,2),'right');
			$LeftOvers = $pdf->addTextWrap(610,$YPos,50,$FontSize,number_format($GTLoan,2),'right');
			$LeftOvers = $pdf->addTextWrap(671,$YPos,50,$FontSize,number_format($GTTax,2),'right');
			$LeftOvers = $pdf->addTextWrap(722,$YPos,50,$FontSize,number_format($GTNet,2),'right');
						
			$LeftOvers = $pdf->line($Page_Width-$Right_Margin, $YPos,$Left_Margin, $YPos);

	
	$pdfcode = $pdf->output();
	$len = strlen($pdfcode);
	if ($len<=20){
		$title = _('Payroll Register Error');
		include ('includes/header.inc.php');
		echo '<p>';
		prnMsg( _('There were no entries to print out for the selections specified') );
		echo '<BR><A HREF="'. $rootpath.'/index.php?' . SID . '">'. _('Back to the menu'). '</A>';
		include ('includes/footer.inc.php');
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=PayrollRegister.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		$pdf->Stream();

	}
	exit;

} elseif (isset($_POST['ShowPR'])) {
		include ('includes/session.inc.php');
		$title=_('PhilHealth Monthly Premium Listing');
		include('includes/header.inc.php');
	   echo 'Use PrintPDF instead';
	   echo "<BR><A HREF='" .$rootpath ."/index.php?" . SID . "'>" . _('Back to the menu') . '</A>';
	   include ('includes/footer.inc.php');
	   exit;
} else { /*The option to print PDF was not hit */

	include ('includes/session.inc.php');
	$title=_('Payroll Register');
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
	echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='ShowPR' VALUE='" . _('Show Payroll Register') . "'>";
	echo "<P><CENTER><INPUT TYPE='Submit' NAME='PrintPDF' VALUE='" . _('PrintPDF') . "'>";

	include ('includes/footer.inc.php');;
} /*end of else not PrintPDF */

?>