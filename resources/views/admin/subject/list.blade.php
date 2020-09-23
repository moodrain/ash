@extends('admin.layout.frame')

@include('admin.piece.list-title')

@section('main')
<el-card>
    <el-form inline>
        <x-input exp="model:search.id;pre:id" />
        <x-input exp="model:search.title;pre:title" />
        <x-select exp="model:search.userId;label:user;key:id;selectLabel:name;value:id;data:users" />
        <x-select exp="model:search.categoryId;label:category;key:id;selectLabel:name;value:id;data:categories" />
        <x-sort />
        <x-admin.list-head-btn :m="$m" />
    </el-form>
</el-card>
<br />
<el-card>
    <el-table :data="list" height="560" border  @selection-change="selectChange">
        <el-table-column type="selection" width="55"></el-table-column>
        <el-table-column prop="id" label="{{ ___('id') }}" width="60"></el-table-column>
        <el-table-column prop="title" label="{{ ___('title') }}"></el-table-column>
        <el-table-column prop="category.name" label="{{ ___('category') }}"></el-table-column>
        <el-table-column prop="user.name" label="{{ ___('user') }}"></el-table-column>
        <el-table-column prop="contentShort" label="{{ ___('content') }}"></el-table-column>
        <el-table-column label="{{ ___('image') }}">
            <template slot-scope="scope">
                <el-image @click="$open(src)" style="max-width:20%;margin: 1%;cursor: pointer" fit="contain" v-for="(src, index) in scope.row.images" :key="index" :src="src"></el-image>
            </template>
        </el-table-column>
        <el-table-column prop="createdAt" label="{{ ___('time') }}" width="160"></el-table-column>
        <x-admin.list-body-col :m="$m" />
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
                users: @json(\App\Models\User::query()->get(['id', 'name'])),
                categories: @json(\App\Models\Subject\Category::query()->get(['id', 'name'])),
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