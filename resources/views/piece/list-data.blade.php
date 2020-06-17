@include('piece.data')
menuActive: '{{ $m }}-list',
selects: [],
sort: {
    prop: '{{ request('sort.prop') }}',
    order: '{{ request('sort.order') ?? 'asc' }}',
},
list: @json($list).data,
page: {{ $list->currentPage() }},
total: {{ $list->total() }},
sortOptions: @json($sortRule),
users: @json(\App\Models\User::query()->get(['id', 'name'])),
@include('piece.list-search')