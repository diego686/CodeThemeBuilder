import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import ColorSelector from './components/ColorSelector';

Vue.use(VueAxios, axios);

new Vue({
	el: '#app',

	components: {
		ColorSelector,
	},

	data: {
		selectedEditor: 'godot',
		showColors: true,
		eyeIcon: 'eye',
		godotColors: {},
		godotOpacity: {},
		codeText: '',
		exportFileName: '',
	},

	created() {
		

		axios.get('http://localhost:8000/api/godot?opacity=true')
		.then(response => response.data).then(data => {
			this.godotOpacity = data;
			this.getGodotColors();
		})
		.catch(error => console.log(error));

		axios.get('http://localhost:8000/api/languages/gdscript')
		.then(response => (this.codeText = response.data))
		.catch(error => console.log(error));
	},
	methods: {
		getGodotColors: function() {
			axios.get('http://localhost:8000/api/godot', )
			.then(response => (this.godotColors = response.data))
			.catch(error => console.log(error));
		},
		toggleShowColors: function() {
			this.showColors = ! this.showColors;
		},

		exportTheme: function() {
			if (this.selectedEditor === 'godot') {
				// console.log('exporting for ' + this.selectedEditor);
				var fileContents = this.convertToGodotThemeFile();

				// Start file download
				if (this.exportFileName.length !== 0) {
					this.download(this.exportFileName + ".tet", fileContents);
				} else {
					this.download("GodotTheme.tet", fileContents);
				}
				
			}
		},

		convertToGodotThemeFile: function() {
			var colors = this.godotColors;
			var result = '';

			result += '[color_theme]\n\n';

			for (var color in colors) {
				// console.log(color);
				result += color + '=' + this.godotOpacity[color] + colors[color].substring(1) + '\n';
			}

			return result;
		},

		download: function(filename, text) {
			var element = document.createElement('a');
			element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
			element.setAttribute('download', filename);

			element.style.display = 'none';
			document.body.appendChild(element);

			element.click();

			document.body.removeChild(element);
		},

		storeColor: function(value1, value2) {
			this.godotColors[value1] = value2;
			// console.log(this.godotColors);
			// console.log(value1 + ", " + value2);
		}
	},
	watch: {
		codeText: function() {
			this.$nextTick(function() {
				Prism.highlightAll();
				// console.log("highlightCode ran");
			});
		}
	}
	// updated: function() {
	// 	Prism.highlightAll();
	// 	// console.log("highlightCode ran");
	// }
}
);