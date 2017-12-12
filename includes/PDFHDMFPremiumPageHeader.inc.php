<?php
	$PageNumber++;
	if ($PageNumber>1){
		$pdf->newPage();
	}

	$FontSize =10;
	$pdf->selectFont('./fonts/Helvetica-Bold.afm');
	$YPos = $Page_Height - $Top_Margin;
	$pdf->addText($Left_Margin,$YPos,$FontSize,$_SESSION['CompanyRecord']['coyname']);

	$YPos -= $line_height;
	$FontSize =10;
	$pdf->selectFont('./fonts/Helvetica-Bold.afm');
	$Heading = _('HDMF Monthly Remittance for All Employees');
	$pdf->addText($Left_Margin, $YPos, $FontSize, $Heading);
	$FontSize = 8;
	$pdf->selectFont('./fonts/Helvetica.afm');
	$pdf->addText($Page_Width-$Right_Margin-120,$YPos,$FontSize,
		_('Printed'). ': ' . Date($_SESSION['DefaultDateFormat'])
		. '   '. _('Page'). ' ' . $PageNumber);
	$YPos -= (1 * $line_height);	
	$Heading1 = _('For the month of ') . $HDMFMonthStr .', ' .$HDMFYear;
	$pdf->addText($Left_Margin,$YPos,$FontSize,$Heading1);

	$YPos -= (2 * $line_height);
	$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,150,$FontSize,'Full Name');
	$LeftOvers = $pdf->addTextWrap($Left_Margin+200,$YPos,50,$FontSize,'HDMF Number','right');
	$LeftOvers = $pdf->addTextWrap($Left_Margin+350,$YPos,50,$FontSize,'Employer','right');
	$LeftOvers = $pdf->addTextWrap($Left_Margin+410,$YPos,50,$FontSize,'Employee','right');			
	$LeftOvers = $pdf->addTextWrap($Left_Margin+460,$YPos,50,$FontSize,'Total','right');
	$LeftOvers = $pdf->line($Page_Width-$Right_Margin, $YPos,$Left_Margin, $YPos);
	$YPos -= (2 * $line_height);
	

?>