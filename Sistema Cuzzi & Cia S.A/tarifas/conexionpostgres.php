<?php
class conexion{
	private $host;
	private $db;
	private $user;
	private $pass;
	private $con;
	private $dbse;
	protected $sql;
	public $query;
	private $datos;
	public $EOF;
	public $BOF;
	protected $numcol;
	protected $numfields;
	public $posicion;
	function __construct($srvname,$dbname , $uname="", $pass="") 
	{
			if($srvname==""){$srvname='localhost';}			
			if($uname==""){$uname='postgres';}
			if($pass==""){$pass='root';}			
				$this->host=$srvname;
				$this->db=$dbname;
				$this->user= $uname;
				$this->pass=$pass;
				$this->conecta($port="");
	}
	public function conecta($port){
		if(!$port || $port == ""){ $port = "5432"; }
		$conn_string = "host=$this->host port=$port dbname=$this->db user=$this->user password=$this->pass";
		$this->con = pg_connect($conn_string) or die("conexion fallida");
	}
	public function Execute($sql){
		$this->sql=$sql;
		$this->query=pg_query($sql) or die("error en la consulta:".$sql);
		$this->numcol=pg_num_rows($this->query);
		$this->numfields=pg_num_fields($this->query);
	}
	public function RecordCount(){
		return pg_num_rows($this->query);
	}
		
	function moveFirst()
	{
		$this->posicion = 0;
		$this->EOF = false;
		$this->BOF=true;
		@pg_result_seek($this->query,0);
		if($this->RecordCount()==0){
			$this->moveLast();
		}

	}
		
	function moveLast()
	{
		$this->posicion = $this->numcol-1;
		$this->EOF = true;
		$this->BOF=false;
		@pg_result_seek($this->query,$this->posicion);

	}
	
	function moveNext()
	{
		if ($this->posicion < $this->numcol-1)
		{
			$this->posicion++;
			@pg_result_seek($this->query,$this->posicion);
		}
		else
		{
			$this->EOF = true;
			$this->moveLast();
		}
	}
	function movePrevius()
	{
		if ($this->posicion > 0)
		{
			$this->posicion--;
			@pg_result_seek($this->query,$this->posicion);
		}
		else
		{
			$this->moveFirst();
		}
	}
	private function pgRecordSet()
	{
		$this->EOF = false;
		$this->BOF = true;
	}
	public function fields($campo){
		@pg_result_seek($this->query,$this->posicion);
		$val= pg_fetch_assoc($this->query);
		return $val[$campo];
	}
	public function field($campo){
		@pg_result_seek($this->query,$this->posicion);
		$val=pg_fetch_array($this->query);
		return $val[$campo];
	}	
	
}

