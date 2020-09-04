@extends('admin.layout.frame')

@section('title', '面板')

@section('main')
    <el-row>
        <el-col :xs="{span:18,offset:3}" :span="8" :offset="8">
            <br />
            <el-card>
                <br />
                <p>你好 {{ user()->name }}</p>
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