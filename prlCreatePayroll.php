<?php

/* $Revision: 1.0 $ */

$PageSecurity = 5;

include ('includes/session.inc.php');

$title = 'Payroll Records Maintenance';

include ('includes/header.inc.php');
include ('includes/prlFunctions.php');

if ( isset($_GET['PayrollID']) ){
	$PayrollID = $_GET['PayrollID'];
} elseif ( isset($_POST['PayrollID']) ){
	$PayrollID = $_POST['PayrollID'];
} else {
	unset($PayrollID);
}


if ( $_POST['Generate'] == 'Generate Payroll Data' )
{
		include ('includes/prlGenerateData.php');
		include ('includes/prlComputeBasic.php');
		include ('includes/prlComputeOthIncome.php');
		include ('includes/prlComputeTD.php');
		include ('includes/prlComputeOT.php');
		include ('includes/prlComputeGross.php');
		include ('includes/prlComputeLoan.php');
		include ('includes/prlComputeSSS.php');
		include ('includes/prlComputeHDMF.php');
		include ('includes/prlComputePH.php');
		include ('includes/prlComputeTAX.php');
		include ('includes/prlComputeNet.php');	
}


if ($_POST['Close'] == 'Close Payroll Period')
{
$Status = GetOpenCloseStr( GetPayrollRow( $PayrollID, $db, 11 ) );
if ( $Status == 'Closed' ) {
   exit( "Payroll is already closed. Re-open first..." );
} else {  
			$sql = "SELECT loantableid,amount
				FROM prlloandeduction
				WHERE payrollid='$PayrollID'";
				$LoanDetails = DB_query( $sql, $db );
				
				if( DB_num_rows($LoanDetails) > 0 )
				{
					while ($loanrow = DB_fetch_array($LoanDetails))
					{
						$LoanPayment=$loanrow['amount'];
						if ( $LoanPayment > 0 or $LoanPayment <> null ) {	   
							$sql = 'UPDATE prlloanfile SET ytddeduction=ytddeduction'.$LoanPayment.', loanbalance=loanbalance-'.$LoanPayment.'
							WHERE loantableid = ' . $loanrow['loantableid'];
							$PostLoanPay = DB_query( $sql, $db );					
						}
					}
				}	
 
		$sql = "UPDATE prlpayrollperiod SET
					payclosed=1
					 WHERE payrollid = '$PayrollID'";
					$ErrMsg = _('The payroll record could not be updated because');
					$DbgMsg = _('The SQL that was used to update the payroll failed was');
					$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);
					prnMsg('The payroll master record for' . ' ' . $PayrollID . ' ' . 'has been closed','success');
	exit("Payroll is succesfully closed...");
}
}

if ( $_POST['Purge'] == 'Purge Payroll Period' )
{
  exit("Not implemented at this moment...");
}

if ( $_POST['Reopen'] == 'Re-open Payroll Period' )
{
$Status = GetOpenCloseStr( GetPayrollRow( $PayrollID, $db, 11 ) );
if ( $Status == 'Open' ) {
   exit("Payroll is already open...");
} else {  
			$sql = "SELECT loantableid,amount
				FROM prlloandeduction
				WHERE payrollid='$PayrollID'";
				$LoanDetails = DB_query($sql,$db);			
				if( DB_num_rows($LoanDetails) > 0 )
				{
					while ($loanrow = DB_fetch_array($LoanDetails))
					{
						$LoanPayment=$loanrow['amount'];
						if ( $LoanPayment > 0 or $LoanPayment <> null ) {	   
							$sql = 'UPDATE prlloanfile SET ytddeduction = ytddeduction-'.$LoanPayment.', loanbalance=loanbalance+'.$LoanPayment.'
							WHERE loantableid = ' . $loanrow['loantableid'];
							$PostLoanPay = DB_query($sql,$db);					
						}
					}
				}	
 
		$sql = "UPDATE prlpayrollperiod SET
					payclosed = 0
					 WHERE payrollid = '$PayrollID'";
					$ErrMsg = _('The payroll record could not be updated because');
					$DbgMsg = _('The SQL that was used to update the payroll failed was');
					$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);
					prnMsg('The payroll master record for' . ' ' . $PayrollID . ' ' . 'has been opened','success');
	exit("Payroll is succesfully re-opened...");
}
}