class meses extends conexion{
	public function get_fecha12(){
		return date('Y/m/d',strtotime($this->fields('mes12'))); 	
	}
	public function get_mes12(){
		$fec=$this->get_fecha12();
		return date('m',strtotime($fec));
	}	
	public function get_anio12(){
		$fec=$this->get_fecha12();
		return date('Y',strtotime($fec));
	}
	public function get_fecha11(){
		return date('Y/m/d',strtotime($this->fields('mes11'))); 	
	}
	public function get_mes11(){
		$fec=$this->get_fecha11();
		return date('m',strtotime($fec));
	}	
	public function get_anio11(){
		$fec=$this->get_fecha11();
		return date('Y',strtotime($fec));
	}
	public function get_fecha10(){
		return date('Y/m/d',strtotime($this->fields('mes10'))); 	
	}
	public function get_mes10(){
		$fec=$this->get_fecha10();
		return date('m',strtotime($fec));
	}	
	public function get_anio10(){
		$fec=$this->get_fecha10();
		return date('Y',strtotime($fec));
	}
	public function get_fecha9(){
		return date('Y/m/d',strtotime($this->fields('mes9'))); 	
	}
	public function get_mes9(){
		$fec=$this->get_fecha9();
		return date('m',strtotime($fec));
	}	
	public function get_anio9(){
		$fec=$this->get_fecha9();
		return date('Y',strtotime($fec));
	}
	public function get_fecha8(){
		return date('Y/m/d',strtotime($this->fields('mes8'))); 	
	}
	public function get_mes8(){
		$fec=$this->get_fecha8();
		return date('m',strtotime($fec));
	}	
	public function get_anio8(){
		$fec=$this->get_fecha8();
		return date('Y',strtotime($fec));
	}
	public function get_fecha7(){
		return date('Y/m/d',strtotime($this->fields('mes7'))); 	
	}
	public function get_mes7(){
		$fec=$this->get_fecha7();
		return date('m',strtotime($fec));
	}	
	public function get_anio7(){
		$fec=$this->get_fecha7();
		return date('Y',strtotime($fec));
	}
	public function get_fecha6(){
		return date('Y/m/d',strtotime($this->fields('mes6'))); 	
	}
	public function get_mes6(){
		$fec=$this->get_fecha6();
		return date('m',strtotime($fec));
	}	
	public function get_anio6(){
		$fec=$this->get_fecha6();
		return date('Y',strtotime($fec));
	}
	public function get_fecha5(){
		return date('Y/m/d',strtotime($this->fields('mes5'))); 	
	}
	public function get_mes5(){
		$fec=$this->get_fecha5();
		return date('m',strtotime($fec));
	}	
	public function get_anio5(){
		$fec=$this->get_fecha5();
		return date('Y',strtotime($fec));
	}
	public function get_fecha4(){
		return date('Y/m/d',strtotime($this->fields('mes4'))); 	
	}
	public function get_mes4(){
		$fec=$this->get_fecha4();
		return date('m',strtotime($fec));
	}	
	public function get_anio4(){
		$fec=$this->get_fecha4();
		return date('Y',strtotime($fec));
	}
	public function get_fecha3(){
		return date('Y/m/d',strtotime($this->fields('mes3'))); 	
	}
	public function get_mes3(){
		$fec=$this->get_fecha3();
		return date('m',strtotime($fec));
	}	
	public function get_anio3(){
		$fec=$this->get_fecha3();
		return date('Y',strtotime($fec));
	}
	public function get_fecha2(){
		return date('Y/m/d',strtotime($this->fields('mes2'))); 	
	}
	public function get_mes2(){
		$fec=$this->get_fecha2();
		return date('m',strtotime($fec));
	}	
	public function get_anio2(){
		$fec=$this->get_fecha2();
		return date('Y',strtotime($fec));
	}
	public function get_fecha1(){
		return date('Y/m/d',strtotime($this->fields('mes1'))); 	
	}
	public function get_mes1(){
		$fec=$this->get_fecha1();
		return date('m',strtotime($fec));
	}	
	public function get_anio1(){
		$fec=$this->get_fecha1();
		return date('Y',strtotime($fec));
	}
	public function get_fecha(){
		return date('Y/m/d',strtotime($this->fields('mes'))); 	
	}
	public function get_mes(){
		$fec=$this->get_fecha();
		return date('m',strtotime($fec));
	}	
	public function get_anio(){
		$fec=$this->get_fecha();
		return date('Y',strtotime($fec));
	}
	
