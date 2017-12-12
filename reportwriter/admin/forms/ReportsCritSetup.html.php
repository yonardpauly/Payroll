<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!-- saved from url=(0144)http://cvs.sourceforge.net/viewcvs.py/*checkout*/web-erp/webERP/reportwriter/admin/forms/ReportsCritSetup.html?content-type=text%2Fplain&rev=1.5 -->
<HTML><HEAD>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<META content="MSHTML 6.00.2800.1106" name=GENERATOR></HEAD>
<BODY>
<H2 align=center><?php echo $FormParams['heading'].$reportname.' - '.RPT_BTN_CRIT; ?></h2>
<form name="CritFieldForm" method="post" action="ReportCreator.php?action=step7">
  <input name="ReportID" type="hidden" value="<?php echo $ReportID; ?>">
  <input name="Type" type="hidden" value="<?php echo $Type; ?>">
  <input name="ReportName" type="hidden" value="<?php echo $reportname; ?>">
  <table align="center" width="550" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="33%"><input name="todo" type="submit" id="todo" value="<?php echo RPT_BTN_BACK; ?>"></td>
      <td width="34%"><div align="center"><input name="todo" type="submit" id="todo" value="<?php echo RPT_BTN_UPDATE; ?>"></div></td>
      <td width="33%"><div align="right"><input name="todo" type="submit" id="todo" value="<?php echo RPT_BTN_FINISH; ?>"></div></td>
    </tr>
  </table>
  <table width="700" align="center" border="2" cellspacing="1" cellpadding="1">
    <tr bgcolor="#CCCCCC">
      <td colspan="3"><div align="center"><?php echo RPT_DATEINFO; ?></div></td>
    </tr>
    <tr>
      <td width="33%"><?php echo RPT_DATELIST; ?><br><br><?php echo RPT_DATEINST; ?></td>
      <td width="33%">
	    <?php if (strpos($DateListings['displaydesc'],'a')===false) $Checked = ''; else $Checked = ' checked'; ?><INPUT 
