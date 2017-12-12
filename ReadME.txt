Anahaw Open Payroll System (AOPS)
http://sourceforge.net/projects/openpayroll/
http://groups.yahoo.com/group/openpayroll/
http://cdnpayroll.gemlog.ca/

Developer
     Eliseo N. Tejada, CPA
     Email : eliseo_tejada@yahoo.com
     Mobile #: 00639212810683    
     Tel #: 0063-46-5027947
    Resume: search the web type : Resume of Mr. Eliseo Tejada
	
	
    Other Program Developed
  
	World Clock,   ( http://sourceforge.net/projects/anagmt/
	World Currency Calculator,  (email me)
	Anahaw Internet Cafe Timer  ( http://sourceforge.net/projects/anatimer/)

Contributor
     Wanted

Tester
    Wanted
	
OVERVIEW
Anahaw Open Payroll System is an open source  window/linux based payroll program especially designed for Philippines. It can be used by other countries with similar tax setup or it can be easily modified to suite any particular need.
·	Unparalleled reliability 
·	Low cost, wide area networking 
·	A common interface available on all computers - a web browser 
·	Minimal investment in infrastructure - the Internet is built largely on open source software 

Implementation
As an add-on module for webERP (see www.weberp.org )
As stand alone payroll application.



FEATURES
·	Web Browser User Interface 
·	Interactive and menu-driven program 
·	Automatic maintenance and retrieval of employee records 
·	Payroll Deduction (user configuration unlimited)  
·	Automatic computation of monthly net income, statutory deduction (PAG-IBIG, Withholding Tax, SSS and PhilHealth). 
·	Can create multiple payroll
·	Standard and Customized Report 
·	Password security to ensure the integrity of data  
Features 
·	Handles any type of payroll (Daily,Bi-weekly,Weekly,Semi-Monthly,Monthly,Bi-annual, Annual)
·	Ability to withhold or not withhold deductions for SSS, Philheath, Pag-ibig and BIR for each employee 
·	Create diskette reports for SSS, Philheath, Pag-ibig and BIR 
·	Tracks different types of loans such as Salary loan, Pag-ibig loan, and SSS loan, Car Loan 
·	Tracks user defined leaves such as vacation leaves, sick leaves, maternity leaves, paternity leaves and others* 
·	Generate pay slip, payroll register and other reports 

	
REPORTS
·	Payroll Summary sheet 
·	Pay Slip 
·	Bank Transmittal 
·	Journal Entries
·	Philippine Government Statutory Reports
·	Can Create Customized Report

HARDWARE/SOFTWARE REQUIREMENTS (taken from webERP)
Hardware:
There are a many possible configurations that could run this application. The scale of the enterprise obviously will have a significant bearing on the final configuration. 

The operating system and the database engine chosen will have the largest bearing on the System requirements. Each client connection to the web server and database engine will also consume RAM so the more connections the larger the RAM requirement. Similarly disk space required is a function of the volume of customers, suppliers and transactions. Suffice it to say that due to the efficiency of the components of the system the demands on the hardware are exceptionally light by client server application standards. 

As a guide the minimal installation for up to 50 simultaneous users, using a Linux operating system and an Apache web server, could use an entry level server with 512Meg RAM a 10 Megabit network would give more than adequate performance 100 Megabit is now entry level. RAID SCSI swappable disks are preferred in any mission critical environment where disk access is intensive. 

Multiple servers with with SMP and load balancing and a separate database server and large amounts of RAM the limit on database size and the number of users is large enough for the most demanding businesses.
Software Requirements (taken from webERP)
·	PHP greater than 4.2. The system is therefore operating system independent since PHP can be configured as a CGI module for use on MS IIS or as a module for Apache under either Windows (NT, 2000 or XP) or Unix/Linux. It has been tested under both windows (NT and XP) and linux. 
·	MySQL greater than version 4, with Innodb transactional tables support - foreign key constraints are also required - these were added to Innodb in 2003. Innodb was introduced in 2001 to MySQL and has oracle like functionality - row level locking and database transactions with similar speed. (The system could be used with Oracle or other database systems, with minimal modification) An example configuration file my.cnf normally under /usr/local/mysql/var is available in the mysql documentation to show typical settings for the innodb configuration. The expected size of the data is useful although innodb can create an auto-extending data file and does so by default as of MySQL 4. All tables are defined as Innodb tables as of version 2.8. 
·	A web server. Apache - the software serving nearly 70% of all web pages - is recommended - but most web servers are supported by PHP in various forms the most popular choice on windows will likley be MS IIS. 
·	If the web server is accessible over the internet ie not just over a LAN then encrypted communications are required. The openssl and mod-ssl module for apache can be used easily to ensure all data is transmitted in encrypted form. 



Creating Payroll

Steps in Creating Payroll

a) Enter Employees Data(Employee Master Record)
b) Enter Regular Time Data Entry for hourly employees (for salaried employees no need to enter)
c) Enter Overtime, Loan deduction
d) Create Payroll(under  Transaction - Create/Modify/Edit Payroll)
e) Select Payroll that you have created(under  Transaction - Create/Modify/Edit Payroll)
f) Once you have selected(press Generate Payroll Data)
g) Now you have a payroll to view or print.

Steps in Modifing Payroll

Once payroll is prepared by pressing Generate Payroll Data and you found some correction.

a) Edit Source for correction(e.g Employee record, regular time, loan, etc.)
b) Select Payroll that you have correction(under  Transaction - Create/Modify/Edit Payroll)
c) Once you have selected(press Generate Payroll Data)
d) Now you have a modified payroll to view or print.

Closing Payroll

Once payroll is finished and you prepared for next payroll period you should closed the previous payroll.
Closing the previous payroll will update loan amortization and number of actual payday(for tax computation).
Anyway, you can still re-open if necessary.

Re-open Payroll

Once payroll is closed and you need to modify the payroll data(means you have correction) you have to re-open it.
