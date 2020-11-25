<template>
    <div class="content">
        <div class="">
            <div class="d-flex justify-content-between mb-2">
                <div>{{post.id}}</div>
                <div>{{post.title}}</div>
                <div>{{post.body}}</div>
                <div><button class="btn btn-info" @click.prevent="addComment1()">Comment</button></div>
            </div>
            <div v-if="visible1">
                <textarea v-model="comment" style="width: 100%;"></textarea>
                <button class="btn btn-success" @click.prevent="confirm(post.id, null)">Confirm</button>
            </div>
        </div>
        
        <div v-for="cmt in post.comments" :key="cmt.id" class="cmts">
            <div class="d-flex justify-content-between mb-2" v-bind:style="{marginLeft: (cmt.redepth * 20) +'px'}">
                <div>{{cmt.content}}</div>
                <div>{{cmt.updated_at}}</div>
                <div>
                    <button class="btn btn-info" @click.prevent="addComment2(cmt.id)">Comment</button>
                    <button class="btn btn-danger" @click.prevent="del(cmt.id)">Delete</button>
                </div>
            </div>
            
            <div v-if="visible2 && cmt.id == curSelected">
                <textarea v-model="comment" style="width: 100%;"></textarea>
                <button class="btn btn-success" @click.prevent="confirm(post.id, cmt)">Confirm</button>
            </div>
        </div>
        
    </div>
</template>

<script>

    export default {
        name: "comment",
        props:{
            post:{}
        },
        data() {
            return {
                comment: '',
                visible1: false,
                visible2: false,
                curSelected: null
            }
        },
        created() {
        },
        methods: {
            addComment1: function(){
                this.visible1 = !this.visible1;
            },

            addComment2: function(id){
                this.visible2 = !this.visible2;
                this.curSelected = id;
            },

            confirm: function(postId, parent) {
                let uri = "api/comments/create";
                let payload = {
                    content: this.comment,
                    parent: parent,
                    post_id: postId
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
    /* height: 50px; */
    padding: 5px;
    border-bottom: 1px solid green;
    margin-top: 5px;
}

.comment-item{
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
}
</style>