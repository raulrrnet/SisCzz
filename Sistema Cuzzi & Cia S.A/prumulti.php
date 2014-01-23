<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

/*while (!$seccion->EOF) {
	$idsec = $seccion->Fields('idseccion');
	// consulta tiempo productivo seccion
	$q_tiemsec12 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino=1 and idseccion = $idsec and date_part('month',fecha)=$mes12 and date_part('year',fecha)=$an12");
	$tiemsec12 = $cnx_cuzzicia->SelectLimit($q_tiemsec12) or die($cnx_cuzzicia->ErrorMsg());
	$totiem12t[] = $tiemsec12->Fields('tiempo');*/
	// consulta operarios seccion
//	$idsec=1;
	$q_opesec12 = sprintf("SELECT idoperario FROM v_informes WHERE date_part('month',fecha)=10 and date_part('year',fecha)=2007 GROUP BY idoperario ORDER BY idoperario");
	$operasec12 = $cnx_cuzzicia->SelectLimit($q_opesec12) or die($cnx_cuzzicia->ErrorMsg());
	$tRows_operasec = $operasec12->RecordCount();
	
//}
?>
<table width="75%" border="1">
<?php
while (!$operasec12->EOF) {
		$idope = $operasec12->Fields('idoperario');
		//consultas para hallar costo x hora x operario
		$q_costoope12 = sprintf("SELECT sum(costototal) as costotal FROM v_operario WHERE date_part('month',mes)=10 and date_part('year',mes)=2007 and idoperario=$idope");
		$exqcostoope12 = $cnx_cuzzicia->SelectLimit($q_costoope12) or die($cnx_cuzzicia->ErrorMsg());
		$q_titoope12 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE date_part('month',fecha)=10 and date_part('year',fecha)=2007 and idoperario=$idope");
		$exqtitoope12 = $cnx_cuzzicia->SelectLimit($q_titoope12) or die($cnx_cuzzicia->ErrorMsg());
		$costxhra12 = $exqcostoope12->Fields('costotal')/$exqtitoope12->Fields('tiempo');
		// consulta tiempos produc operario seccion
		$q_tpopesec12 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino = 1 or iddestino = 2) and date_part('month',fecha)=10 and date_part('year',fecha)=2007 and idoperario = $idope");
		$extpopesec12 = $cnx_cuzzicia->SelectLimit($q_tpopesec12) or die($cnx_cuzzicia->ErrorMsg());
		$product12 = $extpopesec12->Fields('tiempo')*$costxhra12;
		// consulta tiempos Inproduc operario seccion
		$q_tiopesec12 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE idoperacion = 5 and date_part('month',fecha)=10 and date_part('year',fecha)=2007 and idoperario = $idope");
		$extiopesec12 = $cnx_cuzzicia->SelectLimit($q_tiopesec12) or die($cnx_cuzzicia->ErrorMsg());
		$inproducts12 = $extiopesec12->Fields('tiempo')*$costxhra12;
		// consulta tiempos Inproduc operario sin seccion
		$q_tiopesin12 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE idseccion=0 and  date_part('month',fecha)=10 and date_part('year',fecha)=2007 and idoperario = $idope");
		$extiopesin12 = $cnx_cuzzicia->SelectLimit($q_tiopesin12) or die($cnx_cuzzicia->ErrorMsg());
?>
  <tr>
    <td>operario</td>
    <td><?php echo $idope;?></td>
  </tr>
  <tr>
    <td>tiempo total</td>
    <td><?php echo $exqtitoope12->Fields('tiempo');?></td>
  </tr>
  <tr>
    <td>tiempo P</td>
    <td><?php echo $extpopesec12->Fields('tiempo');?></td>
  </tr>
  <tr>
    <td>tiempo I</td>
    <td><?php echo $extiopesec12->Fields('tiempo');?></td>
  </tr>
  <tr>
    <td>tiempo SS</td>
    <td><?php echo $extiopesin12->Fields('tiempo');?></td>
  </tr>
  <tr>
    <td>ciaoto </td>
    <td><?php echo $costxhra12;?></td>
  </tr>
<?php
$operasec12->MoveNext();
}
?>
</table>
