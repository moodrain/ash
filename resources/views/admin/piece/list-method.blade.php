selectChange (selects) { this.selects = selects },
more() { if(this.doMore) { this.doMore() } },
doDelete(id) {
    if(this.selects.length > 0) {
        this.$confirm('{{ ____('confirm delete') }} ' + this.selects.length + ' {{ ___($modelName) }} ?', '{{ ___('confirm') }}', {
            confirmButtonText: '{{ ___('confirm') }}',
            cancelButtonText: '{{ ___('cancel') }}',
            type: 'warning',
        }).then(() => {
            let ids = []
            this.selects.forEach(e => ids.push(e.id))
            $submit('/{{ (empty($prefix) ? '' : endWith('/', $prefix)) . $m }}/destroy', {ids})
        }).catch(() => {})
    } else {
        this.$confirm('{{ ____('confirm delete ' . $modelName) }} ?', '{{ ___('confirm') }}', {
            confirmButtonText: '{{ ___('confirm') }}',
            cancelButtonText: '{{ ___('cancel') }}',
            type: 'warning',
        }).then(() => {
            $submit('/{{ (empty($prefix) ? '' : endWith('/', $prefix)) . $m }}/destroy', {id})
        }).catch(() => {})
    }
},