<?php

/* $Revision: 1.21 $ */

	echo '<BR><BR>';
	echo '</TD>';
	echo '</TR>';
	echo '</TABLE>';

	echo '</TD>';
/*Do the borders */
	echo '<TD BGCOLOR="#555555" COLSPAN="3"></TD></TR>';
	echo '<TR BGCOLOR="#555555"><TD  COLSPAN="3"></TD></TR>';
	echo '<TR BGCOLOR="#555555"><TD COLSPAN="5"><FONT SIZE="1">&nbsp;</FONT></TD></TR>';
	
	echo '</TABLE>';
	
	if ($DefaultClock==12) {
		$hour=date('g:i a');
	} else {
		$hour=date('H:i');
	}
	
	echo '<FONT SIZE=2>' .ucfirst(strftime('%A ') . date($_SESSION['DefaultDateFormat'] . ' | g:i A')) . '</FONT>';
	
	echo '<TABLE ALIGN="center" ID="footer">';
	
	echo '<TR>';
	echo '<TD ALIGN="center">';
	echo '<A HREF="http://( http://sourceforge.net/projects/openpayroll/" TARGET="_blank"><IMG SRC="'. $PathPrefix . $rootpath.'/css/flag.gif" BORDER="0" ALT="" TITLE="AOPS ' . _('Copyright') . ' &copy; Anahaw Computer System - 2006"></A>';
	echo '<BR>' . _('Version') . ' - ' . $Version; //config.php
	echo '</TD></TR>';

	echo '<TR><TD ALIGN="center" CLASS="footer">AOPA ' . _('Copyright') . ' &copy; Anahaw Computer System - 2006</TD></TR>';
	
//	echo '<TR><TD ALIGN="center"><a href="http://sourceforge.net"><img src="http://sflogo.sourceforge.net/sflogo.php?group_id=70949&amp;type=1" width="88" height="31" border="0" alt="SourceForge.net Logo" /></a></TD></TR>';

	echo '</TABLE>';
	
	echo '</BODY>';
	echo '</HTML>';

?>