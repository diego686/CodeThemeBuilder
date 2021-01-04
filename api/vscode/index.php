<?php

$themesPath = "../../themes/theme-solarized-dark/themes/";

$vscodeContents = loadVscodeFile("solarized-dark-color-theme.json");


// $godotEditorSettings = ["background_color", "comment_color", "keyword_color", "engine_type_color", "number_color", "text_color", "function_definition_color", "function_color", "selection_color", "string_color"];

if (isset($_GET["opacity"]) && $_GET["opacity"] == "true") {
    $colors = parseGodotFileOpacity($godotContents);
    echo json_encode($colors);
} else {
    $colors = parseGodotFile($godotContents);
    echo json_encode($colors);
}

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
        // $colorOpacity = substr(get_string_between($arr[$i], '"', '"'), 0, 2);
        // $rawColor = get_string_between($arr[$i], '"', '"');

        $result[$name] = $hexColor;
        // $result [$name] = $rawColor;
    }

    // print_r($result);
    return $result;
    
}

function parseGodotFileOpacity($contents) {
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
        $colorOpacity = substr(get_string_between($arr[$i], '"', '"'), 0, 2);
        // $rawColor = get_string_between($arr[$i], '"', '"');

        $result[$name] = $colorOpacity;
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