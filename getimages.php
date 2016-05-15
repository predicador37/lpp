<?php
/**
 * Created by PhpStorm.
 * User: predicador
 * Date: 9/05/16
 * Time: 20:58
 */


//Recuperación del fichero desde el formulario y almacenamiento en sesión
if ($_POST["action"] == "upload") {
    if ($_FILES["file"]["tmp_name"]) {
        $file = $_FILES["file"]["tmp_name"];
        session_start();
        $repositorio = file_get_contents($file);
        $_SESSION['repositorio'] = $repositorio;


        //Inicialización del array que contendrá toda la estructura XML procesada
        $svg = array();

        //Función invocada al llegar el inicio de un elemento
        function inicio($parser, $nombre, $atributos)
        {
            global $svg;
            $tag = array("nombre" => $nombre, "atributos" => $atributos);
            array_push($svg, $tag);

        }

        //Function invocada al encontrar CDATA
        function data($parser, $data)
        {
            global $svg, $i;

            if (trim($data)) {
                $svg[count($svg) - 1]['data'] = $data;
            }
        }

        //Function invocada  al llegar al final de un elemento
        function fin($parser, $nombre)
        {
            global $svg;
            $svg[count($svg) - 2]['hijos'][] = $svg[count($svg) - 1];
            array_pop($svg);
        }

        //Creación del parser
        $xml_parser = xml_parser_create();
        //Especificación del parser de elementos
        xml_set_element_handler($xml_parser, "inicio", "fin");
        //Especificación del parser de datos
        xml_set_character_data_handler($xml_parser, "data");

        //Parseo del fichero
        $data = xml_parse($xml_parser, file_get_contents($file));
        if (!$data) {
            die(sprintf("XML error: %s at line %d",
                xml_error_string(xml_get_error_code($xml_parser)),
                xml_get_current_line_number($xml_parser)));
        }
        //Liberación del parser
        xml_parser_free($xml_parser);
        //Almacenamiento del array parseado en sesión para posteriores usos
        session_start();
        $_SESSION['svg'] = $svg;

        //Devolución de código HTML para el selector de imágenes al cliente
        $imagenes = count($svg[0]["hijos"]);
        echo "<option>Seleccione imagen</option>";
        foreach (range(1, $imagenes) as $número) {
            echo "<option>" . $número . "</option>";
        }


    } else {
        print "<p>Upload failed.</p>";
    }
}
?>