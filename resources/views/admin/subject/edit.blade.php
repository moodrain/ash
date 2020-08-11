@extends('admin.layout.frame')
@include('admin.piece.edit-title')

@section('main')
    <el-row>
        <el-col :span="8" :xs="24">
            <el-card>
                <el-form>
                    <x-admin.edit-id :d="$d" />
                    <x-input exp="model:form.title;pre:Title" />
                    <x-select exp="model:form.categoryId;label:Category;key:id;selectLabel:name;value:id;data:categories" />
                    <x-select exp="model:form.userId;label:User;key:id;selectLabel:name;value:id;data:users" />
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
                    userId: {{ bv('userId', null) }},
                    categoryId: {{ bv('categoryId') }},
                    images: '{!! old('images') ? old('images') : bv('imageJson') !!}',
                    content: atob('{{ old('content') ? base64_encode(old('content')) : bv('contentBase64') }}')
                },
                users: @json(\App\Models\User::query()->get(['id', 'name'])),
                categories: @json(\App\Models\Subject\Category::query()->get(['id', 'name'])),
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
