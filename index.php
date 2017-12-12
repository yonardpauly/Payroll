<?php

/* $Revision: 1.0 $ */


$PageSecurity = 1;

include ('includes/session.inc.php');
$title = ('Main Menu');

/*The module link codes are hard coded in a switch statement below to determine the options to show for each tab */
$ModuleLink = array('PRL', 'system');
/*The headings showing on the tabs accross the main index used also in WWW_Users for defining what should be visible to the user */
$ModuleList = array(_('Payroll'), _('Setup'));

if (isset($_GET['Application'])){ /*This is sent by this page (to itself) when the user clicks on a tab */
	$_SESSION['Module'] = $_GET['Application'];
}

include ('includes/header.inc.php');

if ( count($_SESSION['AllowedPageSecurityTokens']) == 1 ){

/* if there is only one security access and its 1 (it has to be 1 for this page came up at all)- it must be a customer log on need to limit the menu to show only the customer accessible stuff this is what the page looks like for customers logging in */
?>
	
		<tr>
<?php
	include ('includes/footer.inc.php');
	exit;
} else {  /* Security settings DO allow seeing the main menu */

?>
		<table border="0" width="100%">
			<tr>
			<td class="main_menu">
				<table class="main_menu" cellspacing='0'>
					<tr>

	<?php


	$i=0;

	while ($i < count($ModuleLink)){

		// This determines if the user has display access to the module see config.php and header.inc
		// for the authorisation and security code
		if ($_SESSION['ModulesEnabled'][$i]==1)	{

			// If this is the first time the application is loaded then it is possible that
			// SESSION['Module'] is not set if so set it to the first module that is enabled for the user
			if (!isset($_SESSION['Module'])OR $_SESSION['Module']==''){
				$_SESSION['Module']=$ModuleLink[$i];
			}
			if ($ModuleLink[$i] == $_SESSION['Module']){
				//echo "<td class='main_menu_selected'><a href='". $_SERVER['PHP_SELF'] .'?'. SID . '&Application='. $ModuleLink[$i] ."'>". $ModuleList[$i] .'</a></td>';
			} else {
				//echo "<td class='main_menu_unselected'><a href='". $_SERVER['PHP_SELF'] .'?'. SID . '&Application='. $ModuleLink[$i] ."'>". $ModuleList[$i] .'</a></td>';
			}
		}
		$i++;
	}

	?>
					</tr>
				</table>
			</td>
			</tr>
		</table>
		<table class="blank_area">
			<tr>
			<td>
			</td>
			</tr>
		</table>
	<?php


	switch ($_SESSION['Module']) {

	Case 'orders': //Sales Orders
	Case 'AR': //Debtors Module
	Case 'AP': //Creditors Module
	Case 'PRL': //Payroll Module

	unset($ReceiptBatch);
	unset($AllocTrans);

	?>
		<table width="100%">
			<tr>
			<td valign="top" class="menu_group_area">
				<table width="100%">

					<?php OptionHeadings();  ?>

					<tr>
					<td class="menu_group_items">
						<table width="100%"class="table_index">
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlSelectPayroll.php?' . SID . "'><li>" . _('Create/Modify/Edit Payroll') . '</li></a>'; ?>
							</td>
							</tr>						
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlSelectLoan.php?' . SID . "'><li>" . _('Employee Loan Deduction Entry') . '</li></a>'; ?>
							</td>
							</tr>
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlRegTimeEntry.php?' .SID . "'><li>" . _('Regular Time Data Entry') . '</li></a>'; ?>
							</td>
							</tr>							
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlOtFile.php?' .SID . "'><li>" . _('Overtime Data Entry') . '</li></a>'; ?>
							</td>
							</tr>
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlTardiness.php?' .SID . "'><li>" . _('Lates and Absents  Data Entry') . '</li></a>'; ?>
							</td>
							</tr>
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlOthIncome.php?' .SID . "'><li>" . _('Other Income Data Entry') . '</li></a>'; ?>
							</td>
							</tr>
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlSelectRT.php?' . SID . "'><li>" . _('View Regular Time') . '</li></a>'; ?>
							</td>
							</tr>						
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlSelectOT.php?' . SID . "'><li>" . _('View Overtime') . '</li></a>'; ?>
							</td>
							</tr>
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlSelectPayTrans.php?' . SID . "'><li>" . _('View Payroll Trans') . '</li></a>'; ?>
							</td>
							</tr>
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlSelectDeduction.php?' . SID . "'><li>" . _('View Payroll Deduction') . '</li></a>'; ?>
							</td>
							</tr>
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlSelectTD.php?' . SID . "'><li>" . _('View Lates and Absenses') . '</li></a>'; ?>
							</td>
							</tr>					
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlSelectOthIncome.php?' . SID . "'><li>" . _('View Other Income Data') . '</li></a>'; ?>
							</td>
							</tr>					

						</table>
					</td>
					<td class="menu_group_items">
							<table width="100%" class="table_index">
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlRepPayrollRegister.php?' . SID . "'><li>" . _('Payroll Register') . '</li></a>'; ?>
							</td>
							</tr>
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlRepBankTrans.php?' . SID . "'><li>" . _('Bank Transmittal') . '</li></a>'; ?>
							</td>
							</tr>
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlRepCashTrans.php?' . SID . "'><li>" . _('Over the Counter Listing') . '</li></a>'; ?>
							</td>
							</tr>
							
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlRepPaySlip.php?' . SID . "'><li>" . _('Pay Slip') . '</li></a>'; ?>
							</td>
							</tr>
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlRepSSSPremium.php?' . SID . "'><li>" . _('SSS Monthly Remittance') . '</li></a>'; ?>
							</td>
							</tr>
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlRepHDMFPremium.php?' . SID . "'><li>" . _('HDMF MOnthly Remittance') . '</li></a>'; ?>
							</td>
							</tr>
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlRepTax.php?' . SID . "'><li>" . _('Tax Monthly Return') . '</li></a>'; ?>
							</td>
							</tr>
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlRepPHPremium.php?' . SID . "'><li>" . _('Philhealth Monthly Remittance') . '</li></a>'; ?>
							</td>
							</tr>
							<td class="menu_group_headers"><div align="center">Year to Date Report</div>
								<tr>
								<td class="menu_group_item">
									<?php echo "<a href='" . $rootpath . '/prlRepPayrollRegYTD.php?' . SID . "'><li>" . _('YTD Payroll Register') . '</li></a>'; ?>
								</td>
								</tr>
								<tr>
								<td class="menu_group_item">
									<?php echo "<a href='" . $rootpath . '/prlRepTaxYTD.php?' . SID . "'><li>" . _('AlphaList') . '</li></a>'; ?>
								</td>
								</tr>
							</td>
							<td class="menu_group_headers"><div align="center">Diskette Report</div>
								<tr>
								<td class="menu_group_item">
									<?php echo "<a href='" . $rootpath . '/notyet.php?' . SID . "'><li>" . _('Monthly Alphalist of Payees(MAP)') . '</li></a>'; ?>
								</td>
								</tr>
								<tr>
								<td class="menu_group_item">
									<?php echo "<a href='" . $rootpath . '/notyet.php?' . SID . "'><li>" . _('SSS R3 Diskette') . '</li></a>'; ?>
								</td>
								</tr>					
							</td>	
						</table>
					</td>
					<td class="menu_group_items">
						<table width="100%" class="table_index">
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlSelectEmployee.php?' . SID . "'><li>" . _('Add/Update Employees Record') . '</li></a>'; ?>
							</td>
							</tr>
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlTax.php?' . SID . "'><li>" . _('Add/Update Tax Table') . '</li></a>'; ?>
							</td>
							</tr>
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlSelectTaxStatus.php?' . SID . "'><li>" . _('Add/Update Tax Status Table') . '</li></a>'; ?>
							</td>					
							</tr>														
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlSSS.php?' . SID . "'><li>" . _('Add/Update SSS Table') . '</li></a>'; ?>
							</td>
							</tr>						
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlPH.php?' . SID . "'><li>" . _('Add/Update PhilHealth Table') . '</li></a>'; ?>
							</td>
							</tr>						
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlHDMF.php?' . SID . "'><li>" . _('Add/Update HDMF Table') . '</li></a>'; ?>
							</td>
							</tr>						
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlEmploymentStatus.php?' . SID . "'><li>" . _('Add/Update Employment Status') . '</li></a>'; ?>
							</td>					
							</tr>
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlPayPeriod.php?' . SID . "'><li>" . _('Add/Update Pay Period Table') . '</li></a>'; ?>
							</td>					
							</tr>							
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlOvertime.php?' . SID . "'><li>" . _('Add/Update Overtime Table') . '</li></a>'; ?>
							</td>					
							</tr>													
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlLoanTable.php?' . SID . "'><li>" . _('Add/Update Loan Table') . '</li></a>'; ?>
							</td>					
							</tr>													
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlOthIncTable.php?' . SID . "'><li>" . _('Add/Update Other Income Table') . '</li></a>'; ?>
							</td>					
							</tr>													
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/prlCostCenter.php?' . SID . "'><li>" . _('Add/Update Cost Center') . '</li></a>'; ?>
							</td>					
							</tr>													
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/CompanyPreferences.php?' . SID . "'><li>" . _('Company Preferences') . '</li></a>'; ?>
							</td>
							</tr>
							<tr>
							<td class="menu_group_item">
								<?php echo "<a href='" . $rootpath . '/WWW_Users.php?' . SID . "'><li>" . _('User Accounts') . '</li></a>'; ?>
							</td>
							</tr>
						</table>
					</td>
					</tr>
				</table>
			</td>
			</tr>
		</table>
	<?php
		break;

	/* ********************* 	END OF Payroll OPTIONS **************************** */
	/* ********************* 	END OF Payroll OPTIONS **************************** */
	/* ********************* 	END OF Payroll OPTIONS **************************** */
	/* ********************* 	END OF Payroll OPTIONS **************************** */


	Case 'PO': /* Purchase Ordering */
	Case 'stock': //Inventory Module
	Case 'manuf': //Manufacturing Module
	Case 'system': //System setup
	Case 'GL': //General Ledger
	} //end of module switch
} /* end of if security allows to see the full menu */

