CREATE DATABASE anahaw;
use anahaw;

--
-- Table structure for table 'prlemphdmffile'
--
CREATE TABLE prlemphdmffile (
  counterindex int(11) NOT NULL auto_increment,
  payrollid varchar(10) NOT NULL default '',
  employeeid varchar(10) NOT NULL default '',
  grosspay decimal(12,2) NOT NULL default '0.00',
  employerhdmf decimal(12,2) NOT NULL default '0.00',  
  employeehdmf decimal(12,2) NOT NULL default '0.00',  
  total decimal(12,2) NOT NULL default '0.00',
  fsmonth tinyint(4) NOT NULL default '0',
  fsyear double NOT NULL default '0', 
  PRIMARY KEY  (counterindex)
);

--
-- Table structure for table 'prlemptaxfile'
--
CREATE TABLE prlemptaxfile (
  counterindex int(11) NOT NULL auto_increment,
  payrollid varchar(10) NOT NULL default '',
  employeeid varchar(10) NOT NULL default '',
  taxableincome decimal(12,2) NOT NULL default '0.00', 
  tax decimal(12,2) NOT NULL default '0.00',
  fsmonth tinyint(4) NOT NULL default '0',
  fsyear double NOT NULL default '0', 
  PRIMARY KEY  (counterindex)
);


--
-- Table structure for table 'prlempphfile'
--
CREATE TABLE prlempphfile (
  counterindex int(11) NOT NULL auto_increment,
  payrollid varchar(10) NOT NULL default '',
  employeeid varchar(10) NOT NULL default '',
  grosspay decimal(12,2) NOT NULL default '0.00',
  rangefrom decimal(12,2) NOT NULL default '0.00',
  rangeto decimal(12,2) NOT NULL default '0.00',  
  salarycredit decimal(12,2) NOT NULL default '0.00',  
  employerph decimal(12,2) NOT NULL default '0.00',
  employerec decimal(12,2) NOT NULL default '0.00',  
  employeeph decimal(12,2) NOT NULL default '0.00',  
  total decimal(12,2) NOT NULL default '0.00',
  fsmonth tinyint(4) NOT NULL default '0',
  fsyear double NOT NULL default '0', 
  PRIMARY KEY  (counterindex)
);

--
-- Table structure for table 'prlempsssfile'
--
CREATE TABLE prlempsssfile (
  counterindex int(11) NOT NULL auto_increment,
  payrollid varchar(10) NOT NULL default '',
  employeeid varchar(10) NOT NULL default '',
  grosspay decimal(12,2) NOT NULL default '0.00',
  rangefrom decimal(12,2) NOT NULL default '0.00',
  rangeto decimal(12,2) NOT NULL default '0.00',  
  salarycredit decimal(12,2) NOT NULL default '0.00',  
  employerss decimal(12,2) NOT NULL default '0.00',
  employerec decimal(12,2) NOT NULL default '0.00',  
  employeess decimal(12,2) NOT NULL default '0.00',  
  total decimal(12,2) NOT NULL default '0.00',
  fsmonth tinyint(4) NOT NULL default '0',
  fsyear double NOT NULL default '0', 
  PRIMARY KEY  (counterindex)
);



--
-- Table structure for table 'prlphilhealth'
--
CREATE TABLE prlphilhealth (
  bracket tinyint(4) NOT NULL default '0',
  rangefrom decimal(12,2) NOT NULL default '0.00',
  rangeto decimal(12,2) NOT NULL default '0.00',  
  salarycredit decimal(12,2) NOT NULL default '0.00',  
  employerph decimal(12,2) NOT NULL default '0.00',
  employerec decimal(12,2) NOT NULL default '0.00',  
  employeeph decimal(12,2) NOT NULL default '0.00',  
  total decimal(12,2) NOT NULL default '0.00',  
  PRIMARY KEY  (bracket)
);


--
-- Table structure for table 'prlhdmf'
--
CREATE TABLE prlhdmftable (
  bracket tinyint(4) NOT NULL default '0',
  rangefrom decimal(12,2) NOT NULL default '0.00',
  rangeto decimal(12,2) NOT NULL default '0.00',  
  dedtypeer varchar(10) NOT NULL default '',  
  employershare decimal(12,2) NOT NULL default '0.00',
  dedtypeee varchar(10) NOT NULL default '',  
  employeeshare decimal(12,2) NOT NULL default '0.00',  
  PRIMARY KEY  (bracket)
);


--
-- Table structure for table 'prlsstable'
--
CREATE TABLE prlsstable (
  bracket tinyint(4) NOT NULL default '0',
  rangefrom decimal(12,2) NOT NULL default '0.00',
  rangeto decimal(12,2) NOT NULL default '0.00',  
  salarycredit decimal(12,2) NOT NULL default '0.00',  
  employerss decimal(12,2) NOT NULL default '0.00',
  employerec decimal(12,2) NOT NULL default '0.00',  
  employeess decimal(12,2) NOT NULL default '0.00',  
  total decimal(12,2) NOT NULL default '0.00',  
  PRIMARY KEY  (bracket)
);





-- Dumping data for payroll data 'prlpayrolldata'
CREATE TABLE prlpayrolltrans (
  counterindex int(11) NOT NULL auto_increment,
  payrollid varchar(10) NULL default '',
  employeeid varchar(10) NOT NULL default '',
  reghrs decimal(12,2) NOT NULL default '0.00',
  absenthrs decimal(12,2) NOT NULL default '0.00',
  latehrs decimal(12,2) NOT NULL default '0.00',
  periodrate decimal(12,2) NOT NULL default '0.00',
  hourlyrate decimal(12,2) NOT NULL default '0.00', 
  basicpay decimal(12,2) NOT NULL default '0.00',
  othincome decimal(12,2) NOT NULL default '0.00',
  absent decimal(12,2) NOT NULL default '0.00',
  late   decimal(12,2) NOT NULL default '0.00',
  otpay decimal(12,2) NOT NULL default '0.00',
  grosspay decimal(12,2) NOT NULL default '0.00', 
  loandeduction decimal(12,2) NOT NULL default '0.00',
  sss decimal(12,2) NOT NULL default '0.00',
  hdmf decimal(12,2) NOT NULL default '0.00',
  philhealth decimal(12,2) NOT NULL default '0.00',
  tax decimal(12,2) NOT NULL default '0.00',
  otherdeduction decimal(12,2) NOT NULL default '0.00',
  totaldeduction decimal(12,2) NOT NULL default '0.00',
  netpay decimal(12,2) NOT NULL default '0.00',
  fsmonth tinyint(4) NOT NULL default '0',
  fsyear double NOT NULL default '0',
  PRIMARY KEY  (counterindex)
);


