<?php

$htmlFile = fopen("./language-presets/example.html", "r") or die("Unable to open file!");
$htmlContents = htmlspecialchars(fread($htmlFile, filesize("./language-presets/example.html")));
fclose($htmlFile);

$cssFile = fopen("./language-presets/example.css", "r") or die("Unable to open file!");
$cssContents = trim(fread($cssFile, filesize("./language-presets/example.css")));
fclose($cssFile);

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Code Theme Builder</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/prism.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/prism.js"></script>
    <!-- <link rel="stylesheet" href="./css/bulma.min.css"> -->

</head>

<body>
    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div id="app">
            <h1>App</h1>

            <div class="wrapper">
                <div class="code-container">
                    <pre class="language-html"><code><?= $htmlContents ?></code></pre>
                    <pre class="language-css"><code class="language-css"><?= $cssContents ?></code></pre>
                </div>

                <div class="colors-container">

                    <color-selector></color-selector>

                    <div class="color">
                        <label for="comment-color">Comments</label>
                        <input type="text">
                        <input type="color" id="comment-color">
                    </div>

                </div>
            </div>
        </div>
        



        
        <script src="./dist/app.js"></script>
    </body>

    </html>