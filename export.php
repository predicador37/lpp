<?php
/**
 * Created by PhpStorm.
 * User: predicador
 * Date: 14/05/16
 * Time: 21:08
 */

$svg = $_POST['repo'];
$idImage = $_POST['idImage'];
session_start();
$repositorio = $_SESSION['repositorio'];
if (! $repo =simplexml_load_string($repositorio, 'SimpleXMLElement', LIBXML_NOCDATA, 'lpp', TRUE)) {
 echo "ERROR de parseo";
}

$repo->registerXPathNamespace('lpp', 'http://www.uned.es/lpp');

$imagenSvg = new SimpleXMLElement($svg);
$imagenSvg->registerXPathNamespace('svg', 'http://www.w3.org/2000/svg');
foreach ($repo->imagen as $imagen) {
    if ((string) $imagen->attributes()->id == $idImage) {
       /* POLIGONOS */
        $count_poligono=0;
        $count_polygon=0;
        foreach($imagen->poligono as $poligono) {
            ++$count_poligono;
            $count_polygon=0;
            foreach($imagenSvg->polygon as $polygon) {
                ++$count_polygon;
                if ($count_poligono == $count_polygon) {
                    $poligono->color = $polygon['stroke'];
                    $poligono->borde = $polygon['stroke-width'];
                    $poligono->opacidad = $polygon['opacity'];

                    $points=explode(" ", trim($polygon['points'], " "));
                    $points = array_values($points);
                    $count_puntos=0;
                    foreach($poligono->punto as $punto) {
                            $xy=explode(",", $points[$count_puntos]);
                            $xy=array_values($xy);
                            $punto->x = $xy[0];
                            $punto->y = $xy[1];
                            ++$count_puntos;


                    }
                }
            }
        }
        
        /*POLILINEAS*/

        $count_polilinea=0;
        $count_polyline=0;
        foreach($imagen->polilinea as $polilinea) {
            ++$count_polilinea;
            $count_polyline=0;
            foreach($imagenSvg->polyline as $polyline) {
                ++$count_polyline;
                if ($count_polilinea == $count_polyline) {
                    $polilinea->color = $polyline['stroke'];
                    $points=explode(" ", trim($polyline['points'], " "));
                    $points = array_values($points);
                    $count_puntos=0;
                    foreach($polilinea->punto as $punto) {
                        $xy=explode(",", $points[$count_puntos]);
                        $xy=array_values($xy);
                        $punto->x = $xy[0];
                        $punto->y = $xy[1];
                        ++$count_puntos;

                    }
                }
            }
        }
        
        /* RECTANGULOS */

        $count_rectangulo=0;
        $count_rect=0;
        foreach($imagen->rectangulo as $rectangulo) {
            ++$count_rectangulo;
            $count_rect=0;
            foreach($imagenSvg->rect as $rect) {
                ++$count_rect;
                if ($count_rectangulo == $count_rect) {
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

        $count_circulo=0;
        $count_circle=0;
        foreach($imagen->circulo as $circulo) {
            ++$count_circulo;
            $count_circle=0;
            foreach($imagenSvg->circle as $circle) {
                ++$count_circle;
                if ($count_circulo == $count_circle) {
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

        $count_elipse=0;
        $count_ellipse=0;
        foreach($imagen->elipse as $elipse) {
            ++$count_elipse;
            $count_ellipse=0;
            foreach($imagenSvg->ellipse as $ellipse) {
                ++$count_ellipse;
                if ($count_elipse == $count_ellipse) {
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

        $count_linea=0;
        $count_line=0;
        foreach($imagen->linea as $linea) {
            ++$count_linea;
            $count_line=0;
            foreach($imagenSvg->line as $line) {
                ++$count_line;
                if ($count_linea == $count_line) {
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



header("Content-type: application/download");
header('Content-Disposition: attachment; filename="repositorio.xml"');
//$dom = dom_import_simplexml($repo)->ownerDocument;
//$dom->formatOutput = TRUE;
//$formatted = $dom->saveXML();
//echo $formatted;
echo $repo->asXML();

?>