@extends('layouts.main_layout')

@section('content')
    <h1>Welcome View and Blade</h1>
    <hr>
    <h3>The value is: {{$value}}</h3>
    
    <a href="/page2/{{$value}}">Page 2</a>
    <br>
    <a href="/page3/{{$value}}">Page 3</a>
@endsection
   