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
$formValidation->addField("categoria", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an insert transaction instance
$ins_categoria = new tNG_insert($cnx_cuzzicia);
$tNGs->addTransaction($ins_categoria);
// Register triggers
$ins_categoria->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_categoria->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_categoria->registerTrigger("END", "Trigger_Default_Redirect", 99, "nuevo.php");
// Add columns
$ins_categoria->setTable("categoria");
$ins_categoria->addColumn("categoria", "STRING_TYPE", "POST", "categoria");
$ins_categoria->setPrimaryKey("idcategoria", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscategoria = $tNGs->getRecordset("categoria");
$totalRows_rscategoria = $rscategoria->RecordCount();

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
      <td colspan="2" class="KT_th">NUEVA CATEGORIA</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th"><label for="categoria">Categoria:</label>
      </td>
      <td>
        <input type="text" name="categoria" id="categoria" value="<?php echo KT_escapeAttribute($rscategoria->Fields('categoria')); ?>" size="32" />
        <?php echo $tNGs->displayFieldHint("categoria");?> <?php echo $tNGs->displayFieldError("categoria", "categoria"); ?> </td>
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
