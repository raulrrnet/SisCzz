<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Start trigger
$masterValidation = new tNG_FormValidation();
$masterValidation->addField("descripcion", true, "text", "", "", "", "");
$masterValidation->addField("fecingreso", true, "date", "", "", "", "");
$masterValidation->addField("importe", true, "double", "", "", "", "");
$masterValidation->addField("tasa", true, "double", "", "", "", "");
$tNGs->prepareValidation($masterValidation);
// End trigger

// Start trigger
$detailValidation = new tNG_FormValidation();
$detailValidation->addField("idseccion", true, "numeric", "", "", "", "");
$detailValidation->addField("porcentaje", true, "double", "", "", "", "");
$tNGs->prepareValidation($detailValidation);
// End trigger

//start Trigger_LinkTransactions trigger
//remove this line if you want to edit the code by hand 
function Trigger_LinkTransactions(&$tNG) {
	global $ins_distribuciond;
  $linkObj = new tNG_LinkedTrans($tNG, $ins_distribuciond);
  $linkObj->setLink("iddeprecia");
  return $linkObj->Execute();
}
//end Trigger_LinkTransactions trigger

// begin Recordset
$query_seccion = "SELECT * FROM seccion WHERE status<>'x' ORDER BY seccion ASC";
$seccion = $cnx_cuzzicia->SelectLimit($query_seccion) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_seccion = $seccion->RecordCount();
// end Recordset

// Make an insert transaction instance
$ins_depreciacion = new tNG_insert($cnx_cuzzicia);
$tNGs->addTransaction($ins_depreciacion);
// Register triggers
$ins_depreciacion->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_depreciacion->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $masterValidation);
$ins_depreciacion->registerTrigger("END", "Trigger_Default_Redirect", 99, "costdepre.php");
$ins_depreciacion->registerTrigger("AFTER", "Trigger_LinkTransactions", 98);
$ins_depreciacion->registerTrigger("ERROR", "Trigger_LinkTransactions", 98);
// Add columns
$ins_depreciacion->setTable("depreciacion");
$ins_depreciacion->addColumn("descripcion", "STRING_TYPE", "POST", "descripcion");
$ins_depreciacion->addColumn("fecingreso", "DATE_TYPE", "POST", "fecingreso");
$ins_depreciacion->addColumn("importe", "DOUBLE_TYPE", "POST", "importe");
$ins_depreciacion->addColumn("tasa", "DOUBLE_TYPE", "POST", "tasa");
$ins_depreciacion->setPrimaryKey("iddeprecia", "NUMERIC_TYPE");

// Make an insert transaction instance
$ins_distribuciond = new tNG_insert($cnx_cuzzicia);
$tNGs->addTransaction($ins_distribuciond);
// Register triggers
$ins_distribuciond->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "VALUE", null);
$ins_distribuciond->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $detailValidation);
// Add columns
$ins_distribuciond->setTable("distribuciond");
$ins_distribuciond->addColumn("idseccion", "NUMERIC_TYPE", "POST", "idseccion");
$ins_distribuciond->addColumn("porcentaje", "DOUBLE_TYPE", "POST", "porcentaje");
$ins_distribuciond->addColumn("iddeprecia", "NUMERIC_TYPE", "VALUE", "");
$ins_distribuciond->setPrimaryKey("iddistribd", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsdepreciacion = $tNGs->getRecordset("depreciacion");
$totalRows_rsdepreciacion = $rsdepreciacion->RecordCount();

// Get the transaction recordset
$rsdistribuciond = $tNGs->getRecordset("distribuciond");
$totalRows_rsdistribuciond = $rsdistribuciond->RecordCount();

//PHP ADODB document - made with PHAkt 3.7.1
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ingresos</title>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="../includes/resources/calendar.js"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?></head>
<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">Drepreciacion Costo/Distribicion</td>
    </tr>
    <tr>
      <td colspan="2" class="KT_th">&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th"><label for="descripcion">Descripcion:</label>
      </td>
      <td>
        <input type="text" name="descripcion" id="descripcion" value="<?php echo KT_escapeAttribute($rsdepreciacion->Fields('descripcion')); ?>" size="32" />
        <?php echo $tNGs->displayFieldHint("descripcion");?> <?php echo $tNGs->displayFieldError("depreciacion", "descripcion"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="fecingreso">Fecingreso:</label>
      </td>
      <td>
        <input name="fecingreso" id="fecingreso" value="<?php echo KT_formatDate($rsdepreciacion->Fields('fecingreso')); ?>" size="32" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no" />
        <?php echo $tNGs->displayFieldHint("fecingreso");?> <?php echo $tNGs->displayFieldError("depreciacion", "fecingreso"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="importe">Importe:</label>
      </td>
      <td>
        <input type="text" name="importe" id="importe" value="<?php echo KT_escapeAttribute($rsdepreciacion->Fields('importe')); ?>" size="32" />
        <?php echo $tNGs->displayFieldHint("importe");?> <?php echo $tNGs->displayFieldError("depreciacion", "importe"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="tasa">Tasa:</label>
      </td>
      <td>
        <input type="text" name="tasa" id="tasa" value="<?php echo KT_escapeAttribute($rsdepreciacion->Fields('tasa')); ?>" size="32" />
        %
        <?php echo $tNGs->displayFieldHint("tasa");?> <?php echo $tNGs->displayFieldError("depreciacion", "tasa"); ?> </td>
    </tr>
    <tr>
      <td colspan="2" class="KT_th">Distribici&oacute;n</td>
    </tr>
    <tr>
      <td class="KT_th"><label for="idseccion">Idseccion:</label>
      </td>
      <td>
        <select name="idseccion" id="idseccion">
          <?php
  while(!$seccion->EOF){
?>
          <option value="<?php echo $seccion->Fields('idseccion')?>"<?php if (!(strcmp($seccion->Fields('idseccion'), $rsdistribuciond->Fields('idseccion')))) {echo "SELECTED";} ?>><?php echo $seccion->Fields('seccion')?></option>
          <?php
    $seccion->MoveNext();
  }
  $seccion->MoveFirst();
?>
        </select>
        <?php echo $tNGs->displayFieldError("distribuciond", "idseccion"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="porcentaje">Porcentaje:</label>
      </td>
      <td>
        <input type="text" name="porcentaje" id="porcentaje" value="<?php echo KT_escapeAttribute($rsdistribuciond->Fields('porcentaje')); ?>" size="32" />
        <?php echo $tNGs->displayFieldHint("porcentaje");?> <?php echo $tNGs->displayFieldError("distribuciond", "porcentaje"); ?> </td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2">
        <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Aceptar" />
      </td>
    </tr>
  </table>
</form>
<p><a href="mantedepre.php">VER COSTOS DEPRECIACION</a></p>
</body>
</html>
<?php
$seccion->Close();
?>
