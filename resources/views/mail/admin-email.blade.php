<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Email from Admin</title>
</head>
<body>
	@if ($objective == 'payment')
    <h3 class="text-info"> Payment Issue !</h3>
	@else
	{{ $objective }}
	@endif
	<p>{{ $body }}</p>
	<p>Thank You.</p>
	<h1> Hall Automation Just</h1>

</body>
</html>