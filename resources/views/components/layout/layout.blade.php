<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Idea</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class='bg-background text-foreground'>
<x-layout.nav />
  <main class="relative">
  {{ $slot }}

  </main>


  @session('success')

    <div x-data="{show: true}" x-init="setTimeout(()=>show=false, 3000)" x-transition.opacity.duration.300ms x-show="show" class="bg-primary px-4 py-3 absolute bottom-4 right-4 rounded-lg">
      {{ $value }}
    </div>
  @endsession
</body>
</html>