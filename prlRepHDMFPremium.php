<?php
/* $Revision: 1.0 $ */

$PageSecurity = 2;

if (isset($_POST['PrintPDF'])
	AND isset($_POST['FSMonth'])
	AND $_POST['FSMonth']>=0
	AND isset($_POST['FSYear'])
	AND $_POST['FSYear']>=0){

	include ('config.php');
	include ('includes/PDFStarter.php');
	include ('includes/ConnectDB.inc.php');
	include ('includes/DateFunctions.inc.php');
	include ('includes/prlFunctions.php');

	$FontSize=12;
	$pdf->addinfo('Title',_('HDMF Monthly Premium'));
	$pdf->addinfo('Subject',_('HDMF Monthly Premium'));

	$PageNumber=0;
	$line_height=12;

	if ($_POST['FSMonth']==0) {
		$title = _('HDMF Monthly Premuim Listing') . ' - ' . _('Problem Report');
	   include ('includes/header.inc.php');
	   prnMsg(_('Month not selected'),'error');
	   echo "<BR><A HREF='" .$rootpath ."/index.php?" . SID . "'>" . _('Back to the menu') . '</A>';
	   include ('includes/footer.inc.php');
	   exit;
	}
		if ($_POST['FSYear']==0) {
		$title = _('HDMF Monthly Premuim Listing') . ' - ' . _('Problem Report');
	   include ('includes/header.inc.php');
	   prnMsg(_('Year not selected'),'error');
	   echo "<BR><A HREF='" .$rootpath ."/index.php?" . SID . "'>" . _('Back to the menu') . '</A>';
	   include ('includes/footer.inc.php');
	   exit;
	}
	$HDMFMonth = $_POST['FSMonth'];
	$HDMFYear = $_POST['FSYear'];
	$HDMFMonthStr = GetMonthStr($HDMFMonth);
	$PageNumber = 0;
	$FontSize = 10;
	$line_height = 12;
			$FullName ='';
			$HDMFNumber ='';
			$HDMFER = 0;
			$HDMFEC = 0;
			$HDMFEE = 0;
			$HDMFTotal = 0;

	include ('includes/PDFHDMFPremiumPageHeader.inc.php');
	
	$sql = "SELECT employeeid,employerhdmf,employeehdmf,total
			FROM prlemphdmffile
			WHERE prlemphdmffile.fsmonth='" . $HDMFMonth . "'
			AND prlemphdmffile.fsyear='" . $HDMFYear . "'";		
			$HDMFDetails = DB_query($sql,$db);
					if( DB_num_rows($HDMFDetails) > 0 )
					{
						//although it is assume that hdmf deduction once only every month but who knows 
						while ($hdmfrow = DB_fetch_array($HDMFDetails)) {
							$EmpID = $hdmfrow['employeeid'];
							$FullName = GetName($EmpID, $db);
							$HDMFNumber = GetEmpRow($EmpID, $db,21);
							$HDMFER = $hdmfrow['employerhdmf'];
							$HDMFEE = $hdmfrow['employeehdmf'];
							$HDMFTotal = $hdmfrow['total'];
							$GTHDMFER += $HDMFER;
							$GTHDMFEE += $HDMFEE;
							$GTHDMFTotal += $HDMFTotal;
							//$YPos -= (2 * $line_height);  //double spacing
							if ($HDMFTotal>0) {
								$FontSize = 8;
								$pdf->selectFont('./fonts/Helvetica.afm');
								$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,150,$FontSize,$FullName);
								$LeftOvers = $pdf->addTextWrap($Left_Margin+200,$YPos,50,$FontSize,$HDMFNumber,'right');
								$LeftOvers = $pdf->addTextWrap($Left_Margin+350,$YPos,50,$FontSize,number_format($HDMFER,2),'right');
								$LeftOvers = $pdf->addTextWrap($Left_Margin+410,$YPos,50,$FontSize,number_format($HDMFEE,2),'right');
								$LeftOvers = $pdf->addTextWrap($Left_Margin+460,$YPos,50,$FontSize,number_format($HDMFTotal,2),'right');
								$YPos -= $line_height;
								if ($YPos < ($Bottom_Margin)){		
									include ('includes/PDFHDMFPremiumPageHeader.inc.php');
								}
							}	
						}
					}
	$LeftOvers = $pdf->line($Page_Width-$Right_Margin, $YPos,$Left_Margin, $YPos);
	$YPos -= (2 * $line_height);
	$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,150,$FontSize,'Grand Total');
	$LeftOvers = $pdf->addTextWrap($Left_Margin+350,$YPos,50,$FontSize,number_format($GTHDMFER,2),'right');
	$LeftOvers = $pdf->addTextWrap($Left_Margin+410,$YPos,50,$FontSize,number_format($GTHDMFEE,2),'right');
	$LeftOvers = $pdf->addTextWrap($Left_Margin+460,$YPos,50,$FontSize,number_format($GTHDMFTotal,2),'right');
	$LeftOvers = $pdf->line($Page_Width-$Right_Margin, $YPos,$Left_Margin, $YPos);
	
	$buf = $pdf->output();
	$len = strlen($buf);

	header('Content-type: application/pdf');
	header("Content-Length: $len");
	header('Content-Disposition: inline; filename=HDMFListing.pdf');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');

	$pdf->stream();

} elseif (isset($_POST['ShowPR'])) {
		include ('includes/session.inc.php');
		$title=_('HDMF Monthly Premium Listing');
		include ('includes/header.inc.php');
	   echo 'Use PrintPDF instead';
	   echo "<BR><A HREF='" .$rootpath ."/index.php?" . SID . "'>" . _('Back to the menu') . '</A>';
	   include ('includes/footer.inc.php');
	   exit;
} else { /*The option to print PDF was not hit */

	include ('includes/session.inc.php');
	$title=_('HDMF Monthly Premium Listing');
	include ('includes/header.inc.php');
	
	echo "<FORM METHOD='post' action='" . $_SERVER['PHP_SELF'] . '?' . SID ."'>";
	echo '<CENTER><TABLE>';
	echo '</SELECT></TD></TR>';
	echo '<TR><TD><align="centert"><b>' . _('FS Month') . ":<SELECT NAME='FSMonth'>";
	echo '<OPTION SELECTED VALUE=0>'. _('Select One');
	echo '<OPTION VALUE=1>' . _('January');
	echo '<OPTION VALUE=2>' . _('February');   
	echo '<OPTION VALUE=3>' . _('March');   
	echo '<OPTION VALUE=4>' . _('April');
	echo '<OPTION VALUE=5>' . _('May');
	echo '<OPTION VALUE=6>' . _('June');
	echo '<OPTION VALUE=7>' . _('July');
	echo '<OPTION VALUE=8>' . _('August');
	echo '<OPTION VALUE=9>' . _('September');
	echo '<OPTION VALUE=10>' . _('October');
	echo '<OPTION VALUE=11>' . _('November');
	echo '<OPTION VALUE=12>' . _('December');
	echo '</SELECT>';
	echo '<SELECT NAME="FSYear">';
			    echo '<OPTION SELECTED VALUE=0>'. _('Select One');
                    for ($yy=2006;$yy<=2015;$yy++)
                    {                     
                    	echo "<option value=$yy>$yy</option>\n";
                    }
	echo '</SELECT></TD></TR>';				

	echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='ShowPR' VALUE='" . _('Show HDMF Premium') . "'>";
	echo "<P><CENTER><INPUT TYPE='Submit' NAME='PrintPDF' VALUE='" . _('PrintPDF') . "'>";

	include ('includes/footer.inc.php');;
} /*end of else not PrintPDF */

	
?>