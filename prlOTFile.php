<?php

/* $Revision: 1.0 $ */

include ('includes/prlOverTimeClass.php');

$PageSecurity = 10;
include ('includes/session.inc.php');
$title = _('Overtime Entry');
include ('includes/header.inc.php');
include ('includes/SQL_CommonFunctions.inc.php');

if ($_GET['NewOT']=='Yes' AND isset($_SESSION['OTDetail'])){
	unset($_SESSION['OTDetail']->OTEntries);
	unset($_SESSION['OTDetail']);
}

if (!isset($_SESSION['OTDetail'])){
	$_SESSION['OTDetail'] = new OverTime;
	
}
if (!isset($_POST['OTDate'])){
	$_SESSION['OTDetail']->OTDate=date($_SESSION['DefaultDateFormat']);
}

if (isset($_POST['OTDate'])){
	$_SESSION['OTDetail']->OTDate=$_POST['OTDate'];
	$AllowThisPosting =true; //by default
	if (!Is_Date($_POST['OTDate'])){
		prnMsg(_('The date entered was not valid please enter the overtime date'). $_SESSION['DefaultDateFormat'],'warn');
		$_POST['CommitBatch']='Do not do it the date is wrong';
		$AllowThisPosting =false; //do not allow posting
	}
}
if (isset($_POST['OTType'])){
	$_SESSION['OTDetail']->OTType = $_POST['OTType'];
}
$msg='';

if ($_POST['CommitBatch']==_('Accept and Process Overtime')){

     /*Start a transaction to do the whole lot inside */
	$result = DB_query('BEGIN',$db);

	foreach ($_SESSION['OTDetail']->OTEntries as $OTItem) {
		$SQL = "INSERT INTO prlottrans (
						otref,
						otdesc,
						otdate,
						overtimeid,
						employeeid,
						othours)
				VALUES (
					'$OTRef',
					'$OTDesc',
					'" . FormatDateForSQL($_SESSION['OTDetail']->OTDate) . "',
					'" . $OTItem->OverTimeID . "',
					'" . $OTItem->EmployeeID . "',
					'" . $OTItem->OTHours . "'
					)";					
		$ErrMsg = _('Cannot insert overtime entry because');
		$DbgMsg = _('The SQL that failed to insert the OT Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
	}


	$ErrMsg = _('Cannot commit the changes');
	$result= DB_query('COMMIT',$db,$ErrMsg,_('The commit database transaction failed'),true);

	prnMsg(_('Overtime').' ' . $OTRef . ' '._('has been sucessfully entered'),'success');
	unset($_POST['OTRef']);
	unset($_SESSION['OTDetail']->GLEntries);
	unset($_SESSION['OTDetail']);

	/*Set up a new in case user wishes to enter another */
	echo "<BR><A HREF='" . $_SERVER['PHP_SELF'] . '?' . SID . "&NewOT=Yes'>"._('Enter Another Overtime Data').'</A>';
	exit;
} elseif (isset($_GET['Delete'])){
  /* User hit delete the line from the ot */
   $_SESSION['OTDetail']->Remove_OTEntry($_GET['Delete']);

} elseif ($_POST['Process']==_('Accept')){ //user hit submit
	if ($AllowThisPosting) {
		$sql = "SELECT overtimedesc
			FROM prlovertimetable
			WHERE overtimeid = '" . $_POST['OvertimeID'] . "'";
		$result = DB_query($sql, $db);
		$myrow = DB_fetch_array($result);	
		$OTD = $myrow['overtimedesc'];		
		$sql = "SELECT  lastname,firstname
			FROM prlemployeemaster
			WHERE employeeid = '" . $_POST['EmployeeID'] . "'";
			$result = DB_query($sql, $db);
			$myrow = DB_fetch_array($result);	
		$_SESSION['OTDetail']->Add_OTEntry($_POST['OTHours'], $_POST['EmployeeID'], $myrow['lastname'], $myrow['firstname'], $OTD, $_POST['OvertimeID']);
   $Cancel = 1;
	}	
}

if (isset($Cancel)){
   unset($_POST['EmployeeID']);
}

echo '<FORM ACTION=' . $_SERVER['PHP_SELF'] . '?' . SID . ' METHOD=POST>';


echo '<P><TABLE BORDER=1 WIDTH=100%>';
echo '<TR><TD VALIGN=TOP WIDTH=15%><TABLE>'; // A new table in the first column of the main table

if (!Is_Date($_SESSION['JournalDetail']->JnlDate)){
	// Default the date to the last day of the previous month
	$_SESSION['JournalDetail']->JnlDate = Date($_SESSION['DefaultDateFormat'],mktime(0,0,0,date('m'),0,date('Y')));
}

