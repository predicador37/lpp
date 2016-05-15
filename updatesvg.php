<?php
/**
 * Created by PhpStorm.
 * User: predicador
 * Date: 14/05/16
 * Time: 11:16
 */

//Carga de SVG desde sesión y en objeto SimpleXML
session_start();
$svg = $_SESSION['svgImage'];
$imagen = new SimpleXMLElement($svg);
$imagen->registerXPathNamespace('svg', 'http://www.w3.org/2000/svg');

//Procesado de polígonos y mapeo de parámetros según identificador
foreach ($imagen->polygon as $poligono) {
    $puntos = "";
    $poligono['stroke'] = $_POST['color_' . $poligono['id']];
    $poligono['stroke-width'] = $_POST['borde_' . $poligono['id']];
    $poligono['opacity'] = $_POST['opacidad_' . $poligono['id']];
    for ($i = 1; $i <= $_POST['puntos_' . $poligono['id']]; ++$i) {
        $puntos .= $_POST['x' . $i . "_" . $poligono['id']] . ",";
        $puntos .= $_POST['y' . $i . "_" . $poligono['id']] . " ";
    }
    $poligono['points'] = $puntos;
}

//Procesado de polílíneas y mapeo de parámetros según identificador
foreach ($imagen->polyline as $polilinea) {
    $puntos = "";
    $polilinea['stroke'] = $_POST['color_' . $polilinea['id']];
    for ($i = 1; $i < $_POST['puntos_' . $polilinea['id']]; ++$i) {
        $puntos .= $_POST['x' . $i . "_" . $polilinea['id']] . ",";
        $puntos .= $_POST['y' . $i . "_" . $polilinea['id']] . " ";
    }
    $polilinea['points'] = $puntos;
}

//Procesado de rectángulos y mapeo de parámetros según identificador
foreach ($imagen->rect as $rectangulo) {
    $rectangulo['stroke'] = $_POST['color_' . $rectangulo['id']];
    $rectangulo['stroke-width'] = $_POST['borde_' . $rectangulo['id']];
    $rectangulo['opacity'] = $_POST['opacidad_' . $rectangulo['id']];
    $rectangulo['x'] = $_POST['x_' . $rectangulo['id']];
    $rectangulo['y'] = $_POST['y_' . $rectangulo['id']];
    $rectangulo['width'] = $_POST['width_' . $rectangulo['id']];
    $rectangulo['height'] = $_POST['height_' . $rectangulo['id']];
}

//Procesado de círculos y mapeo de parámetros según identificador
foreach ($imagen->circle as $circulo) {
    $circulo['stroke'] = $_POST['color_' . $circulo['id']];
    $circulo['stroke-width'] = $_POST['borde_' . $circulo['id']];
    $circulo['opacity'] = $_POST['opacidad_' . $circulo['id']];
    $circulo['cx'] = $_POST['x_' . $circulo['id']];
    $circulo['cy'] = $_POST['y_' . $circulo['id']];
    $circulo['r'] = $_POST['radio_' . $circulo['id']];
}

//Procesado de elipses y mapeo de parámetros según identificador
foreach ($imagen->ellipse as $elipse) {
    $elipse['stroke'] = $_POST['color_' . $elipse['id']];
    $elipse['stroke-width'] = $_POST['borde_' . $elipse['id']];
    $elipse['opacity'] = $_POST['opacidad_' . $elipse['id']];
    $elipse['cx'] = $_POST['x_' . $elipse['id']];
    $elipse['cy'] = $_POST['y_' . $elipse['id']];
    $elipse['rx'] = $_POST['radio_x_' . $elipse['id']];
    $elipse['ry'] = $_POST['radio_y_' . $elipse['id']];
}

//Procesado de líneas y mapeo de parámetros según identificador
foreach ($imagen->line as $linea) {
    $linea['stroke'] = $_POST['color_' . $linea['id']];
    $linea['stroke-width'] = $_POST['grosor_' . $linea['id']];
    $linea['x1'] = $_POST['x1_' . $linea['id']];
    $linea['y1'] = $_POST['y1_' . $linea['id']];
    $linea['x2'] = $_POST['x2_' . $linea['id']];
    $linea['y2'] = $_POST['y2_' . $linea['id']];
}

//Devuelve SVG en XML para incorporar en el cliente
echo $imagen->asXML();
?>