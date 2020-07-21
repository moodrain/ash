@extends('admin.layout.frame')

@include('admin.piece.edit-title')

@section('main')
    <el-row>
        <el-col :span="8" :xs="{span:22,offset:1}">
            <el-card>
                <el-form>
                    <x-edit-id :d="$d"></x-edit-id>
                    <x-input exp="model:form.name;label:Name"></x-input>
                    <x-input exp="model:form.abstract;label:Abstract"></x-input>
                    <x-edit-submit :d="$d"></x-edit-submit>
                </el-form>
            </el-card>
        </el-col>
    </el-row>
@endsection

@section('script')
<script>
    let vue = new Vue({
        el: '#app',
        data () {
            return {
                @include('admin.piece.edit-data')
                form: {
                    id: {{ bv('id', null) }},
                    name: '{{ bv('name') }}',
                    abstract: '{{ bv('abstract') }}',
                },
            }
        },
        methods: {
            @include('admin.piece.edit-method')
        },
        mounted() {
            @include('admin.piece.init')
        }
    })
    $enter(() => $submit(vue.form))
</script>
@endsection