// all tables started are ended within this index script which means 2 outstanding from footer.

include ('includes/footer.inc.php');

function OptionHeadings() {

global $rootpath, $theme;

?>
	<tr>
	<td class="menu_group_headers"> <!-- Orders option Headings -->
		<table>
			<tr>
			<td>
				<?php echo '<img src="'.$rootpath.'/css/'.$theme.'/images/transactions.gif" TITLE="' . _('Transactions') . '" ALT="">'; ?>
			</td>
			<td class="menu_group_headers_text">
				<?php echo _('Transactions'); ?>
			</td>
			</tr>
		</table>
	</td>
	<td class="menu_group_headers">
		<table>
			<tr>
			<td>
				<?php echo '<img src="'.$rootpath.'/css/'.$theme.'/images/transactions.gif" TITLE="' . _('Inquiries and Reports') . '" ALT="">'; ?>
			</td>
			<td class="menu_group_headers_text">
				<?php echo _('Inquiries and Reports'); ?>
			</td>
			</tr>
		</table>
	</td>
	<td class="menu_group_headers">
		<table>
			<tr>
			<td>
				<?php echo '<img src="'.$rootpath.'/css/'.$theme.'/images/transactions.gif" TITLE="' . _('Maintenance') . '" ALT="">'; ?>
			</td>
			<td class="menu_group_headers_text">
				<?php echo _('Maintenance'); ?>
			</td>
			</tr>
		</table>
	</td>
	</tr>
	
<?php

}

?>