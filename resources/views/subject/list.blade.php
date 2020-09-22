@extends('layout.frame')

@section('title', 'subject list')

@section('main')
<el-row>
    <el-col :span="18" :xs="24">
        <el-card shadow="hover">
            <el-form inline>
                <x-input exp="model:search.search;pre:search" />
                <x-select exp="model:search.categoryId;label:category;key:id;selectLabel:name;value:id;data:categories" />
                <el-button icon="el-icon-search" @click="this.$to(search)"></el-button>
            </el-form>
        </el-card>
    </el-col>
</el-row>
<el-row>
    <el-col :span="18" :xs="24" v-for="item in subjects" :key="item.id" style="margin: 10px 0;">
        <el-card shadow="hover">
            <p slot="header">
                <a :href="'/subject/' + item.id">@{{ item.title }}</a>
                <el-divider direction="vertical"></el-divider>
                <el-tag style="margin: 0">@{{ item.category.name }}</el-tag>
                <el-divider v-if="item.userId == {{ uid() ?? 'null' }}" direction="vertical"></el-divider>
                <a v-if="item.userId == {{ uid() ?? 'null' }}" :href="'/subject/edit?id=' + item.id">{{ ___('edit') }}</a>
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
        <el-card shadow="hover">
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
            search: {
                search: '{{ request('search') }}',
                categoryId: {{ request('categoryId', 'null') }},
            },
            subjects: @json($subjects),
            page: {{ request('page', 1) }},
            total: {{ $total }},
            categories: @json(\App\Models\Subject\Category::query()->get(['id', 'name'])),
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