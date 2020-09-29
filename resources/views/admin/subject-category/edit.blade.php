@extends('admin.layout.frame')

@include('admin.piece.edit-title')

@section('main')
    <el-row>
        <el-col :span="8" :xs="24">
            <el-card>
                <el-form>
                    @include('admin.piece.edit-id')
                    <x-input exp="model:form.name;pre:name" />
                    @include('admin.piece.edit-submit')
                </el-form>
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
                    name: '{{ bv('name') }}',
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
</script>
@endsection
