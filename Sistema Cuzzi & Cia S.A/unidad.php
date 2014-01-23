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
$formValidation->addField("unidad", true, "text", "", "", "", "");
$formValidation->addField("idmedida", true, "numeric", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an insert transaction instance
$ins_unidad = new tNG_insert($cnx_cuzzicia);
$tNGs->addTransaction($ins_unidad);
// Register triggers
$ins_unidad->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_unidad->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_unidad->registerTrigger("END", "Trigger_Default_Redirect", 99, "nuevo.php");
// Add columns
$ins_unidad->setTable("unidad");
$ins_unidad->addColumn("unidad", "STRING_TYPE", "POST", "unidad");
$ins_unidad->setPrimaryKey("idunidad", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsunidad = $tNGs->getRecordset("unidad");
$totalRows_rsunidad = $rsunidad->RecordCount();

//PHP ADODB document - made with PHAkt 3.6.0
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Unidades</title>
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
      <td colspan="2" class="KT_th">NUEVA UNIDAD</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
	<tr>
      <td class="KT_th"><label for="unidad">Unidad:</label>
      </td>
      <td>
        <input type="text" name="unidad" id="unidad" value="<?php echo KT_escapeAttribute($rsunidad->Fields('unidad')); ?>" size="32" />
        <?php echo $tNGs->displayFieldHint("unidad");?> <?php echo $tNGs->displayFieldError("unidad", "unidad"); ?> </td>
    </tr>
	<tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2">
        <input type="reset" name="cancel" id="cancel" value="Cancelar" />
        <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Aceptar"/>
      </td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
