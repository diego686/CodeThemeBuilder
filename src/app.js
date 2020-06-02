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
	},

	mounted() {
		axios.get('http://localhost:8000/api/godot')
		.then(response => (this.godotColors = response.data));
	},

	methods: {
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
	}
});