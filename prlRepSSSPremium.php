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

	$FontSize = 12;
	$pdf->addinfo('Title',_('SSS Monthly Premium'));
	$pdf->addinfo('Subject',_('SSS Monthly Premium'));

	$PageNumber = 0;
	$line_height = 12;

	if ( $_POST['FSMonth'] == 0 ) {
		$title = _('SSS Monthly Premuim Listing') . ' - ' . _('Problem Report');
	   include ('includes/header.inc.php');
	   prnMsg(_('Month not selected'),'error');
	   echo "<BR><A HREF='" .$rootpath ."/index.php?" . SID . "'>" . _('Back to the menu') . '</A>';
	   include ('includes/footer.inc.php');
	   exit;
	}
		if ($_POST['FSYear']==0) {
		$title = _('SSS Monthly Premuim Listing') . ' - ' . _('Problem Report');
	   include ('includes/header.inc.php');
	   prnMsg(_('Year not selected'),'error');
	   echo "<BR><A HREF='" .$rootpath ."/index.php?" . SID . "'>" . _('Back to the menu') . '</A>';
	   include ('includes/footer.inc.php');
	   exit;
	}
	$SSSMonth = $_POST['FSMonth'];
	$SSSYear = $_POST['FSYear'];
	$SSSMonthStr = GetMonthStr($SSSMonth);
	$PageNumber = 0;
	$FontSize = 10;
	$line_height = 12;
			$FullName ='';
			$SSSNumber ='';
			$SSSER = 0;
			$SSSEC = 0;
			$SSSEE = 0;
			$SSSTotal = 0;

	include ('includes/PDFSSSPremiumPageHeader.inc.php');
	
	$sql = "SELECT employeeid,employerss,employerec,employeess,total
			FROM prlempsssfile
			WHERE prlempsssfile.fsmonth='" . $SSSMonth . "'
			AND prlempsssfile.fsyear='" . $SSSYear . "'";		
			$SSSDetails = DB_query($sql,$db);
					if( DB_num_rows($SSSDetails) > 0 )
					{
						//although it is assume that sss deduction once only every month but who knows 
						while ($sssrow = DB_fetch_array($SSSDetails)) {
							$EmpID =$sssrow['employeeid'];
							$FullName = GetName($EmpID, $db);
							$SSSNumber = GetEmpRow($EmpID, $db,20);
						    $SSSER = $sssrow['employerss'];
							$SSSER = $sssrow['employerss'];
							$SSSEC = $sssrow['employerec'];
							$SSSEE = $sssrow['employeess'];
							$SSSTotal = $sssrow['total'];
							$GTSSSER += $SSSER;
							$GTSSSEC += $SSSEC;
							$GTSSSEE += $SSSEE;
							$GTSSSTotal += $SSSTotal;
							//$YPos -= (2 * $line_height);  //double spacing
							if ( $SSSTotal > 0 ) {
								$FontSize = 8;
								$pdf->selectFont('./fonts/Helvetica.afm');
								$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,150,$FontSize,$FullName);
								$LeftOvers = $pdf->addTextWrap($Left_Margin+200,$YPos,50,$FontSize,$SSSNumber,'right');
								$LeftOvers = $pdf->addTextWrap($Left_Margin+290,$YPos,50,$FontSize,number_format($SSSER,2),'right');
								$LeftOvers = $pdf->addTextWrap($Left_Margin+350,$YPos,50,$FontSize,number_format($SSSEC,2),'right');
								$LeftOvers = $pdf->addTextWrap($Left_Margin+410,$YPos,50,$FontSize,number_format($SSSEE,2),'right');
								$LeftOvers = $pdf->addTextWrap($Left_Margin+460,$YPos,50,$FontSize,number_format($SSSTotal,2),'right');
								$YPos -= $line_height;
								if ($YPos < ($Bottom_Margin)){		
									include('includes/PDFSSSPremiumPageHeader.inc.php');
								}
							}	
						}
					}
	$LeftOvers = $pdf->line($Page_Width-$Right_Margin, $YPos,$Left_Margin, $YPos);
	$YPos -= (2 * $line_height);
	$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,150,$FontSize,'Grand Total');
	$LeftOvers = $pdf->addTextWrap($Left_Margin+290,$YPos,50,$FontSize,number_format($GTSSSER,2),'right');
	$LeftOvers = $pdf->addTextWrap($Left_Margin+350,$YPos,50,$FontSize,number_format($GTSSSEC,2),'right');
	$LeftOvers = $pdf->addTextWrap($Left_Margin+410,$YPos,50,$FontSize,number_format($GTSSSEE,2),'right');
	$LeftOvers = $pdf->addTextWrap($Left_Margin+460,$YPos,50,$FontSize,number_format($GTSSSTotal,2),'right');
	$LeftOvers = $pdf->line($Page_Width-$Right_Margin, $YPos,$Left_Margin, $YPos);
	
	$buf = $pdf->output();
	$len = strlen($buf);

	header('Content-type: application/pdf');
	header("Content-Length: $len");
	header('Content-Disposition: inline; filename=SSSListing.pdf');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');

	$pdf->stream();

} elseif (isset($_POST['ShowPR'])) {
		include ('includes/session.inc.php');
		$title=_('SSS Monthly Premium Listing');
		include ('includes/header.inc.php');
	   echo 'Use PrintPDF instead';
	   echo "<BR><A HREF='" .$rootpath ."/index.php?" . SID . "'>" . _('Back to the menu') . '</A>';
	   include ('includes/footer.inc.php');
	   exit;
} else { /*The option to print PDF was not hit */

	include ('includes/session.inc.php');
	$title=_('SSS Monthly Premium Listing');
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

	echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='ShowPR' VALUE='" . _('Show SSS Premium') . "'>";
	echo "<P><CENTER><INPUT TYPE='Submit' NAME='PrintPDF' VALUE='" . _('PrintPDF') . "'>";

	include ('includes/footer.inc.php');;
} /*end of else not PrintPDF */

	
?>