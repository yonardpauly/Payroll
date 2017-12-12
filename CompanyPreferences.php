<?php

/* $Revision: 1.11 $ */

$PageSecurity = 10;

include 'includes/session.inc.php';

$title = 'Company Preferences';

include 'includes/header.inc.php';

if ( isset($_POST['submit']) ) {

	//initialise no input errors assumed initially before we test
	$InputError = 0;

	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */

	//first off validate inputs sensible

	if ( strlen($_POST['CoyName']) > 40 OR strlen($_POST['CoyName']) == 0 ) {
		$InputError = 1;
		prnMsg('The company name must be entered and be fifty characters or less long', 'error');
	} elseif ( strlen($_POST['RegOffice1']) > 40 ) {
		$InputError = 1;
		prnMsg('The Line 1 of the address must be forty characters or less long','error');
	} elseif ( strlen($_POST['RegOffice2']) > 40 ) {
		$InputError = 1;
		prnMsg('The Line 2 of the address must be forty characters or less long','error');
	} elseif ( strlen($_POST['RegOffice3']) > 40 ) {
		$InputError = 1;
		prnMsg('The Line 3 of the address must be forty characters or less long','error');
	} elseif ( strlen($_POST['RegOffice4']) > 40 ) {
		$InputError = 1;
		prnMsg('The Line 4 of the address must be forty characters or less long','error');
	} elseif ( strlen($_POST['RegOffice5']) > 20 ) {
		$InputError = 1;
		prnMsg('The Line 5 of the address must be twenty characters or less long','error');
	} elseif ( strlen($_POST['RegOffice6']) > 15 ) {
		$InputError = 1;
		prnMsg('The Line 6 of the address must be fifteen characters or less long','error');
	} elseif ( strlen($_POST['Telephone']) > 25 ) {
		$InputError = 1;
		prnMsg('The telephone number must be 25 characters or less long','error');
	} elseif ( strlen($_POST['Fax']) > 25 ) {
		$InputError = 1;
		prnMsg('The fax number must be 25 characters or less long','error');
	} elseif ( strlen($_POST['Email']) > 55 ) {
		$InputError = 1;
		prnMsg('The email address must be 55 characters or less long','error');
	}

	if  ($InputError != 1 ){

		$sql = "UPDATE companies SET
				coyname='" . $_POST['CoyName'] . "',
				companynumber = '" . $_POST['CompanyNumber'] . "',
				gstno='" . $_POST['GSTNo'] . "',
				regoffice1='" . $_POST['RegOffice1'] . "',
				regoffice2='" . $_POST['RegOffice2'] . "',
				regoffice3='" . $_POST['RegOffice3'] . "',
				regoffice4='" . $_POST['RegOffice4'] . "',
				regoffice5='" . $_POST['RegOffice5'] . "',
				regoffice6='" . $_POST['RegOffice6'] . "',
				telephone='" . $_POST['Telephone'] . "',
				fax='" . $_POST['Fax'] . "',
				email='" . $_POST['Email'] . "',
				currencydefault='" . $_POST['CurrencyDefault'] . "'
			WHERE coycod e= 1";

			$ErrMsg = 'The company preferences could not be updated because';
			$result = DB_query( $sql, $db, $ErrMsg );
			prnMsg('Company preferences updated','success');
			
			$ForceConfigReload = True; // Required to force a load even if stored in the session vars
			include ('includes/GetConfig.php');
			$ForceConfigReload = False;

	} else {
		prnMsg('Validation failed' . ', ' . 'no updates or deletes took place', 'warn');
	}

} /* end of if submit */



echo '<FORM METHOD="post" action=' . $_SERVER['PHP_SELF'] . '>';
echo '<CENTER><TABLE>';

$sql = "SELECT coyname,
		gstno,
		companynumber,
		regoffice1,
		regoffice2,
		regoffice3,
		regoffice4,
		regoffice5,
		regoffice6,
		telephone,
		fax,
		email,
		currencydefault
	FROM companies
	WHERE coycode=1";



$ErrMsg = 'The company preferences could not be retrieved because';
$result = DB_query($sql, $db,$ErrMsg);


$myrow = DB_fetch_array($result);

