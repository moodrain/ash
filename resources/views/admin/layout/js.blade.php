<script src="https://s1.moodrain.cn/lib/rium/index.js"></script>
<script src="https://s1.moodrain.cn/lib/vue/index.js"></script>
<script src="https://s1.moodrain.cn/lib/element-ui/index.js"></script>
<script>
    $bindVue(Vue)
    // new ClipboardJS('.clipboard-btn');
    Vue.prototype.$back = () => history.go(-1)
    Vue.prototype.$open = url => window.open(url, '_blank')
</script>