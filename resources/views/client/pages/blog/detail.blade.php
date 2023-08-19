@extends('client.layout.master')

@section('title')
    Blog
@endsection

@section('js-custom')
    <script>
        console.log(123)
    </script>
@endsection

@section('side-bar')
    @parent
    Side bar layout Detail
@endsection
