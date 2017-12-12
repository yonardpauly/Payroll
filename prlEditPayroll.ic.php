<?php

/* $Revision: 1.0 $ */

$PageSecurity = 5;

include ('includes/session.inc');

$title = 'Payroll Records Maintenance';

include ('includes/header.inc');
include ('includes/prlFunctions.php');

if (isset($_GET['PayrollID'])){
	$PayrollID = $_GET['PayrollID'];
} elseif (isset($_POST['PayrollID'])){
	$PayrollID = $_POST['PayrollID'];
} else {
	unset($PayrollID);
}


if (isset($_POST['submit'])) {
	//initialise no input errors assumed initially before we test
	$InputError = 0;
		// Checking if Employee ID is set
       if ($PayrollID=="")
       {
           $InputError=1;	
  	       prnMsg('Payroll ID must not be empty.','error');
       }
	   if ($_POST['PayPeriodID']=="")
       {
           $InputError=1;	
		   prnMsg('PayPeriod ID must not be empty.' ,'error');
       }
	if (!is_date($_POST['StartDate'])) {
		$InputError = 1;
		prnMsg('The field must be a date in the format' . ' ' . $_SESSION['DefaultDateFormat'],'error');
	} 
	if (!is_date($_POST['EndDate'])) {
		$InputError = 1;
		prnMsg('The field must be a date in the format' . ' ' . $_SESSION['DefaultDateFormat'], 'error');
	} 
	if ($_POST['submit']!=_('Update Payroll Period')) {
       if (($_POST[FSMonth]=="") or ($_POST[FSYear] == ""))
       {
             echo "<ul><li>FS Month is a Mandatory Field.</li></ul>";
             $InputError=1;	
       }
	}
 
	if ($InputError != 1){

	    $SQL_StartDate = FormatDateForSQL($_POST['StartDate']);
		$SQL_EndDate = FormatDateForSQL($_POST['EndDate']);
		
		if (!isset($_POST['New'])) {
			$sql = "UPDATE prlpayrollperiod SET
					payrolldesc='" . DB_escape_string($db, $_POST['Description']) ."',
					payperiodid='" . DB_escape_string($db, $_POST['PayPeriodID']) ."',
					startdate='" . $SQL_StartDate . "',
					enddate='" . $SQL_EndDate . "',
					fsmonth='" . $_POST['FSMonth'] . "',	
					fsyear='" . $_POST['FSYear'] . "',							
					deductsss='" . DB_escape_string($db, $_POST['SSS']) . "',
					deducthdmf='" . DB_escape_string($db, $_POST['HDMF']) . "',
					deductphilhealth='" . DB_escape_string($db, $_POST['PhilHealth']) . "'
					 WHERE payrollid = '$PayrollID'";
					$ErrMsg = _('The payroll record could not be updated because');
					$DbgMsg = _('The SQL that was used to update the payroll failed was');
					$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);
					prnMsg(_('The payroll master record for') . ' ' . $PayrollID . ' ' . _('has been updated'),'success');
				
		} else { //its a new payroll
				$sql = "INSERT INTO prlpayrollperiod (		
					payrollid,
					payrolldesc,
					payperiodid,				
					startdate,
					enddate,
					fsmonth,
					fsyear,
					deductsss,
					deducthdmf,
					deductphilhealth,
					payclosed)
				VALUES ('$PayrollID', 
					'" . DB_escape_string($db, $_POST['Description']) ."',
					'" . DB_escape_string($db, $_POST['PayPeriodID']) ."',
					'" . $SQL_StartDate . "',
					'" . $SQL_EndDate . "',
					'" . $_POST['FSMonth'] . "',	
					'" . $_POST['FSYear'] . "',			
					'" . DB_escape_string($db, $_POST['SSS']) . "',			
					'" . DB_escape_string($db, $_POST['HDMF']) . "',
					'" . DB_escape_string($db, $_POST['PhilHealth']) . "',
					'0'
					)";
			$ErrMsg = _('The payroll period') . ' ' . $_POST['Description'] . ' ' . _('could not be added because');
			$DbgMsg = _('The SQL that was used to insert the payroll period but failed was');
			$result = DB_query($sql, $db, $ErrMsg, $DbgMsg);

			prnMsg('A new payroll period for' . ' ' . $_POST['Description'] . ' ' . 'has been added to the database','success');

			unset ($PayrollID);
			unset($_POST['Description']);
			unset($_POST['PayPeriodID']);
			unset($SQL_StartDate);
			unset($SQL_EndDate);
			unset($_POST['FSMonth']);
			unset($_POST['FSYear']);
			unset($_POST['SSS']);
			unset($_POST['HDMF']);
			unset($_POST['PhilHealth']);
		}
		
	} else {

		prnMsg('Validation failed' . 'no updates or deletes took place','warn');

	}

} elseif ( isset($_POST['delete']) AND $_POST['delete'] != '' ) {
//the link to delete a selected record was clicked instead of the submit button

	$CancelDelete = 0;
		$sql = "SELECT counterindex,payrollid,employeeid,basicpay,absent,late,otpay,fsmonth,fsyear
				FROM prlpayrolltrans
				WHERE prlpayrolltrans.payrollid = '" . $PayrollID . "'";
		$PayDetails = DB_query( $sql,$db );
		if(DB_num_rows($PayDetails) > 0 )
		{
		  $CancelDelete = 1;
		  exit("Payroll can not be deleted. Payroll records found...");	  
		}

// PREVENT DELETES IF DEPENDENT RECORDS IN 'SuppTrans' , PurchOrders, SupplierContacts

	if ( $CancelDelete == 0 ) {
		$sql = "DELETE FROM prlpayrollperiod WHERE payrollid = '$PayrollID'";
		$result = DB_query($sql, $db);
		prnMsg(_('Payroll record for') . ' ' . $Description . ' ' . _('has been deleted'),'success');
		unset($PayrollID);
		unset($_SESSION['PayrollID']);
	} //end if Delete payroll
} //end of (isset($_POST['submit'])) 


