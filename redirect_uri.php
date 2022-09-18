<?php
    header("Pragma: no-cache");
    date_default_timezone_set('America/Mexico_City');
    $ayer = date('Y-m-d',strtotime("-2 days"));
    $hoy = date('Y-m-d');
    //recibe el codigo generado por el servidor de mercado libre para confimrar el directorio 
    $codigo_autorizacion = $_GET['code'];
    $seller_id = "seller_id";
    $bd="bd";
    require_once 'config.php';
    //Se inicia la peticion post para enviar los datos necesarios para obtener el token
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://api.mercadolibre.com/oauth/token");
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=authorization_code&client_id=client_id&client_secret=client_secret&code=".$codigo_autorizacion."&redirect_uri=https://redirect_uri");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec ($ch);
    $data = json_decode($remote_server_output, true);
    $token = "Authorization: Bearer ".$data['access_token'];
    curl_close($ch);
    //url de consulta
    $url = "https://api.mercadolibre.com/orders/search?seller=$seller_id&order.date_created.from=".$ayer."T00:00:00.000-00:00&order.date_created.to=".$hoy."T23:59:00.000-00:00";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //cabeceras
    $headers = array(
       $token
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $resp = curl_exec($curl);
    curl_close($curl);
    //acceso al json de respuesta
    $datos = json_decode($resp, true);
    //Iteracion    
    echo"<hr>Actualizando $bd ... desde $ayer  hasta $hoy<hr>";
    for ($i = 1; $i < count($datos['results']); $i++) {
        //Identificacion de la orden
        $d1 = $datos['results'][$i]['payments'][0]['order_id'];
        //Fecha de creacion
        $d2 = $datos['results'][$i]['payments'][0]['date_created'];
        //Cantidad vendida
        $d3 = $datos['results'][$i]['order_items'][0]['requested_quantity']['value'];
        //MLM
        $d4 = $datos['results'][$i]['order_items'][0]['item']['id'];
        //Precio
        $d5 = $datos['results'][$i]['payments'][0]['transaction_amount'];
        $n=explode("T",$d2);
        $esta="";
        $qryf=mysqli_query($conn,"SELECT id FROM `mlo` WHERE `orden` = '".$d1."' AND `mlm` = '".$d4."' LIMIT 0, 1");    
        while ($ro=mysqli_fetch_array($qryf)) {
	       $esta =$ro['id'];
           echo "- Ya registrada antes";
		 }
         if(empty($esta)){
            mysqli_query($conn,"INSERT INTO `proforma` (`cliente`, `nombre`, `observaciones`, `fecha`, `hora`, `total`, `tipo`, `moneda`, `documento`, `bodega`, `vendedor`, `elaboro`, `pedido`, `obs2`, `idWeb`, `plazo`, `cotz`, `pid`, `c_geo_lt`, `c_geo_ln`, `c_vigencia`, `c_pago`, `c_entrega`) VALUES ('4601', 'Mercadolibre ".$d1."', '".$d1."-".$d4."', '".$n[0]."', '00:00 AM', '".$d5."', '0', '1', '0', '0', '166', '166', '0', 'Mercadolibre', '0', '0', '0', '0', '0', '0', '0', '0', '0')");
            $qryD = mysqli_query($conn,"SELECT id FROM `proforma` WHERE `elaboro` = '166' AND `observaciones` = '".$d1."-".$d4."' ORDER BY `id` DESC LIMIT 0, 1");
	        while ($ru=mysqli_fetch_array($qryD)) {	 
	           $proforma =$ru['id'];
		      }
           
            $qryg=mysqli_query($conn,"SELECT id,titulo,autor,codbar FROM `libro` WHERE `MLM` = '".$d4."' LIMIT 0, 1");    
            while ($ri=mysqli_fetch_array($qryg)) {
	           $lid =$ri['id'];
               $lti =$ri['titulo'];
               $lau =$ri['autor'];
               $lcd =$ri['codbar'];
		      }
            
            mysqli_query($conn,"INSERT INTO `proforma_detalle` (`a0`, `a1`, `a2`, `a3`, `a5`, `a6`, `a7`, `a8`, `a9`, `a10`, `a11`, `a12`, `a13`, `a14`, `a15`, `a16`, `a17`, `a21`, `cotizacion`, `a22`, `a24`, `obs1`, `idPedido`, `lista_web`) VALUES ('".$lcd."', '".$lti."', '".$lau."', '".$d3."', '".$d5."', '0', '0', '".$d5."', '".$d5."', '".$lid."', '".$d5."', '1', '0', '0', 'Editorial', '".$d5."', '0', '0', '".$proforma."', '0', '0', '".$d1."', '0', '0')");
            mysqli_query($conn,"INSERT INTO `mlo` (`orden`, `fecha`, `mlm`, `cant`, `precio`, `idpro`) VALUES ('".$d1."', '".$n[0]."', '".$d4."', '".$d3."', '".$d5."', '".$proforma."')");
            echo "Nuevo registro - ";
         } 
       echo " $d1 / $d2 / $n[0] / $d3 / $d4 / $d5 <br>";
    }
    ?>  