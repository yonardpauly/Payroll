<?php

/* $Revision: 1.0 $ */

include ('includes/prlTardinessClass.php');

$PageSecurity = 10;
include ('includes/session.inc.php');
$title = 'Late and Absenses Data Entry';
include ('includes/header.inc.php');
include ('includes/SQL_CommonFunctions.inc.php');

if ($_GET['NewTD']=='Yes' AND isset($_SESSION['TDDetail'])){
	unset($_SESSION['TDDetail']->TDEntries);
	unset($_SESSION['TDDetail']);
}

if (!isset($_SESSION['TDDetail'])){
	$_SESSION['TDDetail'] = new Tardiness;
}
if (!isset($_POST['TDDate'])){
	$_SESSION['TDDetail']->TDDate=date($_SESSION['DefaultDateFormat']);
}

if (isset($_POST['TDDate'])){
	$_SESSION['TDDetail']->TDDate=$_POST['TDDate'];
	$AllowThisPosting =true; //by default
	if (!Is_Date($_POST['TDDate'])){
		prnMsg(_('The date entered was not valid please enter the date'). $_SESSION['DefaultDateFormat'],'warn');
		$_POST['CommitBatch']='Do not do it the date is wrong';
		$AllowThisPosting =false; //do not allow posting
	}
}
$msg='';

if ($_POST['CommitBatch']==_('Accept and Process Tardiness')){
  // echo "Start commit Batch";
	//$PeriodNo = GetPeriod($_SESSION['JournalDetail']->JnlDate,$db);

     /*Start a transaction to do the whole lot inside */
	$result = DB_query('BEGIN',$db);


	foreach ($_SESSION['TDDetail']->TDEntries as $TDItem) {
		$SQL = "INSERT INTO prldailytrans (
						rtref,
						rtdesc,
						rtdate,
						employeeid,
						absenthrs,
						latehrs)
				VALUES (
					'$TDRef',
					'$TDDesc',
					'" . FormatDateForSQL($_SESSION['TDDetail']->TDDate) . "',
					'" . $TDItem->EmployeeID . "',
					'" . $TDItem->TDHoursAbs . "',
					'" . $TDItem->TDHours . "'
					)";					
		$ErrMsg = _('Cannot insert entry because');
		$DbgMsg = _('The SQL that failed to insert Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
	}


	$ErrMsg = _('Cannot commit the changes');
	$result= DB_query('COMMIT',$db,$ErrMsg,_('The commit database transaction failed'),true);

	prnMsg(_('Late/Absenses').' ' . $TDDesc . ' '._('has been sucessfully entered'),'success');
	unset($_POST['TDRef']);
	unset($_SESSION['TDDetail']->TDEntries);
	unset($_SESSION['TDDetail']);

	/*Set up a new in case user wishes to enter another */
	echo "<BR><A HREF='" . $_SERVER['PHP_SELF'] . '?' . SID . "&NewTD=Yes'>"._('Enter Another Late/Absenses Data').'</A>';
	exit;
} elseif (isset($_GET['Delete'])){
  /* User hit delete the line from the ot */
   $_SESSION['TDDetail']->Remove_TDEntry($_GET['Delete']);

} elseif ($_POST['Process']==_('Accept')){ 
	if ($AllowThisPosting) {
		$sql = "SELECT  lastname,firstname
			FROM prlemployeemaster
			WHERE employeeid = '" . $_POST['EmployeeID'] . "'";
			$result = DB_query($sql, $db);
			$myrow = DB_fetch_array($result);	
		$_SESSION['TDDetail']->Add_TDEntry($_POST['TDHours'], $_POST['TDHoursAbs'],$_POST['EmployeeID'], $myrow['lastname'], $myrow['firstname'], $_POST['TDDesc']);
	   /*Make sure the same entry is not double processed by a page refresh */
   $Cancel = 1;
	}	
}

if (isset($Cancel)){
   unset($_POST['EmployeeID']);
}

// set up the form whatever

echo '<FORM ACTION=' . $_SERVER['PHP_SELF'] . '?' . SID . ' METHOD=POST>';


echo '<P><TABLE BORDER=1 WIDTH=100%>';
echo '<TR><TD VALIGN=TOP WIDTH=15%><TABLE>'; // A new table in the first column of the main table

