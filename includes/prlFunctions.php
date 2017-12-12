<?
//include_once("ConnectDB_mysql.inc");

// All Functions
// *************
//function beg() /
//{
//var myConfirm = confirm("Sure you want to leave?");
//return myConfirm
//} 


//
function GetYesNoStr($YesNo)
{
		if ($YesNo ==0) {
				$YesNoStr='Yes';
		} else {
				$YesNoStr='No';
		}  
      return $YesNoStr;
}

function GetOpenCloseStr($OC)
{
		if ($OC ==0) {
				$OCStr='Open';
		} else {
				$OCStr='Closed';
		}  
      return $OCStr;
}

function GetPayTypeDesc($PT)
{
		if ($PT==0) {
			$PTStr='Salary';
		} elseif ($PT==1) {
			$PTStr='Hourly';
		} else {
			$PTStr='Unknown';
		}  
      return $PTStr;
}


Function GetPayPeriodDesc($PeriodID, &$db){

/*Gets the GL Codes relevant to the stock item account from the stock category record */

    $QuerySQL = "SELECT payperiodid, payperioddesc FROM prlpayperiod
	             WHERE payperiodid = '$PeriodID'";
	$ErrMsg =  _('The period code could not be retreived because');
	$GetPayDescResult = DB_query($QuerySQL, $db, $ErrMsg);

	$myrow = DB_fetch_array($GetPayDescResult);
	return $myrow[1];
}

Function GetOthIncRow($OIID, &$db,$PayRow){

/*Gets the GL Codes relevant to the stock item account from the stock category record */
    $sql = "SELECT othincdesc,taxable FROM prlothinctable
	             WHERE othincid = '$OIID'";
			$result = DB_query($sql, $db);
			$myrow = DB_fetch_array($result);
            return $myrow[$PayRow];;			 
}


Function GetPayPeriodRow($PeriodID, &$db,$PayRow){

/*Gets the GL Codes relevant to the stock item account from the stock category record */
    $sql = "SELECT payperiodid, payperioddesc,numberofpayday FROM prlpayperiod
	             WHERE payperiodid = '$PeriodID'";
			$result = DB_query($sql, $db);
			$myrow = DB_fetch_array($result);
            return $myrow[$PayRow];;			 
}

Function GetMyTax($MyTaxableIncome, &$db){
	if ($MyTaxableIncome>0) {
		$sql = "SELECT rangefrom,rangeto,fixtaxableamount,fixtax,percentofexcessamount
				FROM prltaxtablerate
				WHERE rangefrom<='$MyTaxableIncome'
				AND rangeto>='$MyTaxableIncome'";
				$result = DB_query($sql, $db);
				$myrow = DB_fetch_array($result);
				$MyFixTax=$myrow['fixtax'];
				$MyTaxAmt=$MyFixTax+(($MyTaxableIncome-$myrow['fixtaxableamount'])*($myrow['percentofexcessamount']/100));
	} else {
				$MyTaxAmt=0;
	}
	return $MyTaxAmt;
}

Function GetHDMFEE($GrossIncome, &$db){
	$sql = "SELECT rangefrom,rangeto,dedtypeee,employeeshare
			FROM prlhdmftable
			WHERE rangefrom<='$GrossIncome'
			AND rangeto>='$GrossIncome'";
			$result = DB_query($sql, $db);
			$myrow = DB_fetch_array($result);
			if ($myrow['dedtypeee']=='Fixed') {
				$MyHDMFAmt= $myrow['employeeshare'];
			} elseif ($myrow['dedtypeee']=='Percentage') {
				$MyHDMFAmt=$GrossIncome * ($myrow['employeeshare']/100);
			} else {
				$MyHDMFAmt= 0;
			}	
		    return $MyHDMFAmt;
}

Function GetHDMFER($GrossIncome, &$db){
	$sql = "SELECT rangefrom,rangeto,dedtypeer,employershare
			FROM prlhdmftable
			WHERE rangefrom<='$GrossIncome'
			AND rangeto>='$GrossIncome'";
			$result = DB_query($sql, $db);
			$myrow = DB_fetch_array($result);
			if ($myrow['dedtypeer']=='Fixed') {
				$MyHDMFAmt= $myrow['employeeshare'];
			} elseif ($myrow['dedtypeer']=='Percentage') {
				$MyHDMFAmt=$GrossIncome * ($myrow['employershare']/100);
			} else {
				$MyHDMFAmt= 0;
			}	
		    return $MyHDMFAmt;
}



Function GetTaxStatusRow($TaxID, &$db,$PayRow){
		$sql = "SELECT taxstatusid,taxstatusdescription,personalexemption,additionalexemption,totalexemption
			FROM prltaxstatus
			WHERE taxstatusid='$TaxID'";
			$result = DB_query($sql, $db);
			$myrow = DB_fetch_array($result);
            return $myrow[$PayRow];
}


