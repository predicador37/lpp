<?php
/**
 * Created by PhpStorm.
 * User: predicador
 * Date: 9/05/16
 * Time: 20:58
 */

session_start();
$svg = $_SESSION['svg'];
$n_images = $_POST['option'];
        

if($svg[$n_images-1]["hijos"][0]["hijos"][0]["nombre"] == "LPP:POLILINEA"){
    $color = $svg[$n_images-1]["hijos"][0]["hijos"][0]["hijos"][0]["data"];
    $puntos = "";
    for ($i=1; $i < count( $svg[$n_images-1]["hijos"][0]["hijos"][0]["hijos"]);++$i ) {
        if (array_key_exists("data", $svg[$n_images-1]["hijos"][0]["hijos"][0]["hijos"][$i]["hijos"][0])) {
            $puntos.=$svg[$n_images-1]["hijos"][0]["hijos"][0]["hijos"][$i]["hijos"][0]["data"] . ",";
        }
        else { $puntos .= "0" . ",";}
        if (array_key_exists("data",$svg[$n_images-1]["hijos"][0]["hijos"][0]["hijos"][$i]["hijos"][1])) {
            $puntos.=$svg[$n_images-1]["hijos"][0]["hijos"][0]["hijos"][$i]["hijos"][1]["data"] . " ";
        }
        else { $puntos.= "0" . " ";}
    }
    $polilinea = "<polyline ";
    if ($color) {
        $polilinea.="stroke=\"" . $color . "\" ";
    }
    $polilinea.="points=\"" . $puntos . "\" />";
}

header("Content-type: image/svg+xml");
echo '<?xml version="1.0" encoding="iso-8859-1"?>';
echo '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.0//EN" "http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd">';
echo '<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">';
echo $polilinea;
echo '</svg>';

?>