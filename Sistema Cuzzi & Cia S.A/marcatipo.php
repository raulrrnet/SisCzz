<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

// Load the common classes
require_once('includes/common/KT_common.php');

// Load the tNG classes
require_once('includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("");

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("marcatipo", true, "text", "", "", "", "");
$formValidation->addField("idmaterial", true, "numeric", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an insert transaction instance
$ins_marcatipo = new tNG_insert($cnx_cuzzicia);
$tNGs->addTransaction($ins_marcatipo);
// Register triggers
$ins_marcatipo->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_marcatipo->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_marcatipo->registerTrigger("END", "Trigger_Default_Redirect", 99, "nuevo.php");
// Add columns
$ins_marcatipo->setTable("marcatipo");
$ins_marcatipo->addColumn("marcatipo", "STRING_TYPE", "POST", "marcatipo");
$ins_marcatipo->setPrimaryKey("idmarcatipo", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsmarcatipo = $tNGs->getRecordset("marcatipo");
$totalRows_rsmarcatipo = $rsmarcatipo->RecordCount();

//PHP ADODB document - made with PHAkt 3.6.0
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Marca/Tipo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script src="includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
     <tr>
      <td colspan="2" class="KT_th">NUEVA MARCA O TIPO</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
	<tr>
      <td class="KT_th"><label for="marcatipo">Marcatipo:</label>
      </td>
      <td>
        <input type="text" name="marcatipo" id="marcatipo" value="<?php echo KT_escapeAttribute($rsmarcatipo->Fields('marcatipo')); ?>" size="32" />
        <?php echo $tNGs->displayFieldHint("marcatipo");?> <?php echo $tNGs->displayFieldError("marcatipo", "marcatipo"); ?> </td>
    </tr>
	<tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2">
        <input type="reset" name="KT_Insert12" id="KT_Insert13" value="Cancelar" />
        <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Guardar"/>
      </td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
