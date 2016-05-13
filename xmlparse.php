<?php
/**
 * Created by PhpStorm.
 * User: predicador
 * Date: 9/05/16
 * Time: 20:58
 */

session_start();
$svg = $_SESSION['svg'];
//echo '<pre>' . var_export($svg, true) . '</pre>';
$n_images = $_POST['option'];
$n_figuras = count( $svg[0]["hijos"][$n_images-1]["hijos"]);
$figuras="";

for ($i=0; $i < $n_figuras; ++$i ) {

    if($svg[0]["hijos"][$n_images-1]["hijos"][$i]["nombre"] == "LPP:POLILINEA"){
        $color = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][0]["data"];
        $puntos = "";
        for ($j=1; $j < count( $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"]);++$j ) {
            if (array_key_exists("data", $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][$j]["hijos"][0])) {
                $puntos.=$svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][$j]["hijos"][0]["data"] . ",";
            }
            else { $puntos .= "0" . ",";}
            if (array_key_exists("data",$svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][$j]["hijos"][1])) {
                $puntos.=$svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][$j]["hijos"][1]["data"] . " ";
            }
            else { $puntos.= "0" . " ";}
        }
        $polilinea = "<polyline ";
        if ($color) {
            $polilinea.="stroke=\"" . $color . "\" ";
        }
        $polilinea.="points=\"" . $puntos . "\" />";
        $figuras.=$polilinea;
    }
    else if ($svg[0]["hijos"][$n_images-1]["hijos"][$i]["nombre"] == "LPP:POLIGONO") {
        $color = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][0]["data"];
        $borde = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][1]["data"];
        $opacidad = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][2]["data"];
        $n_puntos = count( $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"])-3;
        $puntos = "";
        for ($j=3; $j < $n_puntos+3;++$j ) {
            if (array_key_exists("data", $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][$j]["hijos"][0])) {
                $puntos.=$svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][$j]["hijos"][0]["data"] . ",";
            }
            else { $puntos .= "0" . ",";}
            if (array_key_exists("data",$svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][$j]["hijos"][1])) {
                $puntos.=$svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][$j]["hijos"][1]["data"] . " ";
            }
            else { $puntos.= "0" . " ";}
        }
        $poligono = "<polygon ";
        if ($color) {
            $poligono.="stroke=\"" . $color . "\" ";
        }
        if ($borde) {
            $poligono.="stroke-width=\"" . $borde . "\" ";
        }
        if ($opacidad){
            $poligono.="opacity=\"" . $opacidad . "\" ";
        }
        $poligono.="points=\"" . $puntos . "\" />";
        $figuras.=$poligono;
    }
    else if ($svg[0]["hijos"][$n_images-1]["hijos"][$i]["nombre"] == "LPP:RECTANGULO") {
        $color = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][0]["data"];
        $borde = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][1]["data"];
        $opacidad = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][2]["data"];
        $x = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][3]["hijos"][0]["data"];
        $y = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][3]["hijos"][1]["data"];
        $ancho = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][4]["data"];
        $alto = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][5]["data"];

        $rectangulo = "<rect ";
        if ($color) {
            $rectangulo.="stroke=\"" . $color . "\" ";
        }
        if ($borde) {
            $rectangulo.="stroke-width=\"" . $borde . "\" ";
        }
        if ($opacidad){
            $rectangulo.="opacity=\"" . $opacidad . "\" ";
        }
        if ($x){
            $rectangulo.="x=\"" . $x . "\" ";
        }
        else {  $rectangulo.="x=\"". "0" . "\" ";}
        if ($y){
            $rectangulo.="y=\"" . $y . "\" ";
        }
        else {  $rectangulo.="y=\"". "0" . "\" ";}
        if ($ancho){
            $rectangulo.="width=\"" . $ancho . "\" ";
        }
        if ($alto){
            $rectangulo.="height=\"" . $alto . "\" ";
        }
        $rectangulo.= "/>";
        $figuras.=$rectangulo;
    }
    else if ($svg[0]["hijos"][$n_images-1]["hijos"][$i]["nombre"] == "LPP:CIRCULO") {
        $color = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][0]["data"];
        $borde = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][1]["data"];
        $opacidad = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][2]["data"];
        $cx = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][3]["hijos"][0]["data"];
        $cy = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][3]["hijos"][1]["data"];
        $radio = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][4]["data"];

        $circulo = "<circle ";
        if ($color) {
            $circulo.="stroke=\"" . $color . "\" ";
        }
        if ($borde) {
            $circulo.="stroke-width=\"" . $borde . "\" ";
        }
        if ($opacidad){
            $circulo.="opacity=\"" . $opacidad . "\" ";
        }
        if ($cx){
            $circulo.="cx=\"" . $cx . "\" ";
        }
        else {  $circulo.="cx=\"". "0" . "\" ";}
        if ($cy){
            $circulo.="cy=\"" . $cy . "\" ";
        }
        else {  $circulo.="cy=\"". "0" . "\" ";}
        if ($radio){
            $circulo.="r=\"" . $radio . "\" ";
        }

        $circulo.= "/>";
        $figuras.=$circulo;
       
    }

    else if ($svg[0]["hijos"][$n_images-1]["hijos"][$i]["nombre"] == "LPP:ELIPSE") {
        $color = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][0]["data"];
        $borde = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][1]["data"];
        $opacidad = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][2]["data"];
        $cx = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][3]["hijos"][0]["data"];
        $cy = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][3]["hijos"][1]["data"];
        $rx = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][4]["data"];
        $ry = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][5]["data"];

        $elipse = "<ellipse ";
        if ($color) {
            $elipse.="stroke=\"" . $color . "\" ";
        }
        if ($borde) {
            $elipse.="stroke-width=\"" . $borde . "\" ";
        }
        if ($opacidad){
            $elipse.="opacity=\"" . $opacidad . "\" ";
        }
        if ($cx){
            $elipse.="cx=\"" . $cx . "\" ";
        }
        else {  $elipse.="cx=\"". "0" . "\" ";}
        if ($cy){
            $elipse.="cy=\"" . $cy . "\" ";
        }
        else {  $elipse.="cy=\"". "0" . "\" ";}
        if ($rx){
            $elipse.="rx=\"" . $rx . "\" ";
        }
        if ($ry){
            $elipse.="ry=\"" . $ry . "\" ";
        }

        $elipse.= "/>";
        $figuras.=$elipse;
    }

    else if ($svg[0]["hijos"][$n_images-1]["hijos"][$i]["nombre"] == "LPP:LINEA") {
        $color = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][0]["data"];
        $grosor = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][1]["data"];
        $x1 = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][2]["hijos"][0]["data"];
        $y1 = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][2]["hijos"][1]["data"];
        $x2 = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][3]["hijos"][0]["data"];
        $y2 = $svg[0]["hijos"][$n_images-1]["hijos"][$i]["hijos"][3]["hijos"][1]["data"];

        $linea = "<line ";
        if ($color) {
            $linea.="stroke=\"" . $color . "\" ";
        }
        if ($borde) {
            $linea.="stroke-width=\"" . $borde . "\" ";
        }
        if ($x1){
            $linea.="x1=\"" . $x1 . "\" ";
        }
        else {  $linea.="x1=\"". "0" . "\" ";}
        if ($y1){
            $linea.="y1=\"" . $y1 . "\" ";
        }
        else {  $linea.="y1=\"". "0" . "\" ";}
        if ($x2){
            $linea.="x2=\"" . $x2 . "\" ";
        }
        else {  $linea.="x2=\"". "0" . "\" ";}
        if ($y2){
            $linea.="y2=\"" . $y2 . "\" ";
        }
        else {  $linea.="y2=\"". "0" . "\" ";}
        $linea.= "/>";
        $figuras.=$linea;
    }

}




header("Content-type: image/svg+xml");
echo '<?xml version="1.0" encoding="iso-8859-1"?>';
echo '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.0//EN" "http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd">';
echo '<svg width="500" height="250" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">';
echo $figuras;
echo '</svg>';

?>