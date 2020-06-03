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

			if (this.showColors) {
				this.eyeIcon = 'eye';
			} else {
				this.eyeIcon = 'eye-close';
			}
		},

		exportTheme: function() {
			if (this.selectedEditor === 'godot') {
				console.log('exporting for ' + this.selectedEditor);
			}
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