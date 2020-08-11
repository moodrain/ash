@extends('admin.layout.frame')

@include('admin.piece.list-title')

@section('main')
<el-card>
    <el-form inline>
        <x-input exp="model:search.id;pre:ID" />
        <x-input exp="model:search.title;pre:Title" />
        <x-select exp="model:search.userId;label:User;key:id;selectLabel:name;value:id;data:users" />
        <x-select exp="model:search.categoryId;label:Category;key:id;selectLabel:name;value:id;data:categories" />
        <x-sort />
        <x-admin.list-head-btn :m="$m" />
    </el-form>
</el-card>
<br />
<el-card>
    <el-table :data="list" height="560" border  @selection-change="selectChange">
        <el-table-colcumn type="selection" width="55"></el-table-colcumn>
        <el-table-column prop="id" label="ID" width="60"></el-table-column>
        <el-table-column prop="title" label="Title"></el-table-column>
        <el-table-column prop="category.name" label="Category"></el-table-column>
        <el-table-column prop="user.name" label="User"></el-table-column>
        <el-table-column prop="contentShort" label="Content"></el-table-column>
        <el-table-column label="Image">
            <template slot-scope="scope">
                <el-image @click="$open(src)" style="max-width:20%;margin: 1%;cursor: pointer" fit="contain" v-for="(src, index) in scope.row.images" :key="index" :src="src"></el-image>
            </template>
        </el-table-column>
        <el-table-column prop="createdAt" label="CreatedAt" width="160"></el-table-column>
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