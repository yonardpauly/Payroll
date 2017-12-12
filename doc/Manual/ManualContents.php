<!-- This table of contents allows the choice to display one section or select multiple sections to format for print.
     Selecting multiple sections is for printing
-->

<!-- The individual topics in the manual are in straight html files that are called along with the header and foot from here.
     No style, inline style or style sheet on purpose.
     In this way the help can be easily broken into sections for online context-sensitive help.
		 The only html used in them are:
		 <br>
		 <div>
		 <table>
		 <font>
		 <b>
		 <u>
		 <ul>
		 <ol>

		 Comments beginning with Help Begin and Help End denote the beginning and end of a section that goes into the online help.
		 What section is named after Help Begin: and there can be multiple sections separated with a comma.
-->

<?php
include ('ManualHeader.html');

?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<?php
if ( ( ( !isset($_POST['Submit']) ) AND ( !isset($_GET['ViewTopic'] ) ) ) OR
     (( isset($_POST['Submit']) ) AND ( isset($_POST['SelectTableOfContents']) ))) {
// if not submittws then coming into manual to look at TOC
// if SelectTableOfContents set then user wants it displayed
?>
<?php
  if (!isset($_POST['Submit'])) {
?>  
          <input type="submit" name="Submit" value="Display Checked">
					Click on a link below to view.  Click checkboxes then Display Checked to format for printing. 
					<br><br><br> 
<?php
  }
?>
    <table cellpadding="0" cellspacing="0">
      <tr>
        <td>
<?php
  if (!isset($_POST['Submit'])) {
?>  
  	      <input type="checkbox" name="SelectTableOfContents">
<?php
  }
?>
          <font size="+3"><b>Table of Contents</b></font>
          <br><br>
          <UL>
            <LI>
<?php
  if (!isset($_POST['Submit'])) {
?>  
              <input type="checkbox" name="SelectIntroduction">
              <A HREF="<?php echo $_SERVER['PHP_SELF'] . '?ViewTopic=Introduction'; ?>">Introduction</A>
<?php
  } else {
?>
              <A href="#Introduction">Introduction</A>
<?php	
	}
?>
              <UL>
                <LI>Why Another Payroll Program?</LI>
              </UL>
              <BR>
            </LI>
						<LI>
<?php
  if (!isset($_POST['Submit'])) {
?>  
              <input type="checkbox" name="SelectRequirements">
              <A HREF="<?php echo $_SERVER['PHP_SELF'] . '?ViewTopic=Requirements'; ?>">Requirements</A>
<?php
  } else {
?>
              <A href="#Requirements">Requirements</A>
<?php	
	}
?>
              <UL>
                <LI>Hardware Requirements</LI>
                <LI>Software Requirements</LI>
              </UL>
              <BR>
            </LI>
						<LI>
<?php
  if (!isset($_POST['Submit'])) {
?>  
              <input type="checkbox" name="SelectGettingStarted">
              <A HREF="<?php echo $_SERVER['PHP_SELF'] . '?ViewTopic=GettingStarted'; ?>">Getting Started</A>
<?php
  } else {
?>
              <A HREF="#GettingStarted">Getting Started</A>
<?php	
  }
?>
              <UL>
                <LI>Prerequisites</LI>
                <LI>Copying the PHP Scripts</LI>
                <LI>Creating the Database</LI>
                <LI>Editing config.php</LI>
                <LI>Logging In For the First Time</LI>
                <LI>Themes and GUI Modification</LI>
                <LI>Setting Up Users</LI>
              </UL>
              <BR>
            </LI>
            <LI>
<?php
  if (!isset($_POST['Submit'])) {
?>  
              <input type="checkbox" name="SelectSecuritySchema">
              <A HREF="<?php echo $_SERVER['PHP_SELF'] . '?ViewTopic=SecuritySchema'; ?>">Security Schema</A>
<?php
  } else {
?>
              <A HREF="#SecuritySchema">Security Schema</A>
<?php	
  }
?>
            </LI>
            <br><br>
            <LI>
<?php
  if (!isset($_POST['Submit'])) {
?>  
              <input type="checkbox" name="SelectCreatingNewSystem">
              <A HREF="<?php echo $_SERVER['PHP_SELF'] . '?ViewTopic=CreatingNewSystem'; ?>">Creating a New System</A>
<?php
  } else {
?>
              <A HREF="#CreatingNewSystem">Creating a New System</A>
<?php	
  }
?>
              <UL>
                <LI>Running the Demonstration Database</LI>
              </UL>
              <BR>
						</LI>	
            <LI>
<?php
  if (!isset($_POST['Submit'])) {
?>  
              <input type="checkbox" name="SelectSystemConventions">
              <A HREF="<?php echo $_SERVER['PHP_SELF'] . '?ViewTopic=SystemConventions'; ?>">System Conventions</A>
<?php
  } else {
?>
              <A HREF="#SystemConventions">System Conventions</A>
<?php	
  }
?>
              <UL>
                <LI>Navigating the Menu</LI>
                <LI>Reporting</LI>
              </UL>
              <BR>
            </LI>
						<LI>
<?php
  if (!isset($_POST['Submit'])) {
?>  
              <input type="checkbox" name="SelectPayroll">
              <A HREF="<?php echo $_SERVER['PHP_SELF'] . '?ViewTopic=Payroll'; ?>">Payroll</A>
<?php
  } else {
?>
              <A HREF="#Payroll">Payroll</A>
<?php	
  }
?>
              <UL>
                <LI>Overview</LI>
                <LI>Payroll System Features</LI>
                <LI>Adding Empoloyee Records</LI>
                <LI>Creating Payroll</LI>
              </UL>
              <BR>
            </LI>
            <LI>
<?php
  if (!isset($_POST['Submit'])) {
?>  
              <input type="checkbox" name="SelectTax">
              <A HREF="<?php echo $_SERVER['PHP_SELF'] . '?ViewTopic=Tax'; ?>">Tax</A>
<?php
  } else {
?>
              <A HREF="#Tax">Tax</A>
<?php	
  }
?>
              <UL>
                <LI>Tax Calculations</LI>
                <LI>Overview</LI>
                <LI>Setting up Taxes</LI>
              </UL>
              <BR>
            </LI>
            <LI>
<?php
 if (!isset($_POST['Submit'])) {
?>  
              <input type="checkbox" name="SelectContributors">
              <A HREF="<?php echo $_SERVER['PHP_SELF'] . '?ViewTopic=Contributors'; ?>">Contributors - Acknowledgements</A>
<?php
  } else {
?>
              <A HREF="#Contributors">Contributors - Acknowledgements</A>
<?php	
  }
?>
            </LI>
          </UL>
        </td>
      </tr>
    </table>

<?php
}
?>
  </form>
