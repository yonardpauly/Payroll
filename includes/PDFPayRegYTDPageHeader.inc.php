<?php
	 
	$PageNumber++;
	if ($PageNumber>1){
		$pdf->newPage();
	}

	$FontSize =10;
	$pdf->selectFont('./fonts/Helvetica-Bold.afm');
	$YPos = $Page_Height - $Top_Margin;
	$YPos -= (4 * $line_height);
	$pdf->addText($Left_Margin,$YPos,$FontSize,$_SESSION['CompanyRecord']['coyname']);

	$YPos -= $line_height;
	$FontSize =10;
	$pdf->selectFont('./fonts/Helvetica-Bold.afm');
	$Heading = _('Year to Date Payroll Register');
	$pdf->addText($Left_Margin, $YPos, $FontSize, $Heading);
	$FontSize = 8;
	$pdf->selectFont('./fonts/Helvetica.afm');
	$pdf->addText($Page_Width-$Right_Margin-120,$YPos,$FontSize,
		_('Printed'). ': ' . Date($_SESSION['DefaultDateFormat'])
		. '   '. _('Page'). ' ' . $PageNumber);
	$YPos -= (1 * $line_height);	
	$Heading1 = _('For the Year : ') . $FSYear;
	$pdf->addText($Left_Margin,$YPos,$FontSize,$Heading1);

	$YPos -= (2 * $line_height);
	$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,50,$FontSize,'EmpID');
	$LeftOvers = $pdf->addTextWrap(100,$YPos,120,$FontSize,'Full Name');
	$LeftOvers = $pdf->addTextWrap(231,$YPos,40,$FontSize,'Basic Pay','right');
	$LeftOvers = $pdf->addTextWrap(282,$YPos,50,$FontSize,'Other Income','right');
	$LeftOvers = $pdf->addTextWrap(313,$YPos,50,$FontSize,'Lates','right');
	$LeftOvers = $pdf->addTextWrap(354,$YPos,50,$FontSize,'Absents','right');
	$LeftOvers = $pdf->addTextWrap(395,$YPos,50,$FontSize,'Ovetime','right');
	$LeftOvers = $pdf->addTextWrap(446,$YPos,50,$FontSize,'Gross Pay','right');
	$LeftOvers = $pdf->addTextWrap(487,$YPos,50,$FontSize,'SSS','right');			
	$LeftOvers = $pdf->addTextWrap(528,$YPos,50,$FontSize,'HDMF','right');
	$LeftOvers = $pdf->addTextWrap(569,$YPos,50,$FontSize,'PhilHealth','right');
	$LeftOvers = $pdf->addTextWrap(610,$YPos,70,$FontSize,'Loan Deduction','right');
	$LeftOvers = $pdf->addTextWrap(671,$YPos,40,$FontSize,'Tax','right');
	$LeftOvers = $pdf->addTextWrap(722,$YPos,50,$FontSize,'Net Pay','right');
	$LeftOvers = $pdf->line($Page_Width-$Right_Margin, $YPos,$Left_Margin, $YPos);
	$YPos -= (2 * $line_height);
	

?>