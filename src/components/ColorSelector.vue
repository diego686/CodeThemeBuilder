<template>
	<div class="color-selector">
		<label for="background-color" v-bind:title="hexColor">Background</label>
		<input type="text" v-model="hexColor">
		<input type="color" v-model="hexColor">
		<!-- <input type="color" value="#ff0000"> -->
	</div>
</template>

<script>
	export default {

		name: 'ColorSelector',

		data () {
			return {
				hexColor: '#ffffff'
			}
		}
	}
</script>

<style lang="css" scoped>
</style>