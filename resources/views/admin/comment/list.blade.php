@extends('admin.layout.frame')
@include('admin.piece.list-title')

@section('main')
<el-card>
    <el-form inline>
        <x-input exp="model:search.id;pre:id" />
        <x-input exp="model:search.commentId;pre:comment id" />
        <x-select exp="model:search.fromUserId;label:user;key:id;selectLabel:name;value:id;data:users" />
        <x-select exp="model:search.subjectId;label:subject;key:id;selectLabel:title;value:id;data:subjects" />
        <x-sort />
        @include('admin.piece.list-head-btn')
    </el-form>
</el-card>
<br />
<el-card>
    @php
    $cols = [
        ['id', 'id', 60],
        ['title', 'subject.title'],
        ['comment id', 'commentId'],
        ['user', 'from.name'],
        ['content', 'contentShort'],
        ['time', 'createdAt', 160],
    ];
    @endphp
    <el-table :data="list" height="560" border  @selection-change="selectChange">
        <el-table-column type="selection" width="55"></el-table-column>
        <x-table-col :cols="$cols" />
        <el-table-column label="{{ ___('image') }}">
            <template slot-scope="scope">
                <el-image @click="$open(src)" style="max-width:20%;margin: 1%;cursor: pointer" fit="contain" v-for="(src, index) in scope.row.images" :key="index" :src="src"></el-image>
            </template>
        </el-table-column>
        @include('admin.piece.list-body-col')
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