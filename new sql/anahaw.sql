-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2017 at 10:28 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.0.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `anahaw`
--

-- --------------------------------------------------------

--
-- Table structure for table `chartmaster`
--

CREATE TABLE `chartmaster` (
  `accountcode` int(11) NOT NULL DEFAULT '0',
  `accountname` char(50) NOT NULL DEFAULT '',
  `group_` char(30) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chartmaster`
--

INSERT INTO `chartmaster` (`accountcode`, `accountname`, `group_`) VALUES
(1, 'Default Sales/Discounts', 'Sales'),
(1010, 'Petty Cash', 'Current Assets'),
(1020, 'Cash on Hand', 'Current Assets'),
(1030, 'Cheque Accounts', 'Current Assets'),
(1040, 'Savings Accounts', 'Current Assets'),
(1050, 'Payroll Accounts', 'Current Assets'),
(1060, 'Special Accounts', 'Current Assets'),
(1070, 'Money Market Investments', 'Current Assets'),
(1080, 'Short-Term Investments (< 90 days)', 'Current Assets'),
(1090, 'Interest Receivable', 'Current Assets'),
(1100, 'Accounts Receivable', 'Current Assets'),
(1150, 'Allowance for Doubtful Accounts', 'Current Assets'),
(1200, 'Notes Receivable', 'Current Assets'),
(1250, 'Income Tax Receivable', 'Current Assets'),
(1300, 'Prepaid Expenses', 'Current Assets'),
(1350, 'Advances', 'Current Assets'),
(1400, 'Supplies Inventory', 'Current Assets'),
(1420, 'Raw Material Inventory', 'Current Assets'),
(1440, 'Work in Progress Inventory', 'Current Assets'),
(1460, 'Finished Goods Inventory', 'Current Assets'),
(1500, 'Land', 'Fixed Assets'),
(1550, 'Bonds', 'Fixed Assets'),
(1600, 'Buildings', 'Fixed Assets'),
(1620, 'Accumulated Depreciation of Buildings', 'Fixed Assets'),
(1650, 'Equipment', 'Fixed Assets'),
(1670, 'Accumulated Depreciation of Equipment', 'Fixed Assets'),
(1700, 'Furniture & Fixtures', 'Fixed Assets'),
(1710, 'Accumulated Depreciation of Furniture & Fixtures', 'Fixed Assets'),
(1720, 'Office Equipment', 'Fixed Assets'),
(1730, 'Accumulated Depreciation of Office Equipment', 'Fixed Assets'),
(1740, 'Software', 'Fixed Assets'),
(1750, 'Accumulated Depreciation of Software', 'Fixed Assets'),
(1760, 'Vehicles', 'Fixed Assets'),
(1770, 'Accumulated Depreciation Vehicles', 'Fixed Assets'),
(1780, 'Other Depreciable Property', 'Fixed Assets'),
(1790, 'Accumulated Depreciation of Other Depreciable Prop', 'Fixed Assets'),
(1800, 'Patents', 'Fixed Assets'),
(1850, 'Goodwill', 'Fixed Assets'),
(1900, 'Future Income Tax Receivable', 'Current Assets'),
(2010, 'Bank Indedebtedness (overdraft)', 'Liabilities'),
(2020, 'Retainers or Advances on Work', 'Liabilities'),
(2050, 'Interest Payable', 'Liabilities'),
(2100, 'Accounts Payable', 'Liabilities'),
(2150, 'Goods Received Suspense', 'Liabilities'),
(2200, 'Short-Term Loan Payable', 'Liabilities'),
(2230, 'Current Portion of Long-Term Debt Payable', 'Liabilities'),
(2250, 'Income Tax Payable', 'Liabilities'),
(2300, 'GST Payable', 'Liabilities'),
(2310, 'GST Recoverable', 'Liabilities'),
(2320, 'PST Payable', 'Liabilities'),
(2330, 'PST Recoverable (commission)', 'Liabilities'),
(2340, 'Payroll Tax Payable', 'Liabilities'),
(2350, 'Withholding Income Tax Payable', 'Liabilities'),
(2360, 'Other Taxes Payable', 'Liabilities'),
(2400, 'Employee Salaries Payable', 'Liabilities'),
(2410, 'Management Salaries Payable', 'Liabilities'),
(2420, 'Director / Partner Fees Payable', 'Liabilities'),
(2450, 'Health Benefits Payable', 'Liabilities'),
(2460, 'Pension Benefits Payable', 'Liabilities'),
(2470, 'Canada Pension Plan Payable', 'Liabilities'),
(2480, 'Employment Insurance Premiums Payable', 'Liabilities'),
(2500, 'Land Payable', 'Liabilities'),
(2550, 'Long-Term Bank Loan', 'Liabilities'),
(2560, 'Notes Payable', 'Liabilities'),
(2600, 'Building & Equipment Payable', 'Liabilities'),
(2700, 'Furnishing & Fixture Payable', 'Liabilities'),
(2720, 'Office Equipment Payable', 'Liabilities'),
(2740, 'Vehicle Payable', 'Liabilities'),
(2760, 'Other Property Payable', 'Liabilities'),
(2800, 'Shareholder Loans', 'Liabilities'),
(2900, 'Suspense', 'Liabilities'),
(3100, 'Capital Stock', 'Equity'),
(3200, 'Capital Surplus / Dividends', 'Equity'),
(3300, 'Dividend Taxes Payable', 'Equity'),
(3400, 'Dividend Taxes Refundable', 'Equity'),
(3500, 'Retained Earnings', 'Equity'),
(4100, 'Product / Service Sales', 'Revenue'),
(4200, 'Sales Exchange Gains/Losses', 'Revenue'),
(4500, 'Consulting Services', 'Revenue'),
(4600, 'Rentals', 'Revenue'),
(4700, 'Finance Charge Income', 'Revenue'),
(4800, 'Sales Returns & Allowances', 'Revenue'),
(4900, 'Sales Discounts', 'Revenue'),
(5000, 'Cost of Sales', 'Cost of Goods Sold'),
(5100, 'Production Expenses', 'Cost of Goods Sold'),
(5200, 'Purchases Exchange Gains/Losses', 'Cost of Goods Sold'),
(5500, 'Direct Labour Costs', 'Cost of Goods Sold'),
(5600, 'Freight Charges', 'Cost of Goods Sold'),
(5700, 'Inventory Adjustment', 'Cost of Goods Sold'),
(5800, 'Purchase Returns & Allowances', 'Cost of Goods Sold'),
(5900, 'Purchase Discounts', 'Cost of Goods Sold'),
(6100, 'Advertising', 'Marketing Expenses'),
(6150, 'Promotion', 'Marketing Expenses'),
(6200, 'Communications', 'Marketing Expenses'),
(6250, 'Meeting Expenses', 'Marketing Expenses'),
(6300, 'Travelling Expenses', 'Marketing Expenses'),
(6400, 'Delivery Expenses', 'Marketing Expenses'),
(6500, 'Sales Salaries & Commission', 'Marketing Expenses'),
(6550, 'Sales Salaries & Commission Deductions', 'Marketing Expenses'),
(6590, 'Benefits', 'Marketing Expenses'),
(6600, 'Other Selling Expenses', 'Marketing Expenses'),
(6700, 'Permits, Licenses & License Fees', 'Marketing Expenses'),
(6800, 'Research & Development', 'Marketing Expenses'),
(6900, 'Professional Services', 'Marketing Expenses'),
(7020, 'Support Salaries & Wages', 'Operating Expenses'),
(7030, 'Support Salary & Wage Deductions', 'Operating Expenses'),
(7040, 'Management Salaries', 'Operating Expenses'),
(7050, 'Management Salary deductions', 'Operating Expenses'),
(7060, 'Director / Partner Fees', 'Operating Expenses'),
(7070, 'Director / Partner Deductions', 'Operating Expenses'),
(7080, 'Payroll Tax', 'Operating Expenses'),
(7090, 'Benefits', 'Operating Expenses'),
(7100, 'Training & Education Expenses', 'Operating Expenses'),
(7150, 'Dues & Subscriptions', 'Operating Expenses'),
(7200, 'Accounting Fees', 'Operating Expenses'),
(7210, 'Audit Fees', 'Operating Expenses'),
(7220, 'Banking Fees', 'Operating Expenses'),
(7230, 'Credit Card Fees', 'Operating Expenses'),
(7240, 'Consulting Fees', 'Operating Expenses'),
(7260, 'Legal Fees', 'Operating Expenses'),
(7280, 'Other Professional Fees', 'Operating Expenses'),
(7300, 'Business Tax', 'Operating Expenses'),
(7350, 'Property Tax', 'Operating Expenses'),
(7390, 'Corporation Capital Tax', 'Operating Expenses'),
(7400, 'Office Rent', 'Operating Expenses'),
(7450, 'Equipment Rental', 'Operating Expenses'),
(7500, 'Office Supplies', 'Operating Expenses'),
(7550, 'Office Repair & Maintenance', 'Operating Expenses'),
(7600, 'Automotive Expenses', 'Operating Expenses'),
(7610, 'Communication Expenses', 'Operating Expenses'),
(7620, 'Insurance Expenses', 'Operating Expenses'),
(7630, 'Postage & Courier Expenses', 'Operating Expenses'),
(7640, 'Miscellaneous Expenses', 'Operating Expenses'),
(7650, 'Travel Expenses', 'Operating Expenses'),
(7660, 'Utilities', 'Operating Expenses'),
(7700, 'Ammortization Expenses', 'Operating Expenses'),
(7750, 'Depreciation Expenses', 'Operating Expenses'),
(7800, 'Interest Expense', 'Operating Expenses'),
(7900, 'Bad Debt Expense', 'Operating Expenses'),
(8100, 'Gain on Sale of Assets', 'Other Revenue and Expenses'),
(8200, 'Interest Income', 'Other Revenue and Expenses'),
(8300, 'Recovery on Bad Debt', 'Other Revenue and Expenses'),
(8400, 'Other Revenue', 'Other Revenue and Expenses'),
(8500, 'Loss on Sale of Assets', 'Other Revenue and Expenses'),
(8600, 'Charitable Contributions', 'Other Revenue and Expenses'),
(8900, 'Other Expenses', 'Other Revenue and Expenses'),
(9100, 'Income Tax Provision', 'Income Tax');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `coycode` int(11) NOT NULL DEFAULT '1',
  `coyname` varchar(50) NOT NULL DEFAULT '',
  `gstno` varchar(20) NOT NULL DEFAULT '',
  `companynumber` varchar(20) NOT NULL DEFAULT '0',
  `regoffice1` varchar(40) NOT NULL DEFAULT '',
  `regoffice2` varchar(40) NOT NULL DEFAULT '',
  `regoffice3` varchar(40) NOT NULL DEFAULT '',
  `regoffice4` varchar(40) NOT NULL DEFAULT '',
  `regoffice5` varchar(20) NOT NULL DEFAULT '',
  `regoffice6` varchar(15) NOT NULL DEFAULT '',
  `telephone` varchar(25) NOT NULL DEFAULT '',
  `fax` varchar(25) NOT NULL DEFAULT '',
  `email` varchar(55) NOT NULL DEFAULT '',
  `currencydefault` varchar(4) NOT NULL DEFAULT '',
  `debtorsact` int(11) NOT NULL DEFAULT '70000',
  `pytdiscountact` int(11) NOT NULL DEFAULT '55000',
  `creditorsact` int(11) NOT NULL DEFAULT '80000',
  `payrollact` int(11) NOT NULL DEFAULT '84000',
  `grnact` int(11) NOT NULL DEFAULT '72000',
  `exchangediffact` int(11) NOT NULL DEFAULT '65000',
  `purchasesexchangediffact` int(11) NOT NULL DEFAULT '0',
  `retainedearnings` int(11) NOT NULL DEFAULT '90000',
  `gllink_debtors` tinyint(1) DEFAULT '1',
  `gllink_creditors` tinyint(1) DEFAULT '1',
  `gllink_stock` tinyint(1) DEFAULT '1',
  `freightact` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`coycode`, `coyname`, `gstno`, `companynumber`, `regoffice1`, `regoffice2`, `regoffice3`, `regoffice4`, `regoffice5`, `regoffice6`, `telephone`, `fax`, `email`, `currencydefault`, `debtorsact`, `pytdiscountact`, `creditorsact`, `payrollact`, `grnact`, `exchangediffact`, `purchasesexchangediffact`, `retainedearnings`, `gllink_debtors`, `gllink_creditors`, `gllink_stock`, `freightact`) VALUES
(1, 'Anahaw Computer System', 'not entered yet', '', 'PO Box 1000', 'The White House', 'Washnington DC', 'USA', '', '', '', '', '', 'Php', 1100, 4900, 2100, 2400, 2150, 4200, 5200, 3500, 1, 1, 1, 5600);

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `confname` varchar(35) NOT NULL DEFAULT '',
  `confvalue` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`confname`, `confvalue`) VALUES
('AllowSalesOfZeroCostItems', '0'),
('AutoDebtorNo', '0'),
('CheckCreditLimits', '0'),
('Check_Price_Charged_vs_Order_Price', '1'),
('Check_Qty_Charged_vs_Del_Qty', '1'),
('CountryOfOperation', 'USD'),
('CreditingControlledItems_MustExist', '0'),
('DB_Maintenance', '1'),
('DB_Maintenance_LastRun', '2005-11-13'),
('DefaultBlindPackNote', '1'),
('DefaultCreditLimit', '1000'),
('DefaultDateFormat', 'm/d/Y'),
('DefaultDisplayRecordsMax', '50'),
('DefaultPriceList', 'WS'),
('DefaultTaxCategory', '1'),
('DefaultTheme', 'fresh'),
('Default_Shipper', '1'),
('DispatchCutOffTime', '14'),
('DoFreightCalc', '0'),
('EDIHeaderMsgId', 'D:01B:UN:EAN010'),
('EDIReference', 'WEBERP'),
('EDI_Incoming_Orders', 'companies/weberp/EDI_Incoming_Orders'),
('EDI_MsgPending', 'companies/weberp/EDI_MsgPending'),
('EDI_MsgSent', 'companies/weberp/EDI_Sent'),
('FreightChargeAppliesIfLessThan', '1000'),
('FreightTaxCategory', '1'),
('HTTPS_Only', '0'),
('MaxImageSize', '300'),
('NumberOfPeriodsOfStockUsage', '12'),
('OverChargeProportion', '30'),
('OverReceiveProportion', '20'),
('PackNoteFormat', '1'),
('PageLength', '48'),
('part_pics_dir', 'companies/weberp/part_pics'),
('PastDueDays1', '30'),
('PastDueDays2', '60'),
('PO_AllowSameItemMultipleTimes', '1'),
('QuickEntries', '10'),
('RadioBeaconFileCounter', '/home/RadioBeacon/FileCounter'),
('RadioBeaconFTP_user_name', 'RadioBeacon ftp server user name'),
('RadioBeaconHomeDir', '/home/RadioBeacon'),
('RadioBeaconStockLocation', 'BL'),
('RadioBraconFTP_server', '192.168.2.2'),
('RadioBreaconFilePrefix', 'ORDXX'),
('RadionBeaconFTP_user_pass', 'Radio Beacon remote ftp server password'),
('reports_dir', 'companies/weberp/reports'),
('RomalpaClause', 'Ownership will not pass to the buyer until the goods have been paid for in full.'),
('Show_Settled_LastMonth', '1'),
('SO_AllowSameItemMultipleTimes', '1'),
('TaxAuthorityReferenceName', 'Tax Ref'),
('YearEnd', '3');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `currency` char(20) NOT NULL DEFAULT '',
  `currabrev` char(3) NOT NULL DEFAULT '',
  `country` char(50) NOT NULL DEFAULT '',
  `hundredsname` char(15) NOT NULL DEFAULT 'Cents',
  `rate` double NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`currency`, `currabrev`, `country`, `hundredsname`, `rate`) VALUES
('Australian Dollars', 'AUD', 'Australia', 'cents', 1),
('Canandian Dollars', 'CND', 'Canada', 'cents', 1),
('Pounds', 'GBP', 'England', 'Pence', 1),
('Philippine Peso', 'Php', 'Philippines', 'cents', 1),
('US Dollars', 'USD', 'United States', 'Cents', 1);

-- --------------------------------------------------------

--
-- Table structure for table `prldailytrans`
--

CREATE TABLE `prldailytrans` (
  `counterindex` int(11) NOT NULL,
  `rtref` varchar(11) NOT NULL DEFAULT '',
  `rtdesc` varchar(40) NOT NULL DEFAULT '',
  `rtdate` date NOT NULL DEFAULT '0000-00-00',
  `payrollid` varchar(10) NOT NULL DEFAULT '',
  `employeeid` varchar(10) NOT NULL DEFAULT '',
  `reghrs` decimal(12,2) NOT NULL DEFAULT '0.00',
  `absenthrs` decimal(12,2) NOT NULL DEFAULT '0.00',
  `latehrs` decimal(12,2) NOT NULL DEFAULT '0.00',
  `regamt` decimal(12,2) NOT NULL DEFAULT '0.00',
  `absentamt` decimal(12,2) NOT NULL DEFAULT '0.00',
  `lateamt` decimal(12,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prlemphdmffile`
--

CREATE TABLE `prlemphdmffile` (
  `counterindex` int(11) NOT NULL,
  `payrollid` varchar(10) NOT NULL DEFAULT '',
  `employeeid` varchar(10) NOT NULL DEFAULT '',
  `grosspay` decimal(12,2) NOT NULL DEFAULT '0.00',
  `employerhdmf` decimal(12,2) NOT NULL DEFAULT '0.00',
  `employeehdmf` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `fsmonth` tinyint(4) NOT NULL DEFAULT '0',
  `fsyear` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prlemployeemaster`
--

CREATE TABLE `prlemployeemaster` (
  `employeeid` varchar(10) NOT NULL DEFAULT '',
  `lastname` varchar(40) NOT NULL DEFAULT '',
  `firstname` varchar(40) NOT NULL DEFAULT '',
  `middlename` varchar(40) NOT NULL DEFAULT '',
  `address1` varchar(100) NOT NULL DEFAULT '',
  `address2` varchar(100) NOT NULL DEFAULT '',
  `city` varchar(50) NOT NULL DEFAULT '',
  `state` varchar(20) NOT NULL DEFAULT '',
  `zip` varchar(15) NOT NULL DEFAULT '',
  `country` varchar(40) NOT NULL DEFAULT '',
  `gender` varchar(15) NOT NULL DEFAULT '',
  `phone1` varchar(20) NOT NULL DEFAULT '',
  `phone1comment` varchar(20) NOT NULL DEFAULT '',
  `phone2` varchar(20) NOT NULL DEFAULT '',
  `phone2comment` varchar(20) NOT NULL DEFAULT '',
  `email1` varchar(50) NOT NULL DEFAULT '',
  `email1comment` varchar(20) NOT NULL DEFAULT '',
  `email2` varchar(50) NOT NULL DEFAULT '',
  `email2comment` varchar(20) NOT NULL DEFAULT '',
  `atmnumber` varchar(20) NOT NULL DEFAULT '',
  `ssnumber` varchar(20) NOT NULL DEFAULT '',
  `hdmfnumber` varchar(20) NOT NULL DEFAULT '',
  `phnumber` varchar(15) NOT NULL DEFAULT '',
  `taxactnumber` varchar(15) NOT NULL DEFAULT '',
  `birthdate` date NOT NULL DEFAULT '0000-00-00',
  `hiredate` date NOT NULL DEFAULT '0000-00-00',
  `terminatedate` date NOT NULL DEFAULT '0000-00-00',
  `retireddate` date NOT NULL DEFAULT '0000-00-00',
  `paytype` tinyint(4) NOT NULL DEFAULT '0',
  `payperiodid` tinyint(4) NOT NULL DEFAULT '0',
  `periodrate` decimal(12,2) NOT NULL DEFAULT '0.00',
  `hourlyrate` decimal(12,2) NOT NULL DEFAULT '0.00',
  `glactcode` int(11) NOT NULL DEFAULT '0',
  `marital` varchar(20) NOT NULL DEFAULT '',
  `taxstatusid` varchar(10) DEFAULT '',
  `employmentid` tinyint(4) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '0',
  `costcenterid` varchar(10) NOT NULL DEFAULT '',
  `position` varchar(40) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prlemployeemaster`
--

INSERT INTO `prlemployeemaster` (`employeeid`, `lastname`, `firstname`, `middlename`, `address1`, `address2`, `city`, `state`, `zip`, `country`, `gender`, `phone1`, `phone1comment`, `phone2`, `phone2comment`, `email1`, `email1comment`, `email2`, `email2comment`, `atmnumber`, `ssnumber`, `hdmfnumber`, `phnumber`, `taxactnumber`, `birthdate`, `hiredate`, `terminatedate`, `retireddate`, `paytype`, `payperiodid`, `periodrate`, `hourlyrate`, `glactcode`, `marital`, `taxstatusid`, `employmentid`, `active`, `costcenterid`, `position`) VALUES
('ABD123', 'Alaba', 'Lyn', '', '', '', '', '', '', '', 'M', '', '', '', '', '', '', '', '', '', '', '', '', '', '1901-01-01', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '8000.00', '80.00', 0, '', 'HF', 10, 0, 'ACT', ''),
('AGM123', 'Alerto', 'Gil', 'M', '', '', '', '', '', '', 'M', '', '', '', '', '', '', '', '', '', '', '', '', '', '1901-01-01', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '6800.00', '68.00', 0, 'Married', 'ME4', 10, 0, 'EDP', ''),
('AL1234', 'Ajoc', 'Leo', '', '', '', '', '', '', '', 'M', '', '', '', '', '', '', '', '', '', '', '', '', '', '1901-01-01', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '7000.00', '70.00', 0, 'Married', 'ME2', 10, 0, 'ACT', ''),
('BJE', 'Bautista', 'Jenny', '', '', '', '', '', '', '', 'M', '', '', '', '', '', '', '', '', '', '', '', '', '', '1907-03-07', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '6500.00', '65.00', 0, 'Single', 'S', 10, 0, 'ACT', ''),
('CAJ456', 'Calubag', 'Daylin', '', '', '', '', '', '', '', 'F', '', '', '', '', '', '', '', '', '', '', '', '', '', '1978-04-27', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '12000.00', '120.00', 0, 'Single', 'HF', 10, 0, '0', ''),
('CAL123', 'Cantilado', 'Al', '', '', '', '', '', '', '', 'M', '', '', '', '', '', '', '', '', '', '', '', '', '', '1908-02-05', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '11500.00', '115.00', 0, '', 'S', 10, 0, 'MAR', ''),
('CLB123', 'Campos', 'Leo', '', '', '', '', '', '', '', 'M', '', '', '', '', '', '', '', '', '', '', '', '', '', '1908-07-09', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '7700.00', '77.00', 0, '', 'ME', 10, 0, 'ACT', ''),
('CWC123', 'Calinawan', 'Wilfredo', '', '', '', '', '', '', '', 'M', '', '', '', '', '', '', '', '', '', '', '', '', '', '1905-04-06', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '9000.00', '90.00', 0, '', 'HF', 10, 0, 'EDP', ''),
('ENT100', 'Tejada', 'Eliseo', '', 'Address1', 'Address2', 'City', 'State', '1234', 'Philippines', 'M', '', '', '', '', '', '', '', '', '1234567', '1234567', '1234567', '1234567', '1234567', '1970-06-14', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '10000.00', '100.00', 0, 'Married', 'ME1', 30, 0, '0', 'Accountant'),
('TAD100', 'Tulang', 'Dodong', '', '', '', '', '', '', '', 'M', '', '', '', '', '', '', '', '', '', '', '', '', '', '1901-01-01', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '6000.00', '60.00', 0, '', 'S', 10, 0, 'FIN', ''),
('TDC', 'Tejada', 'Daisy', 'C', '', '', '', '', '', '', 'M', '', '', '', '', '', '', '', '', '', '', '', '', '', '1901-01-01', '0000-00-00', '0000-00-00', '0000-00-00', 0, 10, '7500.00', '75.00', 0, 'Married', 'ME', 10, 0, 'SAL', '');

-- --------------------------------------------------------

--
-- Table structure for table `prlemploymentstatus`
--

CREATE TABLE `prlemploymentstatus` (
  `employmentid` tinyint(4) NOT NULL DEFAULT '0',
  `employmentdesc` varchar(15) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prlemploymentstatus`
--

INSERT INTO `prlemploymentstatus` (`employmentid`, `employmentdesc`) VALUES
(10, 'Regular'),
(20, 'Probationary'),
(30, 'Contractual');

-- --------------------------------------------------------

--
-- Table structure for table `prlempphfile`
--

CREATE TABLE `prlempphfile` (
  `counterindex` int(11) NOT NULL,
  `payrollid` varchar(10) NOT NULL DEFAULT '',
  `employeeid` varchar(10) NOT NULL DEFAULT '',
  `grosspay` decimal(12,2) NOT NULL DEFAULT '0.00',
  `rangefrom` decimal(12,2) NOT NULL DEFAULT '0.00',
  `rangeto` decimal(12,2) NOT NULL DEFAULT '0.00',
  `salarycredit` decimal(12,2) NOT NULL DEFAULT '0.00',
  `employerph` decimal(12,2) NOT NULL DEFAULT '0.00',
  `employerec` decimal(12,2) NOT NULL DEFAULT '0.00',
  `employeeph` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `fsmonth` tinyint(4) NOT NULL DEFAULT '0',
  `fsyear` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prlempsssfile`
--

CREATE TABLE `prlempsssfile` (
  `counterindex` int(11) NOT NULL,
  `payrollid` varchar(10) NOT NULL DEFAULT '',
  `employeeid` varchar(10) NOT NULL DEFAULT '',
  `grosspay` decimal(12,2) NOT NULL DEFAULT '0.00',
  `rangefrom` decimal(12,2) NOT NULL DEFAULT '0.00',
  `rangeto` decimal(12,2) NOT NULL DEFAULT '0.00',
  `salarycredit` decimal(12,2) NOT NULL DEFAULT '0.00',
  `employerss` decimal(12,2) NOT NULL DEFAULT '0.00',
  `employerec` decimal(12,2) NOT NULL DEFAULT '0.00',
  `employeess` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `fsmonth` tinyint(4) NOT NULL DEFAULT '0',
  `fsyear` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prlemptaxfile`
--

CREATE TABLE `prlemptaxfile` (
  `counterindex` int(11) NOT NULL,
  `payrollid` varchar(10) NOT NULL DEFAULT '',
  `employeeid` varchar(10) NOT NULL DEFAULT '',
  `taxableincome` decimal(12,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(12,2) NOT NULL DEFAULT '0.00',
  `fsmonth` tinyint(4) NOT NULL DEFAULT '0',
  `fsyear` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prlhdmftable`
--

CREATE TABLE `prlhdmftable` (
  `bracket` tinyint(4) NOT NULL DEFAULT '0',
  `rangefrom` decimal(12,2) NOT NULL DEFAULT '0.00',
  `rangeto` decimal(12,2) NOT NULL DEFAULT '0.00',
  `dedtypeer` varchar(10) NOT NULL DEFAULT '',
  `employershare` decimal(12,2) NOT NULL DEFAULT '0.00',
  `dedtypeee` varchar(10) NOT NULL DEFAULT '',
  `employeeshare` decimal(12,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prlhdmftable`
--

INSERT INTO `prlhdmftable` (`bracket`, `rangefrom`, `rangeto`, `dedtypeer`, `employershare`, `dedtypeee`, `employeeshare`) VALUES
(1, '1.00', '1500.00', 'Percentage', '2.00', 'Percentage', '1.00'),
(2, '1500.01', '999999.00', 'Percentage', '2.00', 'Percentage', '2.00');

-- --------------------------------------------------------

--
-- Table structure for table `prlloandeduction`
--

CREATE TABLE `prlloandeduction` (
  `counterindex` int(11) NOT NULL,
  `payrollid` varchar(10) DEFAULT '',
  `employeeid` varchar(10) NOT NULL DEFAULT '',
  `loantableid` tinyint(4) NOT NULL DEFAULT '0',
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `accountcode` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prlloanfile`
--

CREATE TABLE `prlloanfile` (
  `loanfileid` varchar(10) NOT NULL DEFAULT '',
  `loanfiledesc` varchar(40) NOT NULL DEFAULT '',
  `employeeid` varchar(10) NOT NULL DEFAULT '',
  `loandate` date NOT NULL DEFAULT '0000-00-00',
  `loantableid` tinyint(4) NOT NULL DEFAULT '0',
  `loanamount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `amortization` decimal(12,2) NOT NULL DEFAULT '0.00',
  `startdeduction` date NOT NULL DEFAULT '0000-00-00',
  `ytddeduction` decimal(12,2) NOT NULL DEFAULT '0.00',
  `loanbalance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `accountcode` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prlloantable`
--

CREATE TABLE `prlloantable` (
  `loantableid` tinyint(4) NOT NULL DEFAULT '0',
  `loantabledesc` varchar(25) NOT NULL DEFAULT '',
  `accountcode` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prlloantable`
--

INSERT INTO `prlloantable` (`loantableid`, `loantabledesc`, `accountcode`) VALUES
(10, 'SSS Salary Loan', 1),
(20, 'Pag-ibig Housing Loan', 1),
(30, 'Cash Advance', 1),
(40, 'Car Loan', 1);

-- --------------------------------------------------------

--
-- Table structure for table `prlothincfile`
--

CREATE TABLE `prlothincfile` (
  `counterindex` int(11) NOT NULL,
  `othfileref` varchar(10) NOT NULL DEFAULT '',
  `othfiledesc` varchar(40) NOT NULL DEFAULT '',
  `employeeid` varchar(10) NOT NULL DEFAULT '',
  `othdate` date NOT NULL DEFAULT '0000-00-00',
  `othincid` tinyint(4) NOT NULL DEFAULT '0',
  `othincamount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `accountcode` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prlothinctable`
--

CREATE TABLE `prlothinctable` (
  `othincid` tinyint(4) NOT NULL DEFAULT '0',
  `othincdesc` varchar(25) NOT NULL DEFAULT '',
  `taxable` varchar(10) NOT NULL DEFAULT '',
  `accountcode` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prlothinctable`
--

INSERT INTO `prlothinctable` (`othincid`, `othincdesc`, `taxable`, `accountcode`) VALUES
(10, 'Meal Allowance', 'Non-Tax', 1),
(20, 'Transportation Allowance', 'Non-Tax', 1),
(30, 'Housing Allowance', 'Taxable', 1);

-- --------------------------------------------------------

--
-- Table structure for table `prlottrans`
--

CREATE TABLE `prlottrans` (
  `counterindex` int(11) NOT NULL,
  `payrollid` varchar(10) DEFAULT '',
  `otref` varchar(11) NOT NULL DEFAULT '',
  `otdesc` varchar(40) NOT NULL DEFAULT '',
  `otdate` date NOT NULL DEFAULT '0000-00-00',
  `overtimeid` tinyint(4) NOT NULL DEFAULT '0',
  `employeeid` varchar(10) NOT NULL DEFAULT '',
  `othours` double NOT NULL DEFAULT '0',
  `joborder` varchar(10) NOT NULL DEFAULT '',
  `accountcode` int(11) NOT NULL DEFAULT '0',
  `otamount` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prlovertimetable`
--

CREATE TABLE `prlovertimetable` (
  `overtimeid` tinyint(4) NOT NULL DEFAULT '0',
  `overtimedesc` varchar(40) NOT NULL DEFAULT '',
  `overtimerate` decimal(6,2) NOT NULL DEFAULT '0.00',
  `accountcode` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prlovertimetable`
--

INSERT INTO `prlovertimetable` (`overtimeid`, `overtimedesc`, `overtimerate`, `accountcode`) VALUES
(10, 'Regular Day OT Work', '1.25', 1),
(15, 'Night Shift Pay ', '0.10', 1),
(20, 'Restday or Special Day OT Work', '1.30', 1),
(25, 'Restday or Special Day OT Work >8 hrs', '1.69', 1),
(30, 'Regular Holiday OT Work', '2.00', 1),
(35, 'Regular Holiday OT Work >8 hrs', '2.60', 1),
(40, 'Restday and Regular Holiday OT Work', '2.60', 1),
(45, 'Restday and Regular Holiday OT Work >8hr', '3.38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `prlpayperiod`
--

CREATE TABLE `prlpayperiod` (
  `payperiodid` tinyint(4) NOT NULL DEFAULT '0',
  `payperioddesc` varchar(15) NOT NULL DEFAULT '',
  `numberofpayday` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prlpayperiod`
--

INSERT INTO `prlpayperiod` (`payperiodid`, `payperioddesc`, `numberofpayday`) VALUES
(10, 'Semi-Monthly', 24),
(20, 'Monthly', 12),
(30, 'Weekly', 52),
(40, 'Bi-Weekly', 104),
(50, 'Daily', 312),
(60, 'Quarterly', 4),
(70, 'Bi-Annual', 2),
(80, 'Annual', 1);

-- --------------------------------------------------------

--
-- Table structure for table `prlpayrollperiod`
--

CREATE TABLE `prlpayrollperiod` (
  `payrollid` varchar(10) NOT NULL DEFAULT '',
  `payrolldesc` varchar(40) NOT NULL DEFAULT '',
  `payperiodid` tinyint(4) NOT NULL DEFAULT '0',
  `startdate` date NOT NULL DEFAULT '0000-00-00',
  `enddate` date NOT NULL DEFAULT '0000-00-00',
  `fsmonth` tinyint(4) NOT NULL DEFAULT '0',
  `fsyear` double NOT NULL DEFAULT '0',
  `deductsss` tinyint(4) NOT NULL DEFAULT '0',
  `deducthdmf` tinyint(4) NOT NULL DEFAULT '0',
  `deductphilhealth` tinyint(4) NOT NULL DEFAULT '0',
  `payclosed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prlpayrollperiod`
--

INSERT INTO `prlpayrollperiod` (`payrollid`, `payrolldesc`, `payperiodid`, `startdate`, `enddate`, `fsmonth`, `fsyear`, `deductsss`, `deducthdmf`, `deductphilhealth`, `payclosed`) VALUES
('10', 'Semi-Monthly Payroll (June 1-15, 2006)', 10, '2006-06-01', '2006-06-15', 6, 2006, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `prlpayrolltrans`
--

CREATE TABLE `prlpayrolltrans` (
  `counterindex` int(11) NOT NULL,
  `payrollid` varchar(10) DEFAULT '',
  `employeeid` varchar(10) NOT NULL DEFAULT '',
  `reghrs` decimal(12,2) NOT NULL DEFAULT '0.00',
  `absenthrs` decimal(12,2) NOT NULL DEFAULT '0.00',
  `latehrs` decimal(12,2) NOT NULL DEFAULT '0.00',
  `periodrate` decimal(12,2) NOT NULL DEFAULT '0.00',
  `hourlyrate` decimal(12,2) NOT NULL DEFAULT '0.00',
  `basicpay` decimal(12,2) NOT NULL DEFAULT '0.00',
  `othincome` decimal(12,2) NOT NULL DEFAULT '0.00',
  `absent` decimal(12,2) NOT NULL DEFAULT '0.00',
  `late` decimal(12,2) NOT NULL DEFAULT '0.00',
  `otpay` decimal(12,2) NOT NULL DEFAULT '0.00',
  `grosspay` decimal(12,2) NOT NULL DEFAULT '0.00',
  `loandeduction` decimal(12,2) NOT NULL DEFAULT '0.00',
  `sss` decimal(12,2) NOT NULL DEFAULT '0.00',
  `hdmf` decimal(12,2) NOT NULL DEFAULT '0.00',
  `philhealth` decimal(12,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(12,2) NOT NULL DEFAULT '0.00',
  `otherdeduction` decimal(12,2) NOT NULL DEFAULT '0.00',
  `totaldeduction` decimal(12,2) NOT NULL DEFAULT '0.00',
  `netpay` decimal(12,2) NOT NULL DEFAULT '0.00',
  `fsmonth` tinyint(4) NOT NULL DEFAULT '0',
  `fsyear` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prlphilhealth`
--

CREATE TABLE `prlphilhealth` (
  `bracket` tinyint(4) NOT NULL DEFAULT '0',
  `rangefrom` decimal(12,2) NOT NULL DEFAULT '0.00',
  `rangeto` decimal(12,2) NOT NULL DEFAULT '0.00',
  `salarycredit` decimal(12,2) NOT NULL DEFAULT '0.00',
  `employerph` decimal(12,2) NOT NULL DEFAULT '0.00',
  `employerec` decimal(12,2) NOT NULL DEFAULT '0.00',
  `employeeph` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prlphilhealth`
--

INSERT INTO `prlphilhealth` (`bracket`, `rangefrom`, `rangeto`, `salarycredit`, `employerph`, `employerec`, `employeeph`, `total`) VALUES
(1, '1.00', '3499.99', '3000.00', '37.50', '0.00', '37.50', '75.00'),
(2, '3500.00', '3999.99', '3500.00', '43.75', '0.00', '43.75', '87.50'),
(3, '4000.00', '4499.99', '4000.00', '50.00', '0.00', '50.00', '100.00'),
(4, '4500.00', '4999.99', '4500.00', '56.25', '0.00', '56.25', '112.50'),
(5, '5000.00', '5499.99', '5000.00', '62.50', '0.00', '62.50', '125.00'),
(6, '5500.00', '5999.99', '5500.00', '68.75', '0.00', '68.75', '137.50'),
(7, '6000.00', '6499.99', '6000.00', '75.00', '0.00', '75.00', '150.00'),
(8, '6500.00', '6999.99', '6500.00', '81.25', '0.00', '81.25', '162.50'),
(9, '7000.00', '7499.99', '7000.00', '87.50', '0.00', '87.50', '175.00'),
(10, '7500.00', '7999.99', '7500.00', '93.75', '0.00', '93.75', '187.50'),
(11, '8000.00', '8499.99', '8000.00', '100.00', '0.00', '100.00', '200.00'),
(12, '8500.00', '8999.99', '8500.00', '106.25', '0.00', '106.25', '212.50'),
(13, '9000.00', '9499.99', '9000.00', '112.50', '0.00', '112.50', '225.00'),
(14, '9500.00', '9999.99', '9500.00', '118.75', '0.00', '118.75', '237.50'),
(15, '10000.00', '999999.00', '10000.00', '125.00', '0.00', '125.00', '250.00');

-- --------------------------------------------------------

--
-- Table structure for table `prlsstable`
--

CREATE TABLE `prlsstable` (
  `bracket` tinyint(4) NOT NULL DEFAULT '0',
  `rangefrom` decimal(12,2) NOT NULL DEFAULT '0.00',
  `rangeto` decimal(12,2) NOT NULL DEFAULT '0.00',
  `salarycredit` decimal(12,2) NOT NULL DEFAULT '0.00',
  `employerss` decimal(12,2) NOT NULL DEFAULT '0.00',
  `employerec` decimal(12,2) NOT NULL DEFAULT '0.00',
  `employeess` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prlsstable`
--

INSERT INTO `prlsstable` (`bracket`, `rangefrom`, `rangeto`, `salarycredit`, `employerss`, `employerec`, `employeess`, `total`) VALUES
(1, '1000.00', '1249.99', '1000.00', '60.70', '10.00', '33.30', '104.00'),
(2, '1250.00', '1749.99', '1500.00', '91.70', '10.00', '50.00', '151.00'),
(3, '1750.00', '2249.99', '2000.00', '121.30', '10.00', '66.70', '198.00'),
(4, '2250.00', '2749.99', '2500.00', '151.70', '10.00', '83.30', '245.00'),
(5, '2750.00', '3249.99', '3000.00', '182.00', '10.00', '100.00', '292.00'),
(6, '3250.00', '3749.99', '3500.00', '212.30', '10.00', '116.70', '339.00'),
(7, '3750.00', '4249.99', '4000.00', '242.70', '10.00', '133.30', '386.00'),
(8, '4250.00', '4749.99', '4500.00', '273.00', '10.00', '150.00', '433.00'),
(9, '4750.00', '5249.99', '5000.00', '303.30', '10.00', '166.70', '480.00'),
(10, '5250.00', '5749.99', '5500.00', '333.70', '10.00', '183.30', '527.00'),
(11, '5750.00', '6249.99', '6000.00', '364.00', '10.00', '200.00', '574.00'),
(12, '6250.00', '6749.99', '6500.00', '394.30', '10.00', '216.70', '621.00'),
(13, '6750.00', '7249.99', '7000.00', '424.70', '10.00', '233.30', '668.00'),
(14, '7250.00', '7749.99', '7500.00', '455.00', '10.00', '250.00', '715.00'),
(15, '7750.00', '8249.99', '8000.00', '485.30', '10.00', '266.70', '762.00'),
(16, '8250.00', '8749.99', '8500.00', '515.70', '10.00', '283.30', '809.00'),
(17, '8750.00', '9249.99', '9000.00', '546.00', '10.00', '300.00', '856.00'),
(18, '9250.00', '9749.99', '9500.00', '576.30', '10.00', '316.70', '903.00'),
(19, '9750.00', '10249.99', '10000.00', '606.70', '10.00', '333.30', '950.00'),
(20, '10250.00', '10749.99', '10500.00', '637.00', '10.00', '350.00', '997.00'),
(21, '10750.00', '11249.99', '11000.00', '667.30', '10.00', '366.70', '1044.00'),
(22, '11250.00', '11749.99', '11500.00', '697.30', '10.00', '383.30', '1091.00'),
(23, '11750.00', '12249.99', '12000.00', '728.00', '10.00', '400.00', '1138.00'),
(24, '12250.00', '12749.99', '12500.00', '758.30', '10.00', '416.70', '1185.00'),
(25, '12750.00', '13249.99', '13000.00', '788.70', '10.00', '433.30', '1232.00'),
(26, '13250.00', '13749.99', '13500.00', '819.00', '10.00', '450.00', '1279.00'),
(27, '13750.00', '14249.99', '14000.00', '849.30', '10.00', '466.70', '1326.00'),
(28, '14250.00', '14749.99', '14500.00', '879.70', '10.00', '483.30', '1373.00'),
(29, '14750.00', '999999.00', '15000.00', '910.00', '10.00', '500.00', '1420.00');

-- --------------------------------------------------------

--
-- Table structure for table `prltaxstatus`
--

CREATE TABLE `prltaxstatus` (
  `taxstatusid` varchar(10) NOT NULL DEFAULT '',
  `taxstatusdescription` varchar(40) NOT NULL DEFAULT '',
  `personalexemption` decimal(12,2) NOT NULL DEFAULT '0.00',
  `additionalexemption` decimal(12,2) NOT NULL DEFAULT '0.00',
  `totalexemption` decimal(12,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prltaxstatus`
--

INSERT INTO `prltaxstatus` (`taxstatusid`, `taxstatusdescription`, `personalexemption`, `additionalexemption`, `totalexemption`) VALUES
('HF', 'Head of the Family', '25000.00', '0.00', '25000.00'),
('HF1', 'Head of the Family with 1 dependent', '25000.00', '8000.00', '33000.00'),
('HF2', 'Head of the Family with 2 dependent', '25000.00', '16000.00', '41000.00'),
('HF3', 'Head of the Family with 3 dependent', '25000.00', '24000.00', '49000.00'),
('HF4', 'Head of the Family with 4 dependent', '25000.00', '32000.00', '57000.00'),
('ME', 'Married', '32000.00', '0.00', '32000.00'),
('ME1', 'Married with 1 dependent', '32000.00', '8000.00', '40000.00'),
('ME2', 'Married with 2 dependent', '32000.00', '16000.00', '48000.00'),
('ME3', 'Married with 3 dependent', '32000.00', '24000.00', '56000.00'),
('ME4', 'Married with 4 dependent', '32000.00', '32000.00', '64000.00'),
('S', 'Single', '20000.00', '0.00', '20000.00'),
('Z', 'Zero Exemption', '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `prltaxtablerate`
--

CREATE TABLE `prltaxtablerate` (
  `bracket` tinyint(4) NOT NULL DEFAULT '0',
  `rangefrom` decimal(12,2) NOT NULL DEFAULT '0.00',
  `rangeto` decimal(12,2) NOT NULL DEFAULT '0.00',
  `fixtaxableamount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `fixtax` decimal(12,2) NOT NULL DEFAULT '0.00',
  `percentofexcessamount` double NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prltaxtablerate`
--

INSERT INTO `prltaxtablerate` (`bracket`, `rangefrom`, `rangeto`, `fixtaxableamount`, `fixtax`, `percentofexcessamount`) VALUES
(1, '0.00', '9999.99', '0.00', '0.00', 5),
(2, '10000.00', '29999.99', '10000.00', '500.00', 10),
(3, '30000.00', '69999.99', '30000.00', '2500.00', 15),
(4, '70000.00', '139999.99', '70000.00', '8500.00', 20),
(5, '140000.00', '249999.99', '140000.00', '22500.00', 25),
(6, '250000.00', '499999.99', '250000.00', '50000.00', 30),
(7, '500000.00', '99999999.99', '500000.00', '125000.00', 32);

-- --------------------------------------------------------

--
-- Table structure for table `securitygroups`
--

CREATE TABLE `securitygroups` (
  `secroleid` int(11) NOT NULL DEFAULT '0',
  `tokenid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `securitygroups`
--

INSERT INTO `securitygroups` (`secroleid`, `tokenid`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(2, 11),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 11),
(4, 1),
(4, 2),
(4, 5),
(5, 1),
(5, 2),
(5, 3),
(5, 11),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(6, 6),
(6, 7),
(6, 8),
(6, 9),
(6, 10),
(6, 11),
(7, 1),
(8, 1),
(8, 2),
(8, 3),
(8, 4),
(8, 5),
(8, 6),
(8, 7),
(8, 8),
(8, 9),
(8, 10),
(8, 11),
(8, 12),
(8, 13),
(8, 14),
(8, 15);

-- --------------------------------------------------------

--
-- Table structure for table `securityroles`
--

CREATE TABLE `securityroles` (
  `secroleid` int(11) NOT NULL,
  `secrolename` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `securityroles`
--

INSERT INTO `securityroles` (`secroleid`, `secrolename`) VALUES
(1, 'Inquiries/Order Entry'),
(2, 'Manufac/Stock Admin'),
(3, 'Purchasing Officer'),
(4, 'AP Clerk'),
(5, 'AR Clerk'),
(6, 'Accountant'),
(7, 'Customer Log On Only'),
(8, 'System Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `securitytokens`
--

CREATE TABLE `securitytokens` (
  `tokenid` int(11) NOT NULL DEFAULT '0',
  `tokenname` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `securitytokens`
--

INSERT INTO `securitytokens` (`tokenid`, `tokenname`) VALUES
(1, 'Order Entry/Inquiries customer access only'),
(2, 'Basic Reports and Inquiries with selection options'),
(3, 'Credit notes and AR management'),
(4, 'Purchasing data/PO Entry/Reorder Levels'),
(5, 'Accounts Payable'),
(6, 'Not Used'),
(7, 'Bank Reconciliations'),
(8, 'General ledger reports/inquiries'),
(9, 'Not Used'),
(10, 'General Ledger Maintenance, stock valuation & Configuration'),
(11, 'Inventory Management and Pricing'),
(12, 'Unknown'),
(13, 'Unknown'),
(14, 'Unknown'),
(15, 'User Management and System Administration');

-- --------------------------------------------------------

--
-- Table structure for table `workcentres`
--

CREATE TABLE `workcentres` (
  `code` char(5) NOT NULL DEFAULT '',
  `location` char(5) NOT NULL DEFAULT '',
  `description` char(20) NOT NULL DEFAULT '',
  `capacity` double NOT NULL DEFAULT '1',
  `overheadperhour` decimal(10,0) NOT NULL DEFAULT '0',
  `overheadrecoveryact` int(11) NOT NULL DEFAULT '0',
  `setuphrs` decimal(10,0) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `workcentres`
--

INSERT INTO `workcentres` (`code`, `location`, `description`, `capacity`, `overheadperhour`, `overheadrecoveryact`, `setuphrs`) VALUES
('ACT', '', 'Accounting', 1, '50', 560000, '0'),
('ASS', 'TOR', 'Assembly', 1, '50', 560000, '0'),
('EDP', '', 'EDP', 1, '50', 560000, '0'),
('FIN', '', 'Finishing', 1, '50', 560000, '0'),
('MAR', '', 'Marketing', 1, '50', 560000, '0'),
('QA', '', 'Quality Control', 1, '50', 560000, '0'),
('SAL', '', 'Sales', 1, '50', 560000, '0');

-- --------------------------------------------------------

--
-- Table structure for table `www_users`
--

CREATE TABLE `www_users` (
  `userid` varchar(20) NOT NULL DEFAULT '',
  `password` text NOT NULL,
  `realname` varchar(35) NOT NULL DEFAULT '',
  `customerid` varchar(10) NOT NULL DEFAULT '',
  `phone` varchar(30) NOT NULL DEFAULT '',
  `email` varchar(55) DEFAULT NULL,
  `defaultlocation` varchar(5) NOT NULL DEFAULT '',
  `fullaccess` int(11) NOT NULL DEFAULT '1',
  `lastvisitdate` datetime DEFAULT NULL,
  `branchcode` varchar(10) NOT NULL DEFAULT '',
  `pagesize` varchar(20) NOT NULL DEFAULT 'A4',
  `modulesallowed` varchar(20) NOT NULL DEFAULT '',
  `blocked` tinyint(4) NOT NULL DEFAULT '0',
  `displayrecordsmax` int(11) NOT NULL DEFAULT '0',
  `theme` varchar(30) NOT NULL DEFAULT 'fresh',
  `language` varchar(5) NOT NULL DEFAULT 'en_GB'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `www_users`
--

INSERT INTO `www_users` (`userid`, `password`, `realname`, `customerid`, `phone`, `email`, `defaultlocation`, `fullaccess`, `lastvisitdate`, `branchcode`, `pagesize`, `modulesallowed`, `blocked`, `displayrecordsmax`, `theme`, `language`) VALUES
('demo', 'anahaw', 'Demo User', '', '', '', 'DEN', 8, '2006-01-01 21:34:05', '', 'A4', '1,1,1,1,1,1,1,1,1,1,', 0, 50, 'professional', 'en_GB');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chartmaster`
--
ALTER TABLE `chartmaster`
  ADD PRIMARY KEY (`accountcode`),
  ADD KEY `AccountCode` (`accountcode`),
  ADD KEY `AccountName` (`accountname`),
  ADD KEY `Group_` (`group_`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`coycode`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`confname`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`currabrev`),
  ADD KEY `Country` (`country`);

--
-- Indexes for table `prldailytrans`
--
ALTER TABLE `prldailytrans`
  ADD PRIMARY KEY (`counterindex`),
  ADD KEY `RTDate` (`rtdate`);

--
-- Indexes for table `prlemphdmffile`
--
ALTER TABLE `prlemphdmffile`
  ADD PRIMARY KEY (`counterindex`);

--
-- Indexes for table `prlemployeemaster`
--
ALTER TABLE `prlemployeemaster`
  ADD PRIMARY KEY (`employeeid`),
  ADD KEY `EmployeeName` (`lastname`,`firstname`);

--
-- Indexes for table `prlemploymentstatus`
--
ALTER TABLE `prlemploymentstatus`
  ADD PRIMARY KEY (`employmentid`);

--
-- Indexes for table `prlempphfile`
--
ALTER TABLE `prlempphfile`
  ADD PRIMARY KEY (`counterindex`);

--
-- Indexes for table `prlempsssfile`
--
ALTER TABLE `prlempsssfile`
  ADD PRIMARY KEY (`counterindex`);

--
-- Indexes for table `prlemptaxfile`
--
ALTER TABLE `prlemptaxfile`
  ADD PRIMARY KEY (`counterindex`);

--
-- Indexes for table `prlhdmftable`
--
ALTER TABLE `prlhdmftable`
  ADD PRIMARY KEY (`bracket`);

--
-- Indexes for table `prlloandeduction`
--
ALTER TABLE `prlloandeduction`
  ADD PRIMARY KEY (`counterindex`);

--
-- Indexes for table `prlloanfile`
--
ALTER TABLE `prlloanfile`
  ADD PRIMARY KEY (`loanfileid`),
  ADD KEY `LoanDate` (`loandate`);

--
-- Indexes for table `prlloantable`
--
ALTER TABLE `prlloantable`
  ADD PRIMARY KEY (`loantableid`);

--
-- Indexes for table `prlothincfile`
--
ALTER TABLE `prlothincfile`
  ADD PRIMARY KEY (`counterindex`),
  ADD KEY `OthDate` (`othdate`);

--
-- Indexes for table `prlothinctable`
--
ALTER TABLE `prlothinctable`
  ADD PRIMARY KEY (`othincid`);

--
-- Indexes for table `prlottrans`
--
ALTER TABLE `prlottrans`
  ADD PRIMARY KEY (`counterindex`),
  ADD KEY `Account` (`accountcode`),
  ADD KEY `OTDate` (`otdate`);

--
-- Indexes for table `prlovertimetable`
--
ALTER TABLE `prlovertimetable`
  ADD PRIMARY KEY (`overtimeid`);

--
-- Indexes for table `prlpayperiod`
--
ALTER TABLE `prlpayperiod`
  ADD PRIMARY KEY (`payperiodid`);

--
-- Indexes for table `prlpayrollperiod`
--
ALTER TABLE `prlpayrollperiod`
  ADD PRIMARY KEY (`payrollid`);

--
-- Indexes for table `prlpayrolltrans`
--
ALTER TABLE `prlpayrolltrans`
  ADD PRIMARY KEY (`counterindex`);

--
-- Indexes for table `prlphilhealth`
--
ALTER TABLE `prlphilhealth`
  ADD PRIMARY KEY (`bracket`);

--
-- Indexes for table `prlsstable`
--
ALTER TABLE `prlsstable`
  ADD PRIMARY KEY (`bracket`);

--
-- Indexes for table `prltaxstatus`
--
ALTER TABLE `prltaxstatus`
  ADD PRIMARY KEY (`taxstatusid`);

--
-- Indexes for table `prltaxtablerate`
--
ALTER TABLE `prltaxtablerate`
  ADD PRIMARY KEY (`bracket`);

--
-- Indexes for table `securitygroups`
--
ALTER TABLE `securitygroups`
  ADD PRIMARY KEY (`secroleid`,`tokenid`),
  ADD KEY `secroleid` (`secroleid`),
  ADD KEY `tokenid` (`tokenid`);

--
-- Indexes for table `securityroles`
--
ALTER TABLE `securityroles`
  ADD PRIMARY KEY (`secroleid`);

--
-- Indexes for table `securitytokens`
--
ALTER TABLE `securitytokens`
  ADD PRIMARY KEY (`tokenid`);

--
-- Indexes for table `workcentres`
--
ALTER TABLE `workcentres`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `www_users`
--
ALTER TABLE `www_users`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `CustomerID` (`customerid`),
  ADD KEY `DefaultLocation` (`defaultlocation`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `prldailytrans`
--
ALTER TABLE `prldailytrans`
  MODIFY `counterindex` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prlemphdmffile`
--
ALTER TABLE `prlemphdmffile`
  MODIFY `counterindex` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prlempphfile`
--
ALTER TABLE `prlempphfile`
  MODIFY `counterindex` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prlempsssfile`
--
ALTER TABLE `prlempsssfile`
  MODIFY `counterindex` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prlemptaxfile`
--
ALTER TABLE `prlemptaxfile`
  MODIFY `counterindex` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prlloandeduction`
--
ALTER TABLE `prlloandeduction`
  MODIFY `counterindex` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prlothincfile`
--
ALTER TABLE `prlothincfile`
  MODIFY `counterindex` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prlottrans`
--
ALTER TABLE `prlottrans`
  MODIFY `counterindex` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prlpayrolltrans`
--
ALTER TABLE `prlpayrolltrans`
  MODIFY `counterindex` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `securityroles`
--
ALTER TABLE `securityroles`
  MODIFY `secroleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `securitygroups`
--
ALTER TABLE `securitygroups`
  ADD CONSTRAINT `securitygroups_secroleid_fk` FOREIGN KEY (`secroleid`) REFERENCES `securityroles` (`secroleid`),
  ADD CONSTRAINT `securitygroups_tokenid_fk` FOREIGN KEY (`tokenid`) REFERENCES `securitytokens` (`tokenid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
