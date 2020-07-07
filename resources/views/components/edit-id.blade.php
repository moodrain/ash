@if(isset($d) && data_get($d, 'id'))
    <x-input exp="value:form.id;label:ID;disabled:1"></x-input>
@endif