Function GetPayrollRow($PayrollID, &$db,$PayRow){
//payrollid - 0, and so on
/*Gets the GL Codes relevant to the stock item account from the stock category record */
		//$sql = "SELECT payrollidyrolldesc,payperiodid,startdate,enddate,fsmonth,fsyear,payclosed
		$sql = "SELECT payrollid,payrolldesc,payperiodid,startdate,enddate,fsmonth,fsyear,deductsss,deducthdmf,deductphilhealth,payclosed
			FROM prlpayrollperiod
			WHERE payrollid = '$PayrollID'";
			$result = DB_query($sql, $db);
			$myrow = DB_fetch_array($result);
			if ($PayRow==11) return $myrow['payclosed']; 
            return $myrow[$PayRow];
}


Function GetEmpRow($EmpID, &$db,$EmpRow){
		$sql = "SELECT paytype,payperiodid,periodrate,hourlyrate,marital,taxstatusid,employmentid,active,ssnumber,hdmfnumber,phnumber,taxactnumber,atmnumber
			FROM prlemployeemaster
			WHERE employeeid= '$EmpID'";
			$result = DB_query($sql, $db);
			$myrow = DB_fetch_array($result);
			if ($EmpRow==35) return $myrow['taxstatusid'];
			if ($EmpRow==29) return $myrow['paytype'];
			if ($EmpRow==19) return $myrow['atmnumber'];
			if ($EmpRow==20) return $myrow['ssnumber'];
			if ($EmpRow==21) return $myrow['hdmfnumber'];
			if ($EmpRow==22) return $myrow['phnumber'];
			if ($EmpRow==23) return $myrow['taxactnumber'];
            return $myrow[$PayRow];
}

Function GetName($EmpID, &$db){
		$sql = "SELECT lastname,firstname,middlename
			FROM prlemployeemaster
			WHERE employeeid= '$EmpID'";
			$result = DB_query($sql, $db);
			$myrow = DB_fetch_array($result);
            return $myrow['lastname'].', '.$myrow['firstname'].', '.$myrow['middlename'];
}


Function GetSSSRow($SSSGross, &$db){
		$sql = "SELECT rangefrom,rangeto,salarycredit,employerss,employerec,employeess,total
			FROM prlsstable
			WHERE rangefrom<='$SSSGross'
			AND rangeto>='$SSSGross'";
			$result = DB_query($sql, $db);
			$myrow = DB_fetch_array($result);
		    return $myrow;
}

Function GetPHRow($PHGross, &$db){
		$sql = "SELECT rangefrom,rangeto,salarycredit,employerph,employerec,employeeph,total
			FROM prlphilhealth
			WHERE rangefrom<='$PHGross'
			AND rangeto>='$PHGross'";
			$result = DB_query($sql, $db);
			$myrow = DB_fetch_array($result);
		    return $myrow;
}




function GetMonthStr($Mos)
{
		if ($Mos ==1) {
				$MosStr='January';
		} elseif ($Mos ==2){
				$MosStr='February';
		} elseif ($Mos ==3){
				$MosStr='March';
		} elseif ($Mos ==4){
				$MosStr='April';
		} elseif ($Mos ==5){
				$MosStr='May';				
		} elseif ($Mos ==6){
				$MosStr='June';				
		} elseif ($Mos ==7){
				$MosStr='July';				
		} elseif ($Mos ==8){
				$MosStr='August';				
		} elseif ($Mos ==9){
				$MosStr='September';				
		} elseif ($Mos ==10){
				$MosStr='October';				
		} elseif ($Mos ==11){
				$MosStr='November';				
		} elseif ($Mos ==12){
				$MosStr='December';				
		} else {
				$MosStr='Month';
		}  
      return $MosStr;
}

//unused
function monthoption($Mos)
{
   $MosStr= GetMonthStr($Mos);
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
   return 1;
}

//unsed
function yearoption($FSYear)
{
	if (($FSYear==0) or ($FSYear==null)) {
	    echo '<OPTION SELECTED VALUE=0>'. _('Year');
	} else {
	    echo '<OPTION SELECTED VALUE=$FSYear>'. _($FSYear);
	}
	for ($yy=2006;$yy<=2015;$yy++)
                    {
                        echo "<option value=$yy>$yy</option>\n";
                    	
                    }

  return 1;
}




//unused
function makedropdown($optionid,$optionname,$table)
{
	   // Query to choose all departments
	   $querydrop = "select $optionid,$optionname from $table order by $optionname"; 
       $resultdrop= MYSQL_QUERY($querydrop);
       $numberdrop = MYSQL_NUMROWS($resultdrop);           

           if ($numberdrop==0)
           {
           
               echo "<option value=\"\" selected>No Data</option>";	
           	
           }
           else if ($numberdrop>0)
           {
           
              $i=0;
              
                echo "<option value=\"\">Please Choose</option>";
                
                while ($i<$numberdrop)
                {
             
                       $opid = mysql_result($resultdrop,$i,"$optionid");
           	          $opname = mysql_result($resultdrop,$i,"$optionname");
                
                          echo "<option value=\"$opid\">$opname</option>\n";
                
                          $i++;

                }
       	
           }
           
           return 0;
}




?>