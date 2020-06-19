<template>
	<div>
		
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