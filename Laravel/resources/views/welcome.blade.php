@extends('app')

@section('content')
{{$name}}
		<div class="container">
			<div class="content">
				<div class="title">Laravel 5</div>
				<div class="quote">{{ Inspiring::quote() }} Привет</div>
			</div>
		</div>
@stop