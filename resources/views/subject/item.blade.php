@extends('layout.frame')

@section('title', 'Subject Detail')

@section('main')
<el-row>
    <el-col :span="18" :xs="24">
        <el-card>
            <span>@{{ subject.title }}</span>
            <el-divider direction="vertical"></el-divider>
            <el-tag style="margin: 0">@{{ subject.category.name }}</el-tag>
            <el-divider v-if="subject.userId == {{ uid() ?? 'null' }}" direction="vertical"></el-divider>
            <a v-if="subject.userId == {{ uid() ?? 'null' }}" :href="'/subject/edit?id=' + subject.id">编辑</a>
            <div class="mdui-type">

            </div>
        </el-card>
    </el-col>
</el-row>
@endsection

@section('script')
<script>
new Vue({
    el: '#app',
    data() {
        return {
            @include('piece.data')
            menuActive: 'subject',
            subject: @json($subject),
            comments: @json($comments),
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