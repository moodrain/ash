@extends('admin.layout.frame')
@include('admin.piece.edit-title')

@section('main')
    <el-row>
        <el-col :span="8" :xs="24">
            <el-card>
                <el-form>
                    <x-admin.edit-id :d="$d" />
                    <x-select exp="model:form.subjectId;label:Subject;key:id;selectLabel:title;value:id;data:subjects" />
                    <x-select exp="model:form.commentId;data:comments;label:Comment" />
                    <x-select exp="model:form.userId;label:To;key:id;selectLabel:name;value:id;data:users" />
                    <x-select exp="model:form.fromUserId;label:From;key:id;selectLabel:name;value:id;data:users" />
                    <x-input exp="model:form.images;label:Images;type:textarea" />
                    <x-input exp="model:form.content;label:Content;type:textarea" />
                    <x-admin.edit-submit :d="$d" />
                </el-form>
            </el-card>
        </el-col>
        <el-col :span="8" :offset="1" :xs="{span:24,offset:0}" @if(mobile()) style="margin-top: 20px" @endif>
            <el-card>
                <p slot="header">预览</p>
                <div class="mdui-typo" v-html="$marked(form.content)"></div>
            </el-card>
        </el-col>
    </el-row>
@endsection

@section('script')
<script>
    new Vue({
        el: '#app',
        data () {
            return {
                @include('admin.piece.edit-data')
                form: {
                    id: {{ bv('id', null) }},
                    title: '{{ bv('title') }}',
                    subjectId: {{ bv('subjectId', null) }},
                    commentId: {{ bv('commentId', null) }},
                    userId: {{ bv('userId', null) }},
                    fromUserId: {{ bv('fromUserId', null) }},
                    images: '{!! old('images') ? old('images') : bv('imageJson') !!}',
                    content: atob('{{ old('content') ? base64_encode(old('content')) : bv('contentBase64') }}')
                },
                users: @json(\App\Models\User::query()->get(['id', 'name'])),
                categories: @json(\App\Models\Subject\Category::query()->get(['id', 'name'])),
                subjects: @json(\App\Models\Subject::query()->get(['id', 'title'])),
                comments: @json(\App\Models\Comment::query()->pluck('id')),
            }
        },
        methods: {
            @include('admin.piece.edit-method')
        },
        mounted() {
            @include('admin.piece.init')
        }
    })
</script>
@endsection
