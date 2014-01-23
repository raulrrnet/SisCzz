<?php
//MX Widgets3 include
require_once('includes/wdg/WDG.php');

//PHP ADODB document - made with PHAkt 3.7.1
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="includes/common/js/sigslot_core.js"></script>
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="includes/resources/calendar.js"></script>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>
<body>
<form action="consumos.php" method="post" name="frm_salidas">
  <table border="0" class="KT_tngtable">
    <tr>
      <td colspan="2">Consumos</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Fecha Inicio </td>
      <td><label>
        <input name="fecini" id="fecini" value="" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no" />
      </label></td>
    </tr>
    <tr>
      <td>Fecha Fin </td>
      <td><label>
        <input name="fecfin" id="fecfin" value="" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Consultar" /></td>
    </tr>
  </table>
</form>
</body>
</html>