if (!Is_Date($_SESSION['JournalDetail']->JnlDate)){
	$_SESSION['JournalDetail']->JnlDate = Date($_SESSION['DefaultDateFormat'],mktime(0,0,0,date('m'),0,date('Y')));
}

echo '<TR><TD>'._('Date').":</TD>
	<TD><INPUT TYPE='text' name='TDDate' maxlength=10 size=11 value='" . $_SESSION['TDDetail']->TDDate . "'></TD></TR>";
echo '<TR><TD>' . _('TD Ref') . ":</TD>
	   <TD><INPUT TYPE='text' NAME='TDRef' SIZE='11' MAXLENGTH='10' value='" . $_POST['TDRef'] . "'></TD></TR>";
echo '</SELECT></TD></TR>';
echo '</TABLE></TD>'; /*close off the table in the first column */
echo '<TD>';
/* Set up the form for the transaction entry */

echo '<FONT SIZE=3 COLOR=BLUE>' . _('Tardiness Time Line Entry - Salaried employees only') . '</FONT><TABLE>';

echo '<TR><TD>' . _('Description') . ":</TD><TD COLSPAN=3><input type='Text' name='TDDesc' SIZE=42 MAXLENGTH=40 value='" . $_POST['TDDesc'] . "'></TD></TR>";
echo '<TR><TD>' . _('Enter Employee Manually') . ":</TD>
	<TD><INPUT TYPE=Text Name='EmployeeManualCode' Maxlength=12 SIZE=12 VALUE=" . $_POST['EmployeeManualCode'] . '></TD>';
echo '<TD>'. _('OR') . ' ' . _('Select Employee Name').  ":</TD><TD><SELECT name='EmployeeID'>";
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
echo '<TR><TD>'._('Late(s) - Hour(s)').":</TD><TD COLSPAN=3><INPUT TYPE=Text Name='TDHours' Maxlength=12 SIZE=12 VALUE=" . $_POST['TDHours'] . '></TD></TR>';
echo '<TR><TD>'._('Absent - Hours').":</TD><TD COLSPAN=3><INPUT TYPE=Text Name='TDHoursAbs' Maxlength=12 SIZE=12 VALUE=" . $_POST['TDHoursAbs'] . '></TD></TR>';
echo '</TABLE>';
echo "<CENTER><INPUT TYPE=SUBMIT name=Process value='" . _('Accept') . "'><INPUT TYPE=SUBMIT name=Cancel value='" . _('Cancel') . "'></CENTER>";

echo '</TD></TR></TABLE>'; /*Close the main table */


echo "<TABLE WIDTH=100% BORDER=1><TR>
	<TD class='tableheader'>"._('Late(s)- Hour(s)')."</TD>
	<TD class='tableheader'>"._('Absent - Hour(s)')."</TD>
	<TD class='tableheader'>"._('Employee Name').'</TD></TR>';
	
foreach ($_SESSION['TDDetail']->TDEntries as $TDItem) 
{
	echo "<TR><TD ALIGN=RIGHT>" . number_format($TDItem->TDHours,2) . "</TD>
        <TD ALIGN=RIGHT>" . number_format($TDItem->TDHoursAbs,2) . "</TD>	
		<TD>" . $TDItem->EmployeeID . ' - ' . $TDItem->LastName . ',' . $TDItem->FirstName . "</TD>
		<TD><a href='" . $_SERVER['PHP_SELF'] . '?' . SID . '&Delete=' . $TDItem->ID . "'>"._('Delete').'</a></TD>
	</TR>';
}

echo '<TR><TD ALIGN=RIGHT><B>' . number_format($_SESSION['TDDetail']->TDTotal,2) . '</B></TD><TD ALIGN=RIGHT><B>' . number_format($_SESSION['TDDetail']->TDTotalAbs,2) . '</B></TD></TR></TABLE>';

if ((ABS($_SESSION['TDDetail']->TDTotal)>0.001 AND $_SESSION['TDDetail']->TDItemCounter > 0) OR (ABS($_SESSION['TDDetail']->TDTotalAbs)>0.001 AND $_SESSION['TDDetail']->TDItemCounter > 0)){
	echo "<BR><BR><INPUT TYPE=SUBMIT NAME='CommitBatch' VALUE='"._('Accept and Process Tardiness')."'>";
}

echo '</form>';
include ('includes/footer.inc.php');
?>