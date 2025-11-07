<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HSL Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-indigo-50 via-white to-indigo-50 min-h-screen flex flex-col">

    <nav class="bg-white shadow-md w-full py-4">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <a href="#" class="text-2xl font-bold text-indigo-600">HSL Dashboard</a>
            <div>
                <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline mr-4">Login</a>
                <a href="{{ route('register') }}" class="text-gray-700 font-semibold hover:underline">Register</a>
            </div>
        </div>
    </nav>

    <header class="flex-grow flex flex-col justify-center items-center text-center px-6">
        <h1 class="text-5xl font-extrabold text-indigo-600 mb-6">Welcome to HSL Dashboard</h1>
        <p class="text-gray-700 text-lg mb-8 max-w-xl">Manage your products, orders, and sales seamlessly with our intuitive dashboard.</p>
        <div class="flex gap-4">
            <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">Get Started</a>
            <a href="#features" class="bg-white border border-indigo-600 text-indigo-600 px-6 py-3 rounded-lg hover:bg-indigo-50 transition">Learn More</a>
        </div>
    </header>

    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-8 px-6">
            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h3 class="font-semibold text-xl mb-3">Manage Products</h3>
                <p class="text-gray-600">Add, edit, and monitor your products efficiently.</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h3 class="font-semibold text-xl mb-3">Track Orders</h3>
                <p class="text-gray-600">View all orders, update status, and ensure timely delivery.</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h3 class="font-semibold text-xl mb-3">Sales Overview</h3>
                <p class="text-gray-600">Analyze monthly sales and generate insights for growth.</p>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t py-6 text-center text-gray-500">
        &copy; {{ date('Y') }} HSL Dashboard. All rights reserved.
    </footer>

</body>
</html>