type=checkbox value=a name=DateRange1 ? $Checked; ?>&gt;<?php echo $DateChoices['a']; ?><BR><?php if (strpos($DateListings['displaydesc'],'b')===false) $Checked = ''; else $Checked = ' checked'; ?><INPUT 
type=checkbox value=b name=DateRange2 ? $Checked; ?>&gt;<?php echo $DateChoices['b']; ?><BR><?php if (strpos($DateListings['displaydesc'],'c')===false) $Checked = ''; else $Checked = ' checked'; ?><INPUT 
type=checkbox value=c name=DateRange3 ? $Checked; ?>&gt;<?php echo $DateChoices['c']; ?><BR><?php if (strpos($DateListings['displaydesc'],'d')===false) $Checked = ''; else $Checked = ' checked'; ?><INPUT 
type=checkbox value=d name=DateRange4 ? $Checked; ?>&gt;<?php echo $DateChoices['d']; ?><BR><?php if (strpos($DateListings['displaydesc'],'e')===false) $Checked = ''; else $Checked = ' checked'; ?><INPUT 
type=checkbox value=e name=DateRange5 ? $Checked; ?>&gt;<?php echo $DateChoices['e']; ?><BR><?php if (strpos($DateListings['displaydesc'],'f')===false) $Checked = ''; else $Checked = ' checked'; ?><INPUT 
type=checkbox value=f name=DateRange6 ? $Checked; ?>&gt;<?php echo $DateChoices['f']; ?><BR></TD><TD width="33%"><?php if (strpos($DateListings['displaydesc'],'g')===false) $Checked = ''; else $Checked = ' checked'; ?><INPUT 
type=checkbox value=g name=DateRange7 ? $Checked; ?>&gt;<?php echo $DateChoices['g']; ?><BR><?php if (strpos($DateListings['displaydesc'],'h')===false) $Checked = ''; else $Checked = ' checked'; ?><INPUT 
type=checkbox value=h name=DateRange8 ? $Checked; ?>&gt;<?php echo $DateChoices['h']; ?><BR><?php if (strpos($DateListings['displaydesc'],'i')===false) $Checked = ''; else $Checked = ' checked'; ?><INPUT 
type=checkbox value=i name=DateRange9 ? $Checked; ?>&gt;<?php echo $DateChoices['i']; ?><BR><?php if (strpos($DateListings['displaydesc'],'j')===false) $Checked = ''; else $Checked = ' checked'; ?><INPUT 
type=checkbox value=j name=DateRange10 ? $Checked; ?>&gt;<?php echo $DateChoices['j']; ?><BR><?php if (strpos($DateListings['displaydesc'],'k')===false) $Checked = ''; else $Checked = ' checked'; ?><INPUT 
type=checkbox value=k name=DateRange11 ? $Checked; ?>&gt;<?php echo $DateChoices['k']; ?><BR></TD></TR><TR><TD><?php echo RPT_DATEDEF; ?></TD><TD 
colspan="2"><SELECT name=DefDate> $value) { if ($DateListings['params']==$key) 
  $Selected = ' selected'; else $Selected = ''; echo '<OPTION value="'.$key.'" 
  selected ?.$Selected.?>'.$value.'</OPTION>'; } ?&gt;</SELECT></TD> </TR><TR><TD><?php echo RPT_DATEFNAME; ?></TD><TD colspan="4"><SELECT 
name=DateField><OPTION value="" selected></OPTION></SELECT> </TD></TR><?php if ($Type<>'frm') { ?>&gt; 
<TR><TD><?php echo RPT_TRUNC; ?></TD><TD colspan="4">
<P><?php if ($TruncListings['params']=='1') $Checked = ' checked'; else $Checked = ''; ?><INPUT 
type=radio value=1 name=TruncLongDesc ? $Checked; ?>&gt;<?php echo RPT_YES; ?> <?php if ($TruncListings['params']=='0') $Checked = ' checked'; else $Checked = ''; ?><INPUT 
type=radio value=0 name=TruncLongDesc ? $Checked; ?>&gt;<?php echo RPT_NO; ?></P></TD></TR><?php } else { ?><TR><TD><?php echo 'Form Page Break Field (table.fieldname)'; ?></TD><TD 
colspan="4"><SELECT name=FormBreakField><OPTION value="" 
selected></OPTION></SELECT> </TD></TR><?php } ?> // end if ($Type<>'frm') ?&gt; 
</TABLE></FORM>
<TABLE cellSpacing=1 cellPadding=1 align=center 
  border=2><?php if ($Type<>'frm') { // then show the sort and group information 
  ?>&gt; 
  <TBODY>
  <TR bgColor=#cccccc>
    <TD colSpan=5>
      <DIV align=center><?php echo RPT_GRPLIST; ?></DIV></TD></TR>
  <TR>
    <TD><?php echo RPT_SEQ; ?></TD>
    <TD align=middle><?php echo RPT_TBLFNAME; ?></TD>
    <TD align=middle><?php echo RPT_DISPNAME; ?></TD>
    <TD align=middle><?php echo RPT_DEFAULT; ?></TD>
    <TD>&nbsp;</TD></TR>
  <TR>
    <FORM name=CritFieldForm action=ReportCreator.php?action=step7 
    method=post><INPUT type=hidden value="<?php echo $ReportID ?>" 
    name=ReportID> <INPUT type=hidden value="<?php echo $Type; ?>" name=Type> 
    <INPUT type=hidden value="<?php echo $reportname; ?>" name=ReportName> 
    <INPUT type=hidden value=grouplist name=EntryType> 
    <TD align=middle><?php if ($GroupListings['defaults']['buttonvalue']=='Change') { ?><INPUT 
      type=hidden value="<?php echo $GroupListings['defaults']['seqnum']; ?>" 
      name=SeqNum> 
      <?php echo $GroupListings['defaults']['seqnum']; } else { ?><INPUT 
      maxLength=3 size=4 
      value="<?php echo $GroupListings['defaults']['seqnum']; ?>" name=SeqNum> <?php } // end if ?></TD>
    <TD><SELECT name=FieldName><OPTION value="" selected></OPTION></SELECT> 
</TD>
    <TD><INPUT maxLength=25 size=26 
      value="<?php echo $GroupListings['defaults']['displaydesc']; ?>" 
      name=DisplayDesc> </TD>
    <TD>
      <DIV align=center><INPUT type=checkbox value=1 name=Params></DIV></TD>
    <TD align=middle><INPUT type=submit value="<?php echo $GroupListings['defaults']['buttonvalue']; ?>" name=todo> 
    </TD></FORM></TR><?php if (!$GroupListings['lists']) {
		echo '<tr><td align="center" colspan="7">'.RPT_NOFIELD.'</td></TR>'; 
  } else { foreach ($GroupListings['lists'] as $FieldDetails) { ?>&gt; 
  <TR>
    <FORM name=CritFieldForm action=ReportCreator.php?action=step7 
    method=post><INPUT type=hidden value="<?php echo $ReportID ?>" 
    name=ReportID> <INPUT type=hidden value="<?php echo $Type; ?>" name=Type> 
    <INPUT type=hidden value="<?php echo $reportname; ?>" name=ReportName> 
    <INPUT type=hidden value=grouplist name=EntryType> <INPUT type=hidden 
    value="<?php echo $FieldDetails['seqnum'] ?>" name=SeqNum> <INPUT 
    type=hidden value="<?php echo $FieldDetails['fieldname'] ?>" name=FieldName> 
    <INPUT type=hidden value="<?php echo $FieldDetails['displaydesc'] ?>" 
    name=DisplayDesc> <INPUT type=hidden 
    value="<?php echo $FieldDetails['params'] ?>" name=Params> 
    <TD align=middle><?php echo $FieldDetails['seqnum']; ?></TD>
    <TD><?php echo $FieldDetails['fieldname']; ?></TD>
    <TD><?php echo $FieldDetails['displaydesc']; ?></TD><?php if ($FieldDetails['params']=='1') $selected=' checked'; else $selected=''; ?>
    <TD align=middle><INPUT disabled type=checkbox ? echo <?php 
    $selected; ?>&gt;</TD>
    <TD><INPUT type=image src="" value=up border=0 name=up> <INPUT type=image 
      src="" value=down border=0 name=dn> <INPUT type=image src="" value=edit 
      border=0 name=ed> <INPUT onclick="return confirm('Delete this field?')" 
      type=image src="" value=delete border=0 name=rm> </TD></FORM></TR><?php } // end foreach 
	} // end else  ?>
  <TR bgColor=#cccccc>
    <TD colSpan=5>
      <DIV align=center><?php echo RPT_SORTLIST; ?></DIV></TD></TR>
  <TR>
    <TD><?php echo RPT_SEQ; ?></TD>
    <TD align=middle><?php echo RPT_TBLFNAME; ?></TD>
    <TD align=middle><?php echo RPT_DISPNAME; ?></TD>
    <TD align=middle><?php echo RPT_DEFAULT; ?></TD>
    <TD>&nbsp;</TD></TR>
  <TR>
    <FORM name=CritFieldForm action=ReportCreator.php?action=step7 
    method=post><INPUT type=hidden value="<?php echo $ReportID ?>" 
    name=ReportID> <INPUT type=hidden value="<?php echo $Type; ?>" name=Type> 
    <INPUT type=hidden value="<?php echo $reportname; ?>" name=ReportName> 
    <INPUT type=hidden value=sortlist name=EntryType> 
    <TD align=middle><?php if ($SortListings['defaults']['buttonvalue']=='Change') { ?><INPUT 
      type=hidden value="<?php echo $SortListings['defaults']['seqnum']; ?>" 
      name=SeqNum> 
      <?php echo $SortListings['defaults']['seqnum']; } else { ?><INPUT 
      maxLength=3 size=4 
      value="<?php echo $SortListings['defaults']['seqnum']; ?>" name=SeqNum> <?php } // end if ?></TD>
    <TD><SELECT name=FieldName><OPTION value="" selected></OPTION></SELECT> 
</TD>
    <TD><INPUT maxLength=25 size=26 
      value="<?php echo $SortListings['defaults']['displaydesc']; ?>" 
      name=DisplayDesc> </TD>
    <TD>
      <DIV align=center><INPUT type=checkbox value=1 name=Params> </DIV></TD>
    <TD align=middle><INPUT type=submit value="<?php echo $SortListings['defaults']['buttonvalue']; ?>" name=todo> 
    </TD></FORM></TR><?php if (!$SortListings['lists']) {
		echo '<tr><td align="center" colspan="7">'.RPT_NOFIELD.'</td></TR>'; 
  } else { foreach ($SortListings['lists'] as $FieldDetails) { ?>&gt; 
  <TR>
    <FORM name=CritFieldForm action=ReportCreator.php?action=step7 
    method=post><INPUT type=hidden value="<?php echo $ReportID ?>" 
    name=ReportID> <INPUT type=hidden value="<?php echo $Type; ?>" name=Type> 
    <INPUT type=hidden value="<?php echo $reportname; ?>" name=ReportName> 
    <INPUT type=hidden value=sortlist name=EntryType> <INPUT type=hidden 
    value="<?php echo $FieldDetails['seqnum'] ?>" name=SeqNum> <INPUT 
    type=hidden value="<?php echo $FieldDetails['fieldname'] ?>" name=FieldName> 
    <INPUT type=hidden value="<?php echo $FieldDetails['displaydesc'] ?>" 
    name=DisplayDesc> <INPUT type=hidden 
    value="<?php echo $FieldDetails['params'] ?>" name=Params> 
    <TD align=middle><?php echo $FieldDetails['seqnum']; ?></TD>
    <TD><?php echo $FieldDetails['fieldname']; ?></TD>
    <TD><?php echo $FieldDetails['displaydesc']; ?></TD><?php if ($FieldDetails['params']=='1') $selected=' checked'; else $selected=''; ?>
    <TD align=middle><INPUT disabled type=checkbox <?php 
    echo $selected; ?>&gt;</TD>
    <TD><INPUT type=image src="" value=up border=0 name=up> <INPUT type=image 
      src="" value=down border=0 name=dn> <INPUT type=image src="" value=edit 
      border=0 name=ed> <INPUT onclick="return confirm('Delete this field?')" 
      type=image src="" value=delete border=0 name=rm> </TD></FORM></TR><?php } // end foreach 
	} // end else 
} // end if ($Type<>'frm') 
  ?>&gt; 
  <TR bgColor=#cccccc>
    <TD colSpan=5>
      <DIV align=center><?php echo RPT_BTN_CRIT; ?></DIV></TD></TR>
  <TR>
    <TD><?php echo RPT_SEQ; ?></TD>
    <TD align=middle><?php echo RPT_TBLFNAME; ?></TD>
    <TD align=middle><?php echo RPT_DISPNAME; ?></TD>
    <TD align=middle><?php echo RPT_CRITTYPE; ?></TD>
    <TD>&nbsp;</TD></TR>
  <TR>
    <FORM name=CritFieldForm action=ReportCreator.php?action=step7 
    method=post><INPUT type=hidden value="<?php echo $ReportID ?>" 
    name=ReportID> <INPUT type=hidden value="<?php echo $Type; ?>" name=Type> 
    <INPUT type=hidden value="<?php echo $reportname; ?>" name=ReportName> 
    <INPUT type=hidden value=critlist name=EntryType> 
    <TD align=middle><?php if ($CritListings['defaults']['buttonvalue']=='Change') { ?><INPUT 
      type=hidden value="<?php echo $CritListings['defaults']['seqnum']; ?>" 
      name=SeqNum> 
      <?php echo $CritListings['defaults']['seqnum']; } else { ?><INPUT 
      maxLength=3 size=4 
      value="<?php echo $CritListings['defaults']['seqnum']; ?>" name=SeqNum> <?php } // end if ?></TD>
    <TD><SELECT name=FieldName><OPTION value="" selected></OPTION></SELECT> 
</TD>
    <TD><INPUT maxLength=25 size=26 
      value="<?php echo $CritListings['defaults']['displaydesc']; ?>" 
      name=DisplayDesc> </TD>
    <TD><SELECT name=Params> $value) { $value=substr($value,2); if 
        ($CritListings['defaults']['params']==$key) $selected = ' selected'; 
        else $selected = ''; echo '<OPTION value="'.$key.'" selected 
        ?.$selected.?>'.$value.'</OPTION>'; } ?&gt;</SELECT></TD>
    <TD align=middle><INPUT type=submit value="<?php echo $CritListings['defaults']['buttonvalue']; ?>" name=todo> 
    </TD></FORM></TR><?php if (!$CritListings['lists']) {
		echo '<tr><td align="center" colspan="7">'.RPT_NOFIELD.'</td></TR>'; 
  } else { foreach ($CritListings['lists'] as $FieldDetails) { ?>&gt; 
  <TR>
    <FORM name=CritFieldForm action=ReportCreator.php?action=step7 
    method=post><INPUT type=hidden value="<?php echo $ReportID ?>" 
    name=ReportID> <INPUT type=hidden value="<?php echo $Type; ?>" name=Type> 
    <INPUT type=hidden value="<?php echo $reportname; ?>" name=ReportName> 
    <INPUT type=hidden value=critlist name=EntryType> <INPUT type=hidden 
    value="<?php echo $FieldDetails['seqnum'] ?>" name=SeqNum> <INPUT 
    type=hidden value="<?php echo $FieldDetails['fieldname'] ?>" name=FieldName> 
    <INPUT type=hidden value="<?php echo $FieldDetails['displaydesc'] ?>" 
    name=DisplayDesc> <INPUT type=hidden 
    value="<?php echo $FieldDetails['params'] ?>" name=Params> 
    <TD align=middle><?php echo $FieldDetails['seqnum']; ?></TD>
    <TD><?php echo $FieldDetails['fieldname']; ?></TD>
    <TD><?php echo $FieldDetails['displaydesc']; ?></TD>
    <TD align=middle><?php echo substr($CritChoices[$FieldDetails['params']],2); ?></TD>
    <TD><INPUT type=image src="" value=up border=0 name=up> <INPUT type=image 
      src="" value=down border=0 name=dn> <INPUT type=image src="" value=edit 
      border=0 name=ed> <INPUT onclick="return confirm('Delete this field?')" 
      type=image src="" value=delete border=0 name=rm> </TD></FORM></TR><?php } // end foreach 
} // end else ?></TBODY></TABLE></H2></BODY></HTML>
