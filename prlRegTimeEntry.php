<?php

/* $Revision: 1.0 $ */

include ('includes/prlRegTimeClass.php');

$PageSecurity = 10;
include ('includes/session.inc.php');
$title = 'Regular Time Entry for Hourly Employees';
include ('includes/header.inc.php');
include ('includes/SQL_CommonFunctions.inc.php');

if ($_GET['NewRT']=='Yes' AND isset($_SESSION['RTDetail'])){
	unset($_SESSION['RTDetail']->RTEntries);
	unset($_SESSION['RTDetail']);
}

if (!isset($_SESSION['RTDetail'])){
	$_SESSION['RTDetail'] = new OverTime;
}
if (!isset($_POST['RTDate'])){
	$_SESSION['RTDetail']->RTDate=date($_SESSION['DefaultDateFormat']);
}

if (isset($_POST['RTDate'])){
	$_SESSION['RTDetail']->RTDate=$_POST['RTDate'];
	$AllowThisPosting =true; //by default
	if (!Is_Date($_POST['RTDate'])){
		prnMsg(_('The date entered was not valid please enter the overtime date'). $_SESSION['DefaultDateFormat'],'warn');
		$_POST['CommitBatch']='Do not do it the date is wrong';
		$AllowThisPosting =false; //do not allow posting
	}
}
$msg='';

if ( $_POST['CommitBatch'] == 'Accept and Process Overtime' ){
  // echo "Start commit Batch";
	//$PeriodNo = GetPeriod($_SESSION['JournalDetail']->JnlDate,$db);

     /*Start a transaction to do the whole lot inside */
	$result = DB_query('BEGIN',$db);

	//$TransNo = GetNextTransNo( 0, $db);

	foreach ( $_SESSION['RTDetail']->RTEntries as $RTItem ) {
		$SQL = "INSERT INTO prldailytrans (
						rtref,
						rtdesc,
						rtdate,
						employeeid,
						reghrs)
				VALUES (
					'$RTRef',
					'$RTDesc',
					'" . FormatDateForSQL($_SESSION['RTDetail']->RTDate) . "',
					'" . $RTItem->EmployeeID . "',
					'" . $RTItem->RTHours . "'
					)";					
		$ErrMsg = 'Cannot insert regular time entry because';
		$DbgMsg = 'The SQL that failed to insert the regular time Trans record was';
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
	}


	$ErrMsg = _('Cannot commit the changes');
	$result= DB_query('COMMIT',$db,$ErrMsg,_('The commit database transaction failed'),true);

	prnMsg(_('Regular Time').' ' . $RTDesc . ' '._('has been sucessfully entered'),'success');
	unset($_POST['RTRef']);
	unset($_SESSION['RTDetail']->GLEntries);
	unset($_SESSION['RTDetail']);

	/*Set up a newy in case user wishes to enter another */
	echo "<BR><A HREF='" . $_SERVER['PHP_SELF'] . '?' . SID . "&NewRT=Yes'>"._('Enter Another Overtime Data').'</A>';
	/*And post the journal too */
	   //include ('includes/GLPostings.inc');
	exit;
} elseif (isset($_GET['Delete'])){
  /* User hit delete the line from the ot */
   $_SESSION['RTDetail']->Remove_RTEntry($_GET['Delete']);

//   $_SESSION['JournalDetail']->Remove_GLEntry($_GET['Delete']);

} elseif ($_POST['Process']==_('Accept')){ //user hit submit a new GL Analysis line into the journal
	if ($AllowThisPosting) {
		$sql = "SELECT  lastname,firstname
			FROM prlemployeemaster
			WHERE employeeid = '" . $_POST['EmployeeID'] . "'";
			$result = DB_query($sql, $db);
			$myrow = DB_fetch_array($result);	
		$_SESSION['RTDetail']->Add_RTEntry($_POST['RTHours'], $_POST['EmployeeID'], $myrow['lastname'], $myrow['firstname'], $_POST['RTDesc']);
	   /*Make sure the same receipt is not double processed by a page refresh */
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
	<TD><INPUT TYPE='text' name='RTDate' maxlength=10 size=11 value='" . $_SESSION['RTDetail']->RTDate . "'></TD></TR>";
echo '<TR><TD>' . _('RT Ref') . ":</TD>
	   <TD><INPUT TYPE='text' NAME='RTRef' SIZE='11' MAXLENGTH='10' value='" . $_POST['RTRef'] . "'></TD></TR>";
echo '</SELECT></TD></TR>';
echo '</TABLE></TD>'; /*close off the table in the first column */
echo '<TD>';
/* Set upthe form for the transaction entry for a GL Payment Analysis item */

echo '<FONT SIZE=3 COLOR=BLUE>' . _('Regular Time Line Entry') . '</FONT><TABLE>';

/*now set up a GLCode field to select from avaialble GL accounts */
echo '<TR><TD>' . _('Description') . ":</TD><TD COLSPAN=3><input type='Text' name='RTDesc' SIZE=42 MAXLENGTH=40 value='" . $_POST['RTDesc'] . "'></TD></TR>";
/*now set up a GLCode field to select from avaialble GL accounts */
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
echo '<TR><TD>'._('Hours').":</TD><TD COLSPAN=3><INPUT TYPE=Text Name='RTHours' Maxlength=12 SIZE=12 VALUE=" . $_POST['RTHours'] . '></TD></TR>';
echo '</TABLE>';
echo "<CENTER><INPUT TYPE=SUBMIT name=Process value='" . _('Accept') . "'><INPUT TYPE=SUBMIT name=Cancel value='" . _('Cancel') . "'></CENTER>";

echo '</TD></TR></TABLE>'; /*Close the main table */


echo "<TABLE WIDTH=100% BORDER=1><TR>
	<TD class='tableheader'>"._('RT Hour')."</TD>
	<TD class='tableheader'>"._('Employee Name').'</TD></TR>';
    //<TD class='tableheader'>"._('Overtime Type').'</TD></TR>';
	
foreach ($_SESSION['RTDetail']->RTEntries as $RTItem) 
{
	echo "<TR><TD ALIGN=RIGHT>" . number_format($RTItem->RTHours,2) . "</TD>
		<TD>" . $RTItem->EmployeeID . ' - ' . $RTItem->LastName . ',' . $RTItem->FirstName . "</TD>
		<TD><a href='" . $_SERVER['PHP_SELF'] . '?' . SID . '&Delete=' . $RTItem->ID . "'>"._('Delete').'</a></TD>
	</TR>';
}

echo '<TR><TD ALIGN=RIGHT><B>' . number_format($_SESSION['RTDetail']->RTTotal,2) . '</B></TD></TR></TABLE>';

if (ABS($_SESSION['RTDetail']->RTTotal)>0.001 AND $_SESSION['RTDetail']->RTItemCounter > 0){
	echo "<BR><BR><INPUT TYPE=SUBMIT NAME='CommitBatch' VALUE='"._('Accept and Process Overtime')."'>";
}

echo '</form>';
include ('includes/footer.inc.php');
?>