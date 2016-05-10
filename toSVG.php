<!DOCTYPE html>
<html>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: predicador
 * Date: 9/05/16
 * Time: 19:50
 */

//Initialize the XML parser
$parser=xml_parser_create();
function start($parser,$element_name,$element_attrs) {
    //echo $element_name;
    $points='';
    switch($element_name) {
        case "LPP:POLILINEA":
            echo "<polyline ";
            break;
        case "LPP:COLOR":
            echo "stroke=\"";
            break;
        case "LPP:PUNTO":
            echo "points=\"";
            break;
        case "HEADING":
            echo "Heading: ";
            break;
        case "BODY":
            echo "Message: ";
    }
}


//<polyline stroke="blue" points="0,0 25,25 70,70" />

//Function to use at the end of an element
function stop($parser,$element_name) {
    echo "\"";
}

//Function to use when finding character data
function char($parser,$data) {
    echo $data;
}

//Specify element handler
xml_set_element_handler($parser,"start","stop");

//Specify data handler
xml_set_character_data_handler($parser,"char");
//Open XML file
$fp=fopen("test.xml","r");

//Read data
while ($data=fread($fp,4096)) {
    xml_parse($parser,$data,feof($fp)) or
    die (sprintf("XML Error: %s at line %d",
        xml_error_string(xml_get_error_code($parser)),
        xml_get_current_line_number($parser)));
}

//Free the XML parser
xml_parser_free($parser);
?>
</body>
</html>
