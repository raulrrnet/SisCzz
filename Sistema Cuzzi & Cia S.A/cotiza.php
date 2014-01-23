<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cotización</title>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>
	
<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="4" class="KT_th">ESPECIFICACIONES:</td>
  </tr>
  <tr>
    <td colspan="4" class="MXW_disabled">&nbsp;</td>
  </tr>
  <tr>
    <td class="KT_th">Categoria:</td>
    <td><label>
      <select id="categoria" name="categoria" onChange="tipoconsumo_reload(this)">
        <option selected="selected">categoria</option>
      </select>
    </label></td>
    <td class="KT_th">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="KT_th">Material:</td>
    <td><select id="select" name="material" onChange="tipoconsumo_reload(this)">
      <option selected="selected">material</option>
    </select></td>
    <td class="KT_th">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="KT_th">Marca/Tipo:</td>
    <td><select id="select2" name="marcatipo" onChange="tipoconsumo_reload(this)">
      <option selected="selected">marcatipo</option>
    </select></td>
    <td class="KT_th">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="KT_th">Gramaje/Calibre:</td>
    <td><select id="select4" name="gramcal" onChange="tipoconsumo_reload(this)">
      <option selected="selected">gramcal</option>
    </select></td>
    <td class="KT_th">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="KT_th"><label for="idmaterial">Medidas:</label></td>
    <td><select id="select3" name="medidas" onChange="tipoconsumo_reload(this)">
      <option selected="selected">medidas</option>
    </select></td>
    <td class="KT_th">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="KT_th"><label for="cantidad">Cantidad:</label></td>
    <td><input name="cant" type="text" id="cant" />
      <select id="select5" name="idmat" onChange="tipoconsumo_reload(this)">
        <option>uni</option>
      </select>
</td>
    <td class="KT_th">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="KT_th">Procesos:</td>
    <td><select id="select2" name="marcatipo" onChange="tipoconsumo_reload(this)">
      <option>impresion</option>
    </select></td>
    <td class="KT_th">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="KT_th">&nbsp;</td>
    <td><select id="select4" name="gramcal" onChange="tipoconsumo_reload(this)">
      <option>troquelado</option>
    </select></td>
    <td class="KT_th">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="KT_th">&nbsp;</td>
    <td><select id="select3" name="medidas" onChange="tipoconsumo_reload(this)">
      <option>acabados</option>
    </select></td>
    <td class="KT_th">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="KT_th">Material: </td>
    <td><label>
      <input name="material" type="text" id="material" />
    </label></td>
    <td class="KT_th">Trazo x hoja:</td>
    <td><label>
      <input name="thoja" type="text" id="thoja" />
    </label></td>
  </tr>
  <tr>
    <td class="KT_th">Formato:</td>
    <td><label>
      <input type="text" name="formato" id="formato" />
    </label></td>
    <td class="KT_th">F. x pliego:</td>
    <td><label>
      <input type="text" name="fpliego" id="fpliego" />
    </label></td>
  </tr>
  <tr>
    <td class="KT_th">Color Tinta:</td>
    <td><label>
      <input type="text" name="ctinta" id="ctinta" />
    </label></td>
    <td class="KT_th">Cant. Colores:</td>
    <td><label>
      <input type="text" name="ccolores" id="ccolores" />
    </label></td>
  </tr>
  <tr>
    <td class="KT_th">Observaciones:</td>
    <td colspan="3"><textarea name="observ" cols="48" id="observ"></textarea></td>
  </tr>
</table>
</body>
</html>