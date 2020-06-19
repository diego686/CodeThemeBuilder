import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
// import VueRouter from 'vue-router';
import ColorSelector from './components/ColorSelector';
import CommentSection from './components/CommentSection';
// import Godot from './components/Godot';

Vue.use(VueAxios, axios);
// Vue.use(VueRouter);

// const router = new VueRouter({
// 	routes: [
// 		{ path: '/', component: Godot }
// 	],

// 	mode: 'history'
// });


new Vue({
	el: '#app',

	// router,

	components: {
		ColorSelector,
		CommentSection,
	},

	data: {
		selectedEditor: 'godot',
		showColors: true,
		eyeIcon: 'eye',
		showOthers: false,
		godotColors: {},
		colorsArray: ['background_color', 'text_color', 'comment_color', 'keyword_color', 'engine_type_color', 'string_color', 'number_color', 'function_definition_color'],
		godotOpacity: {},
		codeText: '',
		exportFileName: '',
		languageLoading: true,
		colorsLoading: true,
		vueLoading: true,
	},

	computed: {
		editableGodotColors: function() {
			var result = {};

			for (var i = 0; i < this.colorsArray.length; ++i) {
				if (this.colorsArray[i] in this.godotColors) {
					result[this.colorsArray[i]] = this.godotColors[this.colorsArray[i]];
				}
			}

			return result;
		},

		otherGodotSettings: function() {
			var result = {};
			var diff_array = [];

			var colorKeys = Object.keys(this.godotColors);

			diff_array = colorKeys.diff(this.colorsArray);

			for (var i = 0; i < diff_array.length; ++i) {
				result[diff_array[i]] = this.godotColors[diff_array[i]];
			}

			return result;
		}
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
		.finally(this.languageLoading = false)
		.catch(error => console.log(error));
	},
	methods: {
		getGodotColors: function() {
			axios.get('http://localhost:8000/api/godot', )
			.then(response => (this.godotColors = response.data))
			.finally(this.colorsLoading = false)
			.catch(error => console.log(error));
		},
		toggleShowColors: function() {
			this.showColors = ! this.showColors;
		},

		toggleShowOthers: function() {
			this.showOthers = ! this.showOthers;
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
				this.vueLoading = false;
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