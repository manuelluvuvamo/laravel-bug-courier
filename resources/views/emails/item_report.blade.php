<h1>{{ $title }}</h1>
<p>{{ $description }}</p>
<ul>
    @foreach ($metadata as $key => $value)
        <li>{{ $key }}: {{ $value }}</li>
    @endforeach
</ul>