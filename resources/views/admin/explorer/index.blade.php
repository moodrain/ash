@extends('admin.layout.frame')

@section('title', '文件管理')

@section('main')
    <el-row>
        <el-col :xs="24" :span="18">
            <el-card>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item @click.native="breadTo(index)" style="cursor: pointer" v-for="(item, index) in pagePathArr" :key="index">@{{ item }}</el-breadcrumb-item>
                </el-breadcrumb>
                <el-form inline>
                    <el-divider></el-divider>
                    <el-form-item>
                        <el-button icon="el-icon-back" @click="parentPath"></el-button>
                        <el-form-item>
                            <el-input v-model="path" :placeholder="pagePath">
                                <template slot="prepend">路径</template>
                            </el-input>
                        </el-form-item>
                        <el-button icon="el-icon-right" @click="$to('/admin/explorer', {path}, true)"></el-button>
                    </el-form-item>
                    <el-form-item>
                        <el-upload multiple :action="uploadAction" :on-success="uploadOk" :show-file-list="false" :with-credentials="true">
                            <el-button slot="trigger" icon="el-icon-upload2"></el-button>
                        </el-upload>
                    </el-form-item>
                    <el-form-item>
                        <el-button @click="$submit('/admin/explorer/mkdir', {path})" icon="el-icon-folder-add"></el-button>
                    </el-form-item>
                </el-form>
            </el-card>
            <br />
            <el-card>
                <el-table :data="directories">
                    <el-table-column label="目录">
                        <template slot-scope="scope">
                            <div style="cursor: pointer" @click="$to({path: scope.row.path})">@{{ scope.row.name }}</div>
                        </template>
                    </el-table-column>
                    <el-table-column width="220">
                        <template slot-scope="scope">
                            <el-button @click="copy(scope.row.path)" icon="el-icon-document-copy"></el-button>
                            <el-button @click="move(scope.row.path)" icon="el-icon-scissors"></el-button>
                            <el-button icon="el-icon-delete" @click="rmdir(scope.row)"></el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </el-card>
            <br />
            <el-card>
                <el-table :data="files">
                    <el-table-column label="文件">
                        <template slot-scope="scope">
                            <div style="cursor: pointer;" @click="$open(scope.row.url)">@{{ scope.row.name }}</div>
                        </template>
                    </el-table-column>
                    <el-table-column label="Preview" width="200">
                        <template slot-scope="scope">
                            <el-image v-if="scope.row.img" :src="scope.row.url" style="cursor: pointer;height: 60px;object-fit: contain" fit="contain" @click="$open(scope.row.url)" />
                        </template>
                    </el-table-column>
                    <el-table-column label="Size" width="100">
                        <template slot-scope="scope">
                            @{{ scope.row.size > 1024 ? parseInt(scope.row.size / 1024) + ' m' : scope.row.size + ' k' }}
                        </template>
                    </el-table-column>
                    <el-table-column width="220">
                        <template slot-scope="scope">
                            <el-button @click="copy(scope.row.file)" icon="el-icon-document-copy"></el-button>
                            <el-button @click="move(scope.row.file)" icon="el-icon-scissors"></el-button>
                            <el-button icon="el-icon-delete" @click="$confirm('confirm to delete ?').then(() => {$submit('/admin/explorer/delete', {file: scope.row.file})}).catch(() => {})"></el-button>
                        </template>
                    </el-table-column>
                </el-table>
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
                    menuActive: 'explorer',
                    path: '{{ request('path') }}',
                    pagePath: '{{ request('path') }}',
                    directories: @json($directories),
                    files: @json($files),
                }
            },
            methods: {
                @include('admin.piece.method')
                parentPath() {
                    let pathPieces = this.pagePath.split('/')
                    if (pathPieces.length < 1) {
                        return
                    }
                    let parentPath = pathPieces.slice(0, pathPieces.length - 1).join('/')
                    this.$to({path: parentPath})
                },
                uploadOk(rs) {
                    this.$notify({message: rs.msg, type: rs.code === 0 ? 'success' : 'warning'})
                },
                rmdir(dir) {
                    let path = this.pagePath ? (this.pagePath + '/' + dir.name) : dir.name
                    this.$confirm('confirm to rmdir ?').then(() => {
                        this.$submit('/admin/explorer/rmdir', {path})
                    }).catch(() => {})
                },
                breadTo(index) {
                    this.$to('/admin/explorer', {path: this.pagePathArr.slice(1, index + 1).join('/')}, true)
                },
                move(from) {
                    this.$prompt('move target').then(({value}) => { this.$submit('/admin/explorer/move', {from, to: value}) }).catch(() => {})
                },
                copy(from) {
                    this.$prompt('copy target').then(({value}) => { this.$submit('/admin/explorer/copy', {from, to: value}) }).catch(() => {})
                }
            },
            mounted() {
                @include('admin.piece.init')
            },
            computed: {
                uploadAction: {
                    get() {
                        return '/admin/explorer/upload?path=' + this.path
                    }
                },
                pagePathArr: {
                    get() {
                        return ['Home'].concat(this.pagePath.split('/'))
                    }
                },
            }
        })
    </script>
@endsection