<el-menu-item index="dashboard" @click="$to('/')">Dashboard</el-menu-item>

<el-submenu index="post">
    <template slot="title">Post</template>
    <el-menu-item index="post-list" @click="$to('/post/list')">Post List</el-menu-item>
    <el-menu-item index="post-edit" @click="$to('/post/edit')">Post Edit</el-menu-item>
</el-submenu>