	public function fechas($fecha){
	$sql="select date '$fecha' - interval '12 month' as mes12,
			date '$fecha' - interval '11 month' as mes11,
			date '$fecha' - interval '10 month' as mes10,
			date '$fecha' - interval '9 month' as mes9,
			date '$fecha' - interval '8 month' as mes8,
			date '$fecha' - interval '7 month' as mes7,
			date '$fecha' - interval '6 month' as mes6,
			date '$fecha' - interval '5 month' as mes5,
			date '$fecha' - interval '4 month' as mes4,
			date '$fecha' - interval '3 month' as mes3,
			date '$fecha' - interval '2 month' as mes2,
			date '$fecha' - interval '1 month' as mes1,
			date '$fecha' as mes";
	$this->Execute($sql);
	}
}
class seccion extends conexion{
	public function get_idseccion(){
		return $this->fields('idseccion');	
	}
	public function get_seccion(){
		return $this->fields('seccion');	
	}
	public function get_unidad(){
		return $this->fields('unidad');	
	}
	public function get_status(){
		return $this->fields('status');	
	}
	public function get_potencia(){
		return $this->fields('potencia');	
	}
	public function conectar(){
		$this->sql="SELECT idseccion,seccion,unidad,status,potencia FROM seccion where status<>'x' and idseccion<>0 ORDER BY seccion";
		$this->Execute($this->sql);
	}
}
class factor extends conexion{
	public function get_idfactor(){
		return $this->fields('id');	
	}
	public function get_factor(){
		return $this->fields('factor');	
	}
	public function conectar(){
		$this->sql="SELECT id,factor FROM factorgac";
		$this->Execute($this->sql);
	}
}
class fposg extends conexion{
private $tps;
	public function electricidad_a($mes,$anio)////consultas para calculo electricidad 13 meses
	{
		$query1="SELECT sum(tiempo*potencia) as tiempo 
		        FROM v_informes 
		        WHERE iddestino = 1  
		        and date_part('year',fecha)=$anio 
		        and date_part('month',fecha)=$mes";
	    $rs1=pg_query($query1) or die("error en la consulta:".$query1);
        $val1= pg_fetch_array($rs1);
        return $val1[0];
	}	
    public function electricidad_b($mes,$anio){
        $query2="SELECT costototal as costotal 
		          FROM costoelec 
		          WHERE date_part('month',mes)=$mes 
		          and date_part('year',mes)=$anio";		
		$rs2=pg_query($query2) or die("error en la consulta:".$query2);
		$val2= pg_fetch_array($rs2);
        pg_free_result($rs2);
		return $val2[0];
    }
	public function generalesplanta($mes,$anio)
	{
		$query="SELECT sum(tiempo) as tiempo 
		        FROM v_informes 
		        WHERE iddestino = 1 
		        and date_part('month',fecha)=$mes 
		        and date_part('year',fecha)=$anio";
		$rs=pg_query($query) or die("error en la consulta:".$query);
		$val= pg_fetch_array($rs);
		pg_free_result($rs);
		return $val[0];
	}
   public function TiempoProductivoSeccion($idsec,$anio,$mes)//consulta tiempo productivo seccion
   {
        $query="SELECT sum(tiempo) as tiempo 
        FROM v_informes 
        WHERE iddestino=1 
        and idseccion = $idsec 
        and date_part('month',fecha)=$mes 
        and date_part('year',fecha)=$anio";
        $rs=pg_query($query) or die("error en la consulta:".$query);
		  $val= pg_fetch_array($rs);
		  $this->tps=$val[0];
		  pg_free_result($rs);
		  return $val[0]; 
    }
    public function get_tieprosec()
    {
    	return $this->tps;
     }
    /*public function OperariosSeccion()//consulta operarios seccion
    {
       se convirtio en clase
    }*/
   public function CostoHoraOperario_A($idope,$anio,$mes){
   	 $query ="SELECT sum(costototal) as costotal 
   	        FROM v_operario 
   	        WHERE date_part('month',mes)=$mes 
   	        and date_part('year',mes)=$anio
   	        and idoperario=$idope";
   	 $rs=pg_query($query) or die("error en la consulta:".$query);
   	// echo $query."<br>";
     $val= pg_fetch_array($rs);
     pg_free_result($rs);
     return $val[0];
       
   }
   
