<template>
	<div class="color-selector">
		<label v-bind:title="hexColor">{{ this.labelName }}</label>
		<input type="text" v-model="hexColor" @input="updateColor">
		<!-- <input type="text"> -->
		<input type="color" v-model="hexColor" @input="updateColor">
		
		<!-- <style>
		:root {
			--background-color: {{ hexColor }};
		}
	</style> -->
</div>
</template>

<script>
	export default {

		name: 'ColorSelector',

		data () {
			return {
				hexColor: this.initialcolor
			}
		},

		props: [
		'colorname',
		'initialcolor'
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
				this.$emit('colorchanged', this.colorname, this.hexColor);
			}
		},

		computed: {
			labelName: function() {
				return this.colorname.replace(/_/g, ' ').trim();
			},
			cssColorName: function() {
				return '--' + this.colorname.replace(/_/g, '-').trim();
			}
		}
	}
</script>

<style lang="css" scoped>
label {
	text-transform: capitalize;
}
</style>