-- Dumping data for payroll data 'prlpayrolldata'
CREATE TABLE prldailytrans (
  counterindex int(11) NOT NULL auto_increment,
  rtref varchar(11) NOT NULL default '',
  rtdesc varchar(40) NOT NULL default '',
  rtdate date NOT NULL default '0000-00-00',
  payrollid varchar(10) NOT NULL default '',
  employeeid varchar(10) NOT NULL default '',
  reghrs decimal(12,2) NOT NULL default '0.00',
  absenthrs decimal(12,2) NOT NULL default '0.00',
  latehrs decimal(12,2) NOT NULL default '0.00',
  regamt decimal(12,2) NOT NULL default '0.00',
  absentamt decimal(12,2) NOT NULL default '0.00',
  lateamt decimal(12,2) NOT NULL default '0.00',  
  PRIMARY KEY  (counterindex),
  KEY RTDate (rtdate)
);




-- Dumping data for create payroll 'prlperiod'
-- payperiodid 'monthly/weekly'

CREATE TABLE prlpayrollperiod (
  payrollid varchar(10) NULL default '',
  payrolldesc varchar(40) NOT NULL default '',
  payperiodid tinyint(4) NOT NULL default '0',
  startdate date NOT NULL default '0000-00-00',
  enddate date NOT NULL default '0000-00-00',
  fsmonth tinyint(4) NOT NULL default '0',
  fsyear double NOT NULL default '0',
  deductsss tinyint(4) NOT NULL default '0',
  deducthdmf tinyint(4) NOT NULL default '0',
  deductphilhealth tinyint(4) NOT NULL default '0',
  payclosed tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (payrollid)
);

--
-- Table structure for table 'prlemployee'
-- paytype 0>salary 1>hourly
-- payperiodid 'monthly/weekly'
CREATE TABLE prlemployeemaster (
  employeeid varchar(10) NOT NULL default '',
  lastname varchar(40) NOT NULL default '',
  firstname varchar(40) NOT NULL default '',
  middlename varchar(40) NOT NULL default '',
  address1 varchar(100) NOT NULL default '',
  address2 varchar(100) NOT NULL default '',  
  city varchar(50) NOT NULL default '',
  state varchar(20) NOT NULL default '',
  zip varchar(15) NOT NULL default '',
  country varchar(40) NOT NULL default '',
  gender varchar(15) NOT NULL default '',
  phone1 varchar(20) NOT NULL default '',
  phone1comment varchar(20) NOT NULL default '',
  phone2 varchar(20) NOT NULL default '',
  phone2comment varchar(20) NOT NULL default '',
  email1 varchar(50) NOT NULL default '',
  email1comment varchar(20) NOT NULL default '',
  email2 varchar(50) NOT NULL default '',
  email2comment varchar(20) NOT NULL default '',
  atmnumber varchar(20) NOT NULL default '', 
  ssnumber varchar(20) NOT NULL default '',
  hdmfnumber varchar(20) NOT NULL default '',
  phnumber varchar(15) NOT NULL default '',
  taxactnumber varchar(15) NOT NULL default '',
  birthdate date NOT NULL default '0000-00-00',
  hiredate date NOT NULL default '0000-00-00',
  terminatedate date NOT NULL default '0000-00-00',
  retireddate date NOT NULL default '0000-00-00', 
  paytype tinyint(4) NOT NULL default '0',
  payperiodid tinyint(4) NOT NULL default '0',
  periodrate decimal(12,2) NOT NULL default '0.00',
  hourlyrate decimal(12,2) NOT NULL default '0.00',
  glactcode int(11) NOT NULL default '0',
  marital varchar(20) NOT NULL default '',
  taxstatusid varchar(10) NULL default '',
  employmentid tinyint(4) NOT NULL default '0',
  active int(11) NOT NULL default '0',
  costcenterid varchar(10) NOT NULL default '',
  position varchar(40) NOT NULL default '',
  PRIMARY KEY  (employeeid),
  KEY EmployeeName (lastname,firstname)
);


-- Dumping data for table 'prlloanfile'
-- data entry
CREATE TABLE prlloanfile (
  loanfileid varchar(10) NOT NULL default '',
  loanfiledesc varchar(40) NOT NULL default '',
  employeeid varchar(10) NOT NULL default '',
  loandate date NOT NULL default '0000-00-00',
  loantableid tinyint(4) NOT NULL default '0',
  loanamount decimal(12,2) NOT NULL default '0.00',
  amortization decimal(12,2) NOT NULL default '0.00',
  startdeduction date NOT NULL default '0000-00-00',
  ytddeduction decimal(12,2) NOT NULL default '0.00',
  loanbalance decimal(12,2) NOT NULL default '0.00',
  accountcode int(11) NOT NULL default '0',
  PRIMARY KEY  (loanfileid),
  KEY LoanDate (loandate)
);





-- Dumping data for table 'prlemployeeloandeduction'
-- compute payroll
CREATE TABLE prlloandeduction (
  counterindex int(11) NOT NULL auto_increment,
  payrollid varchar(10) NULL default '',
  employeeid varchar(10) NOT NULL default '',
  loantableid tinyint(4) NOT NULL default '0',
  amount decimal(12,2) NOT NULL default '0.00',
  accountcode int(11) NOT NULL default '0',
  PRIMARY KEY  (counterindex)
)

-- Dumping data for table 'loantable'
--
CREATE TABLE prlloantable (
  loantableid tinyint(4) NOT NULL default '0',
  loantabledesc varchar(25) NOT NULL default '',
  accountcode int(11) NOT NULL default '0',
  PRIMARY KEY  (loantableid)
)

-- Dumping data for table 'prlothincfile'
-- data entry
CREATE TABLE prlothincfile (
  counterindex int(11) NOT NULL auto_increment,
  othfileref varchar(10) NOT NULL default '',
  othfiledesc varchar(40) NOT NULL default '',
  employeeid varchar(10) NOT NULL default '',
  othdate date NOT NULL default '0000-00-00',
  othincid tinyint(4) NOT NULL default '0',
  othincamount decimal(12,2) NOT NULL default '0.00',
  accountcode int(11) NOT NULL default '0',
  PRIMARY KEY  (counterindex),
  KEY OthDate (othdate)
)

-- Dumping data for table 'prlothinctable'
CREATE TABLE prlothinctable (
  othincid tinyint(4) NOT NULL default '0',
  othincdesc varchar(25) NOT NULL default '',
  taxable varchar(10) NOT NULL default '',
  accountcode int(11) NOT NULL default '0',
  PRIMARY KEY  (othincid)
)


-- Dumping data for table 'prlottrans'
CREATE TABLE prlottrans (
  counterindex int(11) NOT NULL auto_increment,
  payrollid varchar(10) NULL default '',
  otref varchar(11) NOT NULL default '',
  otdesc varchar(40) NOT NULL default '',
  otdate date NOT NULL default '0000-00-00',
  overtimeid tinyint(4) NOT NULL default '0',
  employeeid varchar(10) NOT NULL default '',
  othours double NOT NULL default '0',
  joborder varchar(10) NOT NULL default '',
  accountcode int(11) NOT NULL default '0',
  otamount double NOT NULL default '0',
  PRIMARY KEY  (counterindex),
  KEY Account (accountcode),
  KEY OTDate (otdate)
)




