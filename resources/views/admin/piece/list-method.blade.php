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
            $submit('/admin/{{ $m }}/destroy', {ids})
        }).catch(() => {})
    } else {
        this.$confirm('{{ ____('confirm delete ' . $modelName) }} ?', '{{ ___('confirm') }}', {
            confirmButtonText: '{{ ___('confirm') }}',
            cancelButtonText: '{{ ___('cancel') }}',
            type: 'warning',
        }).then(() => {
            $submit('/admin/{{ $m }}/destroy', {id})
        }).catch(() => {})
    }
},