    public function CostoHoraOperario_B($idope,$anio,$mes)//consultas para hallar costo x hora x operario
    {
            $query="SELECT sum(tiempo) as tiempo 
                FROM v_informes 
                WHERE date_part('month',fecha)=$mes 
                and date_part('year',fecha)=$anio 
                and idoperario=$idope";
            $rs=pg_query($query) or die("error en la consulta:".$query);
			$val= pg_fetch_array($rs);
			pg_free_result($rs);
			return $val[0];
    }
    function tprodopesec($idsec,$mes,$anio,$idope)//consulta tiempos produc operario seccion
    {
        $query="SELECT sum(tiempo) as tiempo 
                FROM v_informes WHERE (iddestino=1 or iddestino = 2) 
                and idseccion = $idsec 
                and date_part('month',fecha)=$mes 
                and date_part('year',fecha)=$anio 
                and idoperario = $idope";
      
        $rs=pg_query($query) or die("error en la consulta:".$query);
		  $val= pg_fetch_array($rs);
		  pg_free_result($rs);
		  return $val[0]; 
    }
    function timprodopesec($idsec,$mes,$anio,$idope)//tiempos Inproduc operario seccion
    {
    	$query="SELECT sum(tiempo) as tiempo 
    	       FROM v_informes 
    	       WHERE idoperacion = 5 
    	       and idseccion = $idsec 
    	       and date_part('month',fecha)=$mes 
    	       and date_part('year',fecha)=$anio 
    	       and idoperario = $idope";
   	
    	$rs=pg_query($query) or die("error en la consulta:".$query);
		$val= pg_fetch_array($rs);
		pg_free_result($rs);
		return $val[0]; 
    }
    function asignacionope($idsec,$idope)// consulta asignacion operarios
    {
    	$query="SELECT porcentaje/100 as porcent 
    	       FROM asignacion a 
    	       WHERE idseccion=$idsec 
    	       and idoperario = $idope";
    		$rs=pg_query($query) or die("error en la consulta:".$query);
		  	$val= pg_fetch_array($rs);
		  	pg_free_result($rs);
		return $val[0]; 
    }
    function timpopesinsec($mes,$anio,$idope)// consulta tiempos Inproduc operario sin seccion
    {
    	$query="SELECT sum(tiempo) as tiempo 
    	       FROM v_informes 
    	       WHERE (iddestino = 5 or iddestino = 6 or iddestino = 7 or iddestino = 8) 
    	       and date_part('month',fecha)=$mes 
    	       and date_part('year',fecha)=$anio 
    	       and idoperario = $idope";

		  $rs=pg_query($query) or die("error en la consulta:".$query);
		  $val= pg_fetch_array($rs);
		  pg_free_result($rs);
		  return $val[0];     
    }
    /*function depreciacion() {
        ahora es una clase	
    }*/
    function diferenciafechas($fecha1,$fecha2){
    	$query="select extract(year from age('$fecha1' ,'$fecha2'))*12+extract(month from age('$fecha1' ,'$fecha2')) as diff;";
       	$rs=pg_query($query) or die("error en la consulta:".$query);
		$val= pg_fetch_array($rs);
		pg_free_result($rs);
		return $val[0]; 
    }
    function insumos($mes,$anio,$idsec)// consulta de insumos
    {	
        $query="SELECT sum(vusoles*cantidad) as insu 
    	       From movimientos 
    	       WHERE motivo='5Consumo' 
    	       and date_part('month',fecha)=$mes 
    	       and date_part('year',fecha)=$anio 
    	       and idseccion=$idsec and idorden=0";
    	  $rs=pg_query($query) or die("error en la consulta:".$query);
		  $val= pg_fetch_array($rs);
		  pg_free_result($rs);
		  return $val[0]; 
    }
    function consumos($mes,$anio,$idsec)
    {
    	$query="SELECT costototal as costotal 
    	       FROM costomante 
    	       WHERE date_part('month',fecha)=$mes 
    	       and date_part('year',fecha)=$anio 
    	       and idseccion = $idsec";

    		$rs=pg_query($query) or die("error en la consulta:".$query);
		  	$val= pg_fetch_array($rs);
		  	pg_free_result($rs);
		return $val[0]; 
    }
    /*function seguros()
    {
    	/*ahora es una clase
    }*/
    function electricidad2($idsec,$mes,$anio)
    {
    	$query="SELECT sum(tiempo*potencia) as tiempo 
    	       FROM v_informes WHERE (iddestino = 1) 
    	       and idseccion = $idsec 
    	       and date_part('month',fecha)=$mes 
    	       and date_part('year',fecha)=$anio";

    		$rs=pg_query($query) or die("error en la consulta:".$query);
		  	$val= pg_fetch_array($rs);
		  	pg_free_result($rs);
		  	return $val[0]; 
    }
    function genplanta($mes,$anio,$idsec)//costo generales planta
    {
    	$query="SELECT sum(costototal) as costotal 
    	       FROM costogp 
    	       WHERE date_part('month',mes)=$mes 
    	       and date_part('year',mes)=$anio 
    	       and idseccion=$idsec";

    	 $rs=pg_query($query) or die("error en la consulta:".$query);
		 $val= pg_fetch_array($rs);
		 pg_free_result($rs);
		 return $val[0]; 
    }
    function facgpseccion($idsec,$mes,$anio){
    	$query="SELECT sum(tiempo) as tiempo 
    	       FROM v_informes 
    	       WHERE iddestino = 1 and 
    	       idseccion = $idsec 
    	       and date_part('month',fecha)=$mes 
    	       and date_part('year',fecha)=$anio";    	
    		$rs=pg_query($query) or die("error en la consulta:".$query);
		  	$val= pg_fetch_array($rs);
		  	pg_free_result($rs);
		return $val[0]; 
    }
    function otrosgp($idsec,$mes,$anio)
    {
        $query="SELECT sum(costototal) as costotal 
                FROM costotros 
                WHERE idsec=$idsec 
                and date_part('month',mes)=$mes 
                and date_part('year',mes)=$anio";
        $rs=pg_query($query) or die("error en la consulta:".$query);
		  $val= pg_fetch_array($rs);
		  pg_free_result($rs);
		  return $val[0]; 	
    }
	public function IIF($condion) 
	{
    	return (($condition==0) ? 1 : $condition);
	}
	public function insertReporte($n,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12){
		if(!is_numeric($n)){$n=0;}else{$n=round($n,2);};if(!is_numeric($n1)){$n1=0;}else{$n1=round($n1,2);};if(!is_numeric($n2)){$n2=0;}else{$n2=round($n2,2);};if(!is_numeric($n3)){$n3=0;}else{$n3=round($n3,2);};
		if(!is_numeric($n4)){$n4=0;}else{$n4=round($n4,2);};if(!is_numeric($n5)){$n5=0;}else{$n5=round($n5,2);};if(!is_numeric($n6)){$n6=0;}else{$n6=round($n6,2);};if(!is_numeric($n7)){$n7=0;}else{$n7=round($n7,2);};
		if(!is_numeric($n8)){$n8=0;}else{$n8=round($n8,2);};if(!is_numeric($n9)){$n9=0;}else{$n9=round($n9,2);};if(!is_numeric($n10)){$n10=0;}else{$n10=round($n10,2);};if(!is_numeric($n11)){$n11=0;}else{$n11=round($n11,2);};
		if(!is_numeric($n12)){$n12=0;}else{$n12=round($n12,2);};
		$query="INSERT INTO reportefinal(costo,costo1, costo2, costo3, costo4, costo5, costo6,costo7, costo8, costo9, costo10, costo11, costo12)
		          VALUES ($n, $n1, $n2, $n3, $n4, $n5, $n6, $n7, $n8, $n9, $n10, $n11, $n12)";
		$result = pg_query($query) or die("error en la consulta:".$query);
		pg_free_result($result);
		return 1;           
	}
	public function BorrarData(){
		$query="truncate table reportefinal";
		$result = pg_query($query) or die("error en la consulta:".$query);
		$query="ALTER SEQUENCE sq_reporte RESTART WITH 1";
		$result = pg_query($query) or die("error en la consulta:".$query);
		pg_free_result($result);
		return 1;
	}
	public function insertFecReporte($cod,$fec){
		$query="truncate table fecreporte";
		$result = pg_query($query);
		$query="INSERT INTO fecreporte(id,fecha) VALUES (1,'$fec')";
		$result = pg_query($query);
		return 1;           
	}
}
class depreciacion extends conexion
{
//
	public function get_iddeprecia(){
		return $this->fields('iddeprecia');	
	} 
	public function get_descripcion(){
		return $this->fields('descripcion');	
	} 
	public function get_idseccion(){
		return $this->fields('idseccion');	
	} 
	public function get_fecingreso(){
		return $this->fields('fecingreso');	
	} 
	public function get_nrocuotas(){
		return $this->fields('nrocuotas');	
	} 
	public function get_tasa(){
		return $this->fields('tasa');	
	} 
	public function get_dep (){
		return $this->fields('dep');	
	} 
	public function get_porcentaje(){
		return $this->fields('porcentaje');	
	}     
//    
    public function conectar($idsec,$fecha)
    {
        $query="SELECT d.iddeprecia,d.descripcion,dd.idseccion,d.fecingreso,d.importe,1/tasa*12 AS nrocuotas
        ,d.tasa,d.importe/(1/tasa*12)*porcentaje as dep,dd.porcentaje 
        FROM depreciacion d,distribuciond dd 
        WHERE(d.iddeprecia = dd.iddeprecia) AND (idseccion = $idsec) and fecingreso<='$fecha' 
        ORDER BY iddeprecia";
        
        $this->sql=$query;
        $this->Execute($query);  
        
        if($this->Recordcount()==0){
        	$this->moveLast();
        
        }  
    }
    
}
// prima de seguros
class seguros extends conexion{
	private $pm;
	/*
	public function get_pm(){
	if ($this->EOF){
            $re=$this->fields('pm');
        }
        else{
            $re=$this->fields('pm');
            $this->fechavigencia=$this->fields('pm');
        }
        return $re;	
	} */
	public function get_pm(){
			$this->pm=$this->fields('pm');
            return $this->fields('pm');
	} 
		
