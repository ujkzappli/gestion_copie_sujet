@extends('layouts.app')

@section('title', 'eBazar - Dashboard')

@section('content')

@endsection

@push('scripts')
    <script src="{{ asset('js/page/index.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1Jr7axGGkwvHRnNfoOzoVRFV3yOPHJEU&callback=myMap"></script>
    <script>
        $('#myDataTable')
        .addClass('nowrap')
        .dataTable({
            responsive: true,
            columnDefs: [
                { targets: [-1, -3], className: 'dt-body-right' }
            ]
        });
    </script>
@endpush