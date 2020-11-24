<template>
    <div>
        <h1>Posts</h1>
        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <router-link :to="{ name: 'create' }" class="btn btn-primary">Create Post</router-link>
            </div>
        </div><br />

        <!-- <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Actions</th>
                </tr>
            </thead> -->
            <div v-for="post of posts" :key="post.id">
                <comment-component :post="post"></comment-component>    
            </div>
            
        <!-- </table> -->
    </div>
</template>

<script>
import CommentComponent from './CommentComponent.vue';
    export default {
  components: { CommentComponent },
        data() {
            return {
                posts: [],
                currentPostId: null
            }
        },
        created() {
            let uri = 'api/posts';
            this.axios.get(uri)
                    .then(response => {
                        this.posts = response.data.data;
                    })
                    .catch((error) => {
                        alert("Could not load for the Post list. Please try again!")
                    });
        },
        methods: {
            addComment(id)
            {
                this.currentPostId = id;
            }
        }
    }
</script>