    public function conectar($idsec,$anio)
        {
            $query="SELECT (prima/(13-date_part('month',fecha))*porcentaje) as pm 
               From seguros s, distribucions ds 
               WHERE s.idseguro=ds.idseguro 
               and idseccion = $idsec 
			   and date_part('year',fecha)=$anio 
               ORDER BY fecha";
			  /* $query="SELECT (prima/(13-date_part('month',s.fecha))*porcentaje) as pm
			  ,ds.fecha as fecha1
               From seguros s, distribucions ds 
               WHERE s.idseguro=ds.idseguro 
               and idseccion = $idsec 
			   and date_part('month',ds.fecha)=$mes 
               and date_part('year',s.fecha)=$anio 
               ORDER BY fecha" ;*/
            $this->Execute($query);
            if($this->Recordcount()==0){
        	   $this->moveLast();
            }              
        }
}
class opseccion extends conexion{
	private $idoperario;
	public function get_idoperario(){
		return $this->fields('idoperario');	
	}    
    public function OperariosSeccion($idsec,$anio,$mes)//consulta operarios seccion
    {
        $query="SELECT idoperario FROM v_informes 
        WHERE (idseccion = $idsec or idseccion=0) 
        and date_part('month',fecha)=$mes 
        and date_part('year',fecha)=$anio 
        GROUP BY idoperario 
        ORDER BY idoperario";
        $this->Execute($query);
            if($this->Recordcount()==0){
        	   $this->moveLast();
            }
    }
}


