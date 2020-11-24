<template>
    <div class="content">
        <div class="comment-item">
            <div>{{post.id}}</div>
            <div>{{post.title}}</div>
            <div>{{post.body}}</div>
            <div><button class="btn btn-info" @click.prevent="addComment()">Add comment</button></div>
        </div>
        <div v-for="cmt in post.comments" :key="cmt.id" class="cmts">
            <div>{{cmt.content}}</div>
            <div>{{cmt.updated_at}}</div>
            <button class="btn btn-danger" @click.prevent="del(cmt.id)">Delete</button>
        </div>
        <div v-if="visible">
            <textarea v-model="comment" style="width: 100%;"></textarea>
            <button class="btn btn-success" @click.prevent="confirm(post.id)">Confirm</button>
        </div>
    </div>
</template>

<script>

    export default {
        name: "comment",
        props:{
            post:{},
            comment: ''
        },
        data() {
            return {
                visible: false
            }
        },
        created() {
        },
        methods: {
            addComment: function(){
                this.visible = !this.visible;
            },

            confirm: function(id) {
                let uri = "api/comments/create";
                let payload = {
                    content: this.comment,
                    reply: '',
                    post_id: id
                };

                this.axios.post(uri, payload)
                        .then(response => {
                            this.$router.push({name: "create"});
                        });
            },

            del: function(id) {
                let uri = `api/comments/delete/${id}`;

                this.axios.delete(uri, {})
                        .then(response => {
                            this.$router.push({name: "create"});
                        });
            }
        }
    }
</script>
<style scoped>

.content {
    padding: 10px;
    margin: 10px;
    border: 1px solid #000000;
}

.cmts {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 5px;
    background-color: grey;
    border: 1px solid green;
    margin-top: 5px;
}

.comment-item{
    display: flex;
    justify-content: space-between;
    align-items: center;
}
</style>