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
	$Heading = _('Alphalist');
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
	$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,120,$FontSize,'Full Name');
	$LeftOvers = $pdf->addTextWrap(150,$YPos,70,$FontSize,'T I N','right');
	$LeftOvers = $pdf->addTextWrap(220,$YPos,70,$FontSize,'Tax Status','right');
	$LeftOvers = $pdf->addTextWrap(290,$YPos,70,$FontSize,'Gross Taxable Income','right');
	$LeftOvers = $pdf->addTextWrap(360,$YPos,70,$FontSize,'Total Exemption','right');
	$LeftOvers = $pdf->addTextWrap(430,$YPos,70,$FontSize,'Net Taxable Income','right');
	$LeftOvers = $pdf->addTextWrap(500,$YPos,70,$FontSize,'Income Tax','right');
	$LeftOvers = $pdf->addTextWrap(570,$YPos,70,$FontSize,'Tax Withhheld','right');			
	$LeftOvers = $pdf->addTextWrap(660,$YPos,80,$FontSize,'Payable(Refundable)','right');
	$LeftOvers = $pdf->line($Page_Width-$Right_Margin, $YPos,$Left_Margin, $YPos);
	$YPos -= (2 * $line_height);
	

?>