@extends('layout.frame')

@section('title', 'Subject List')

@section('main')
<el-row>
    <el-col :span="18" :xs="24" v-for="item in subjects" :key="item.id" style="margin-bottom: 20px;">
        <el-card>
            <p slot="header">
                <a :href="'/subject/' + item.id">@{{ item.title }}</a>
                <el-divider direction="vertical"></el-divider>
                <el-tag style="margin: 0">@{{ item.category.name }}</el-tag>
            </p>
            <p class="preview">
                <img style="max-width: 100px;max-height: 100px;object-fit: contain;cursor: pointer;margin: 1px;" :src="src" v-for="(src, index) in item.images" :key="index" />
            </p>
            <p style="margin-top: 5px">@{{ item.contentShort }}</p>
        </el-card>
    </el-col>
</el-row>
<el-row>
    <el-col :span="18" :xs="24">
        <el-card>
            <x-pager :size="20" />
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
            @include('piece.data')
            menuActive: 'subject',
            subjects: @json($subjects),
            page: {{ request('page', 1) }},
            total: {{ $total }},
        }
    },
    methods: {
        @include('piece.method')
    },
    mounted() {
        @include('piece.init')
    }
})
</script>
@endsection