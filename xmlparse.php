<?php
/**
 * Created by PhpStorm.
 * User: predicador
 * Date: 9/05/16
 * Time: 20:58
 */


//$file = 'test.xml';
if ($_POST["action"] == "upload")
{
    if ($_FILES["file"]["tmp_name"])
    {
        $file = $_FILES["file"]["tmp_name"];

$svg = array();

function inicio($parser, $nombre, $atributos)
{
    global $svg;
    $tag=array("nombre"=>$nombre,"atributos"=>$atributos);
    array_push($svg,$tag);

}

function data($parser, $data)
{
    global $svg,$i;

    if(trim($data))
    {
        $svg[count($svg)-1]['data']=$data;
    }
}

function fin($parser, $nombre)
{
    global $svg;
    $svg[count($svg)-2]['hijos'][] = $svg[count($svg)-1];
    array_pop($svg);
}

$xml_parser = xml_parser_create();
xml_set_element_handler($xml_parser, "inicio", "fin");
xml_set_character_data_handler($xml_parser, "data");

$data = xml_parse($xml_parser,file_get_contents($file));
if(!$data) {
    die(sprintf("XML error: %s at line %d",
        xml_error_string(xml_get_error_code($xml_parser)),
        xml_get_current_line_number($xml_parser)));
}

xml_parser_free($xml_parser);
        
        

if($svg[0]["hijos"][0]["hijos"][0]["nombre"] == "LPP:POLILINEA"){
    $color = $svg[0]["hijos"][0]["hijos"][0]["hijos"][0]["data"];
    $puntos = "";
    for ($i=1; $i < count( $svg[0]["hijos"][0]["hijos"][0]["hijos"]);++$i ) {
        if (array_key_exists("data", $svg[0]["hijos"][0]["hijos"][0]["hijos"][$i]["hijos"][0])) {
            $puntos.=$svg[0]["hijos"][0]["hijos"][0]["hijos"][$i]["hijos"][0]["data"] . ",";
        }
        else { $puntos .= "0" . ",";}
        if (array_key_exists("data",$svg[0]["hijos"][0]["hijos"][0]["hijos"][$i]["hijos"][1])) {
            $puntos.=$svg[0]["hijos"][0]["hijos"][0]["hijos"][$i]["hijos"][1]["data"] . " ";
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

       
    }
    else
    {
        print "<p>Upload failed.</p>";
    }
}
print_r($svg);
?>