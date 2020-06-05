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

        <div class="menu-container">
            <select name="editor" id="editor" v-model="selectedEditor">
                <option value="godot">Godot</option>
                <option value="vscode">Visual Studio Code</option>
            </select>

            <!-- <button @click="exportTheme">Export</button> -->
            <a href="#export-your-theme">Export</a>
        </div>

        

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

        <div class="end-wrapper">

            <div id="export-your-theme" class="export-wrapper">
                <h3>Export Your Godot Theme</h3>
                <div class="download-container">
                    <label for="filename">File Name</label>
                    <input type="text" name="filename" v-model="exportFileName"><span><code>.tet</code></span>
                    <button @click="exportTheme" class="export-button">
                        Download
                        <!-- <span class="jam-24" data-jam="download" height="24" width="24" data-fill="#fff"></span> -->
                    </button>
                </div>
            </div> 

            <div class="installation-wrapper">
                <h3>Installation</h3>
                <p>Place the .tet files in your Godot text editor theme directory:</p>
                <ul>
                    <li>On Linux: <code>~/.config/godot/text_editor_themes/</code></li>
                    <li>On macOS: <code>~/Library/Application Support/Godot/</code></li>
                    <li>On Windows: <code>%APPDATA%\Godot\text_editor_themes\</code></li>
                </ul>

                <p>Note: If you installed Godot using Steam, your Godot text editor theme folder should be placed in <code>steamapps/common/Godot Engine/editor_data/text_editor_themes/</code> in your Steam installation folder.</p>

                <p>To change the theme:</p>
                <ul>
                    <li>In Godot 3: Open a project in Godot, then click on <strong>Editor</strong> in the top menu, then go to the <strong>Editor Settings</strong> then <strong>Text Editor</strong>. You should now be able to choose the desired theme.</li>
                    <li>In Godot 2.1: Open a project in Godot, then click on the upper-right <strong>Settings → Editor Settings → Text Editor</strong>. You should now be able to choose the desired theme.</li>
                </ul>
            </div>

        </div>
    </div>
    <script src="./dist/app.js"></script>
    <script src="https://unpkg.com/jam-icons/js/jam.min.js"></script>
</body>

</html>