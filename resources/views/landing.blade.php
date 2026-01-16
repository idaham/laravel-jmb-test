<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Vista Apartment – JMB Resident Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 text-gray-800">

<!-- ================= HEADER ================= -->
<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="font-semibold text-lg tracking-wide">
            Vista Apartment
        </h1>

        @auth
            @if(auth()->user()->can('access system'))
                <a href="/system"
                   class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
                    Admin System
                </a>
            @else
                <a href="/portal"
                   class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-emerald-700">
                    My Portal
                </a>
            @endif
        @else
            <a href="/login"
               class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-emerald-700">
                Resident Login
            </a>
        @endauth
    </div>
</header>

<!-- ================= HERO ================= -->
<section class="relative h-[420px] text-white">
    <img src="/images/condo-exterior.jpg"
         alt="Vista Apartment"
         class="absolute inset-0 w-full h-full object-cover">

    <div class="absolute inset-0 bg-emerald-900/70"></div>

    <div class="relative z-10 h-full flex items-center justify-center">
        <div class="max-w-3xl px-6 text-center">
            <h2 class="text-4xl font-bold mb-4">
                JMB Resident Portal
            </h2>
            <p class="text-lg mb-6">
                Official Joint Management Body portal for residents of Vista Apartment.
            </p>

            @guest
                <a href="/login"
                   class="inline-block bg-white text-emerald-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">
                    Login to Portal
                </a>
            @endguest
        </div>
    </div>
</section>

<!-- ================= ABOUT ================= -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-6">
        <h3 class="text-2xl font-bold mb-4">About This Community</h3>
        <p class="text-gray-600 max-w-3xl leading-relaxed">
            Vista Apartment is managed by the Joint Management Body (JMB),
            responsible for the maintenance, management, and administration
            of common property in accordance with the Strata Management Act.
        </p>
    </div>
</section>

<!-- ================= ANNOUNCEMENTS ================= -->
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold">Announcements</h3>
            <span class="text-sm text-gray-500">Latest updates</span>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="border rounded-lg p-5">
                <h4 class="font-semibold mb-2">Water Disruption</h4>
                <p class="text-sm text-gray-600">
                    Scheduled water interruption on 15 March 2026, 10:00am – 4:00pm.
                </p>
            </div>

            <div class="border rounded-lg p-5">
                <h4 class="font-semibold mb-2">AGM Notice</h4>
                <p class="text-sm text-gray-600">
                    Annual General Meeting on 30 April 2026.
                </p>
            </div>

            <div class="border rounded-lg p-5">
                <h4 class="font-semibold mb-2">Lift Maintenance</h4>
                <p class="text-sm text-gray-600">
                    Servicing scheduled block by block next week.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ================= NEWS & EVENTS ================= -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-6">
        <h3 class="text-2xl font-bold mb-6">News & Events</h3>

        <div class="space-y-4 max-w-3xl">
            <div class="bg-white p-5 rounded-lg shadow-sm">
                <h4 class="font-semibold">Gotong-Royong</h4>
                <p class="text-sm text-gray-600">
                    Community clean-up activity this Saturday.
                </p>
            </div>

            <div class="bg-white p-5 rounded-lg shadow-sm">
                <h4 class="font-semibold">Fire Drill</h4>
                <p class="text-sm text-gray-600">
                    Safety awareness drill with BOMBA.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ================= FACILITIES ================= -->
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-6">
        <h3 class="text-2xl font-bold mb-6">Facilities</h3>

        <div class="grid md:grid-cols-4 gap-6 text-sm">
            <div class="border rounded-lg p-5 text-center">Swimming Pool</div>
            <div class="border rounded-lg p-5 text-center">Gymnasium</div>
            <div class="border rounded-lg p-5 text-center">Multi-purpose Hall</div>
            <div class="border rounded-lg p-5 text-center">Playground</div>
        </div>
    </div>
</section>

<!-- ================= CONTACT ================= -->
<section class="bg-emerald-700 text-white py-16">
    <div class="max-w-7xl mx-auto px-6">
        <h3 class="text-2xl font-bold mb-4">Management Office</h3>
        <p class="text-sm leading-relaxed">
            Email: admin@vista-apartment.com.my<br>
            Office Hours: Mon – Fri, 9:00am – 5:00pm
        </p>
    </div>
</section>

<!-- ================= FOOTER / Admin Login ================= -->
<footer class="bg-gray-900 text-gray-400 text-center text-xs py-6">
    © {{ date('Y') }} Vista Apartment – Joint Management Body
    <span class="mx-2">|</span>
    <a href="/system/login" class="hover:text-white">
        Staff Login
    </a>
</footer>

</body>
</html>
