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
        session_start();
        $_SESSION['svg'] = $svg;

        $imagenes = count($svg[0]["hijos"]);
        echo "<option>Seleccione imagen</option>";
        foreach (range(1, $imagenes) as $número) {
            echo "<option>".$número."</option>";
        }



}
else
{
print "<p>Upload failed.</p>";
}
}
?>