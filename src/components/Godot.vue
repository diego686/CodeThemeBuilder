<template>
	<div>
		<div class="code-container">
			<pre class="language-gdscript">
				<code>
					
				</code>
			</pre>
		</div>
		<div class="colors-container">
			
		</div>
	</div>
</template>

<script>
export default {

  name: 'Godot',

  data () {
    return {

    }
  },

  methods: {
  	fetchCode: function() {
  		this.axios.get('localhost:8000/')
  	}
  }
}
</script>

<style lang="css" scoped>
</style>