if ( !isset($PayrollID) ) {
/*If the page was called without $PayrollID passed to page then assume a new payroll is to be entered*/
	echo "<FORM METHOD='post' ACTION='" . $_SERVER['PHP_SELF'] . "?" . SID . "'>";
	echo "<INPUT TYPE='hidden' NAME='New' VALUE='Yes'>";
	echo '<CENTER><TABLE>';
	echo '<TR><TD width=200 height=20><div align="right"><b>' . _('Payroll ID') . ":</TD><TD><INPUT TYPE='text' NAME='PayrollID'  SIZE=11 MAXLENGTH=10></TD>;
	     '<TD><align=right><b>Accept Alpha Numeric Character</b></TD>'</TR>";
	echo '<TR><TD width=200 height=20><div align="right"><b>' . _('Description') . ":</TD><TD><input type='Text' name='Description' SIZE=42 MAXLENGTH=40></TD></TR>";
	echo '<TR><TD width=200 height=20><div align="right"><b>' . _('Pay Period') . ":</TD><TD><SELECT NAME='PayPeriodID'>";
	DB_data_seek($result, 0);
	$sql = 'SELECT payperiodid, payperioddesc FROM prlpayperiod';
	$result = DB_query( $sql, $db );
	while ($myrow = DB_fetch_array($result)) {
		if ($_POST['PayPeriodID'] == $myrow['payperiodid']){
			echo '<OPTION SELECTED VALUE=' . $myrow['payperiodid'] . '>' . $myrow['payperioddesc'];
		} else {
			echo '<OPTION VALUE=' . $myrow['payperiodid'] . '>' . $myrow['payperioddesc'];
		}
	} //end while loop
	$DateString = Date( $_SESSION['DefaultDateFormat'] );	
	echo '<TR><TD width=200 height=20><div align="right"><b>' . _('Start Date') . ' (' . $_SESSION['DefaultDateFormat'] . ":</TD><TD><input type='Text' name='StartDate' value=$DateString SIZE=12 MAXLENGTH=10></TD></TR>";
	echo '<TR><TD width=200 height=20><div align="right"><b>' . _('End Date') . ' (' . $_SESSION['DefaultDateFormat'] . ":</TD><TD><input type='Text' name='EndDate' value=$DateString SIZE=12 MAXLENGTH=10></TD></TR>";
?>
	       <tr> 
	          <td width=200 height="20"> 
              <div align="right"><b>FS Month :</b></div>
              </td>
              <td height="20"> 
                <select name="FSMonth">
   	            <option value="" SELECTED>Month</option>
                <option value=01>January</option>
                <option value=02>February</option>
                <option value=03>March</option>
                <option value=04>April</option>
                <option value=05>May</option>
                <option value=06>June</option>
                <option value=07>July</option>
                <option value=08>August</option>
                <option value=09>September</option>
                <option value=10>October</option>
                <option value=11>November</option>
                <option value=12>December</option>
              </select>
              <select name="FSYear">
              <option value="" Selected>Year</option>
              <?
              
                    for ( $yy=2006; $yy<=2015; $yy++ )
                    {                     
                        echo "<option value=$yy>$yy</option>\n";
                    	
                    }
              ?>
              </select>
              <? echo $star; ?>
              </td>
          </tr>
	<?	  
    echo '</SELECT></TD></TR><TR><TD width=200 height=20><div align="right"><b>' . _('Deduct SSS') . ":</TD><TD><SELECT NAME='SSS'>";
	echo '<OPTION VALUE=0>' . _('Yes');
	echo '<OPTION VALUE=1>' . _('No');
	echo '</SELECT></TD></TR>';
    echo '</SELECT></TD></TR><TR><TD width=200 height=20><div align="right"><b>' . _('Deduct HDMF') . ":</TD><TD><SELECT NAME='HDMF'>";
	echo '<OPTION VALUE=0>' . _('Yes');
	echo '<OPTION VALUE=1>' . _('No');
    echo '</SELECT></TD></TR><TR><TD width=200 height=20><div align="right"><b>' . _('Deduct PhilHealt') . ":</TD><TD><SELECT NAME='PhilHealth'>";
	echo '<OPTION VALUE=0>' . _('Yes');
	echo '<OPTION VALUE=1>' . _('No');
	echo '</SELECT></TD></TR>';
	echo "</SELECT></TD></TR></TABLE><p><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Insert New Payroll') . "'>";
	echo '</FORM>';
	
} else {
	echo "<FORM METHOD='post' action='" . $_SERVER['PHP_SELF'] . '?' . SID ."'>";
	echo '<CENTER><TABLE>';
		if (!isset($_POST['New'])) {
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
			$result = DB_query($sql, $db);
			$myrow = DB_fetch_array($result);
		$_POST['Description'] = $myrow['payrolldesc'];
		$_POST['PayPeriodID'] = $myrow['payperiodid'];	
		$_POST['StartDate']  = ConvertSQLDate($myrow['startdate']);
		$_POST['EndDate']  = ConvertSQLDate($myrow['enddate']);
		$_POST['FSMonth'] = $myrow['fsmonth'];
		$_POST['FSYear'] = $myrow['fsyear'];		
		$_POST['SSS']  = $myrow['deductsss'];
		$_POST['HDMF']  = $myrow['deducthdmf'];
		$_POST['PhilHealth']  = $myrow['deductphilhealth'];
		$_POST['Status']  = $myrow['payclosed'];
		echo "<INPUT TYPE=HIDDEN NAME='PayrollID' VALUE='$PayrollID'>";
		} else {
		// its a new employee  being added
		echo "<INPUT TYPE=HIDDEN NAME='New' VALUE='Yes'>";
		echo '<TR><TD>' . _('Payroll ID') . ":</TD><TD><INPUT TYPE='text' NAME='PayrollID' VALUE='$PayrollID' SIZE=12 MAXLENGTH=10></TD></TR>";
		}
	echo '<TR><TD width=200 height=20><div align="right"><b>' . _('Description') . ":</TD><TD><input type='Text' name='Description' value='" . $_POST['Description'] . "' SIZE=42 MAXLENGTH=40></TD></TR>";	
	echo '</SELECT></TD></TR>';
	echo '<TR><TD width=200 height=20><div align="right"><b>' . _('Pay Period') . ":</TD><TD><SELECT NAME='PayPeriodID'>";
	DB_data_seek($result, 0);
	$sql = 'SELECT payperiodid, payperioddesc FROM prlpayperiod';
	$result = DB_query($sql, $db);
	while ($myrow = DB_fetch_array($result)) {
		if ($myrow['payperiodid'] == $_POST['PayPeriodID']){
			echo '<OPTION SELECTED VALUE=';
		} else {
			echo '<OPTION VALUE=';
		}
		echo $myrow['payperiodid'] . '>' . $myrow['payperioddesc'];
	} //end while loop
	echo '<TR><TD width=200 height=20><div align="right"><b>' . _('Start Date') . ":</TD><TD><input type='Text' name='StartDate' value='" . $_POST['StartDate'] . "' SIZE=22 MAXLENGTH=20></TD></TR>";			
	echo '<TR><TD width=200 height=20><div align="right"><b>' . _('End Date') . ":</TD><TD><input type='Text' name='EndDate' value='" . $_POST['EndDate'] . "' SIZE=22 MAXLENGTH=20></TD></TR>";
	$MosStr= GetMonthStr($_POST['FSMonth']);
	$Mos= GetMonthStr($_POST['FSMonth']);
	$FSY=$_POST['FSYear'];
	echo '</SELECT></TD></TR>';
	echo '<TR><TD width=200 height="20"><div align="right"><b>' . _('FS Month') . ":</TD><TD><SELECT NAME='FSMonth'>";
	echo '<OPTION SELECTED VALUE=$Mos>'. _($MosStr);
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
 
    $FSY=$_POST['FSYear'];
	echo '</SELECT>';
	echo "<SELECT NAME='FSYear'>";
			    echo '<OPTION SELECTED VALUE=$FSY>'. _($FSY);
                    for ($yy=2006;$yy<=2015;$yy++)
                    {                     
                    	echo "<option value=$yy>$yy</option>\n";
                    }
	echo '</SELECT></TD></TR><TR><TD width=200 height=20><div align="right"><b>' . _('Deduct SSS') . ":</TD><TD><SELECT NAME='SSS'>";
	if ($_POST['SSS'] == 0){
		echo '<OPTION SELECTED VALUE=0>' . _('Yes');
		echo '<OPTION VALUE=1>' . _('No');
	} else {
		echo '<OPTION VALUE=0>' . _('Yes');
		echo '<OPTION SELECTED VALUE=1>' . _('No');
	}

    echo '</SELECT></TD></TR><TR><TD width=200 height=20><div align="right"><b>' . _('Deduct HDMF') . ":</TD><TD><SELECT NAME='HDMF'>";
	if ($_POST['HDMF'] == 0){
		echo '<OPTION SELECTED VALUE=0>' . _('Yes');
		echo '<OPTION VALUE=1>' . _('No');
	} else {
		echo '<OPTION VALUE=0>' . _('Yes');
		echo '<OPTION SELECTED VALUE=1>' . _('No');
	}
    echo '</SELECT></TD></TR><TR><TD width=200 height=20><div align="right"><b>' . _('Deduct PhilHealt') . ":</TD><TD><SELECT NAME='PhilHealth'>";
	if ($_POST['PhilHealth'] == 0){
		echo '<OPTION SELECTED VALUE=0>' . _('Yes');
		echo '<OPTION VALUE=1>' . _('No');
	} else {
		echo '<OPTION VALUE=0>' . _('Yes');
		echo '<OPTION SELECTED VALUE=1>' . _('No');
	}
	if (isset($_POST['New'])) {
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Add These New Employee Details') . "'></FORM>";
	} else {
		//echo "</SELECT></TD></TR></TABLE><p><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Update Payroll Period') . "'>";
		echo "</TABLE><P><CENTER><INPUT TYPE='Submit' NAME='submit' VALUE='" . _('Update Payroll Period') . "'>";
		echo '<P><FONT COLOR=red><B>' . _('WARNING') . ': ' . _('There is no second warning if you hit the delete button below') . '. ' . _('However checks will be made to ensure there are no outstanding purchase orders or existing accounts payable transactions before the deletion is processed') . '<BR></FONT></B>';
		echo "<INPUT TYPE='Submit' NAME='delete' VALUE='" . _('Delete Payroll') . "' onclick=\"return confirm('" . _('Are you sure you wish to delete this payroll period?') . "');\"></FORM>";
	}

}
include ('includes/footer.inc.php');

?>