--
-- Dumping data for table `prlpayperiod`
-- (monthly,semi-monthly,weekly payment)
CREATE TABLE prlpayperiod (
  payperiodid tinyint(4) NOT NULL default '0',
  payperioddesc varchar(15) NOT NULL default '',
  numberofpayday int(11) NOT NULL default '0',  
  PRIMARY KEY  (payperiodid)
)



--
-- Table structure for table 'prltaxstatus'
--
CREATE TABLE prltaxstatus (
  taxstatusid varchar(10) NULL default '',
  taxstatusdescription varchar(40) NOT NULL default '',
  personalexemption decimal(12,2) NOT NULL default '0.00',
  additionalexemption decimal(12,2) NOT NULL default '0.00',
  totalexemption decimal(12,2) NOT NULL default '0.00',
  PRIMARY KEY  (taxstatusid)
)

--
-- Table structure for table 'prltaxtablerate'
--
CREATE TABLE prltaxtablerate (
  bracket tinyint(4) NOT NULL default '0',
  rangefrom decimal(12,2) NOT NULL default '0.00',
  rangeto decimal(12,2) NOT NULL default '0.00',  
  fixtaxableamount decimal(12,2) NOT NULL default '0.00',  
  fixtax decimal(12,2) NOT NULL default '0.00',    
  percentofexcessamount double NOT NULL default '1',
  PRIMARY KEY  (bracket)
)



-- Dumping data for table 'overtimetable'
CREATE TABLE prlovertimetable (
  overtimeid tinyint(4) NOT NULL default '0',
  overtimedesc varchar(40) NOT NULL default '',
  overtimerate decimal(6,2) NOT NULL default '0.00',
  accountcode int(11) NOT NULL default '0',
  PRIMARY KEY  (overtimeid)
)


CREATE TABLE prlemploymentstatus (
  employmentid tinyint(4) NOT NULL default '0',
  employmentdesc varchar(15) NOT NULL default '',
  PRIMARY KEY  (employmentid)
)

--
-- Table structure for table `chartmaster`
--

CREATE TABLE `chartmaster` (
  `accountcode` int(11) NOT NULL default '0',
  `accountname` char(50) NOT NULL default '',
  `group_` char(30) NOT NULL default '',
  PRIMARY KEY  (`accountcode`),
  KEY `AccountCode` (`accountcode`),
  KEY `AccountName` (`accountname`),
  KEY `Group_` (`group_`)
)


--
-- Table structure for table `workcentres`

CREATE TABLE workcentres (
  code char(5) NOT NULL default '',
  location char(5) NOT NULL default '',
  description char(20) NOT NULL default '',
  capacity double NOT NULL default '1',
  overheadperhour decimal(10,0) NOT NULL default '0',
  overheadrecoveryact int(11) NOT NULL default '0',
  setuphrs decimal(10,0) NOT NULL default '0',
  PRIMARY KEY  (code)
)

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `currency` char(20) NOT NULL default '',
  `currabrev` char(3) NOT NULL default '',
  `country` char(50) NOT NULL default '',
  `hundredsname` char(15) NOT NULL default 'Cents',
  `rate` double NOT NULL default '1',
  PRIMARY KEY  (`currabrev`),
  KEY `Country` (`country`)
)

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `coycode` int(11) NOT NULL default '1',
  `coyname` varchar(50) NOT NULL default '',
  `gstno` varchar(20) NOT NULL default '',
  `companynumber` varchar(20) NOT NULL default '0',
  `regoffice1` varchar(40) NOT NULL default '',
  `regoffice2` varchar(40) NOT NULL default '',
  `regoffice3` varchar(40) NOT NULL default '',
  `regoffice4` varchar(40) NOT NULL default '',
  `regoffice5` varchar(20) NOT NULL default '',
  `regoffice6` varchar(15) NOT NULL default '',
  `telephone` varchar(25) NOT NULL default '',
  `fax` varchar(25) NOT NULL default '',
  `email` varchar(55) NOT NULL default '',
  `currencydefault` varchar(4) NOT NULL default '',
  `debtorsact` int(11) NOT NULL default '70000',
  `pytdiscountact` int(11) NOT NULL default '55000',
  `creditorsact` int(11) NOT NULL default '80000',
  `payrollact` int(11) NOT NULL default '84000',
  `grnact` int(11) NOT NULL default '72000',
  `exchangediffact` int(11) NOT NULL default '65000',
  `purchasesexchangediffact` int(11) NOT NULL default '0',
  `retainedearnings` int(11) NOT NULL default '90000',
  `gllink_debtors` tinyint(1) default '1',
  `gllink_creditors` tinyint(1) default '1',
  `gllink_stock` tinyint(1) default '1',
  `freightact` int(11) NOT NULL default '0',
  PRIMARY KEY  (`coycode`)
)

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `confname` varchar(35) NOT NULL default '',
  `confvalue` text NOT NULL,
  PRIMARY KEY  (`confname`)
)


--
-- Table structure for table `www_users`
--

CREATE TABLE `www_users` (
  `userid` varchar(20) NOT NULL default '',
  `password` text NOT NULL,
  `realname` varchar(35) NOT NULL default '',
  `customerid` varchar(10) NOT NULL default '',
  `phone` varchar(30) NOT NULL default '',
  `email` varchar(55) default NULL,
  `defaultlocation` varchar(5) NOT NULL default '',
  `fullaccess` int(11) NOT NULL default '1',
  `lastvisitdate` datetime default NULL,
  `branchcode` varchar(10) NOT NULL default '',
  `pagesize` varchar(20) NOT NULL default 'A4',
  `modulesallowed` varchar(20) NOT NULL default '',
  `blocked` tinyint(4) NOT NULL default '0',
  `displayrecordsmax` int(11) NOT NULL default '0',
  `theme` varchar(30) NOT NULL default 'fresh',
  `language` varchar(5) NOT NULL default 'en_GB',
  PRIMARY KEY  (`userid`),
  KEY `CustomerID` (`customerid`),
  KEY `DefaultLocation` (`defaultlocation`)
)


--
-- Table structure for table `securitytokens`
--

CREATE TABLE `securitytokens` (
  `tokenid` int(11) NOT NULL default '0',
  `tokenname` text NOT NULL,
  PRIMARY KEY  (`tokenid`)
)

--
-- Table structure for table `securityroles`
--

CREATE TABLE `securityroles` (
  `secroleid` int(11) NOT NULL auto_increment,
  `secrolename` text NOT NULL,
  PRIMARY KEY  (`secroleid`)
)

--
-- Table structure for table `securitygroups`
--

