@extends('layout.master')
@section('initialScript')
    <script>
        window['baseUrl'] = "{{ url('/') . '/' }}";
    </script>
@endsection
@section('content')

<div id="example"></div>
@endsection

