<!DOCTYPE html>
<html>
<head>
    <title>My web page</title>
</head>
<body>
<h1>Hello, world!</h1>
<p>This is my first web page.</p>
<p>It contains a
    <strong>main heading</strong> and <em> paragraph </em>.
</p>
<div>
    <button type="submit" class="button">@lang('messages.search')</button>
    <a href="{{ url('/') }}" class="button">@lang('messages.back')</a>
</div>
</body>
</html>
