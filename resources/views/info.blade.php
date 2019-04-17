@extends('template')

@section('title', $name)

@section('content')
	<h1>{{ $name }}</h1>
	
	<h2>Category</h2>
	{{ $category }}

	<h2>Synopsis</h2>
	{{ $synopsis }}

	<h2>Version</h2>
	{{ $version }}

	<h2>Institution</h2>
	{{ $institution }}

	<h2>Release Time</h2>
	{{ $release_time }}

	<h2>Research Subject</h2>
	{{ $research_subject }}

	<h2>Support Email</h2>
	{{ $support_email }}

	<h2>Tags</h2>
	{{ $tags }}
@stop

