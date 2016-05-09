<?php
/**
 * Created by PhpStorm.
 * User: predicador
 * Date: 6/05/16
 * Time: 19:11
 */


    //Let's now print out the received values in the browser


    $repositorio = new SimpleXMLElement("<lpp:repositorio xmlns:lpp=\"http://www.uned.es/lpp\"></lpp:repositorio>");

for ($i = 1; $i <= $_POST['imagens']; ++$i) {
    $imagen =  $repositorio->addChild('imagen');
    $imagen->addAttribute('id', $i);
    if (isset($_POST['rectangulos_imagen_'.$i])){
        for ($j = 1; $j <= $_POST['rectangulos_imagen_'.$i]; ++$j) {

            $rectangulo = $imagen->addChild('rectangulo');
            if ($_POST['color_rectangulo_'.$j.'_imagen_'.$i]) {
                $rectangulo->addChild('color', $_POST['color_rectangulo_'.$j.'_imagen_'.$i]);
            }
            if ($_POST['borde_rectangulo_'.$j.'_imagen_'.$i]) {
                $rectangulo->addChild('borde', $_POST['borde_rectangulo_' . $j.'_imagen_'.$i]);
            }
            if ($_POST['opacidad_rectangulo_'.$j.'_imagen_'.$i]) {
                $rectangulo->addChild('opacidad', $_POST['opacidad_rectangulo_' . $j.'_imagen_'.$i]);
            }
            if ($_POST['x_rectangulo_'.$j.'_imagen_'.$i] && $_POST['y_rectangulo_'.$j.'_imagen_'.$i]) {
                $posicion = $rectangulo->addChild('posicion');
                $posicion->addChild('x', $_POST['x_rectangulo_'.$j.'_imagen_'.$i]);
                $posicion->addChild('y', $_POST['y_rectangulo_'.$j.'_imagen_'.$i]);
            }

            if ($_POST['ancho_rectangulo_'.$j.'_imagen_'.$i]) {
                $rectangulo->addChild('ancho', $_POST['ancho_rectangulo_' . $j.'_imagen_'.$i]);
            }
            if ($_POST['alto_rectangulo_'.$j.'_imagen_'.$i]) {
                $rectangulo->addChild('alto', $_POST['alto_rectangulo_' . $j.'_imagen_'.$i]);
            }

        }
    }

    if (isset($_POST['circulos_imagen_'.$i])){
        for ($j = 1; $j <= $_POST['circulos_imagen_'.$i]; ++$j) {

            $circulo = $imagen->addChild('circulo');
            if ($_POST['color_circulo_'.$j.'_imagen_'.$i]) {
                $circulo->addChild('color', $_POST['color_circulo_'.$j.'_imagen_'.$i]);
            }
            if ($_POST['borde_circulo_'.$j.'_imagen_'.$i]) {
                $circulo->addChild('borde', $_POST['borde_circulo_' . $j.'_imagen_'.$i]);
            }
            if ($_POST['opacidad_circulo_'.$j.'_imagen_'.$i]) {
                $circulo->addChild('opacidad', $_POST['opacidad_circulo_' . $j.'_imagen_'.$i]);
            }
            if ($_POST['x_circulo_'.$j.'_imagen_'.$i] && $_POST['y_circulo_'.$j.'_imagen_'.$i]) {
                $posicion = $circulo->addChild('centro');
                $posicion->addChild('x', $_POST['x_circulo_'.$j.'_imagen_'.$i]);
                $posicion->addChild('y', $_POST['y_circulo_'.$j.'_imagen_'.$i]);
            }

            if ($_POST['radio_circulo_'.$j.'_imagen_'.$i]) {
                $circulo->addChild('radio', $_POST['radio_circulo_' . $j.'_imagen_'.$i]);
            }


        }
    }
    
    if (isset($_POST['poligonos_imagen_'.$i])){
        for ($j = 1; $j <= $_POST['poligonos_imagen_'.$i]; ++$j) {
            $poligono = $imagen->addChild('poligono');
            if ($_POST['color_poligono_'.$j.'_imagen_'.$i]) {
                $poligono->addChild('color', $_POST['color_poligono_' . $j.'_imagen_'.$i]);
            }
            if ($_POST['borde_poligono_'.$j.'_imagen_'.$i]) {
                $poligono->addChild('borde', $_POST['borde_poligono_' . $j.'_imagen_'.$i]);
            }
            if ($_POST['opacidad_poligono_'.$j.'_imagen_'.$i]) {
                $poligono->addChild('opacidad', $_POST['opacidad_poligono_' . $j.'_imagen_'.$i]);
            }
            for ($k = 1; $k <= $_POST['cuenta_puntos_poligono_'.$j.'_imagen_'.$i]; ++$k) {
                $punto = $poligono-> addChild('punto');
                $x = $punto->addChild('x', $_POST['x'.$k.'_poligono_'.$j.'_imagen_'.$i]);
                $y = $punto->addChild('y', $_POST['y'.$k.'_poligono_'.$j.'_imagen_'.$i]);
            }
        }
        
    }

}

/*
    for ($i = 1; $i <= $_POST['poligonos']; ++$i) {
    $poligono = $repositorio->addChild('poligono');
        if ($_POST['color_poligono_'.$i]) {
            $poligono->addChild('color', $_POST['color_poligono_' . $i]);
        }
        if ($_POST['borde_poligono_'.$i]) {
            $poligono->addChild('borde', $_POST['borde_poligono_' . $i]);
        }
        if ($_POST['opacidad_poligono_'.$i]) {
            $poligono->addChild('opacidad', $_POST['opacidad_poligono_' . $i]);
        }

   }*/



    $dom = dom_import_simplexml($repositorio)->ownerDocument;
    $dom->formatOutput = TRUE;
    $formatted = $dom->saveXML();
    echo $formatted


?>