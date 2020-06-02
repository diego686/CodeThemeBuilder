<template>
	<div class="color-selector">
		<label v-bind:title="hexColor">{{ this.labelName }}</label>
		<input type="text" v-model="hexColor" @input="updateColor" @change="saveColor">
		<!-- <input type="text"> -->
		<input type="color" v-model="hexColor" @input="updateColor" @change="saveColor">
		
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
				name: this.colorname,
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
			}
		}
	}
</script>

<style lang="css" scoped>
label {
	text-transform: capitalize;
}
</style>