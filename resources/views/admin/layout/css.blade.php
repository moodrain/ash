<link href="https://s1.moodrain.cn/lib/element-ui/index.css" rel="stylesheet">
<link href="https://s1.moodrain.cn/lib/mdui/index.css" rel="stylesheet">
<style>
    * {
        margin: 0;
        padding: 0;
        scrollbar-width: none
    }
    html, body, #app {
        width: 100%;
        height: 100%;
    }
    a {
        text-decoration: none;
        color: black;
    }
    ::-webkit-scrollbar {
        width: 0;
        height: 0;
    }
    .el-tag {
        margin: 2px;
    }
    .card {
        margin-bottom: 10px;
    }
    .point {
        cursor: pointer;
        user-select: none;
    }
    .user-content img {
        max-width: 200px;
        max-height: 200px;
        object-fit: contain;
        cursor: pointer;
    }
    table {
        border-collapse: collapse;
        border-spacing: 0;
        empty-cells: show;
        border: 1px solid #cbcbcb;
    }
    table tbody tr td,th {
        margin: 20px;
        padding: 20px;
        border-width: 0 0 1px 0;
        border-bottom: 1px solid #cbcbcb
    }
    table thead {
        background-color: #e0e0e0;
        color: #000;
        text-align: left;
        vertical-align: bottom
    }
    .el-table__header, .el-table__body {
        border: none !important;
    }
</style>