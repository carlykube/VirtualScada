@extends('app')

@section('content')

<h1> {{ $project->name }} </h1>
<h2> Created at: {{ $project->created_at }}</h2>

@endsection