@extends('layout.frame')

@section('title', 'Subject Edit')

@section('main')
<el-row>
    <el-col>
        <el-card></el-card>
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
                search: {

                },
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