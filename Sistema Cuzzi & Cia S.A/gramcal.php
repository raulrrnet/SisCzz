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
$formValidation->addField("gramajecalibre", true, "text", "", "", "", "");
$formValidation->addField("idmarcatipo", true, "numeric", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an insert transaction instance
$ins_gramajecalibre = new tNG_insert($cnx_cuzzicia);
$tNGs->addTransaction($ins_gramajecalibre);
// Register triggers
$ins_gramajecalibre->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_gramajecalibre->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_gramajecalibre->registerTrigger("END", "Trigger_Default_Redirect", 99, "nuevo.php");
// Add columns
$ins_gramajecalibre->setTable("gramajecalibre");
$ins_gramajecalibre->addColumn("gramajecalibre", "STRING_TYPE", "POST", "gramajecalibre");
$ins_gramajecalibre->setPrimaryKey("idgramcal", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsgramajecalibre = $tNGs->getRecordset("gramajecalibre");
$totalRows_rsgramajecalibre = $rsgramajecalibre->RecordCount();

//PHP ADODB document - made with PHAkt 3.6.0
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Gramaje Calibre</title>
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
      <td colspan="2" class="KT_th">NUEVO GRAMAJE O CALIBRE</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
	<tr>
      <td class="KT_th"><label for="gramajecalibre">Gramajecalibre:</label>
      </td>
      <td>
        <input type="text" name="gramajecalibre" id="gramajecalibre" value="<?php echo KT_escapeAttribute($rsgramajecalibre->Fields('gramajecalibre')); ?>" size="32" />
        <?php echo $tNGs->displayFieldHint("gramajecalibre");?> <?php echo $tNGs->displayFieldError("gramajecalibre", "gramajecalibre"); ?> </td>
    </tr>
	<tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2">
        <input type="reset" name="cancel" id="cancel" value="Cancelar" />
        <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Guardar"/>
      </td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
