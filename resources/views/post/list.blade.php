@extends('layout.frame')

@include('piece.list-title')

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
        <el-table-column prop="name" label="name"></el-table-column>
        <el-table-column prop="abstract" label="abstract"></el-table-column>
        <el-table-column prop="user.name" label="user"></el-table-column>
        <el-table-column prop="createdAt" label="createdAt" width="160"></el-table-column>
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
                @include('piece.list-data')
            }
        },
        methods: {
            @include('piece.list-method')
        },
        mounted() {
            @include('piece.init')
        }
    })
</script>
@endsection