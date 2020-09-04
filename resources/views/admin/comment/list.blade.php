@extends('admin.layout.frame')

@include('admin.piece.list-title')

@section('main')
<el-card>
    <el-form inline>
        <x-input exp="model:search.id;pre:ID" />
        <x-input exp="model:search.commentId;pre:回复ID" />
        <x-select exp="model:search.fromUserId;label:用户;key:id;selectLabel:name;value:id;data:users" />
        <x-select exp="model:search.subjectId;label:主题;key:id;selectLabel:title;value:id;data:subjects" />
        <x-sort />
        <x-admin.list-head-btn :m="$m" />
    </el-form>
</el-card>
<br />
<el-card>
    <el-table :data="list" height="560" border  @selection-change="selectChange">
        <el-table-column type="selection" width="55"></el-table-column>
        <el-table-column prop="id" label="ID" width="60"></el-table-column>
        <el-table-column prop="subject.title" label="主题"></el-table-column>
        <el-table-column prop="from.name" label="用户"></el-table-column>
        <el-table-column prop="contentShort" label="内容"></el-table-column>
        <el-table-column label="图片">
            <template slot-scope="scope">
                <el-image @click="$open(src)" style="max-width:20%;margin: 1%;cursor: pointer" fit="contain" v-for="(src, index) in scope.row.images" :key="index" :src="src"></el-image>
            </template>
        </el-table-column>
        <el-table-column prop="commentId" label="回复ID"></el-table-column>
        <el-table-column prop="createdAt" label="时间" width="160"></el-table-column>
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
                subjects: @json(\App\Models\Subject::query()->get(['id', 'title'])),
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