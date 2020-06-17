@extends('layout.frame')

@section('title', 'Dashboard')

@section('main')
    <el-row id="app">
        <el-col :span="8" :offset="8">
            <br />
            <el-card>
                <br />
                <p>Greeting {{ user()->name }}</p>
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
            menuActive: 'dashboard'
        }
    }
})
</script>
@endsection