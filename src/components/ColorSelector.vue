<template>
	<div class="color-selector">
		<label v-bind:title="hexColor">{{ this.labelName }}</label>
		<input type="text" v-model="hexColor" @input="updateColor" @change="saveColor">
		<!-- <input type="text" v-model="colorOpacity" @input="updateColor"> -->
		<input type="color" v-model="hexColor" @input="updateColor" @change="saveColor">
		
	</div>
</template>

<script>
	export default {

		name: 'ColorSelector',

		data () {
			return {
				name: this.colorname,
				hexColor: this.initialcolor,
				colorOpacity: this.initialopacity,
			}
		},

		props: [
		'colorname',
		'initialcolor',
		'initialopacity',
		],

		mounted: function() {
			let root = document.documentElement;
			root.style.setProperty(this.cssColorName, this.hexColor);
		},

		methods: {
			updateColor: function() {
				// console.log(this.cssColorName);
				let root = document.documentElement;
				root.style.setProperty(this.cssColorName, this.hexColor);
			},
			saveColor: function() {
				this.$emit('colorchanged', this.colorname, this.hexColor);
			}
		},

		computed: {
			labelName: function() {
				return this.colorname.replace(/_/g, ' ').trim();
				// return this.colorname;
			},
			cssColorName: function() {
				// return this.colorname;
				return '--' + this.colorname.replace(/_/g, '-').trim();
			},
			displayColor: function() {
				return this.hexColor + this.colorOpacity;
			}
		}
	}
</script>

<style lang="css" scoped>
label {
	text-transform: capitalize;
}
</style>