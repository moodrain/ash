@extends('layout.frame')

@include('piece.edit-title')

@section('main')
    <el-row>
        <el-col :xs="{span:22,offset:1}" :lg="8">
            <el-card>
                <el-form label-width="80px">
                    <x-edit-id :d="$d"></x-edit-id>
                    <x-input exp="model:form.name;label:Name"></x-input>
                    <x-input exp="model:form.abstract;label:Abstract"></x-input>
                    <x-edit-submit :d="$d"></x-edit-submit>
                </el-form>
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
                form: {
                    id: {{ $d->id ?? 'null' }},
                    name: '{{ $d->name ?? '' }}',
                    abstract: '{{ $d->abstract ?? '' }}',
                },
                @include('piece.edit-data')
            }
        },
        methods: {
            @include('piece.edit-method')
        },
        mounted() {
            @include('piece.init')
        }
    })
</script>
@endsection
