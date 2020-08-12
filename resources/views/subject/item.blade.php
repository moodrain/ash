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
            <el-divider></el-divider>
            <p>
                <span>@{{ subject.user.name }}</span>
                <el-divider direction="vertical"></el-divider>
                <span>@{{ subject.updatedAtReadable }}</span>
            </p>
        </el-card>

        <br />
        <el-card>
            <el-card v-for="comment in comments" :key="comment.id" style="margin: 10px 0;" shadow="none">
                <div class="mdui-typo" v-html="content(comment.contentBase64)"></div>
                <el-divider></el-divider>
                <div>
                    <span v-if="comment.commentId"> reply </span>
                    <span v-if="comment.commentId">@{{ comment.to.name }}</span>
                    <el-divider v-if="comment.commentId" direction="vertical"></el-divider>
                    <span>@{{ comment.from.name }}</span>
                    <el-divider direction="vertical"></el-divider>
                    <span>@{{ subject.createdAtReadable }}</span>
                </div>
            </el-card>
            <x-pager :size="20" />
        </el-card>
        <br />
        <el-card>
            <div slot="header">
                <p>
                    <span v-if="preview">Comment Preview</span>
                    <span v-if="! preview">Comment Edit</span>
                    <el-divider v-if="reply.commentId" direction="vertical"></el-divider>
                    <span v-if="reply.commentId"> Reply @{{ reply.user.name }}</span>
                </p>
            </div>
            <el-form>
                <x-input exp="model:comment.content;type:textarea;row:4" />
            </el-form>
        </el-card>
    </el-col>
</el-row>
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
        }
    },
    mounted() {
        @include('piece.init')
    }
})
</script>
@endsection