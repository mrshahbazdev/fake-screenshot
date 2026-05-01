<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Quick Receipt') — Quick Receipt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50:'#f0f9ff',100:'#e0f2fe',200:'#bae6fd',300:'#7dd3fc',400:'#38bdf8',500:'#0ea5e9',600:'#0284c7',700:'#0369a1',800:'#075985',900:'#0c4a6e' },
                        accent:  { 50:'#fdf4ff',100:'#fae8ff',200:'#f5d0fe',300:'#f0abfc',400:'#e879f9',500:'#d946ef',600:'#c026d3',700:'#a21caf',800:'#86198f',900:'#701a75' },
                    },
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        .glass { background: rgba(255,255,255,0.08); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.12); }
        .glass-dark { background: rgba(15,23,42,0.7); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.08); }
        .gradient-bg { background: linear-gradient(135deg, #0c4a6e 0%, #1e1b4b 50%, #701a75 100%); }
        .gradient-text { background: linear-gradient(135deg, #38bdf8, #e879f9); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .btn-gradient { background: linear-gradient(135deg, #0ea5e9, #d946ef); transition: all 0.3s; }
        .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 10px 40px rgba(14,165,233,0.3); }
        .input-modern { transition: all 0.3s; }
        .input-modern:focus { box-shadow: 0 0 0 3px rgba(14,165,233,0.2); }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased text-gray-100 min-h-screen gradient-bg">
    @yield('content')
    @stack('scripts')
</body>
</html>
