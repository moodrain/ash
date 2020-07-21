@extends('admin.layout.frame')

@include('admin.piece.list-title')

@section('main')
<el-card>
    <el-form inline>
        <x-input exp="model:search.id;pre:ID" />
        <x-input exp="model:search.name;pre:Name" />
        <x-select exp="model:search.userId;label:User;data:users;key:id;selectLabel:name;value:id" />
        <x-sort />
        <x-list-head-btn :m="$m" />
    </el-form>
</el-card>
<br />
<el-card>
    <el-table :data="list" height="560" border  @selection-change="selectChange">
        <el-table-column type="selection" width="55"></el-table-column>
        <el-table-column prop="id" label="ID" width="60"></el-table-column>
        <el-table-column prop="name" label="Name"></el-table-column>
        <el-table-column prop="abstract" label="Abstract"></el-table-column>
        <el-table-column prop="user.name" label="User"></el-table-column>
        <el-table-column prop="createdAt" label="CreatedAt" width="160"></el-table-column>
        <x-list-body-col :m="$m" />
    </el-table>
    <x-pager />
</el-card>
@endsection

@section('script')
<script>
    new Vue({
        el: '#app',
        data () {
            return {
                @include('admin.piece.list-data')
            }
        },
        methods: {
            @include('admin.piece.list-method')
        },
        mounted() {
            @include('admin.piece.init')
        }
    })
</script>
@endsection