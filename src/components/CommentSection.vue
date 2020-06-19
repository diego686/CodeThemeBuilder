<template>
	<div>
		<h3>Comments</h3>
    <ul>
      <li>comment1</li>
      <li>comment2</li>
    </ul>

    <input type="text" v-model="username">
    <input type="text" v-model="comment">
    <button @click="postComment">Submit</button>
	</div>
</template>

<script>
export default {

  name: 'CommentSection',

  data () {
    return {
      username: '',
      comment: '',
      responseData: {},

    }
  },

  computed: {
    postData: function() {
      var params = {};
      params['username'] = this.username;
      params['comment'] = this.comment;

      return params;
    }
  },

  methods: {
  	fetchCode: function() {
  		this.axios.get('localhost:8000/')
  	},
    postComment: function() {
      // console.log('postComment');
      this.axios.post('http://localhost:8000/api/comments', this.postData)
      .then(response => (this.responseData = response.data))
      .catch(error => console.log(error));
    }
  }
}
</script>

<style lang="css" scoped>
</style>