if ( !isset($PayrollID) ) {
} else {
//PayrollID exists - either passed when calling the form or from the form itself
	echo "<FORM METHOD = 'post' action = '" . $_SERVER['PHP_SELF'] . '?' . SID ."'>";
	echo '<CENTER><TABLE>';
		if ( !isset($_POST['New']) ) {
				$sql = "SELECT payrollid,
					payrolldesc,
					payperiodid,				
					startdate,
					enddate,
					fsmonth,
					fsyear,
					deductsss,
					deducthdmf,
					deductphilhealth,
					payclosed
			FROM prlpayrollperiod
			WHERE payrollid = '$PayrollID'";
			$result = DB_query( $sql, $db );
			$myrow = DB_fetch_array($result);
		$Description = $myrow['payrolldesc'];
		$PayPeriodID = GetPayPeriodDesc( $myrow['payperiodid'], $db );	
		$StartDate = ConvertSQLDate( $myrow['startdate'] );
		$EndDate  = ConvertSQLDate( $myrow['enddate'] );
		$FSMonth = GetMonthStr( $myrow['fsmonth'] );
		$FSYear  = $myrow['fsyear'];	
		$SSS  = GetYesNoStr( $myrow['deductsss'] );
		$HDMF = GetYesNoStr( $myrow['deducthdmf'] );
		$PhilHealth  = GetYesNoStr( $myrow['deductphilhealth'] );
		$Status = GetOpenCloseStr( $myrow['payclosed'] );
		echo "<INPUT TYPE=HIDDEN NAME='PayrollID' VALUE='$PayrollID'>";
		} else {
		// its a new employee  being added
		echo "<INPUT TYPE=HIDDEN NAME='New' VALUE='Yes'>";
		echo '<TR><TD>' . _('Payroll ID') . ":</TD><TD><INPUT TYPE='text' NAME='PayrollID' VALUE='$PayrollID' SIZE=12 MAXLENGTH=10></TD></TR>";
		}
 		echo "<CENTER><TABLE WIDTH=30% BORDER=2><TR></TR>";		
		echo '<TR><TD WIDTH=100%>';
		echo '<CENTER><a href="' . $rootpath . '/prlEditPayroll.php?&PayrollID='.$PayrollID.'">' . _('Edit Payroll Period') . '</a>';
		echo '</TD><TD WIDTH=100%>';
    echo '</TD></TR></TABLE><BR></CENTER>';
		echo '<CENTER><FONT SIZE=1>' . _('') . "</FONT><INPUT TYPE=SUBMIT NAME='Close' VALUE='" . _('Close Payroll Period') . "'><INPUT TYPE=SUBMIT NAME='Purge' VALUE='" . _('Purge Payroll Period') . "'><HR>";
		echo '<FONT SIZE=1>' . _('') . "</FONT><INPUT TYPE=SUBMIT NAME='Generate' VALUE='" . _('Generate Payroll Data') . "'><INPUT TYPE=SUBMIT NAME='Reopen' VALUE='" . _('Re-open Payroll Period') . "'><HR>";
		

?>	

<table width="640" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="180" valign="top"> 
	
      <table width="90%" border="1" cellspacing="0" cellpadding="0" align="center" bordercolordark="#CCCCCC" bordercolorlight="#CCCCCC" bgcolor="#F2F2F2">
        <tr bgcolor="#F4F4F4"> 
          <td height="30" width="26%"> 
            <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Payroll ID
              :</font></div>
          </td>
          <td height="30" width="74%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1" color="#000066"><b><?php echo $PayrollID; ?></b></font></td>
        </tr>
        <tr bgcolor="#F4F4F4"> 
          <td height="30" width="26%"> 
            <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Description 
              :</font></div>
          </td>
          <td height="30" width="74%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1" color="#000066"><b><?php echo $Description; ?></b></font></td>
        </tr>
        <tr bgcolor="#F4F4F4"> 
          <td height="30" width="26%"> 
            <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Pay Period
              :</font></div>
          </td>
          <td height="30" width="74%"> 
            <p><font face="Verdana, Arial, Helvetica, sans-serif" size="-1" color="#000066"><b><?php echo $PayPeriodID; ?></b></font></p>
          </td>
        </tr>
        <tr bgcolor="#F4F4F4"> 
          <td height="30" width="26%"> 
            <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Start Date 
              :</font></div>
          </td>
          <td height="30" width="74%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1" color="#000066"><b><?php echo $StartDate; ?></a></b></font></td>
        </tr>
        <tr bgcolor="#F4F4F4"> 
          <td height="30" width="26%"> 
            <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">End Date 
              :</font></div>
          </td>
          <td height="30" width="74%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1" color="#000066"><b><?php echo $EndDate; ?></a></b></font></td>
        </tr>
        <tr bgcolor="#F4F4F4"> 
          <td height="30" width="26%"> 
            <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">FS Month 
              :</font></div>
          </td>
          <td height="30" width="74%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1" color="#000066"><b><?php echo "$FSMonth $FSYear"; ?></a></b></font></td>
        </tr>
        <tr bgcolor="#F4F4F4"> 
          <td height="30" width="26%"> 
            <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Deduct SSS 
              :</font></div>
          </td>
          <td height="30" width="74%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1" color="#000066"><b><?php echo $SSS; ?></a></b></font></td>
        </tr>
        <tr bgcolor="#F4F4F4"> 
          <td height="30" width="26%"> 
            <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Deduct HDMF 
              :</font></div>
          </td>
          <td height="30" width="74%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1" color="#000066"><b><?php echo $HDMF; ?></a></b></font></td>
        </tr>
        <tr bgcolor="#F4F4F4"> 
          <td height="30" width="26%"> 
            <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Deduct PhilHealth 
              :</font></div>
          </td>
          <td height="30" width="74%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1" color="#000066"><b><?php echo $PhilHealth; ?></a></b></font></td>
        </tr>
        <tr bgcolor="#F4F4F4"> 
          <td height="30" width="26%"> 
            <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Payroll Status
              :</font></div>
          </td>
          <td height="30" width="74%" bgcolor="#F4F4F4"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b><font color="#000066"><?php echo $Status; ?></font></b></font></td>
        </tr>
      </table>
	  
    </td>
  </tr>

</table>
<?php

}

include 'includes/footer.inc.php';

?>