class fvtarifas extends conexion{
	   public function get_idtarifa(){
        return $this->fields('idtarifa'); 
    }  
        public function get_nombre(){
        return $this->fields('nombre'); 
    }  
        public function get_estado(){
        return $this->fields('estado'); 
    }  
        public function get_viginicio(){
        return $this->fields('vig_inicio'); 
    }  
        public function get_vigfin(){
        return $this->fields('vig_fin'); 
    }  
        public function get_idtarifadet(){
        return $this->fields('idtarifadet'); 
    }  
        public function get_vdolar(){
        return $this->fields('vdolar'); 
    }  
     public function get_vsoles(){
        return $this->fields('vsoles'); 
    }  
     public function get_idseccion(){
        return $this->fields('idseccion'); 
    }  
     public function get_seccion(){
        return $this->fields('seccion'); 
    }
    public function get_unidad(){
        return $this->fields('unidad'); 
    }  
    public function get_status(){
        return $this->fields('status'); 
    }    
	public function get_potencia(){
        return $this->fields('potencia'); 
    }  
	function conectar($idsec,$anio,$mes){
		$query="select 
		idtarifa,nombre,estado,vig_inicio,vig_fin,idtarifadet,vdolar,vsoles,idseccion,seccion,unidad,status,potencia 
        from v_tarifas 
        where  idseccion = $idsec 
        and '$anio/$mes/01' BETWEEN vig_inicio and vig_fin";
		$this->Execute($query);
            if($this->Recordcount()==0){
        	   $this->moveLast();
            }
	}
}
class fvtarifas2 extends conexion{
    private $idseccion;
    public function get_idseccion(){
        if ($this->EOF){
            $re=$this->idseccion;
        }
        else{
            $re=$this->fields('idseccion');
            $this->idseccion=$this->fields('idseccion');
        }
        return $re;
    }
    private $vdolar;
    public function get_vdolar(){
        if ($this->EOF){
            $re=$this->vdolar;
        }
        else{
            $re=$this->fields('vdolar');
            $this->vdolar=$this->fields('vdolar');
        }
        return $re;
    }
    private $vsoles;
        public function get_vsoles(){
        if ($this->EOF){
            $re=$this->vsoles;
        }
        else{
            $re=$this->fields('vsoles');
            $this->vsoles=$this->fields('vsoles');
        }
        return $re;
    }
    private $fechavigencia;
        public function get_fechavigencia(){
        if ($this->EOF){
            $re=$this->fechavigencia;
        }
        else{
            $re=$this->fields('fechavigencia');
            $this->fechavigencia=$this->fields('fechavigencia');
        }
        return $re;
    }
    function conectar($idsec,$anio,$mes,$var=""){
        $activo=false;
        $query="select idtarifadet,idseccion,vdolar,vsoles,fechavigencia
        from detalletarifa
        where idseccion=$idsec
        and date_part('month',fechavigencia)=$mes 
        and date_part('year',fechavigencia)=$anio"; 
            $this->Execute($query);
            if($this->Recordcount()==0){
            	   $this->moveLast();
                   $activo=true;
            }
            else{
                $this->moveFirst();
                
            }        
		if ($activo==true && $var<>""){
			$query="select idtarifadet,idseccion,vdolar,vsoles,fechavigencia
        		from detalletarifa
		        where idseccion=$idsec
		        and date_part('year',fechavigencia)<=$anio
				order by fechavigencia desc
				limit 1"; 
		        $this->Execute($query);
                $this->vsoles=$this->fields('vsoles');                        
		}
    }
}

?>