<?php
if ($_GET['ViewTopic'] == 'Introduction' OR isset($_POST['SelectIntroduction'])) {
  include('ManualIntroduction.html');
}

if ($_GET['ViewTopic'] == 'Requirements' OR isset($_POST['SelectRequirements'])) {
  include('ManualRequirements.html');
}

if ($_GET['ViewTopic'] == 'GettingStarted' OR isset($_POST['SelectGettingStarted'])) {
  include('ManualGettingStarted.html');
}

if ($_GET['ViewTopic'] == 'SecuritySchema' OR isset($_POST['SelectSecuritySchema'])) {
  include('ManualSecuritySchema.html');
}

if ($_GET['ViewTopic'] == 'CreatingNewSystem' OR isset($_POST['SelectCreatingNewSystem'])) {
  include('ManualCreatingNewSystem.html');
}

if ($_GET['ViewTopic'] == 'SystemConventions' OR isset($_POST['SelectSystemConventions'])) {
  include('ManualSystemConventions.html');
}

if ($_GET['ViewTopic'] == 'Inventory' OR isset($_POST['SelectInventory'])) {
  include('ManualInventory.html');
}


if ($_GET['ViewTopic'] == 'Tax' OR isset($_POST['SelectTax'])) {
  include('ManualTax.html');
}

if ($_GET['ViewTopic'] == 'Payroll' OR isset($_POST['SelectPayroll'])) {
  include('ManualPayroll.html');
}

if ($_GET['ViewTopic'] == 'Structure' OR isset($_POST['SelectStructure'])) {
  include('ManualDevelopmentStructure.html');
}

if ($_GET['ViewTopic'] == 'Contributors' OR isset($_POST['SelectContributors'])) {
  include('ManualContributors.html');
}

include ('ManualFooter.html');