CREATE TABLE `securitygroups` (
  `secroleid` int(11) NOT NULL default '0',
  `tokenid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`secroleid`,`tokenid`),
  KEY `secroleid` (`secroleid`),
  KEY `tokenid` (`tokenid`),
  CONSTRAINT `securitygroups_secroleid_fk` FOREIGN KEY (`secroleid`) REFERENCES `securityroles` (`secroleid`),
  CONSTRAINT `securitygroups_tokenid_fk` FOREIGN KEY (`tokenid`) REFERENCES `securitytokens` (`tokenid`)
)

--
-- Dumping data for table `prlpayrollperiod`
--
INSERT INTO prlpayrollperiod VALUES ('10', 'Semi-Monthly Payroll (June 1-15, 2006)', 10, '2006-06-01', '2006-06-15', 6, 2006, 0, 0, 0, 0);

--
-- Dumping data for table `prlemployeemaster`
--

INSERT INTO prlemployeemaster VALUES('ABD123', 'Alaba', 'Lyn', '', '', '', '', '', '', '', 'M', '', '', '', '', '', '', '', '', '', '', '', '', '', '1901-01-01', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '8000.00', '80.00', 0, '', 'HF', 10, 0, 'ACT', '');
INSERT INTO prlemployeemaster VALUES('AGM123', 'Alerto', 'Gil', 'M', '', '', '', '', '', '', 'M', '', '', '', '', '', '', '', '', '', '', '', '', '', '1901-01-01', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '6800.00', '68.00', 0, 'Married', 'ME4', 10, 0, 'EDP', '');
INSERT INTO prlemployeemaster VALUES('AL1234', 'Ajoc', 'Leo', '', '', '', '', '', '', '', 'M', '', '', '', '', '', '', '', '', '', '', '', '', '', '1901-01-01', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '7000.00', '70.00', 0, 'Married', 'ME2', 10, 0, 'ACT', '');
INSERT INTO prlemployeemaster VALUES('BJE', 'Bautista', 'Jenny', '', '', '', '', '', '', '', 'M', '', '', '', '', '', '', '', '', '', '', '', '', '', '1907-03-07', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '6500.00', '65.00', 0, 'Single', 'S', 10, 0, 'ACT', '');
INSERT INTO prlemployeemaster VALUES('CAJ456', 'Calubag', 'Daylin', '', '', '', '', '', '', '', 'F', '', '', '', '', '', '', '', '', '', '', '', '', '', '1978-04-27', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '12000.00', '120.00', 0, 'Single', 'HF', 10, 0, '0', '');
INSERT INTO prlemployeemaster VALUES('CAL123', 'Cantilado', 'Al', '', '', '', '', '', '', '', 'M', '', '', '', '', '', '', '', '', '', '', '', '', '', '1908-02-05', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '11500.00', '115.00', 0, '', 'S', 10, 0, 'MAR', '');
INSERT INTO prlemployeemaster VALUES('CLB123', 'Campos', 'Leo', '', '', '', '', '', '', '', 'M', '', '', '', '', '', '', '', '', '', '', '', '', '', '1908-07-09', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '7700.00', '77.00', 0, '', 'ME', 10, 0, 'ACT', '');
INSERT INTO prlemployeemaster VALUES('CWC123', 'Calinawan', 'Wilfredo', '', '', '', '', '', '', '', 'M', '', '', '', '', '', '', '', '', '', '', '', '', '', '1905-04-06', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '9000.00', '90.00', 0, '', 'HF', 10, 0, 'EDP', '');
INSERT INTO prlemployeemaster VALUES('ENT100', 'Tejada', 'Eliseo', '', 'Address1', 'Address2', 'City', 'State', '1234', 'Philippines', 'M', '', '', '', '', '', '', '', '', '1234567', '1234567', '1234567', '1234567', '1234567', '1970-06-14', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '10000.00', '100.00', 0, 'Married', 'ME1', 30, 0, '0', 'Accountant');
INSERT INTO prlemployeemaster VALUES('TAD100', 'Tulang', 'Dodong', '', '', '', '', '', '', '', 'M', '', '', '', '', '', '', '', '', '', '', '', '', '', '1901-01-01', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '6000.00', '60.00', 0, '', 'S', 10, 0, 'FIN', '');
INSERT INTO prlemployeemaster VALUES('TDC', 'Tejada', 'Daisy', 'C', '', '', '', '', '', '', 'M', '', '', '', '', '', '', '', '', '', '', '', '', '', '1901-01-01', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '7500.00', '75.00', 0, 'Married', 'ME', 10, 0, 'SAL', '');


--
-- Dumping data for table `securitytokens`
--

INSERT INTO `securitytokens` VALUES (1,'Order Entry/Inquiries customer access only');
INSERT INTO `securitytokens` VALUES (2,'Basic Reports and Inquiries with selection options');
INSERT INTO `securitytokens` VALUES (3,'Credit notes and AR management');
INSERT INTO `securitytokens` VALUES (4,'Purchasing data/PO Entry/Reorder Levels');
INSERT INTO `securitytokens` VALUES (5,'Accounts Payable');
INSERT INTO `securitytokens` VALUES (6,'Not Used');
INSERT INTO `securitytokens` VALUES (7,'Bank Reconciliations');
INSERT INTO `securitytokens` VALUES (8,'General ledger reports/inquiries');
INSERT INTO `securitytokens` VALUES (9,'Not Used');
INSERT INTO `securitytokens` VALUES (10,'General Ledger Maintenance, stock valuation & Configuration');
INSERT INTO `securitytokens` VALUES (11,'Inventory Management and Pricing');
INSERT INTO `securitytokens` VALUES (12,'Unknown');
INSERT INTO `securitytokens` VALUES (13,'Unknown');
INSERT INTO `securitytokens` VALUES (14,'Unknown');
INSERT INTO `securitytokens` VALUES (15,'User Management and System Administration');

--
-- Dumping data for table `securityroles`
--

INSERT INTO `securityroles` VALUES (1,'Inquiries/Order Entry');
INSERT INTO `securityroles` VALUES (2,'Manufac/Stock Admin');
INSERT INTO `securityroles` VALUES (3,'Purchasing Officer');
INSERT INTO `securityroles` VALUES (4,'AP Clerk');
INSERT INTO `securityroles` VALUES (5,'AR Clerk');
INSERT INTO `securityroles` VALUES (6,'Accountant');
INSERT INTO `securityroles` VALUES (7,'Customer Log On Only');
INSERT INTO `securityroles` VALUES (8,'System Administrator');

--
-- Dumping data for table `securitygroups`
--

INSERT INTO `securitygroups` VALUES (1,1);
INSERT INTO `securitygroups` VALUES (1,2);
INSERT INTO `securitygroups` VALUES (2,1);
INSERT INTO `securitygroups` VALUES (2,2);
INSERT INTO `securitygroups` VALUES (2,11);
INSERT INTO `securitygroups` VALUES (3,1);
INSERT INTO `securitygroups` VALUES (3,2);
INSERT INTO `securitygroups` VALUES (3,3);
INSERT INTO `securitygroups` VALUES (3,4);
INSERT INTO `securitygroups` VALUES (3,5);
INSERT INTO `securitygroups` VALUES (3,11);
INSERT INTO `securitygroups` VALUES (4,1);
INSERT INTO `securitygroups` VALUES (4,2);
INSERT INTO `securitygroups` VALUES (4,5);
INSERT INTO `securitygroups` VALUES (5,1);
INSERT INTO `securitygroups` VALUES (5,2);
INSERT INTO `securitygroups` VALUES (5,3);
INSERT INTO `securitygroups` VALUES (5,11);
INSERT INTO `securitygroups` VALUES (6,1);
INSERT INTO `securitygroups` VALUES (6,2);
INSERT INTO `securitygroups` VALUES (6,3);
INSERT INTO `securitygroups` VALUES (6,4);
INSERT INTO `securitygroups` VALUES (6,5);
INSERT INTO `securitygroups` VALUES (6,6);
INSERT INTO `securitygroups` VALUES (6,7);
INSERT INTO `securitygroups` VALUES (6,8);
INSERT INTO `securitygroups` VALUES (6,9);
INSERT INTO `securitygroups` VALUES (6,10);
INSERT INTO `securitygroups` VALUES (6,11);
INSERT INTO `securitygroups` VALUES (7,1);
INSERT INTO `securitygroups` VALUES (8,1);
INSERT INTO `securitygroups` VALUES (8,2);
INSERT INTO `securitygroups` VALUES (8,3);
INSERT INTO `securitygroups` VALUES (8,4);
INSERT INTO `securitygroups` VALUES (8,5);
INSERT INTO `securitygroups` VALUES (8,6);
INSERT INTO `securitygroups` VALUES (8,7);
INSERT INTO `securitygroups` VALUES (8,8);
INSERT INTO `securitygroups` VALUES (8,9);
INSERT INTO `securitygroups` VALUES (8,10);
INSERT INTO `securitygroups` VALUES (8,11);
INSERT INTO `securitygroups` VALUES (8,12);
INSERT INTO `securitygroups` VALUES (8,13);
INSERT INTO `securitygroups` VALUES (8,14);
INSERT INTO `securitygroups` VALUES (8,15);






--
-- Dumping data for table `workcentres`
--

INSERT INTO `workcentres` VALUES ('ASS','TOR','Assembly',1,'50',560000,'0');
INSERT INTO `workcentres` VALUES ('FIN','','Finishing',1,'50',560000,'0');
INSERT INTO `workcentres` VALUES ('SAL','','Sales',1,'50',560000,'0');
INSERT INTO `workcentres` VALUES ('MAR','','Marketing',1,'50',560000,'0');
INSERT INTO `workcentres` VALUES ('ACT','','Accounting',1,'50',560000,'0');
INSERT INTO `workcentres` VALUES ('EDP','','EDP',1,'50',560000,'0');
INSERT INTO `workcentres` VALUES ('QA','','Quality Control',1,'50',560000,'0');

--
-- Dumping data for table `chartmaster`
--


INSERT INTO `chartmaster` VALUES (1,'Default Sales/Discounts','Sales');
INSERT INTO `chartmaster` VALUES (1010,'Petty Cash','Current Assets');
INSERT INTO `chartmaster` VALUES (1020,'Cash on Hand','Current Assets');
INSERT INTO `chartmaster` VALUES (1030,'Cheque Accounts','Current Assets');
INSERT INTO `chartmaster` VALUES (1040,'Savings Accounts','Current Assets');
INSERT INTO `chartmaster` VALUES (1050,'Payroll Accounts','Current Assets');
INSERT INTO `chartmaster` VALUES (1060,'Special Accounts','Current Assets');
INSERT INTO `chartmaster` VALUES (1070,'Money Market Investments','Current Assets');
INSERT INTO `chartmaster` VALUES (1080,'Short-Term Investments (< 90 days)','Current Assets');
INSERT INTO `chartmaster` VALUES (1090,'Interest Receivable','Current Assets');
INSERT INTO `chartmaster` VALUES (1100,'Accounts Receivable','Current Assets');
INSERT INTO `chartmaster` VALUES (1150,'Allowance for Doubtful Accounts','Current Assets');
INSERT INTO `chartmaster` VALUES (1200,'Notes Receivable','Current Assets');
INSERT INTO `chartmaster` VALUES (1250,'Income Tax Receivable','Current Assets');
INSERT INTO `chartmaster` VALUES (1300,'Prepaid Expenses','Current Assets');
INSERT INTO `chartmaster` VALUES (1350,'Advances','Current Assets');
INSERT INTO `chartmaster` VALUES (1400,'Supplies Inventory','Current Assets');
INSERT INTO `chartmaster` VALUES (1420,'Raw Material Inventory','Current Assets');
INSERT INTO `chartmaster` VALUES (1440,'Work in Progress Inventory','Current Assets');
INSERT INTO `chartmaster` VALUES (1460,'Finished Goods Inventory','Current Assets');
INSERT INTO `chartmaster` VALUES (1500,'Land','Fixed Assets');
INSERT INTO `chartmaster` VALUES (1550,'Bonds','Fixed Assets');
INSERT INTO `chartmaster` VALUES (1600,'Buildings','Fixed Assets');
INSERT INTO `chartmaster` VALUES (1620,'Accumulated Depreciation of Buildings','Fixed Assets');
INSERT INTO `chartmaster` VALUES (1650,'Equipment','Fixed Assets');
INSERT INTO `chartmaster` VALUES (1670,'Accumulated Depreciation of Equipment','Fixed Assets');
INSERT INTO `chartmaster` VALUES (1700,'Furniture & Fixtures','Fixed Assets');
INSERT INTO `chartmaster` VALUES (1710,'Accumulated Depreciation of Furniture & Fixtures','Fixed Assets');
INSERT INTO `chartmaster` VALUES (1720,'Office Equipment','Fixed Assets');
INSERT INTO `chartmaster` VALUES (1730,'Accumulated Depreciation of Office Equipment','Fixed Assets');
INSERT INTO `chartmaster` VALUES (1740,'Software','Fixed Assets');
INSERT INTO `chartmaster` VALUES (1750,'Accumulated Depreciation of Software','Fixed Assets');
INSERT INTO `chartmaster` VALUES (1760,'Vehicles','Fixed Assets');
INSERT INTO `chartmaster` VALUES (1770,'Accumulated Depreciation Vehicles','Fixed Assets');
INSERT INTO `chartmaster` VALUES (1780,'Other Depreciable Property','Fixed Assets');
INSERT INTO `chartmaster` VALUES (1790,'Accumulated Depreciation of Other Depreciable Prop','Fixed Assets');
INSERT INTO `chartmaster` VALUES (1800,'Patents','Fixed Assets');
INSERT INTO `chartmaster` VALUES (1850,'Goodwill','Fixed Assets');
INSERT INTO `chartmaster` VALUES (1900,'Future Income Tax Receivable','Current Assets');
INSERT INTO `chartmaster` VALUES (2010,'Bank Indedebtedness (overdraft)','Liabilities');
INSERT INTO `chartmaster` VALUES (2020,'Retainers or Advances on Work','Liabilities');
INSERT INTO `chartmaster` VALUES (2050,'Interest Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2100,'Accounts Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2150,'Goods Received Suspense','Liabilities');
INSERT INTO `chartmaster` VALUES (2200,'Short-Term Loan Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2230,'Current Portion of Long-Term Debt Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2250,'Income Tax Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2300,'GST Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2310,'GST Recoverable','Liabilities');
INSERT INTO `chartmaster` VALUES (2320,'PST Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2330,'PST Recoverable (commission)','Liabilities');
INSERT INTO `chartmaster` VALUES (2340,'Payroll Tax Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2350,'Withholding Income Tax Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2360,'Other Taxes Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2400,'Employee Salaries Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2410,'Management Salaries Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2420,'Director / Partner Fees Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2450,'Health Benefits Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2460,'Pension Benefits Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2470,'Canada Pension Plan Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2480,'Employment Insurance Premiums Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2500,'Land Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2550,'Long-Term Bank Loan','Liabilities');
INSERT INTO `chartmaster` VALUES (2560,'Notes Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2600,'Building & Equipment Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2700,'Furnishing & Fixture Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2720,'Office Equipment Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2740,'Vehicle Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2760,'Other Property Payable','Liabilities');
INSERT INTO `chartmaster` VALUES (2800,'Shareholder Loans','Liabilities');
INSERT INTO `chartmaster` VALUES (2900,'Suspense','Liabilities');
INSERT INTO `chartmaster` VALUES (3100,'Capital Stock','Equity');
INSERT INTO `chartmaster` VALUES (3200,'Capital Surplus / Dividends','Equity');
INSERT INTO `chartmaster` VALUES (3300,'Dividend Taxes Payable','Equity');
INSERT INTO `chartmaster` VALUES (3400,'Dividend Taxes Refundable','Equity');
INSERT INTO `chartmaster` VALUES (3500,'Retained Earnings','Equity');
INSERT INTO `chartmaster` VALUES (4100,'Product / Service Sales','Revenue');
INSERT INTO `chartmaster` VALUES (4200,'Sales Exchange Gains/Losses','Revenue');
INSERT INTO `chartmaster` VALUES (4500,'Consulting Services','Revenue');
INSERT INTO `chartmaster` VALUES (4600,'Rentals','Revenue');
INSERT INTO `chartmaster` VALUES (4700,'Finance Charge Income','Revenue');
INSERT INTO `chartmaster` VALUES (4800,'Sales Returns & Allowances','Revenue');
INSERT INTO `chartmaster` VALUES (4900,'Sales Discounts','Revenue');
INSERT INTO `chartmaster` VALUES (5000,'Cost of Sales','Cost of Goods Sold');
INSERT INTO `chartmaster` VALUES (5100,'Production Expenses','Cost of Goods Sold');
INSERT INTO `chartmaster` VALUES (5200,'Purchases Exchange Gains/Losses','Cost of Goods Sold');
INSERT INTO `chartmaster` VALUES (5500,'Direct Labour Costs','Cost of Goods Sold');
INSERT INTO `chartmaster` VALUES (5600,'Freight Charges','Cost of Goods Sold');
INSERT INTO `chartmaster` VALUES (5700,'Inventory Adjustment','Cost of Goods Sold');
INSERT INTO `chartmaster` VALUES (5800,'Purchase Returns & Allowances','Cost of Goods Sold');
INSERT INTO `chartmaster` VALUES (5900,'Purchase Discounts','Cost of Goods Sold');
INSERT INTO `chartmaster` VALUES (6100,'Advertising','Marketing Expenses');
INSERT INTO `chartmaster` VALUES (6150,'Promotion','Marketing Expenses');
INSERT INTO `chartmaster` VALUES (6200,'Communications','Marketing Expenses');
INSERT INTO `chartmaster` VALUES (6250,'Meeting Expenses','Marketing Expenses');
INSERT INTO `chartmaster` VALUES (6300,'Travelling Expenses','Marketing Expenses');
INSERT INTO `chartmaster` VALUES (6400,'Delivery Expenses','Marketing Expenses');
INSERT INTO `chartmaster` VALUES (6500,'Sales Salaries & Commission','Marketing Expenses');
INSERT INTO `chartmaster` VALUES (6550,'Sales Salaries & Commission Deductions','Marketing Expenses');
INSERT INTO `chartmaster` VALUES (6590,'Benefits','Marketing Expenses');
INSERT INTO `chartmaster` VALUES (6600,'Other Selling Expenses','Marketing Expenses');
INSERT INTO `chartmaster` VALUES (6700,'Permits, Licenses & License Fees','Marketing Expenses');
INSERT INTO `chartmaster` VALUES (6800,'Research & Development','Marketing Expenses');
INSERT INTO `chartmaster` VALUES (6900,'Professional Services','Marketing Expenses');
INSERT INTO `chartmaster` VALUES (7020,'Support Salaries & Wages','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7030,'Support Salary & Wage Deductions','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7040,'Management Salaries','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7050,'Management Salary deductions','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7060,'Director / Partner Fees','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7070,'Director / Partner Deductions','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7080,'Payroll Tax','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7090,'Benefits','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7100,'Training & Education Expenses','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7150,'Dues & Subscriptions','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7200,'Accounting Fees','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7210,'Audit Fees','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7220,'Banking Fees','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7230,'Credit Card Fees','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7240,'Consulting Fees','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7260,'Legal Fees','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7280,'Other Professional Fees','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7300,'Business Tax','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7350,'Property Tax','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7390,'Corporation Capital Tax','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7400,'Office Rent','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7450,'Equipment Rental','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7500,'Office Supplies','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7550,'Office Repair & Maintenance','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7600,'Automotive Expenses','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7610,'Communication Expenses','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7620,'Insurance Expenses','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7630,'Postage & Courier Expenses','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7640,'Miscellaneous Expenses','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7650,'Travel Expenses','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7660,'Utilities','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7700,'Ammortization Expenses','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7750,'Depreciation Expenses','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7800,'Interest Expense','Operating Expenses');
INSERT INTO `chartmaster` VALUES (7900,'Bad Debt Expense','Operating Expenses');
INSERT INTO `chartmaster` VALUES (8100,'Gain on Sale of Assets','Other Revenue and Expenses');
INSERT INTO `chartmaster` VALUES (8200,'Interest Income','Other Revenue and Expenses');
INSERT INTO `chartmaster` VALUES (8300,'Recovery on Bad Debt','Other Revenue and Expenses');
INSERT INTO `chartmaster` VALUES (8400,'Other Revenue','Other Revenue and Expenses');
INSERT INTO `chartmaster` VALUES (8500,'Loss on Sale of Assets','Other Revenue and Expenses');
INSERT INTO `chartmaster` VALUES (8600,'Charitable Contributions','Other Revenue and Expenses');
INSERT INTO `chartmaster` VALUES (8900,'Other Expenses','Other Revenue and Expenses');
INSERT INTO `chartmaster` VALUES (9100,'Income Tax Provision','Income Tax');

--
-- Dumping data for table `config`
--

INSERT INTO `config` VALUES ('AllowSalesOfZeroCostItems','0');
INSERT INTO `config` VALUES ('AutoDebtorNo','0');
INSERT INTO `config` VALUES ('CheckCreditLimits','0');
INSERT INTO `config` VALUES ('Check_Price_Charged_vs_Order_Price','1');
INSERT INTO `config` VALUES ('Check_Qty_Charged_vs_Del_Qty','1');
INSERT INTO `config` VALUES ('CountryOfOperation','USD');
INSERT INTO `config` VALUES ('CreditingControlledItems_MustExist','0');
INSERT INTO `config` VALUES ('DB_Maintenance','1');
INSERT INTO `config` VALUES ('DB_Maintenance_LastRun','2005-11-13');
INSERT INTO `config` VALUES ('DefaultBlindPackNote','1');
INSERT INTO `config` VALUES ('DefaultCreditLimit','1000');
INSERT INTO `config` VALUES ('DefaultDateFormat','m/d/Y');
INSERT INTO `config` VALUES ('DefaultDisplayRecordsMax','50');
INSERT INTO `config` VALUES ('DefaultPriceList','WS');
INSERT INTO `config` VALUES ('DefaultTaxCategory','1');
INSERT INTO `config` VALUES ('DefaultTheme','fresh');
INSERT INTO `config` VALUES ('Default_Shipper','1');
INSERT INTO `config` VALUES ('DispatchCutOffTime','14');
INSERT INTO `config` VALUES ('DoFreightCalc','0');
INSERT INTO `config` VALUES ('EDIHeaderMsgId','D:01B:UN:EAN010');
INSERT INTO `config` VALUES ('EDIReference','WEBERP');
INSERT INTO `config` VALUES ('EDI_Incoming_Orders','companies/weberp/EDI_Incoming_Orders');
INSERT INTO `config` VALUES ('EDI_MsgPending','companies/weberp/EDI_MsgPending');
INSERT INTO `config` VALUES ('EDI_MsgSent','companies/weberp/EDI_Sent');
INSERT INTO `config` VALUES ('FreightChargeAppliesIfLessThan','1000');
INSERT INTO `config` VALUES ('FreightTaxCategory','1');
INSERT INTO `config` VALUES ('HTTPS_Only','0');
INSERT INTO `config` VALUES ('MaxImageSize','300');
INSERT INTO `config` VALUES ('NumberOfPeriodsOfStockUsage','12');
INSERT INTO `config` VALUES ('OverChargeProportion','30');
INSERT INTO `config` VALUES ('OverReceiveProportion','20');
INSERT INTO `config` VALUES ('PackNoteFormat','1');
INSERT INTO `config` VALUES ('PageLength','48');
INSERT INTO `config` VALUES ('part_pics_dir','companies/weberp/part_pics');
INSERT INTO `config` VALUES ('PastDueDays1','30');
INSERT INTO `config` VALUES ('PastDueDays2','60');
INSERT INTO `config` VALUES ('PO_AllowSameItemMultipleTimes','1');
INSERT INTO `config` VALUES ('QuickEntries','10');
INSERT INTO `config` VALUES ('RadioBeaconFileCounter','/home/RadioBeacon/FileCounter');
INSERT INTO `config` VALUES ('RadioBeaconFTP_user_name','RadioBeacon ftp server user name');
INSERT INTO `config` VALUES ('RadioBeaconHomeDir','/home/RadioBeacon');
INSERT INTO `config` VALUES ('RadioBeaconStockLocation','BL');
INSERT INTO `config` VALUES ('RadioBraconFTP_server','192.168.2.2');
INSERT INTO `config` VALUES ('RadioBreaconFilePrefix','ORDXX');
INSERT INTO `config` VALUES ('RadionBeaconFTP_user_pass','Radio Beacon remote ftp server password');
INSERT INTO `config` VALUES ('reports_dir','companies/weberp/reports');
INSERT INTO `config` VALUES ('RomalpaClause','Ownership will not pass to the buyer until the goods have been paid for in full.');
INSERT INTO `config` VALUES ('Show_Settled_LastMonth','1');
INSERT INTO `config` VALUES ('SO_AllowSameItemMultipleTimes','1');
INSERT INTO `config` VALUES ('TaxAuthorityReferenceName','Tax Ref');
INSERT INTO `config` VALUES ('YearEnd','3');


--
-- Dumping data for table `companies`
--

INSERT INTO `companies` VALUES (1,'Anahaw Computer System','not entered yet','','PO Box 1000','The White House','Washnington DC','USA','','','','','','Php',1100,4900,2100,2400,2150,4200,5200,3500,1,1,1,5600);


INSERT INTO `www_users` VALUES ('demo','anahaw','Demo User','','','','DEN',8,'2006-01-01 21:34:05','','A4','1,1,1,1,1,1,1,1,1,1,1,',0,50,'professional','en_GB');
--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` VALUES ('Australian Dollars','AUD','Australia','cents',1);
INSERT INTO `currencies` VALUES ('Pounds','GBP','England','Pence',1);
INSERT INTO `currencies` VALUES ('US Dollars','USD','United States','Cents',1);
INSERT INTO `currencies` VALUES ('Canandian Dollars','CND','Canada','cents',1);
INSERT INTO `currencies` VALUES ('Philippine Peso','Php','Philippines','cents',1);
insert into prlothinctable values (10,'Meal Allowance','Non-Tax',1);
insert into prlothinctable values (20,'Transportation Allowance','Non-Tax',1);
insert into prlothinctable values (30,'Housing Allowance','Taxable',1);
insert into prlemploymentstatus values (10,'Regular');
insert into prlemploymentstatus values (20,'Probationary');
insert into prlemploymentstatus values (30,'Contractual');
insert into prlpayperiod values (10,'Semi-Monthly',24);
insert into prlpayperiod values (20,'Monthly',12);
insert into prlpayperiod values (30,'Weekly',52);
insert into prlpayperiod values (40,'Bi-Weekly',104);
insert into prlpayperiod values (50,'Daily',312);
insert into prlpayperiod values (60,'Quarterly',4);
insert into prlpayperiod values (70,'Bi-Annual',2);
insert into prlpayperiod values (80,'Annual',1);
insert into prlovertimetable values (10,'Regular Day OT Work',1.25,1);
insert into prlovertimetable values (15,'Night Shift Pay ',0.1,1);
insert into prlovertimetable values (20,'Restday or Special Day OT Work',1.30,1);
insert into prlovertimetable values (25,'Restday or Special Day OT Work >8 hrs',1.69,1);
insert into prlovertimetable values (30,'Regular Holiday OT Work',2.00,1);
insert into prlovertimetable values (35,'Regular Holiday OT Work >8 hrs',2.6,1);
insert into prlovertimetable values (40,'Restday and Regular Holiday OT Work',2.60,1);
insert into prlovertimetable values (45,'Restday and Regular Holiday OT Work >8hrs',3.38,1);
insert into prlloantable values (10,'SSS Salary Loan',1);
insert into prlloantable values (20,'Pag-ibig Housing Loan',1);
insert into prlloantable values (30,'Cash Advance',1);
insert into prlloantable values (40,'Car Loan',1);
insert into prlhdmftable values (1,1,1500,'Percentage',2.00,'Percentage',1.00);
insert into prlhdmftable values (2,1500.01,999999,'Percentage',2.00,'Percentage',2.00);
insert into prlsstable values (1,1000,1249.99,1000,60.70,10.00,33.30,104.00);
insert into prlsstable values (2,1250,1749.99,1500,91.70,10.00,50.00,151.00);
insert into prlsstable values (3,1750,2249.99,2000,121.30,10.00,66.70,198.00);
insert into prlsstable values (4,2250,2749.99,2500,151.70,10.00,83.30,245.00);
insert into prlsstable values (5,2750,3249.99,3000,182.00,10.00,100.00,292.00);
insert into prlsstable values (6,3250,3749.99,3500,212.30,10.00,116.70,339.00);
insert into prlsstable values (7,3750,4249.99,4000,242.70,10.00,133.30,386.00);
insert into prlsstable values (8,4250,4749.99,4500,273.00,10.00,150.00,433.00);
insert into prlsstable values (9,4750,5249.99,5000,303.30,10.00,166.70,480.00);
insert into prlsstable values (10,5250,5749.99,5500,333.70,10.00,183.30,527.00);
insert into prlsstable values (11,5750,6249.99,6000,364.00,10.00,200.00,574.00);
insert into prlsstable values (12,6250,6749.99,6500,394.30,10.00,216.70,621.00);
insert into prlsstable values (13,6750,7249.99,7000,424.70,10.00,233.30,668.00);
insert into prlsstable values (14,7250,7749.99,7500,455.00,10.00,250.00,715.00);
insert into prlsstable values (15,7750,8249.99,8000,485.30,10.00,266.70,762.00);
insert into prlsstable values (16,8250,8749.99,8500,515.70,10.00,283.30,809.00);
insert into prlsstable values (17,8750,9249.99,9000,546.00,10.00,300.00,856.00);
insert into prlsstable values (18,9250,9749.99,9500,576.30,10.00,316.70,903.00);
insert into prlsstable values (19,9750,10249.99,10000,606.70,10.00,333.30,950.00);
insert into prlsstable values (20,10250,10749.99,10500,637.00,10.00,350.00,997.00);
insert into prlsstable values (21,10750,11249.99,11000,667.30,10.00,366.70,1044.00);
insert into prlsstable values (22,11250,11749.99,11500,697.30,10.00,383.30,1091.00);
insert into prlsstable values (23,11750,12249.99,12000,728.00,10.00,400.00,1138.00);
insert into prlsstable values (24,12250,12749.99,12500,758.30,10.00,416.70,1185.00);
insert into prlsstable values (25,12750,13249.99,13000,788.70,10.00,433.30,1232.00);
insert into prlsstable values (26,13250,13749.99,13500,819.00,10.00,450.00,1279.00);
insert into prlsstable values (27,13750,14249.99,14000,849.30,10.00,466.70,1326.00);
insert into prlsstable values (28,14250,14749.99,14500,879.70,10.00,483.30,1373.00);
insert into prlsstable values (29,14750,999999,15000,910.00,10.00,500.00,1420.00);
insert into prlphilhealth values (1,1,3499.99,3000,37.50,0,37.50,75.00);
insert into prlphilhealth values (2,3500,3999.99,3500,43.75,0,43.75,87.50);
insert into prlphilhealth values (3,4000,4499.99,4000,50,0,50,100.00);
insert into prlphilhealth values (4,4500,4999.99,4500,56.25,0,56.25,112.50);
insert into prlphilhealth values (5,5000,5499.99,5000,62.50,0,62.50,125);
insert into prlphilhealth values (6,5500,5999.99,5500,68.75,0,68.75,137.50);
insert into prlphilhealth values (7,6000,6499.99,6000,75.00,0,75.00,150.00);
insert into prlphilhealth values (8,6500,6999.99,6500,81.25,0,81.25,162.50);
insert into prlphilhealth values (9,7000,7499.99,7000,87.50,0,87.50,175.00);
insert into prlphilhealth values (10,7500,7999.99,7500,93.75,0,93.75,187.50);
insert into prlphilhealth values (11,8000,8499.99,8000,100.00,0,100.00,200.00);
insert into prlphilhealth values (12,8500,8999.99,8500,106.25,0,106.25,212.50);
insert into prlphilhealth values (13,9000,9499.99,9000,112.50,0,112.50,225.00);
insert into prlphilhealth values (14,9500,9999.99,9500,118.75,0,118.75,237.50);
insert into prlphilhealth values (15,10000,999999,10000,125.00,0,125.00,250.00);
insert into prltaxstatus values ('S','Single',20000,0,20000);
insert into prltaxstatus values ('HF','Head of the Family',25000,0,25000);
insert into prltaxstatus values ('ME','Married',32000,0,32000);
insert into prltaxstatus values ('HF1','Head of the Family with 1 dependent',25000,8000,33000);
insert into prltaxstatus values ('HF2','Head of the Family with 2 dependent',25000,16000,41000);
insert into prltaxstatus values ('HF3','Head of the Family with 3 dependent',25000,24000,49000);
insert into prltaxstatus values ('HF4','Head of the Family with 4 dependent',25000,32000,57000);
insert into prltaxstatus values ('ME1','Married with 1 dependent',32000,8000,40000);
insert into prltaxstatus values ('ME2','Married with 2 dependent',32000,16000,48000);
insert into prltaxstatus values ('ME3','Married with 3 dependent',32000,24000,56000);
insert into prltaxstatus values ('ME4','Married with 4 dependent',32000,32000,64000);
insert into prltaxstatus values ('Z','Zero Exemption',0,0,0);
insert into prltaxtablerate values (1,0,9999.99,0,0,5);
insert into prltaxtablerate values (2,10000,29999.99,10000,500,10);
insert into prltaxtablerate values (3,30000,69999.99,30000,2500,15);
insert into prltaxtablerate values (4,70000,139999.99,70000,8500,20);
insert into prltaxtablerate values (5,140000,249999.99,140000,22500,25);
insert into prltaxtablerate values (6,250000,499999.99,250000,50000,30);
insert into prltaxtablerate values (7,500000,99999999.99,500000,125000,32);