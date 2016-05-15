<?php
/**
 * Created by PhpStorm.
 * User: predicador
 * Date: 14/05/16
 * Time: 21:08
 */

//Recuperación de SVG enviado desde el formulario
$svg = $_POST['repo'];
$idImage = $_POST['idImage'];

//Recuperación de XML almacenado en sesión
session_start();
$repositorio = $_SESSION['repositorio'];

//Parseo de XML en objeto SimpleXML
if (!$repo = simplexml_load_string($repositorio, 'SimpleXMLElement', LIBXML_NOCDATA, 'lpp', TRUE)) {
    echo "ERROR de parseo";
}
$repo->registerXPathNamespace('lpp', 'http://www.uned.es/lpp');

//Parseo de SVG en objeto SimpleXML
$imagenSvg = new SimpleXMLElement($svg);
$imagenSvg->registerXPathNamespace('svg', 'http://www.w3.org/2000/svg');

//Iteración en imágenes hasta coincidir con identificador de imagen seleccionada por usuario
foreach ($repo->imagen as $imagen) {
    if ((string)$imagen->attributes()->id == $idImage) {

        /* POLIGONOS */

        $count_poligono = 0;
        $count_polygon = 0;
        foreach ($imagen->poligono as $poligono) { //Iteración en XML
            ++$count_poligono;
            $count_polygon = 0;
            foreach ($imagenSvg->polygon as $polygon) { //Iteración en SVG
                ++$count_polygon;
                if ($count_poligono == $count_polygon) { //Mapeo de atributos
                    $poligono->color = $polygon['stroke'];
                    $poligono->borde = $polygon['stroke-width'];
                    $poligono->opacidad = $polygon['opacity'];

                    $points = explode(" ", trim($polygon['points'], " "));
                    $points = array_values($points);
                    $count_puntos = 0;
                    foreach ($poligono->punto as $punto) { //Iteración de puntos
                        $xy = explode(",", $points[$count_puntos]);
                        $xy = array_values($xy);
                        $punto->x = $xy[0];
                        $punto->y = $xy[1];
                        ++$count_puntos;


                    }
                }
            }
        }

        /*POLILINEAS*/

        $count_polilinea = 0;
        $count_polyline = 0;
        foreach ($imagen->polilinea as $polilinea) { //Iteración en XML
            ++$count_polilinea;
            $count_polyline = 0;
            foreach ($imagenSvg->polyline as $polyline) { //Iteración en SVG
                ++$count_polyline;
                if ($count_polilinea == $count_polyline) { //Mapeo de atributos
                    $polilinea->color = $polyline['stroke'];
                    $points = explode(" ", trim($polyline['points'], " "));
                    $points = array_values($points);
                    $count_puntos = 0;
                    foreach ($polilinea->punto as $punto) { //Iteración de puntos
                        $xy = explode(",", $points[$count_puntos]);
                        $xy = array_values($xy);
                        $punto->x = $xy[0];
                        $punto->y = $xy[1];
                        ++$count_puntos;

                    }
                }
            }
        }

        /* RECTANGULOS */

        $count_rectangulo = 0;
        $count_rect = 0;
        foreach ($imagen->rectangulo as $rectangulo) { //Iteración en XML
            ++$count_rectangulo;
            $count_rect = 0;
            foreach ($imagenSvg->rect as $rect) { //Iteración en SVG
                ++$count_rect;
                if ($count_rectangulo == $count_rect) { //Mapeo de atributos
                    $rectangulo->color = $rect['stroke'];
                    $rectangulo->borde = $rect['stroke-width'];
                    $rectangulo->opacidad = $rect['opacity'];
                    $rectangulo->posicion->x = $rect['x'];
                    $rectangulo->posicion->y = $rect['y'];
                    $rectangulo->ancho = $rect['width'];
                    $rectangulo->alto = $rect['height'];

                }
            }
        }

        /* CIRCULOS */

        $count_circulo = 0;
        $count_circle = 0;
        foreach ($imagen->circulo as $circulo) { //Iteración en XML
            ++$count_circulo;
            $count_circle = 0;
            foreach ($imagenSvg->circle as $circle) { //Iteración en SVG
                ++$count_circle;
                if ($count_circulo == $count_circle) { //Mapeo de atributos
                    $circulo->color = $circle['stroke'];
                    $circulo->borde = $circle['stroke-width'];
                    $circulo->opacidad = $circle['opacity'];
                    $circulo->centro->x = $circle['cx'];
                    $circulo->centro->y = $circle['cy'];
                    $circulo->radio = $circle['r'];


                }
            }
        }

        /* ELIPSES */

        $count_elipse = 0;
        $count_ellipse = 0;
        foreach ($imagen->elipse as $elipse) { //Iteración en XML
            ++$count_elipse;
            $count_ellipse = 0;
            foreach ($imagenSvg->ellipse as $ellipse) { //Iteración en SVG
                ++$count_ellipse;
                if ($count_elipse == $count_ellipse) { //Mapeo de atributos
                    $elipse->color = $ellipse['stroke'];
                    $elipse->borde = $ellipse['stroke-width'];
                    $elipse->opacidad = $ellipse['opacity'];
                    $elipse->centro->x = $ellipse['cx'];
                    $elipse->centro->y = $ellipse['cy'];
                    $elipse->radio_x = $ellipse['rx'];
                    $elipse->radio_y = $ellipse['ry'];


                }
            }
        }

        /* LINEAS */

        $count_linea = 0;
        $count_line = 0;
        foreach ($imagen->linea as $linea) { //Iteración en XML
            ++$count_linea;
            $count_line = 0;
            foreach ($imagenSvg->line as $line) { //Iteración en SVG
                ++$count_line;
                if ($count_linea == $count_line) { //Mapeo de atributos
                    $linea->color = $line['stroke'];
                    $linea->grosor = $line['stroke-width'];
                    $linea->puntoInicial->x = $line['x1'];
                    $linea->puntoInicial->y = $line['y1'];
                    $linea->puntoFinal->x = $line['x2'];
                    $linea->puntoFinal->y = $line['y2'];


                }
            }
        }

    }
}

//Descarga de XML en el navegador
header("Content-type: application/download");
header('Content-Disposition: attachment; filename="repositorio.xml"');
echo $repo->asXML();

?>