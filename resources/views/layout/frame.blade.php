@extends('layout.app')

@section('title')
@endsection

@section('html')
<div id="app">
    <el-container style="height: 100%">

        <el-aside style="width: 200px;height: 100%;">

            <el-menu
                style="height: 100%;width: 100%" :default-active="menuActive" background-color="#545c64" text-color="#fff" active-text-color="#ffd04b">

                <el-container style="width: 100%;height: 60px;line-height: 60px;">
                    <p style="color: white;font-size: 1.4em;width: 100%;text-align: center;user-select: none">Ash</p>
                </el-container>

                <a href="/"><el-menu-item index="dashboard">Dashboard</el-menu-item></a>

                <el-submenu index="post">
                    <template slot="title">Post</template>
                    <a href="/post/list"><el-menu-item index="post-list">Post List</el-menu-item></a>
                    <a href="/post/edit"><el-menu-item index="post-edit">Post Edit</el-menu-item></a>
                </el-submenu>

            </el-menu>

        </el-aside>

        <el-container>

            <el-header style="user-select: none;background-color: #545c64;color: #fff;line-height: 60px">

                <el-dropdown style="float: right">
                    <p style="cursor: pointer;color: #fff">{{ user()->name }} <i class="el-icon-arrow-down el-icon--right"></i></p>
                    <el-dropdown-menu slot="dropdown">
                        <form hidden id="logout" action="/logout" method="POST"></form>
                        <el-dropdown-item><a href="javascript:" onclick="confirm('Sure to Logout ?') && document.querySelector('#logout').submit()">Logout</a></el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>

            </el-header>

            <el-main style="width: 100%;height: 100%;background: #b4f3f4">
                @yield('main')
            </el-main>

        </el-container>

    </el-container>
</div>
@endsection



@section('js')
    @include('layout.js')
    @yield('script')
@endsection

@section('css')
    @include('layout.css')
    @yield('style')
@endsection