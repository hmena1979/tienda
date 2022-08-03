<?php 
	function getModulosArray(){
		$a = [
			'1' => 'Tipo de Documento',
			'2' => 'Sexo',
			'3' => 'Estado Civil',
			'4' => 'Moneda',
			'5' => 'Medio de Pago',
			'6' => 'Status Comprobante Electrónico',
			'7' => 'Tipo de Operación',
			'8' => 'Documentos Relacionados Guía de Remisión',
			'9' => 'Motivos de Traslado',
			'10' => 'Modalidad de Traslado',
		];
		return $a;
	}

	function getProductosArray(){
		$a = [
			'1' => 'Tipo',
			// '2' => 'Marca',
			// '3' => 'Talla',
			// '4' => 'Color',
		];
		return $a;
	}

	function getEmbarquesArray(){
		$a = [
			'1' => 'STUFFING PLACE',
			'2' => 'FFW',
			'3' => 'AGENCIA ADUANA',
			'4' => 'RELEASE',
			'5' => 'PI2',
			'6' => 'PY',
			'7' => 'PAY T',
		];
		return $a;
	}

	function geMensajeriaArray(){
		$a = [
			'1' => 'Pagos Masivos',
			'2' => 'Logistica | Almacen',
		];
		return $a;
	}

	function getMeses(){
		$m = [
			'01' => 'Enero',
			'02' => 'Febrero',
			'03' => 'Marzo',
			'04' => 'Abril',
			'05' => 'Mayo',
			'06' => 'Junio',
			'07' => 'Julio',
			'08' => 'Agosto',
			'09' => 'Septiembre',
			'10' => 'Octubre',
			'11' => 'Noviembre',
			'12' => 'Diciembre',
		];
		return $m;
	}

	function getMes($mes){
		switch ($mes){
			case '01':
				return 'ENERO';
			case '02':
				return 'FEBRERO';
			case '03':
				return 'MARZO';
			case '04':
				return 'ABRIL';
			case '05':
				return 'MAYO';
			case '06':
				return 'JUNIO';
			case '07':
				return 'JULIO';
			case '08':
				return 'AGOSTO';
			case '09':
				return 'SEPTIEMBRE';
			case '10':
				return 'OCTUBRE';
			case '11':
				return 'NOVIEMBRE';
			case '12':
				return 'DICIEMBRE';
		}
	}



	//Key Value From JSon
	function kvfj($json, $key){
		if($json == null):
			return null;
		else:
			$json = $json;
			$json = json_decode($json, true);
			if(array_key_exists($key, $json)):
				return $json[$key];
			else:
				return null;
			endif;
		endif;
		

	}

	function preProm($cant, $pant, $cnue, $pnue){
		$pre = round((($cant * $pant) + ($cnue * $pnue)) / ($cant + $cnue), 4);
		return($pre);
	}

	function prePromE($cant, $pant, $cnue, $pnue){
		if($cant - $cnue == 0){
			$pre = 0.00;
		}else{
			$pre = round((($cant * $pant) - ($cnue* $pnue)) / ($cant - $cnue), 4);
		}		
		return($pre);
	}

	function numDoc($serie,$numero){
		if(strlen(trim($serie))==0){
			return(trim($numero));
		}else{
			return(trim($serie).'-'.trim($numero));
		}
	}

	function serieNumero($numero, $tipo = 1) {
		$guion = strpos($numero, '-');
		if ($tipo == 1) {
			if ($guion === false) {
				return '';
			} else {
				return substr($numero, 0, $guion);
			}
		} else {
			if ($guion === false) {
				return $numero;
			} else {
				return ltrim(substr($numero, $guion+1),'0');
			}
		}
	}

	function numeroOperacion($fecha){
		return
			substr($fecha, 8,2)
			.substr($fecha, 5,2)
			.substr($fecha, 0,4);
		
	}

	function periodo(){
		$dia = \Carbon\Carbon::now();
		$periodo = substr($dia,5,2).substr($dia,0,4);
		return $periodo;
	}

	function pAnterior($periodo){
		$mes = substr($periodo, 0,2);
		$anio = substr($periodo, 2);
		if($mes == '01'){
			$n = '12'.strval(intval($anio)-1);
		}else{
			$n = str_pad(intval($mes)-1, 2, '0', STR_PAD_LEFT).$anio;
		}
		return $n;
	}
	
	function pSiguiente($periodo){
		$mes = substr($periodo, 0,2);
		$anio = substr($periodo, 2);
		if($mes == '12'){
			$n = '01'.strval(intval($anio)+1);
		}else{
			$n = str_pad(intval($mes)+1, 2, '0', STR_PAD_LEFT).$anio;
		}
		return $n;
	}

	function primerDiaPeriodo($periodo) {
		return substr($periodo, 2, 4).'-'.substr($periodo, 0, 2).'-01';
	}

	function generateRandomString($length = 10) { 
		return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length); 
	}

	function azarMayusculas($length = 10) { 
		return substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length); 
	}

	function azarNumeros($length = 10) { 
		return substr(str_shuffle("0123456789"), 0, $length); 
	}

	function decimal($n,$cantidad){
		$respuesta = explode('.',number_format($n, 2))[1];
		return $respuesta;
	}

	function colorExcel($color) {
		switch ($color) {
			case 1:
				return 'FF'.'FFA7F0';
				break;
			case 2:
				return 'FF'.'C0C0C0';
				break;
			case 3:
				return 'FF'.'FFFF2B';
				break;
			case 4:
				return 'FF'.'9999FF';
				break;
			case 5:
				return 'FF'.'FFFFCC';
				break;
			case 6:
				return 'FF'.'CCFFFF';
				break;
			case 7:
				return 'FF'.'008080';
				break;
			case 8:
				return 'FF'.'993366';
				break;
			case 9:
				return 'FF'.'FF8080';
				break;
			case 10:
				return 'FF'.'CCCCFF';
				break;
			case 11:
				return 'FF'.'808000';
				break;
			case 12:
				return 'FF'.'808080';
				break;
			case 13:
				return 'FF'.'008000';
				break;
			case 14:
				return 'FF'.'008080';
				break;
			case 15:
				return 'FF'.'00CCFF';
				break;
			case 16:
				return 'FF'.'CCFFCC';
				break;
			case 17:
				return 'FF'.'FF99CC';
				break;
			case 18:
				return 'FF'.'CC99FF';
				break;
			case 19:
				return 'FF'.'FFCC99';
				break;
			case 20:
				return 'FF'.'33AAFF';
				break;
			case 21:
				return 'FF'.'993366';
				break;
			case 22:
				return 'FF'.'993300';
				break;
			case 'rojo':
				return 'FF'.'FF0000';
				break;
			case 'azul':
				return 'FF'.'0000FF';
				break;
			case 'verde':
				return 'FF'.'008000';
				break;
			case 'amarillo':
				return 'FF'.'FFFF00';
				break;
			case 'magenta':
				return 'FF'.'FF00FF';
				break;
			case 'cyan':
				return 'FF'.'00FFFF';
				break;
		}
	}

	function BusTc($fecha)
    {
        $context = stream_context_create(array(
            'http' => array('ignore_errors' => true),
        ));

        // return $fecha;
        $url = 'https://api.apis.net.pe/v1/tipo-cambio-sunat?fecha='.$fecha;

        $api = file_get_contents($url,false,$context);

        if($api == false){
            return 0;
        }else{
            $api = str_replace('&Ntilde;','Ñ',$api);
            $api = json_decode($api);
            return $api->venta;
        }
    }


?>