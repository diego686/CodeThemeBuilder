<template>
	<div>
    <div id="comment-form" class="comment-form">
      <h3>Leave a Comment</h3>

      <div class="top row">

        <div class="column input-field">
          <label for="displayname" class="required">Name*</label>
          <input type="text" v-model="username" name="displayname" required>
        </div>

        <div class="column input-field">
          <label for="email">Email <span>(your email will not be published)</span></label>
          <input type="email" v-model="email" name="email">
        </div>

      </div>
      
      <div class="input-field">
        <label for="comment" class="required">Comment*</label>
        <input type="text" v-model="comment" name="comment" class="comment-input" required>
      </div>

      

      <span class="required">*required</span>
      <br>

      <span class="messages" v-text="messages"></span>
      <span class="error" v-text="errors"></span>

      <button @click="postComment">Submit</button>
    </div>
    <div class="comments">
      <h3>Comments</h3>
      <ul>
        <li v-if="comments.length == 0">No comments to show.</li>
        <li v-for="comment in comments" :key="comment.id" class="comment">
          <span class="name">{{ comment.username }}</span>
          <span class="time">{{ formatTime(comment.time) }}</span>
          <span class="text">{{ comment.comment }}</span>
          <!-- <a href="#comment-form" class="reply">reply</a> -->
        </li>
      </ul>
    </div>



  </div>
</template>

<script>
  import {BASE_URL} from '../const';

  export default {

    name: 'CommentSection',

    data () {
      return {
        username: '',
        email: '',
        comment: '',
        comments: {},
        responseData: '',
        errors: '',
        messages: ''

      }
    },

    computed: {
      postData: function() {
        var params = {};
        params['username'] = this.username;
        params['email'] = this.email;
        params['comment'] = this.comment;

        return params;
      }
      // commentsOrdered: function() {
      //   var byDate = this.comments.slice(0);

      //   byDate.sort(function(a,b) {
      //     var x = a.time.toLowerCase();
      //     var y = b.time.toLowerCase();
      //     return x < y ? -1 : x > y ? 1 : 0;
      //   });

      //   return byDate.reverse();
      // }
    },

    created: function() {
      this.getComments();
    },

    methods: {
    postComment: function() {
      this.messages = '';
      this.errors = '';

      if (this.username === '') {
        this.errors += 'A name is required.';
        return;
      }

      if (this.comment === '') {
        this.errors += 'A comment is required.';
        return;
      }



      this.axios.post(`${BASE_URL}/api/comments/`, this.postData)
      .then(response => (console.log(response.data)))
      .finally(this.afterPostComment())
      .catch(error => console.log(error));
    },
    getComments: function() {
      this.axios.get(`${BASE_URL}/api/comments/`)
      .then(response => (this.comments = response.data.reverse()))
      .catch(error => console.log(error));
    },
    formatTime: function(t) {
      let result = '';

      result = t.substr(0, t.indexOf(' '));

      return result;
    },
    afterPostComment: function() {
      this.getComments();
      this.comment = '';
      this.messages = 'Success! Your comment is now under review.';
    }
  }
}
</script>

<style lang="css" scoped>

ul {
  list-style-type: none;
}

.comment-form .top.row {
  display: flex;
}

.comment-form .top.row .column {
  flex: 50%;
}

.comment-form .top input {
  display: block;
  /*width: 100%;*/
}

.comment-form .input-field {
  padding-bottom: 20px;
}

.comment-form .input-field label span {
  font-size: 12px;
}

.comment-form .comment-input {
  width: 100%;
  display: block;
}

.comment-form button {
  float: right;
}

.required {
  font-weight: bold;
}

.comments {
  margin-top: 50px;
}

.messages {
  color: var(--engine-type-color);
}

.error {
  color: red;
}

.comment {
  padding: 20px 0px;
}


.comment .name {
  font-weight: bold;
  font-size: 16px;
}

.comment .time {
  color: var(--comment-color);
  padding-left: 10px;
  font-size: 14px;
}

.comment .text {
  display: block;
  padding: 10px 0px;
  font-size: 18px;
}

.reply {
  border: 0;
  font-weight: normal;
  float: right;
  padding: 0;
  color: var(--text-color);
}

.reply:hover {
  cursor: pointer;
  text-decoration: underline;
}

</style>