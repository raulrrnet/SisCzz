<?php
class conexion 
{	
	//variables de acceso
	private $_srvname;
	private $_dbname;
	private $_user;
	private $_pass;
	public $siteaddress;
	private $conn;
	//metodos de la clase
	function __construct($srvname, $dbname, $uname, $pass) 
	{
				$this->_srvname=$srvname;
				$this->_dbname=$dbname;
				$this->_user= $uname;
				$this->_pass=$pass;
	}
	
	function __destruct(){}
	
	public function Conexion($port)
	{
	if(!$port || $port == ""){ $port = "5432"; }
	$conn_string = "host=$this->_srvname port=$port dbname=$this->_dbname user=$this->_user password=$this->_pass";
	$conn = pg_connect($conn_string);
	return $conn;
	}
	
	public function todosCampos($query) {		
				return pg_query($query);		
	}
	public function tiempoPlanta($anio,$mes)
	{
		$query="select gen_planta_tiempo($anio,$mes)";
		$result = pg_fetch_row(pg_query($query));
		return $result;
	}

	public function CostoHoraOperario($idop,$anio,$mess)
	{
		$query="select CostoHoraOperario($idop,$anio,$mess)";
		$result=pg_query($query);
		return $result;
	}
	public function todasSeccion()
	{
		$query="select * from seccion";
		$result=pg_query($query);
		return $result;
	}
	public function TiempoProductivoSeccion($idsec,$anio,$mes){
		$query="select TiempoProductivoSeccion($idsec,$anio,$mes)";
		$result=pg_fetch_row(pg_query($query));
		return $result;
	}
	//reales
	//######################################################################33
	public function TiempoProductivo($idsec,$mes,$anio){
		$query="select TiempoProductivo($idsec,$mes,$anio)";
		$result=pg_fetch_row(pg_query($query));
		return $result;
	}
	public function Operarios($idsec,$anio,$mes)
	{
		$query = "select idoperario FROM v_informes ";
		$query .= "where (idseccion = $idsec or idseccion=0) ";
		$query .= "and date_part('month',fecha)=$mes ";
		$query .= "and date_part('year',fecha)=$anio ";
		$query .= "GROUP BY idoperario ";
		$query .= "ORDER BY idoperario";	
		$result = pg_query($query);
		return $result;
	}
	public function costototaloperario($idop,$anio,$mess){
		$query="select costototaloperario($idop,$anio,$mess)";
		$result=pg_fetch_row(pg_query($query));
		return $result;
	}
	public function SumaTiempos($mes,$anio,$idope){
		$query="select SumaTiempos($mes,$anio,$idope)";
		$result=pg_fetch_row(pg_query($query));
		return $result;
	}
	public function SumaTiempos2($mes,$anio,$idope)
	{
		$query="SELECT sum(tiempo) as tiempo FROM v_informes WHERE date_part('month',fecha)=$mes and date_part('year',fecha)=$anio and idoperario=$idope";
		$result=pg_query($query);
		return $result;
	}
	
	public function SumtiempoOpe($idsec,$mes,$anio,$idop)
	{
		$query="select SumtiempoOpe($idsec,$mes,$anio,$idop)";
		$result=pg_query($query);
		return $result;
	}
		public function	TiempoImproOpeSec($idsec,$mess,$anio,$idop)
	{
		$query="select TiempoImproOpeSec($idsec,$mess,$anio,$idop)";
		$result=pg_fetch_row(pg_query($query));
		return $result;
	}
	public function AsignacionOperarios($idsec,$idop)
	{
		$query="select asigoperarios($idsec,$idop)";
		$result=pg_fetch_row(pg_query($query));
		return $result;
	}
	public function ImprOpeSinSecc($mess,$anio,$idop)
	{
		$query="select ImprOpeSinSecc($idop,$anio,$mess)";
		$result=pg_fetch_row(pg_query($query));
		return $result;
	}
	public function Depreciacion($idsec,$fecha)
	{
		$query="SELECT d.iddeprecia,d.descripcion ";
		$query.=", dd.idseccion,d.fecingreso,d.importe,1/tasa*12 AS nrocuotas ";
		$query.=", d.tasa, d.importe/(1/tasa*12)*porcentaje as dep,dd.porcentaje ";
		$query.="FROM depreciacion  d ";
		$query.="inner join distribuciond  dd ";
		$query.="on(d.iddeprecia = dd.iddeprecia AND idseccion =$idsec) "; 
		$query.="and fecingreso<='$fecha' ";
		$query.="ORDER BY iddeprecia";
		$result=pg_query($query);
		return $result;
	}		
	public function insumos($seccion,$anio,$mes)
	{
		$query="select insumos($seccion,$anio,$mes)";
		$result=pg_fetch_row(pg_query($query));
		return $result;
	}
	public function mantenimiento($seccion,$anio,$mes)
	{
		$query="select mantenimiento($seccion,$anio,$mes)";
		$result=pg_fetch_array(pg_query($query));
		return $result;
	}
	public function Prima($seccion,$anio)
	{
		$query =  "SELECT (prima/(13-date_part('month',fecha))*porcentaje) as pm ";
		$query .= "From seguros s inner join distribucions ds ";
		$query .= "on(s.idseguro=ds.idseguro) ";
		$query .= "and idseccion = $seccion ";
		$query .= "and date_part('year',fecha)=$anio ";
		$query .= "ORDER BY fecha";
		$result = pg_query($query);
		return $result;
	}
	public function electricidad($idsec,$anio,$mes)
	{
		$query="select electricidad($idsec,$anio,$mes)";
		$result=pg_fetch_row(pg_query($query));
		return $result;
	}
	public function generales_planta($idsec,$anio,$mes)
	{
		$query="select generales_planta($idsec,$anio,$mes)";
		$result=pg_fetch_row(pg_query($query));
		return $result;
	}
	public function TiempoXSeccion($idsec,$anio,$mes)
	{
		$query="select tiempoxseccion($idsec,$anio,$mes)";
		$result=pg_fetch_array(pg_query($query));
		return $result;
	}
	public function otrosGastos($idsec,$anio,$mess)
	{
		$query="select otrosGastos($idsec,$anio,$mess)";
		$result=pg_fetch_row(pg_query($query));
		return $result;
	}
	public function Factor($anio,$mes)
	{
		$query="select factor($anio,$mes)";
		$result = pg_fetch_row(pg_query($query));
		return $result;
	}
	public function IIF($condion) 
	{
    	return (($condition==0) ? 1 : $condition);
	}
	public function insertReporte($n,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12){
		$query="INSERT INTO reportefinal(";
		$query.="costo,costo1, costo2, costo3, costo4, costo5, costo6," ;
		$query.="costo7, costo8, costo9, costo10, costo11, costo12)";
		$query.="VALUES ($n,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12)";
		$result = pg_query($query);
		return 1;           
	}
	public function BorrarData(){
		$query="truncate table reportefinal";
		$result = pg_query($query);
		$query="ALTER SEQUENCE sq_reporte RESTART WITH 1";
		$result = pg_query($query);
		return 1;
	}
	public function insertFecReporte($cod,$fec){
		$query="truncate table fecreporte";
		$result = pg_query($query);
		$query="INSERT INTO fecreporte(id,fecha) VALUES ($cod,'$fec')";
		$result = pg_query($query);
		return 1;           
	}
	public function Fechas()
	{
		$query="select * from fecreporte";
		$result = pg_fetch_row(pg_query($query));
		return $result;
	}
}
?>