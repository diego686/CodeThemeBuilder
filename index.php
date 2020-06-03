<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Code Theme Builder</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/godot.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Bitter:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://unpkg.com/jam-icons/css/jam.min.css"> -->
    
    <!-- <script src="https://unpkg.com/feather-icons"></script> -->
    <script src="./js/prism.js"></script>
    <script src="./js/function_parser.js"></script>

    <!-- <link rel="stylesheet" href="./css/bulma.min.css"> -->

</head>

<body>

    <div id="app">
        <h1>Code Theme Editor</h1>

        <select name="editor" id="editor" v-model="selectedEditor">
            <option value="godot">Godot</option>
            <option value="vscode">Visual Studio Code</option>
        </select>

        <button @click="exportTheme">Export</button>

        <div class="wrapper">
            <div class="first-container"></div>
            <div class="code-container">
                <div class="godot-code" v-show="selectedEditor == 'godot'">
                    <pre class="language-gdscript"><code>{{ codeText }}</code></pre>
                </div>   
            </div>
            <div class="colors-container">

                <div class="toggle-container">
                    <div @click="toggleShowColors" v-show="showColors">
                        <span class="show-color" data-jam="eye-close" height="32" width="32" data-fill="#fff"></span>
                    </div>
                    <div @click="toggleShowColors" v-show="! showColors">
                        <span class="show-color" data-jam="eye" height="32" width="32" data-fill="#fff"></span>
                    </div>
                </div>
                
                


                <div class="godot-colors" v-if="selectedEditor == 'godot'" v-show="showColors" >

                    <div class="color-theme">
                        <h2>Color Theme</h2>

                        <color-selector v-for="(color, index) in godotColors" :key="color.colorname" :colorname="index" :initialcolor="color" :initialopacity="godotOpacity[index]" @colorchanged="storeColor"></color-selector>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="./dist/app.js"></script>
    <script src="https://unpkg.com/jam-icons/js/jam.min.js"></script>
</body>

</html>