echo '<TR><TD>'._('Date').":</TD>
	<TD><INPUT TYPE='text' name='OTDate' maxlength=10 size=11 value='" . $_SESSION['OTDetail']->OTDate . "'></TD></TR>";


echo '<TR><TD>' . _('OT Ref') . ":</TD>
	   <TD><INPUT TYPE='text' NAME='OTRef' SIZE='11' MAXLENGTH='10' value='" . $_POST['OTRef'] . "'></TD></TR>";

echo '</SELECT></TD></TR>';

echo '</TABLE></TD>'; /*close off the table in the first column */

echo '<TD>';
/* Set upthe form for the transaction entry */

echo '<FONT SIZE=3 COLOR=BLUE>' . _('Overtime Line Entry') . '</FONT><TABLE>';

echo '<TR><TD>' . _('Description') . ":</TD><TD COLSPAN=3><input type='Text' name='OTDesc' SIZE=42 MAXLENGTH=40 value='" . $_POST['OTDesc'] . "'></TD></TR>";
echo '<TR><TD>' . _('Employee ') . ":</TD>
	<TD><INPUT TYPE=Text Name='EmployeeManualCode' Maxlength=12 SIZE=12 VALUE=" . $_POST['EmployeeManualCode'] . '></TD>';
echo "<TD><SELECT name='EmployeeID'>";
$sql = 'SELECT employeeid, lastname, firstname FROM prlemployeemaster ORDER BY employeeid';
$result = DB_query($sql, $db);
if (DB_num_rows($result)==0){
	echo '</SELECT></TD></TR>';
	prnMsg(_('No Empoloyee accounts have been set up yet'),'warn');
} else {
	while ($myrow = DB_fetch_array($result)) {
		if ($_POST['EmployeeID'] == $myrow['employeeid']){
			echo '<OPTION SELECTED VALUE=' . $myrow['employeeid'] . '>' . $myrow['lastname'] . ',' . $myrow['firstname'];
		} else {
			echo '<OPTION VALUE=' . $myrow['employeeid'] . '>' . $myrow['lastname'] . ',' . $myrow['firstname'];
		}
	} //end while loop
	echo '</SELECT></TD></TR>';
}
echo '<TR><TD>' . _('Overtime Type') . ":</TD><TD><SELECT NAME='OvertimeID'>";		
	DB_data_seek($result, 0);
	$sql = 'SELECT overtimeid, overtimedesc FROM prlovertimetable';
	$result = DB_query($sql, $db);
	while ($myrow = DB_fetch_array($result)) {
		if ($_POST['OvertimeID'] == ''){
			echo '<OPTION SELECTED VALUE=' . $myrow['overtimeid'] . '>' . $myrow['overtimedesc'];
		} else {
			echo '<OPTION VALUE=' . $myrow['overtimeid'] . '>' . $myrow['overtimedesc'];
		}
	} //end while loop
echo '<TR><TD>'._('OTHours').":</TD><TD COLSPAN=3><INPUT TYPE=Text Name='OTHours' Maxlength=12 SIZE=12 VALUE=" . $_POST['OTHours'] . '></TD></TR>';
echo '</TABLE>';
echo "<CENTER><INPUT TYPE=SUBMIT name=Process value='" . _('Accept') . "'><INPUT TYPE=SUBMIT name=Cancel value='" . _('Cancel') . "'></CENTER>";

echo '</TD></TR></TABLE>'; /*Close the main table */


echo "<TABLE WIDTH=100% BORDER=1><TR>
	<TD class='tableheader'>"._('OT Hour')."</TD>
	<TD class='tableheader'>"._('Employee Name')."</TD>
	<TD class='tableheader'>"._('Overtime Type').'</TD></TR>';

foreach ($_SESSION['OTDetail']->OTEntries as $OTItem) 
{
	echo "<TR><TD ALIGN=RIGHT>" . number_format($OTItem->OTHours,2) . "</TD>
		<TD>" . $OTItem->EmployeeID . ' - ' . $OTItem->LastName . ',' . $OTItem->FirstName  .'</TD>
		<TD>' . $OTItem->OverTimeDesc  . "</TD>
		<TD><a href='" . $_SERVER['PHP_SELF'] . '?' . SID . '&Delete=' . $OTItem->ID . "'>"._('Delete').'</a></TD>
	</TR>';
}

echo '<TR><TD ALIGN=RIGHT><B>' . number_format($_SESSION['OTDetail']->OTTotal,2) . '</B></TD></TR></TABLE>';

if (ABS($_SESSION['OTDetail']->OTTotal)>0.001 AND $_SESSION['OTDetail']->OTItemCounter > 0){
	echo "<BR><BR><INPUT TYPE=SUBMIT NAME='CommitBatch' VALUE='"._('Accept and Process Overtime')."'>";
}

echo '</form>';
include ('includes/footer.inc.php');
?>