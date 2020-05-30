<?php

$themesPath = "../../themes/";

$godotContents = loadGodotFile("Solarized-Dark.tet");
$colors = parseGodotFile($godotContents);
echo json_encode($colors);

$godotEditorSettings = ["background_color", "comment_color", "keyword_color", "engine_type_color", "number_color", "text_color", "function_definition_color", "function_color", "selection_color", "string_color"];

function loadGodotFile($fileName) {
    global $themesPath;

    $filePath = $themesPath . $fileName;

    $godotFile = fopen($filePath, "r") or die("Unable to open Godot file!");
    $godotContents = trim(fread($godotFile, filesize($filePath)));
    fclose($godotFile);

    return $godotContents;
}

function parseGodotFile($contents) {
    $result = [];

    $contents = trim(str_replace("[color_theme]", "", $contents));

    $arr = preg_split('/\s+/', $contents);
    // $arr[1] = '2';
    // print_r($arr);

    $length = count($arr);

    for($i = 0; $i < $length - 1; ++$i) {
        $name = strtok($arr[$i], '=');

        if (strpos($name, '/') !== false) {
            $name = substr(strstr($name, '/'), strlen('/'));
        }
        
        $hexColor = "#" . substr(get_string_between($arr[$i], '"', '"'), 2);

        $result[$name] = $hexColor;
    }

    // print_r($result);
    return $result;
    
}

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}


?>