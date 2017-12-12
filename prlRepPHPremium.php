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
	$pdf->addinfo('Title',_('PhilHealth Monthly Premium'));
	$pdf->addinfo('Subject',_('PhilHealth Monthly Premium'));

	$PageNumber = 0;
	$line_height = 12;

	if ($_POST['FSMonth'] == 0) {
		$title = 'PhilHealth Monthly Premuim Listing' . ' - ' . 'Problem Report';
	   include ('includes/header.inc.php');
	   prnMsg(_('Month not selected'),'error');
	   echo "<BR><A HREF='" .$rootpath ."/index.php?" . SID . "'>" . _('Back to the menu') . '</A>';
	   include ('includes/footer.inc.php');
	   exit;
	}
		if ($_POST['FSYear']==0) {
		$title = _('PhilHealth Monthly Premuim Listing') . ' - ' . _('Problem Report');
	   include ('includes/header.inc.php');
	   prnMsg(_('Year not selected'),'error');
	   echo "<BR><A HREF='" .$rootpath ."/index.php?" . SID . "'>" . _('Back to the menu') . '</A>';
	   include ('includes/footer.inc.php');
	   exit;
	}
	$PhilHealthMonth = $_POST['FSMonth'];
	$PhilHealthYear = $_POST['FSYear'];
	$PhilHealthMonthStr = GetMonthStr($PhilHealthMonth);
	$PageNumber = 0;
	$FontSize = 10;
	$line_height = 12;
			$FullName ='';
			$PhilHealthNumber ='';
			$PhilHealthER = 0;
			$PhilHealthEC = 0;
			$PhilHealthEE = 0;
			$PhilHealthTotal = 0;

	include ('includes/PDFPhilHealthPageHeader.inc.php');
	
	$sql = "SELECT employeeid,employerph,employeeph,total
			FROM prlempphfile
			WHERE prlempphfile.fsmonth='" . $PhilHealthMonth . "'
			AND prlempphfile.fsyear='" . $PhilHealthYear . "'";		
			$PhilHealthDetails = DB_query($sql,$db);
					if( DB_num_rows($PhilHealthDetails) > 0 )
					{
						//although it is assume that PhilHealth deduction once only every month but who knows 
						while ($phrow = DB_fetch_array($PhilHealthDetails)) {
							$EmpID = $phrow['employeeid'];
							$FullName = GetName($EmpID, $db);
							$PhilHealthNumber = GetEmpRow($EmpID, $db,21);
							$PhilHealthER = $phrow['employerph'];
							$PhilHealthEE = $phrow['employeeph'];
							$PhilHealthTotal = $phrow['total'];
							$GTPhilHealthER += $PhilHealthER;
							$GTPhilHealthEE += $PhilHealthEE;
							$GTPhilHealthTotal += $PhilHealthTotal;
							//$YPos -= (2 * $line_height);  //double spacing
							if ( $PhilHealthTotal > 0 ) {
								$FontSize = 8;
								$pdf->selectFont('./fonts/Helvetica.afm');
								$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,150,$FontSize,$FullName);
								$LeftOvers = $pdf->addTextWrap($Left_Margin+200,$YPos,50,$FontSize,$PhilHealthNumber,'right');
								$LeftOvers = $pdf->addTextWrap($Left_Margin+350,$YPos,50,$FontSize,number_format($PhilHealthER,2),'right');
								$LeftOvers = $pdf->addTextWrap($Left_Margin+410,$YPos,50,$FontSize,number_format($PhilHealthEE,2),'right');
								$LeftOvers = $pdf->addTextWrap($Left_Margin+460,$YPos,50,$FontSize,number_format($PhilHealthTotal,2),'right');
								$YPos -= $line_height;
								if ($YPos < ($Bottom_Margin)){		
									include ('includes/PDFPhilHealthPageHeader.inc.php');
								}
							}	
						}
					}
	$LeftOvers = $pdf->line($Page_Width-$Right_Margin, $YPos,$Left_Margin, $YPos);
	$YPos -= (2 * $line_height);
	$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,150,$FontSize,'Grand Total');
	$LeftOvers = $pdf->addTextWrap($Left_Margin+350,$YPos,50,$FontSize,number_format($GTPhilHealthER,2),'right');
	$LeftOvers = $pdf->addTextWrap($Left_Margin+410,$YPos,50,$FontSize,number_format($GTPhilHealthEE,2),'right');
	$LeftOvers = $pdf->addTextWrap($Left_Margin+460,$YPos,50,$FontSize,number_format($GTPhilHealthTotal,2),'right');
	$LeftOvers = $pdf->line($Page_Width-$Right_Margin, $YPos,$Left_Margin, $YPos);
	
	$buf = $pdf->output();
	$len = strlen($buf);

	header('Content-type: application/pdf');
	header("Content-Length: $len");
	header('Content-Disposition: inline; filename=PHListing.pdf');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');

	$pdf->stream();

} elseif (isset($_POST['ShowPR'])) {
		include ('includes/session.inc.php');
		$title = 'PhilHealth Monthly Premium Listing';
		include ('includes/header.inc.php');
	   echo 'Use PrintPDF instead';
	   echo "<BR><A HREF='" .$rootpath ."/index.php?" . SID . "'>" . _('Back to the menu') . '</A>';
	   include ('includes/footer.inc.php');
	   exit;
} else { /*The option to print PDF was not hit */

	include ('includes/session.inc.php');
	$title = 'PhilHealth Monthly Premium Listing';
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

	echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='ShowPR' VALUE='" . _('Show PhilHealth Premium') . "'>";
	echo "<P><CENTER><INPUT TYPE='Submit' NAME='PrintPDF' VALUE='" . _('PrintPDF') . "'>";

	include ('includes/footer.inc.php');;
} /*end of else not PrintPDF */

	
?>