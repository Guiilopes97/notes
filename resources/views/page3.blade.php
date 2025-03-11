@extends('layouts.main_layout')

@section('content')
    <h1>Welcome View and Blade</h1>
    <hr>
    <h3>This is page 3</h3>
    <h3>The value is: {{$value}}</h3>
    
    <a href="/main/{{$value}}">Main</a>
    <br>
    <a href="/page2/{{$value}}">Page 2</a>
@endsection
   