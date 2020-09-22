@extends('admin.layout.frame')

@section('title', 'dash')

@section('main')
    <el-row>
        <el-col :xs="{span:18,offset:3}" :span="8" :offset="8">
            <br />
            <el-card>
                <br />
                <p>{{ ___('greet') }} {{ user()->name }}</p>
                <br />
            </el-card>
        </el-col>
    </el-row>
@endsection

@section('script')
<script>
new Vue({
    el: '#app',
    data () {
        return {
            @include('admin.piece.data')
            menuActive: 'dashboard'
        }
    },
    methods: {
        @include('admin.piece.method')
    },
    mounted() {
        @include('admin.piece.init')
    }
})
</script>
@endsection