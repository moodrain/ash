<el-menu-item index="dashboard" @click="$to('/', {}, true)">Dashboard</el-menu-item>

<el-submenu index="post">
    <template slot="title">Post</template>
    <el-menu-item index="post-list" @click="$to('/post/list', {}, true)">Post List</el-menu-item>
    <el-menu-item index="post-edit" @click="$to('/post/edit', {}, true)">Post Edit</el-menu-item>
</el-submenu>