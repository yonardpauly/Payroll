<?php

/* $Revision: 1.0 $ */

include('includes/prlOthIncomeClass.php');

$PageSecurity = 10;
include ('includes/session.inc.php');
$title = _('Other Income Data Entry');
include ('includes/header.inc.php');
include ('includes/SQL_CommonFunctions.inc.php');
include ('includes/prlFunctions.php');

if ($_GET['NewOI']=='Yes' AND isset($_SESSION['OIDetail'])){
	unset($_SESSION['OIDetail']->OIEntries);
	unset($_SESSION['OIDetail']);
}

if (!isset($_SESSION['OIDetail'])){
	$_SESSION['OIDetail'] = new OthIncome;
}
if (!isset($_POST['OIDate'])){
	$_SESSION['OIDetail']->OIDate=date($_SESSION['DefaultDateFormat']);
}

if (isset($_POST['OIDate'])){
	$_SESSION['OIDetail']->OIDate=$_POST['OIDate'];
	$AllowThisPosting =true; //by default
	if (!Is_Date($_POST['OIDate'])){
		prnMsg(_('The date entered was not valid please enter the date'). $_SESSION['DefaultDateFormat'],'warn');
		$_POST['CommitBatch']='Do not do it the date is wrong';
		$AllowThisPosting =false; //do not allow posting
	}
}
$msg='';

if ($_POST['CommitBatch']==_('Accept and Process Other Income')){

     /*Start a transaction to do the whole lot inside */
	$result = DB_query('BEGIN',$db);


	foreach ($_SESSION['OIDetail']->OIEntries as $OIItem) {
		$SQL = "INSERT INTO prlothincfile (						
						othfileref,
						othfiledesc,
						employeeid,
						othdate,
						othincid,
						othincamount)
				VALUES (
					'$OIRef',
					'$OIDesc',
					'" . $OIItem->EmployeeID . "',
					'" . FormatDateForSQL($_SESSION['OIDetail']->OIDate) . "',
					'" . $OIItem->OIID . "',
					'" . $OIItem->Amount . "'
					)";					
		$ErrMsg = _('Cannot insert entry because');
		$DbgMsg = _('The SQL that failed to insert Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
	}


	$ErrMsg = _('Cannot commit the changes');
	$result= DB_query('COMMIT',$db,$ErrMsg,_('The commit database transaction failed'),true);

	prnMsg(_('Other Income').' ' . $OIDesc . ' '._('has been sucessfully entered'),'success');
	unset($_POST['OIRef']);
	unset($_SESSION['OIDetail']->OIEntries);
	unset($_SESSION['OIDetail']);

	/*Set up a new in case user wishes to enter another */
	echo "<BR><A HREF='" . $_SERVER['PHP_SELF'] . '?' . SID . "&NewOI=Yes'>"._('Enter Other Income Data').'</A>';
	exit;
} elseif (isset($_GET['Delete'])){
  /* User hit delete the line from the ot */
   $_SESSION['OIDetail']->Remove_OIEntry($_GET['Delete']);

} elseif ($_POST['Process']==_('Accept')){ 
	if ($AllowThisPosting) {
		$OIIDDesc= GetOthIncRow($_POST['OthIncID'], $db,0);
		$sql = "SELECT  lastname,firstname
			FROM prlemployeemaster
			WHERE employeeid = '" . $_POST['EmployeeID'] . "'";
			$result = DB_query($sql, $db);
			$myrow = DB_fetch_array($result);	
		$_SESSION['OIDetail']->Add_OIEntry($_POST['Amount'], $_POST['EmployeeID'], $myrow['lastname'], $myrow['firstname'],$_POST['OthIncID'],$OIIDDesc);
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
	<TD><INPUT TYPE='text' name='OIDate' maxlength=10 size=11 value='" . $_SESSION['OIDetail']->OIDate . "'></TD></TR>";
echo '<TR><TD>' . _('Ref') . ":</TD>
	   <TD><INPUT TYPE='text' NAME='OIRef' SIZE='11' MAXLENGTH='10' value='" . $_POST['OIRef'] . "'></TD></TR>";
echo '</SELECT></TD></TR>';
echo '</TABLE></TD>'; /*close off the table in the first column */
echo '<TD>';
/* Set up the form for the transaction entry */

echo '<FONT SIZE=3 COLOR=BLUE>' . _('Other Income Line Entry') . '</FONT><TABLE>';

echo '<TR><TD>' . _('Description') . ":</TD><TD COLSPAN=3><input type='Text' name='OIDesc' SIZE=42 MAXLENGTH=40 value='" . $_POST['OIDesc'] . "'></TD></TR>";
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
echo '<TR><TD>' . _('Other Income Type') . ":</TD><TD><SELECT NAME='OthIncID'>";		
	DB_data_seek($result, 0);
	$sql = 'SELECT othincid, othincdesc FROM prlothinctable';
	$result = DB_query($sql, $db);
	while ($myrow = DB_fetch_array($result)) {
		if ($_POST['OthIncID'] == ''){
			echo '<OPTION SELECTED VALUE=' . $myrow['othincid'] . '>' . $myrow['othincdesc'];
		} else {
			echo '<OPTION VALUE=' . $myrow['othincid'] . '>' . $myrow['othincdesc'];
		}
	} //end while loop
echo '<TR><TD>'._('Amount').":</TD><TD COLSPAN=3><INPUT TYPE=Text Name='Amount' Maxlength=12 SIZE=12 VALUE=" . $_POST['Amount'] . '></TD></TR>';
echo '</TABLE>';
echo "<CENTER><INPUT TYPE=SUBMIT name=Process value='" . _('Accept') . "'><INPUT TYPE=SUBMIT name=Cancel value='" . _('Cancel') . "'></CENTER>";

echo '</TD></TR></TABLE>'; /*Close the main table */


echo "<TABLE WIDTH=100% BORDER=1><TR>
	<TD class='tableheader'>"._('Amount')."</TD>
	<TD class='tableheader'>"._('Description')."</TD>
	<TD class='tableheader'>"._('Employee Name').'</TD></TR>';
	
foreach ($_SESSION['OIDetail']->OIEntries as $OIItem) 
{
	echo "<TR><TD ALIGN=RIGHT>" . number_format($OIItem->Amount,2) . "</TD>
		<TD>" . $OIItem->OIIDDesc  . "</TD>
		<TD>" . $OIItem->EmployeeID . ' - ' . $OIItem->LastName . ',' . $OIItem->FirstName . "</TD>
		<TD><a href='" . $_SERVER['PHP_SELF'] . '?' . SID . '&Delete=' . $OIItem->ID . "'>"._('Delete').'</a></TD>
	</TR>';
}

echo '<TR><TD ALIGN=RIGHT><B>' . number_format($_SESSION['OIDetail']->OITotal,2) . '</B></TD></TR></TABLE>';

if ((ABS($_SESSION['OIDetail']->OITotal)>0.001 AND $_SESSION['OIDetail']->OIItemCounter > 0) AND $_SESSION['OIDetail']->OIItemCounter > 0){
	echo "<BR><BR><INPUT TYPE=SUBMIT NAME='CommitBatch' VALUE='"._('Accept and Process Other Income')."'>";
}

echo '</form>';
include ('includes/footer.inc.php');
?>