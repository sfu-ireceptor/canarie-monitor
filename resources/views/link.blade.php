@extends('template')

@section('title', $title)

@section('content')
<h1>{{ $page }}</h1>
<p>
	For more information, see
	<a href="{{ $url }}">{{ $url }}</a>.
</p>
@stop
