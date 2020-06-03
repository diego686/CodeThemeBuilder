<?php

$filePath = "../../../language-presets/";
$fileName = "player.gd";

$gdscriptFile = fopen($filePath . $fileName, "r") or die("Unable to open file!");
$gdscriptContents = trim(fread($gdscriptFile, filesize($filePath . $fileName)));
fclose($gdscriptFile);

echo $gdscriptContents;

?>