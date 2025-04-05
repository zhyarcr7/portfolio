<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Hero Slides</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .section { margin-bottom: 30px; }
        .file { background: #f5f5f5; padding: 10px; margin: 5px 0; }
        .slide { background: #e9f7fe; padding: 10px; margin: 10px 0; border: 1px solid #ccc; }
        .image-test { margin: 10px 0; padding: 10px; background: #f0f0f0; }
        img { max-width: 300px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <h1>Hero Slides Debug</h1>
    
    <div class="section">
        <h2>Files in storage/hero-slides directory:</h2>
        @if(count($files) > 0)
            @foreach($files as $file)
                <div class="file">{{ basename($file) }}</div>
            @endforeach
        @else
            <p>No files found in the storage directory.</p>
        @endif
    </div>
    
    <div class="section">
        <h2>Hero Slides in Database:</h2>
        @if(count($slides) > 0)
            @foreach($slides as $slide)
                <div class="slide">
                    <h3>Slide ID: {{ $slide->id }}</h3>
                    <p><strong>Title:</strong> {{ $slide->title }}</p>
                    <p><strong>Image Path:</strong> {{ $slide->bgImage }}</p>
                    
                    <div class="image-test">
                        <h4>Testing Image Display:</h4>
                        <p>Using asset('storage/' . bgImage):</p>
                        <img src="{{ asset('storage/' . $slide->bgImage) }}" alt="Test 1">
                        
                        <p>Using direct path to public/storage:</p>
                        <img src="/storage/{{ $slide->bgImage }}" alt="Test 2">
                        
                        <p>Using basename of the path:</p>
                        @php
                            $basename = basename($slide->bgImage);
                        @endphp
                        <img src="{{ asset('storage/hero-slides/' . $basename) }}" alt="Test 3">
                    </div>
                </div>
            @endforeach
        @else
            <p>No slides found in the database.</p>
        @endif
    </div>
</body>
</html> 