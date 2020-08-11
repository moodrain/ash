@extends('layout.frame')

@section('title', 'Subject Edit')

@section('main')
<el-row>
    <el-col :span="8" :xs="24">
        <el-card>
            <el-form>
                <x-admin.edit-id :d="$d" />
                <x-input exp="model:form.title;pre:Title" />
                <x-select exp="model:form.categoryId;label:Category;key:id;selectLabel:name;value:id;data:categories" />
                <x-input exp="model:form.content;label:Content;type:textarea" />
                <el-card>
                    <div slot="header">
                        <div style="display: inline-block;width: 60%">Images</div>
                        <div style="display: inline-block;width: 38%;text-align: right">
                            <el-upload multiple action="/subject/upload" :on-success="uploadOk" :show-file-list="false" :with-credentials="true">
                                <el-button slot="trigger" icon="el-icon-upload2" size="small"></el-button>
                            </el-upload>
                        </div>
                    </div>
                    <div class="preview">
                        <img :src="src" v-for="(src, index) in form.images" :key="index" @click.right.prevent="removeImage(index)" style="max-width: 100px;max-height: 100px;object-fit: contain;cursor: pointer;margin: 2px;" />
                    </div>
                    @if(mobile())
                        <p>Long Press to Remove</p>
                    @else
                        <p>Right Click to Remove</p>
                    @endif
                </el-card>
                <br />
                <el-form-item><el-button @click="$submit(form)">Submit</el-button></el-form-item>
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
<x-image-preview />
@endsection

@section('script')
<script>
    new Vue({
        el: '#app',
        data() {
            return {
                @php(bv($d ?? []))
                @include('piece.data')
                menuActive: 'subject-edit',
                form: {
                    id: {{ request('id', 'null') }},
                    title: '{{ bv('title') }}',
                    categoryId: {{ bv('categoryId', null) }},
                    content: atob('{{ old('content') ? base64_encode(old('content')) : bv('contentBase64') }}'),
                    images: @json(bv('images')),
                },
                categories: @json(\App\Models\Subject\Category::query()->get(['id', 'name'])),
            }
        },
        methods: {
            @include('piece.method')
            uploadOk(rs) {
                this.form.images.push(rs.data)
            },
            removeImage(index) {
                this.form.images.splice(index, 1)
            }
        },
        mounted() {
            @include('piece.init')
        }
    })
</script>
@endsection