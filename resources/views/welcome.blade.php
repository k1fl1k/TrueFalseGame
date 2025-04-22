<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TrueFalse</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css'])
</head>
<body class="m-0 p-0 font-sans bg-[#1a1a1a] text-[#f5f5f5] h-screen overflow-hidden">

<div class="flex h-full w-full">
    <!-- Порожній блок ліворуч (можна буде вставити фон, якщо треба) -->
    <div class="left" style="background-image: url('{{ asset('images/truefalse.png') }}');"></div>

    <!-- Панель праворуч -->
    <div class="right">
        <div class="logo">TrueFalse</div>
        <div class="subtitle">Colorize your day with pretty arts</div>

        <a href="{{ route('register') }}" class="button btn-gold">Create an account</a>
        <a href="{{ route('login') }}" class="button btn-dark">Login</a>
    </div>
    </div>
</div>

</body>
</html>
