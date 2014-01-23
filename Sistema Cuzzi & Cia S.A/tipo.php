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
$formValidation->addField("tipoconsumo", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an insert transaction instance
$ins_tipoconsumo = new tNG_insert($cnx_cuzzicia);
$tNGs->addTransaction($ins_tipoconsumo);
// Register triggers
$ins_tipoconsumo->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_tipoconsumo->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_tipoconsumo->registerTrigger("END", "Trigger_Default_Redirect", 99, "nuevo.php");
// Add columns
$ins_tipoconsumo->setTable("tipoconsumo");
$ins_tipoconsumo->addColumn("tipoconsumo", "STRING_TYPE", "POST", "tipoconsumo");
$ins_tipoconsumo->setPrimaryKey("idtipoconsumo", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rstipoconsumo = $tNGs->getRecordset("tipoconsumo");
$totalRows_rstipoconsumo = $rstipoconsumo->RecordCount();

//PHP ADODB document - made with PHAkt 3.6.0
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Categorias</title>
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
      <td colspan="2" class="KT_th">NUEVO TIPO</td>
    </tr>
    <tr>
      <td class="KT_th">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th"><label for="tipoconsumo">Tipoconsumo:</label>
      </td>
      <td>
        <input type="text" name="tipoconsumo" id="tipoconsumo" value="<?php echo KT_escapeAttribute($rstipoconsumo->Fields('tipoconsumo')); ?>" size="32" />
        <?php echo $tNGs->displayFieldHint("tipoconsumo");?> <?php echo $tNGs->displayFieldError("tipoconsumo", "tipoconsumo"); ?> </td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2">
        <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Insertar" />
      </td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>