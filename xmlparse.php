<?php
/**
 * Created by PhpStorm.
 * User: predicador
 * Date: 9/05/16
 * Time: 20:58
 */

session_start();

//Recuperación del array con el SVG procesado de la sesión
$svg = $_SESSION['svg'];
$n_images = $_POST['option'];
$n_figuras = count($svg[0]["hijos"][$n_images - 1]["hijos"]);
$figuras = "";
$edit = "";

//Iteración en el total de las figuras que componen la imagen
for ($i = 0; $i < $n_figuras; ++$i) {

    //Procesado del tipo POLILINEA
    if ($svg[0]["hijos"][$n_images - 1]["hijos"][$i]["nombre"] == "LPP:POLILINEA") {

        //Extracción de atributos
        $n_puntos = count($svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"]);
        $color = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][0]["data"];
        $puntos = "";

        //Extracción de puntos de coordenadas
        for ($j = 1; $j < count($svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"]); ++$j) {
            if (array_key_exists("data", $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][$j]["hijos"][0])) {
                $puntos .= $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][$j]["hijos"][0]["data"] . ",";
            } else {
                $puntos .= "0" . ",";
            }
            if (array_key_exists("data", $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][$j]["hijos"][1])) {
                $puntos .= $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][$j]["hijos"][1]["data"] . " ";
            } else {
                $puntos .= "0" . " ";
            }
        }
        //Mapeo y generación de SVG

        $polilinea = '<polyline  id="polilinea' . $i . '" ';
        if ($color) {
            $polilinea .= 'stroke="' . $color . '" ';
        }
        $polilinea .= 'points="' . $puntos . '" />';
        $figuras .= $polilinea;

        //Formulario para la edición del SVG
        $polilineaHtml =
            ' <div class="polilinea">' .
            '<input name="puntos_polilinea' . $i . '" id="puntos_polilinea' . $i . '" type="text" style="display: none" value="' . $n_puntos . '" />' .
            '<h3>Polilínea</h3>' .
            '<hr class="separator"/>' .

            '<div class="form-group">' .
            '<label for="color_polilinea' . $i . '">Color</label>' .
            '<input value="' . $color . '" class="form-control" type="text" name="color_polilinea' . $i . '" id="color_polilinea' . $i . '" />' .
            '</div>' .

            '<div class="puntos_polilinea' . $i . '">';
        for ($j = 1; $j < $n_puntos; ++$j) {
            $polilineaHtml .=
                '<div class="punto_polilinea">' .
                '<h4>Punto ' . ($j) . '</h4>' .
                '<hr class="separator"/>' .

                '<div class="form-group">' .
                '<label for="x' . ($j) . '_polilinea' . $i . '">X</label>' .
                '<input value="' . (array_key_exists("data", $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][$j]["hijos"][0]) ? $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][$j]["hijos"][0]["data"] : 0) . '" class="form-control" type="number" name="x' . ($j) . '_polilinea' . $i . '" id="x' . ($j) . '_polilinea' . $i . '" />' .
                '</div>' .

                '<div class="form-group">' .
                '<label for="y' . ($j) . '_polilinea' . $i . '">Y</label>' .

                '<input value="' . (array_key_exists("data", $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][$j]["hijos"][1]) ? $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][$j]["hijos"][1]["data"] : 0) . '" class="form-control" type="number" name="y' . ($j) . '_polilinea' . $i . '" id="y' . ($j) . '_polilinea' . $i . '" />' .
                '</div>' .
                '</div>';
        }
        $polilineaHtml .=
            '</div>' .
            '</div>';
        $edit .= $polilineaHtml;

    } //Procesado del tipo POLIGONO
    else if ($svg[0]["hijos"][$n_images - 1]["hijos"][$i]["nombre"] == "LPP:POLIGONO") {

        //Extracción de atributos
        $n_puntos = count($svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"]) - 3;
        $color = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][0]["data"];
        $borde = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][1]["data"];
        $opacidad = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][2]["data"];

        //Extracción de puntos de coordenadas
        $puntos = "";
        for ($j = 3; $j < $n_puntos + 3; ++$j) {
            if (array_key_exists("data", $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][$j]["hijos"][0])) {
                $puntos .= $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][$j]["hijos"][0]["data"] . ",";
            } else {
                $puntos .= "0" . ",";
            }
            if (array_key_exists("data", $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][$j]["hijos"][1])) {
                $puntos .= $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][$j]["hijos"][1]["data"] . " ";
            } else {
                $puntos .= "0" . " ";
            }
        }
        //Mapeo y generación de SVG
        $poligono = '<polygon id="poligono' . $i . '" ';
        if ($color) {
            $poligono .= "stroke=\"" . $color . "\" ";
        }
        if ($borde) {
            $poligono .= "stroke-width=\"" . $borde . "\" ";
        }
        if ($opacidad) {
            $poligono .= "opacity=\"" . $opacidad . "\" ";
        }
        $poligono .= "points=\"" . $puntos . "\" />";
        $figuras .= $poligono;

        //Formulario para la edición del SVG
        $poligonoHtml =
            ' <div class="poligono">' .
            '<input name="puntos_poligono' . $i . '" id="puntos_poligono' . $i . '" type="text" style="display: none" value="' . $n_puntos . '" />' .
            '<h3>Polígono</h3>' .
            '<hr class="separator"/>' .
            '<div class="form-group">' .
            '<label for="color_poligono' . $i . '">Color</label>' .
            '<input class="form-control" value="' . $color . '" type="text" name="color_poligono' . $i . '" id="color_poligono' . $i . '" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="borde_poligono' . $i . '">Borde</label>' .
            '<input class="form-control"  value="' . $borde . '" type="number" name="borde_poligono' . $i . '" id="borde_poligono' . $i . '" min="0" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="opacidad_poligono' . $i . '">Opacidad</label>' .
            '<input class="form-control" value="' . $opacidad . '" type="number" step="any" name="opacidad_poligono' . $i . '" id="opacidad_poligono' . $i . '" min="0" max="1"  required/>' .
            '</div>' .
            '<div class="puntos_poligono' . $i . '">';
        for ($j = 3; $j < $n_puntos + 3; ++$j) {
            $poligonoHtml .=
                '<div class="punto_poligono">' .
                '<h4>Punto ' . ($j - 2) . '</h4>' .
                '<hr class="separator"/>' .
                '<div class="form-group">' .
                '<label for="x' . ($j - 2) . '_poligono' . $i . '">X</label>' .
                '<input class="form-control" value="' . (array_key_exists("data", $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][$j]["hijos"][0]) ? $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][$j]["hijos"][0]["data"] : 0) . '" type="number" step="any" name="x' . ($j - 2) . '_poligono' . $i . '" id="x' . ($j - 2) . '_poligono' . $i . '"  required />' .
                '</div>' .
                '<div class="form-group">' .
                '<label for="y' . ($j - 2) . '_poligono' . $i . '">Y</label>' .
                '<input class="form-control" value="' . (array_key_exists("data", $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][$j]["hijos"][1]) ? $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][$j]["hijos"][1]["data"] : 0) . '" type="number" step="any" name="y' . ($j - 2) . '_poligono' . $i . '" id="y' . ($j - 2) . '_poligono' . $i . '" required />' .
                '</div>' .
                '</div>';
        }
        $poligonoHtml .=
            '</div>' .
            '</div>';

        $edit .= $poligonoHtml;
    } //Procesado del tipo RECTANGULO
    else if ($svg[0]["hijos"][$n_images - 1]["hijos"][$i]["nombre"] == "LPP:RECTANGULO") {

        //Extracción de atributos
        $color = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][0]["data"];
        $borde = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][1]["data"];
        $opacidad = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][2]["data"];
        if (array_key_exists("data", $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][3]["hijos"][0])) {
            $x = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][3]["hijos"][0]["data"];
        } else {
            $x = "0";
        }
        if (array_key_exists("data", $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][3]["hijos"][1])) {
            $y = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][3]["hijos"][1]["data"];
        } else {
            $y = "0";
        }
        $ancho = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][4]["data"];
        $alto = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][5]["data"];

        //Mapeo y generación de SVG
        $rectangulo = "<rect id=\"rectangulo" . $i . "\" ";
        if ($color) {
            $rectangulo .= "stroke=\"" . $color . "\" ";
        }
        if ($borde) {
            $rectangulo .= "stroke-width=\"" . $borde . "\" ";
        }
        if ($opacidad) {
            $rectangulo .= "opacity=\"" . $opacidad . "\" ";
        }
        if ($x) {
            $rectangulo .= "x=\"" . $x . "\" ";
        } else {
            $rectangulo .= "x=\"" . "0" . "\" ";
        }
        if ($y) {
            $rectangulo .= "y=\"" . $y . "\" ";
        } else {
            $rectangulo .= "y=\"" . "0" . "\" ";
        }
        if ($ancho) {
            $rectangulo .= "width=\"" . $ancho . "\" ";
        }
        if ($alto) {
            $rectangulo .= "height=\"" . $alto . "\" ";
        }
        $rectangulo .= "/>";
        $figuras .= $rectangulo;

        //Formulario para la edición del SVG
        $rectanguloHtml = '<div class="rectangulo">' .
            '<h3>Rectángulo</h3>' .
            '<hr class="separator"/>' .
            '<div class="form-group">' .
            '<label for="color_rectangulo' . $i . '">Color</label>' .
            '<input value="' . $color . '" class="form-control" type="text" name="color_rectangulo' . $i . '" id="color_rectangulo' . $i . '" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="borde_rectangulo' . $i . '">Borde</label>' .
            '<input value="' . $borde . '" class="form-control" type="number" name="borde_rectangulo' . $i . '" id="borde_rectangulo' . $i . '" min="0" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="opacidad_rectangulo' . $i . '">Opacidad</label>' .
            '<input value="' . $opacidad . '" class="form-control" type="number" step="any" name="opacidad_rectangulo' . $i . '" id="opacidad_rectangulo' . $i . '" min="0" max="1"  required/>' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="x_rectangulo' . $i . '">X</label>' .
            '<input value="' . $x . '" class="form-control" type="number" step="any" name="x_rectangulo' . $i . '" id="x_rectangulo' . $i . '" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="y_rectangulo' . $i . '">Y</label>' .
            '<input value="' . $y . '" class="form-control" type="number" step="any" name="y_rectangulo' . $i . '" id="y_rectangulo' . $i . '" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="width_rectangulo' . $i . '">Ancho</label>' .
            '<input value="' . $ancho . '" class="form-control" type="number" step="any" name="width_rectangulo' . $i . '" id="width_rectangulo' . $i . '" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="height_rectangulo' . $i . '">Alto</label>' .
            '<input value="' . $alto . '" class="form-control" type="number" step="any" name="height_rectangulo' . $i . '" id="height_rectangulo' . $i . '" required />' .
            '</div>' .
            '</div>';
        $edit .= $rectanguloHtml;
    } //Procesado del tipo CIRCULO
    else if ($svg[0]["hijos"][$n_images - 1]["hijos"][$i]["nombre"] == "LPP:CIRCULO") {

        //Extracción de atributos
        $color = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][0]["data"];
        $borde = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][1]["data"];
        $opacidad = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][2]["data"];
        if (array_key_exists("data", $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][3]["hijos"][0])) {
            $cx = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][3]["hijos"][0]["data"];
        } else {
            $cx = "0";
        }
        if (array_key_exists("data", $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][3]["hijos"][1])) {
            $cy = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][3]["hijos"][1]["data"];
        } else {
            $cy = "0";
        }

        $radio = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][4]["data"];

        //Mapeo y generación del SVG
        $circulo = "<circle id=\"circulo" . $i . "\" ";
        if ($color) {
            $circulo .= "stroke=\"" . $color . "\" ";
        }
        if ($borde) {
            $circulo .= "stroke-width=\"" . $borde . "\" ";
        }
        if ($opacidad) {
            $circulo .= "opacity=\"" . $opacidad . "\" ";
        }
        if ($cx) {
            $circulo .= "cx=\"" . $cx . "\" ";
        } else {
            $circulo .= "cx=\"" . "0" . "\" ";
        }
        if ($cy) {
            $circulo .= "cy=\"" . $cy . "\" ";
        } else {
            $circulo .= "cy=\"" . "0" . "\" ";
        }
        if ($radio) {
            $circulo .= "r=\"" . $radio . "\" ";
        }

        $circulo .= "/>";
        $figuras .= $circulo;

        $circuloHtml = '<div class="circulo">' .
            '<h3>Círculo</h3>' .
            '<hr class="separator"/>' .
            '<div class="form-group">' .
            '<label for="color_circulo' . $i . '">Color</label>' .
            '<input value="' . $color . '" class="form-control" type="text" name="color_circulo' . $i . '" id="color_circulo' . $i . '" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="borde_circulo_1_imagen_1">Borde</label>' .
            '<input value="' . $borde . '" class="form-control" type="number" name="borde_circulo' . $i . '" id="borde_circulo' . $i . '" min="0" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="opacidad_circulo' . $i . '">Opacidad</label>' .
            '<input value="' . $opacidad . '" class="form-control" type="number" step="any" name="opacidad_circulo' . $i . '" id="opacidad_circulo' . $i . '" min="0" max="1"  required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="x_circulo' . $i . '">X</label>' .
            '<input value="' . $cx . '" class="form-control" type="number" step="any" name="x_circulo' . $i . '" id="x_circulo' . $i . '" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="y_circulo_1_imagen_1">Y</label>' .
            '<input value="' . $cy . '" class="form-control" type="number" step="any" name="y_circulo' . $i . '" id="y_circulo' . $i . '" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="radio_circulo' . $i . '">Radio</label>' .
            '<input value="' . $radio . '" class="form-control" type="number" step="any" name="radio_circulo' . $i . '" id="radio_circulo' . $i . '" required />' .
            '</div>';
        '</div>';
        $edit .= $circuloHtml;

    } //Procesado del tipo ELIPSE
    else if ($svg[0]["hijos"][$n_images - 1]["hijos"][$i]["nombre"] == "LPP:ELIPSE") {

        //Extracción de atributos
        $color = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][0]["data"];
        $borde = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][1]["data"];
        $opacidad = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][2]["data"];
        if (array_key_exists("data", $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][3]["hijos"][0])) {
            $cx = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][3]["hijos"][0]["data"];
        } else {
            $cx = "0";
        }
        if (array_key_exists("data", $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][3]["hijos"][1])) {
            $cy = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][3]["hijos"][1]["data"];
        } else {
            $cy = "0";
        }
        $rx = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][4]["data"];
        $ry = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][5]["data"];

        //Mapeo y generación de SVG
        $elipse = "<ellipse id=\"elipse" . $i . "\" ";
        if ($color) {
            $elipse .= "stroke=\"" . $color . "\" ";
        }
        if ($borde) {
            $elipse .= "stroke-width=\"" . $borde . "\" ";
        }
        if ($opacidad) {
            $elipse .= "opacity=\"" . $opacidad . "\" ";
        }
        if ($cx) {
            $elipse .= "cx=\"" . $cx . "\" ";
        } else {
            $elipse .= "cx=\"" . "0" . "\" ";
        }
        if ($cy) {
            $elipse .= "cy=\"" . $cy . "\" ";
        } else {
            $elipse .= "cy=\"" . "0" . "\" ";
        }
        if ($rx) {
            $elipse .= "rx=\"" . $rx . "\" ";
        }
        if ($ry) {
            $elipse .= "ry=\"" . $ry . "\" ";
        }

        $elipse .= "/>";
        $figuras .= $elipse;

        //Formulario para la edición del SVG
        $elipseHtml =
            ' <div class="elipse">' .
            '<h3>Elipse</h3>' .
            '<div>' .
            '<hr class="separator"/>' .
            '<div class="form-group">' .
            '<label for="color_elipse' . $i . '">Color</label>' .
            '<input value="' . $color . '"  class="form-control" type="text" name="color_elipse' . $i . '" id="color_elipse' . $i . '" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="borde_elipse' . $i . '">Borde</label>' .
            '<input value="' . $borde . '"  class="form-control" type="number" name="borde_elipse' . $i . '" id="borde_elipse' . $i . '" min="0" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="opacidad_elipse' . $i . '">Opacidad</label>' .
            '<input value="' . $opacidad . '"  class="form-control" type="number" step="any" name="opacidad_elipse' . $i . '" id="opacidad_elipse_1_imagen_1" min="0" max="1"  required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="x_elipse' . $i . '">X</label>' .
            '<input value="' . $cx . '"  class="form-control" type="number" step="any" name="x_elipse' . $i . '" id="x_elipse' . $i . '" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="y_elipse' . $i . '">Y</label>' .
            '<input value="' . $cy . '"  class="form-control" type="number" step="any" name="y_elipse' . $i . '" id="y_elipse' . $i . '" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="radio_x_elipse' . $i . '">Radio X</label>' .
            '<input value="' . $rx . '"  class="form-control" type="number" step="any" name="radio_x_elipse' . $i . '" id="radio_x_elipse' . $i . '" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="radio_y_elipse' . $i . '">Radio Y</label>' .
            '<input value="' . $ry . '"  class="form-control" type="number" step="any" name="radio_y_elipse' . $i . '" id="radio_y_elipse' . $i . '" required />' .
            '</div>';
        '</div>';
        $edit .= $elipseHtml;
    } //Procesado del tipo LINEA
    else if ($svg[0]["hijos"][$n_images - 1]["hijos"][$i]["nombre"] == "LPP:LINEA") {

        //Extracción de atributos
        $color = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][0]["data"];
        $grosor = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][1]["data"];
        if (array_key_exists("data", $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][2]["hijos"][0])) {
            $x1 = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][2]["hijos"][0]["data"];
        } else {
            $x1 = "0";
        }
        if (array_key_exists("data", $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][2]["hijos"][1])) {
            $y1 = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][2]["hijos"][1]["data"];
        } else {
            $y1 = "0";
        }
        if (array_key_exists("data", $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][3]["hijos"][0])) {
            $x2 = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][3]["hijos"][0]["data"];
        } else {
            $x2 = "0";
        }
        if (array_key_exists("data", $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][3]["hijos"][1])) {
            $y2 = $svg[0]["hijos"][$n_images - 1]["hijos"][$i]["hijos"][3]["hijos"][1]["data"];
        } else {
            $y2 = "0";
        }

        //Mapeo y generación del SVG
        $linea = "<line id=\"linea" . $i . "\" ";
        if ($color) {
            $linea .= "stroke=\"" . $color . "\" ";
        }
        if ($grosor) {
            $linea .= "stroke-width=\"" . $grosor . "\" ";
        }
        if ($x1) {
            $linea .= "x1=\"" . $x1 . "\" ";
        } else {
            $linea .= "x1=\"" . "0" . "\" ";
        }
        if ($y1) {
            $linea .= "y1=\"" . $y1 . "\" ";
        } else {
            $linea .= "y1=\"" . "0" . "\" ";
        }
        if ($x2) {
            $linea .= "x2=\"" . $x2 . "\" ";
        } else {
            $linea .= "x2=\"" . "0" . "\" ";
        }
        if ($y2) {
            $linea .= "y2=\"" . $y2 . "\" ";
        } else {
            $linea .= "y2=\"" . "0" . "\" ";
        }
        $linea .= "/>";
        $figuras .= $linea;

        //Formulario para la edición del SVG
        $lineaHtml =
            ' <div class="linea">' .
            '<h3>Línea</h3>' .
            '<hr class="separator"/>' .
            '<div class="form-group">' .
            '<label for="color_linea' . $i . '">Color</label>' .
            '<input value="' . $color . '" class="form-control" type="text" name="color_linea' . $i . '" id="color_linea' . $i . '" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="grosor_linea' . $i . '">Grosor</label>' .
            '<input value="' . $grosor . '" class="form-control" type="number" name="grosor_linea' . $i . '" id="grosor_linea' . $i . '" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="x1_linea' . $i . '">X</label>' .
            '<input value="' . $x1 . '" class="form-control" type="number" step="any" name="x1_linea' . $i . '" id="x1_linea' . $i . '" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="y1_linea' . $i . '">Y</label>' .
            '<input value="' . $y1 . '" class="form-control" type="number" step="any" name="y1_linea' . $i . '" id="y1_linea' . $i . '" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="x2_linea' . $i . '">X</label>' .
            '<input value="' . $x2 . '" class="form-control" type="number" step="any" name="x2_linea' . $i . '" id="x2_linea' . $i . '" required />' .
            '</div>' .
            '<div class="form-group">' .
            '<label for="y2_linea' . $i . '">Y</label>' .
            '<input value="' . $y2 . '" class="form-control" type="number" step="any" name="y2_linea' . $i . '" id="y2_linea' . $i . '" required />' .
            '</div>';
        $edit .= $lineaHtml;
    }

}

//Composición final del SVG con un tamaño de lienzo apropiado
$imagen = '<svg width="500" height="250" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">';
$imagen .= $figuras;
$imagen .= '</svg>';

//Empaquetado de la respuesta en un array para su envío usando JSON
$data = array(
    'imagen' => $imagen,
    'edit' => $edit
);
//Almacenamiento de la imagen generada en sesión
$_SESSION['svgImage'] = $imagen;
//Envío usando JSON
header('Content-type: application/json');
echo json_encode($data);
?>