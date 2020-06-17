@php
    $search = [];
    foreach ($searchRule ?? [] as $key => $val) {
        $search[$key] = request('search.' . $key);
    }
@endphp
search: @json($search)