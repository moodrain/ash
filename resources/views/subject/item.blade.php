@extends('layout.frame')

@section('title', 'Subject Detail')

@section('main')
<el-row>
    <el-col :span="18" :xs="24">
        <el-card>
            <div slot="header">
                <span>@{{ subject.title }}</span>
                <el-divider direction="vertical"></el-divider>
                <el-tag style="margin: 0">@{{ subject.category.name }}</el-tag>
                <el-divider v-if="subject.userId == {{ uid() ?? 'null' }}" direction="vertical"></el-divider>
                <a v-if="subject.userId == {{ uid() ?? 'null' }}" :href="'/subject/edit?id=' + subject.id">编辑</a>
            </div>
            <div class="mdui-typo" v-html="content(subject.contentBase64)"></div>
            <p class="preview">
                <img style="max-width: 100px;max-height: 100px;object-fit: contain;cursor: pointer;margin: 1px;" :src="src" v-for="(src, index) in subject.images" :key="index" />
            </p>
            <el-divider></el-divider>
            <p>
                <span>@{{ subject.user.name }}</span>
                <el-divider direction="vertical"></el-divider>
                <span>@{{ subject.updatedAtReadable }}</span>
                @auth
                    <el-divider direction="vertical"></el-divider>
                    <a href="javascript:" @click="replySubject">Reply</a>
                @endauth
            </p>
        </el-card>
    </el-col>
</el-row>

<br />
<el-row>
    <el-col :span="comment.commentId ? 17 : 18" :xs="comment.commentId ? 23 : 24" :offset="comment.commentId ? 1 : 0"  v-for="comment in comments" :key="comment.id">
        <el-card style="margin: 10px 0;">
            <div v-if="comment.commentId" slot="header">
                <span v-if="comment.commentId"> reply </span>
                <span v-if="comment.commentId">@{{ comment.to.name }}</span>
                <el-divider v-if="comment.commentId" direction="vertical"></el-divider>
                <span>@{{ comment.from.name }}</span>
                <el-divider direction="vertical"></el-divider>
                <span>@{{ subject.createdAtReadable }}</span>
                @auth
                    <el-divider direction="vertical"></el-divider>
                    <a href="javascript:" @click="replyComment(comment)">Reply</a>
                @endauth
            </div>
            <div class="mdui-typo" v-html="content(comment.contentBase64)"></div>
            <p class="preview">
                <img style="max-width: 100px;max-height: 100px;object-fit: contain;cursor: pointer;margin: 1px;" :src="src" v-for="(src, index) in subject.images" :key="index" />
            </p>
            <div v-if="! comment.commentId">
                <el-divider></el-divider>
                <span>@{{ comment.from.name }}</span>
                <el-divider direction="vertical"></el-divider>
                <span>@{{ subject.createdAtReadable }}</span>
                @auth
                    <el-divider direction="vertical"></el-divider>
                    <a href="javascript:" @click="replyComment(comment)">Reply</a>
                @endauth
            </div>
        </el-card>
    </el-col>
</el-row>

<el-row>
    <el-col :span="18" :xs="24">
        <el-card>
            <x-pager :size="20" />
            <el-divider></el-divider>
            @auth
            <p>
                <span v-if="preview">Comment Preview</span>
                <span v-if="! preview">Comment Edit</span>
                <el-divider v-if="reply.commentId" direction="vertical"></el-divider>
                <span v-if="reply.commentId"> Reply @{{ reply.user.name }}</span>
            </p>
            <br />

                <el-form>
                    <x-input exp="model:comment.content;type:textarea;row:4;ref:commentInput" />
                    <el-button>Submit</el-button>
                </el-form>
            @endauth
            @guest
                Please login before comment
            @endguest
        </el-card>
    </el-col>
</el-row>
<x-image-preview />
@endsection

@section('script')
<script>
new Vue({
    el: '#app',
    data() {
        return {
            @include('piece.data')
            menuActive: 'subject',
            subject: @json($subject),
            comments: @json($comments),
            page: {{ request('page', 1) }},
            total: {{ $total }},
            preview: false,
            reply: {
                commentId: null,
                user: {
                    id: null,
                    name: '',
                },
            },
            comment: {
                content: '',
            }
        }
    },
    methods: {
        @include('piece.method')
        content(base) {
            return this.$marked(atob(base))
        },
        toBottom() {
            let el = this.$refs.main.$el
            el.scroll({
                top: 9999,
                left: 0,
                behavior: 'smooth',
            })
            setTimeout(() => {
                this.$refs.commentInput.focus()
            }, (el.scrollHeight - el.scrollTop) / 3)
        },
        replySubject() {
            this.toBottom()
        },
        replyComment(comment) {
            this.toBottom()
        }
    },
    mounted() {
        @include('piece.init')
    }
})
</script>
@endsection