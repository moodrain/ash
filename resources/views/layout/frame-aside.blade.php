<a href="/"><el-menu-item index="dashboard">Dashboard</el-menu-item></a>

<el-submenu index="post">
    <template slot="title">Post</template>
    <a href="/post/list"><el-menu-item index="post-list">Post List</el-menu-item></a>
    <a href="/post/edit"><el-menu-item index="post-edit">Post Edit</el-menu-item></a>
</el-submenu>