$_POST['CoyName'] = $myrow['coyname'];
$_POST['GSTNo'] = $myrow['gstno'];
$_POST['CompanyNumber']  = $myrow['companynumber'];
$_POST['RegOffice1']  = $myrow['regoffice1'];
$_POST['RegOffice2']  = $myrow['regoffice2'];
$_POST['RegOffice3']  = $myrow['regoffice3'];
$_POST['RegOffice4']  = $myrow['regoffice4'];
$_POST['RegOffice5']  = $myrow['regoffice5'];
$_POST['RegOffice6']  = $myrow['regoffice6'];
$_POST['Telephone']  = $myrow['telephone'];
$_POST['Fax']  = $myrow['fax'];
$_POST['Email']  = $myrow['email'];
$_POST['CurrencyDefault']  = $myrow['currencydefault'];

echo '<TR><TD>' . _('Name') . ' (' . _('to appear on reports') . '):</TD>
	<TD><input type="Text" Name="CoyName" value="' . $_POST['CoyName'] . '" SIZE=52 MAXLENGTH=50></TD>
</TR>';

echo '<TR><TD>' . _('Official Company Number') . ':</TD>
	<TD><input type="Text" Name="CompanyNumber" value="' . $_POST['CompanyNumber'] . '" SIZE=22 MAXLENGTH=20></TD>
	</TR>';

echo '<TR><TD>' . _('Tax Authority Reference') . ':</TD>
	<TD><input type="Text" Name="GSTNo" value="' . $_POST['GSTNo'] . '" SIZE=22 MAXLENGTH=20></TD>
</TR>';

echo '<TR><TD>' . _('Address Line 1') . ':</TD>
	<TD><input type="Text" Name="RegOffice1" SIZE=42 MAXLENGTH=40 value="' . $_POST['RegOffice1'] . '"></TD>
</TR>';

echo '<TR><TD>' . _('Address Line 2') . ':</TD>
	<TD><input type="Text" Name="RegOffice2" SIZE=42 MAXLENGTH=40 value="' . $_POST['RegOffice2'] . '"></TD>
</TR>';

echo '<TR><TD>' . _('Address Line 3') . ':</TD>
	<TD><input type="Text" Name="RegOffice3" SIZE=42 MAXLENGTH=40 value="' . $_POST['RegOffice3'] . '"></TD>
</TR>';

echo '<TR><TD>' . _('Address Line 4') . ':</TD>
	<TD><input type="Text" Name="RegOffice4" SIZE=42 MAXLENGTH=40 value="' . $_POST['RegOffice4'] . '"></TD>
</TR>';

echo '<TR><TD>' . _('Address Line 5') . ':</TD>
	<TD><input type="Text" Name="RegOffice5" SIZE=22 MAXLENGTH=20 value="' . $_POST['RegOffice5'] . '"></TD>
</TR>';

echo '<TR><TD>' . _('Address Line 6') . ':</TD>
	<TD><input type="Text" Name="RegOffice6" SIZE=17 MAXLENGTH=15 value="' . $_POST['RegOffice6'] . '"></TD>
</TR>';

echo '<TR><TD>' . _('Telephone Number') . ':</TD>
	<TD><input type="Text" Name="Telephone" SIZE=26 MAXLENGTH=25 value="' . $_POST['Telephone'] . '"></TD>
</TR>';

echo '<TR><TD>' . _('Facsimile Number') . ':</TD>
	<TD><input type="Text" Name="Fax" SIZE=26 MAXLENGTH=25 value="' . $_POST['Fax'] . '"></TD>
</TR>';

echo '<TR><TD>' . _('Email Address') . ':</TD>
	<TD><input type="Text" Name="Email" SIZE=26 MAXLENGTH=55 value="' . $_POST['Email'] . '"></TD>
</TR>';


$result = DB_query("SELECT currabrev, currency FROM currencies", $db);

echo '<TR><TD>' . _('Home Currency') . ':</TD><TD><SELECT Name=CurrencyDefault>';

while ($myrow = DB_fetch_array($result)) {
	if ($_POST['CurrencyDefault']==$myrow['currabrev']){
		echo "<OPTION SELECTED VALUE='". $myrow['currabrev'] . "'>" . $myrow['currency'];
	} else {
		echo "<OPTION VALUE='". $myrow['currabrev'] . "'>" . $myrow['currency'];
	}
} //end while loop


echo '</SELECT></TD></TR>';


echo '</TABLE><CENTER><input type="Submit" Name="submit" value="' . _('Update') . '">';

include ('includes/footer.inc.php');
?>
