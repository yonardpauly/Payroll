<?php
$PageSecurity = 2;

if (isset($_POST['PrintPDF'])
	AND isset($_POST['FSYear'])) {
	
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
	$pdf->addinfo('Title', _('YTD Payroll Register') );
	$pdf->addinfo('Subject', _('YTD Payroll Register') );


	$PageNumber=1;
	$line_height=12;
	
	$PageNumber = 0;
	$FontSize = 10;
	$pdf->addinfo('Title', _('YTD Payroll Register') );
	$pdf->addinfo('Subject', _('YTD Payroll Register') );
	$line_height = 12;
	include ('includes/PDFPayRegYTDPageHeader.inc.php');
	//list of all employees
	$sql = "SELECT employeeid
			FROM prlemployeemaster 
			WHERE prlemployeemaster.employeeid<>''"; 
	$EmpListResult = DB_query($sql,$db,_('Could not test to see that all detail records properly initiated'));
	if( DB_num_rows($EmpListResult) > 0 )
	{
		while ( $emprow = DB_fetch_array($EmpListResult) ) {
				$k = 0; //row colour counter
					$sql = "SELECT sum(basicpay) AS Basic,sum(othincome) AS OthInc,sum(absent) as Absent,
					          sum(late) AS Late,sum(otpay) AS OT,sum(grosspay) AS GrossPay,
							  sum(loandeduction) AS LoanDed,sum(sss) AS SSS,sum(hdmf) AS HDMF,sum(philhealth) AS PH,
							  sum(tax) AS Tax,sum(netpay) AS NetPay
					FROM prlpayrolltrans
					WHERE prlpayrolltrans.employeeid='" . $emprow['employeeid'] . "'
					AND prlpayrolltrans.fsyear='" . $FSYear . "'";
				$PayResult = DB_query($sql,$db);
				if( DB_num_rows($PayResult) > 0 )
				{
				      $myrow=DB_fetch_array($PayResult);
						$EmpID =$emprow['employeeid'];
						$FullName=GetName($EmpID, $db);
						$Basic =$myrow['Basic'];
						$OthInc = $myrow['OthInc'];
						$Late = $myrow['Late'];
						$Absent = $myrow['Absent'];
						$OT =$myrow['OT'];
						$Gross =$myrow['GrossPay'];
						$SSS =$myrow['SSS'];
						$HDMF =$myrow['HDMF'];
						$PH = $myrow['PH'];
						$LoanDed =$myrow['LoanDed'];
						$Tax = $myrow['Tax'];
						$NetPay =$myrow['NetPay'];					
						
						$GTBasic +=$myrow['Basic'];
						$GTOthInc += $myrow['OthInc'];
						$GTLate += $myrow['Late'];
						$GTAbsent += $myrow['Absent'];
						$GTOT +=$myrow['OT'];
						$GTGross +=$myrow['GrossPay'];
						$GTSSS +=$myrow['SSS'];
						$GTHDMF +=$myrow['HDMF'];
						$GTPhilHealth += $myrow['PH'];
						$GTLoan +=$myrow['LoanDed'];
						$GTTax += $myrow['Tax'];
						$GTNet +=$myrow['NetPay'];
			
						//$YPos -= (2 * $line_height);  //double spacing
						$FontSize = 8;
						$pdf->selectFont('./fonts/Helvetica.afm');
						$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,50,$FontSize,$EmpID);
						$LeftOvers = $pdf->addTextWrap(100,$YPos,120,$FontSize,$FullName,'left');
						$LeftOvers = $pdf->addTextWrap(221,$YPos,50,$FontSize,number_format($Basic,2),'right');
						$LeftOvers = $pdf->addTextWrap(272,$YPos,50,$FontSize,number_format($OthInc,2),'right');
						$LeftOvers = $pdf->addTextWrap(313,$YPos,50,$FontSize,number_format($Late,2),'right');
						$LeftOvers = $pdf->addTextWrap(354,$YPos,50,$FontSize,number_format($Absent,2),'right');		
						$LeftOvers = $pdf->addTextWrap(395,$YPos,50,$FontSize,number_format($OT,2),'right');
						$LeftOvers = $pdf->addTextWrap(446,$YPos,50,$FontSize,number_format($GrossPay,2),'right');
						$LeftOvers = $pdf->addTextWrap(487,$YPos,50,$FontSize,number_format($SSS,2),'right');
						$LeftOvers = $pdf->addTextWrap(528,$YPos,50,$FontSize,number_format($HDMF,2),'right');
						$LeftOvers = $pdf->addTextWrap(569,$YPos,50,$FontSize,number_format($PH,2),'right');
						$LeftOvers = $pdf->addTextWrap(610,$YPos,50,$FontSize,number_format($LoanDed,2),'right');
						$LeftOvers = $pdf->addTextWrap(671,$YPos,50,$FontSize,number_format($Tax,2),'right');
						$LeftOvers = $pdf->addTextWrap(722,$YPos,50,$FontSize,number_format($NetPay,2),'right');
						$YPos -= $line_height;
						if ( $YPos < ($Bottom_Margin) ){		
							include ('includes/PDFPayRegYTDPageHeader.inc.php');
						}
				}
		}		
	}	
	
			$LeftOvers = $pdf->line($Page_Width-$Right_Margin, $YPos,$Left_Margin, $YPos);
			$YPos -= (2 * $line_height);
			$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,150,$FontSize,'Grand Total');
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
		$title = _('YTD Payroll Register Error');
		include ('includes/header.inc.php');
		echo '<p>';
		prnMsg( _('There were no entries to print out for the selections specified') );
		echo '<BR><A HREF="'. $rootpath.'/index.php?' . SID . '">'. _('Back to the menu'). '</A>';
		include ('includes/footer.inc.php');
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=YTDPayrollReg.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		$pdf->Stream();

	}
	exit;

} elseif (isset($_POST['ShowPR'])) {
		include ('includes/session.inc.php');
		$title=_('PhilHealth Monthly Premium Listing');
		include ('includes/header.inc.php');
	   echo 'Use PrintPDF instead';
	   echo "<BR><A HREF='" .$rootpath ."/index.php?" . SID . "'>" . _('Back to the menu') . '</A>';
	   include ('includes/footer.inc.php');
	   exit;
} else { /*The option to print PDF was not hit */
	include ('includes/session.inc.php');
	$title = 'YTD Payroll Register';
	include ('includes/header.inc.php');
	
	echo "<FORM METHOD='post' action='" . $_SERVER['PHP_SELF'] . '?' . SID ."'>";
	echo '<CENTER><TABLE>';
	echo '</SELECT></TD></TR>';
	echo '<TR><TD><align="centert"><b>' . _('FS Year') . ":<SELECT NAME='FSYear'>";
			    echo '<OPTION SELECTED VALUE=0>'. _('Select One');
                    for ($yy=2006;$yy<=2015;$yy++)
                    {                     
                    	echo "<option value=$yy>$yy</option>\n";
                    }
	echo '</SELECT></TD></TR>';				

	echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='ShowPR' VALUE='" . _('Show YTD Payroll Register') . "'>";
	echo "<P><CENTER><INPUT TYPE='Submit' NAME='PrintPDF' VALUE='" . _('PrintPDF') . "'>";

	include ('includes/footer.inc.php');;

} /*end of else not PrintPDF */

?>