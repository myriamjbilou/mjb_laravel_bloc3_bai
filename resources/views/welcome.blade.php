<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="antialiased bg-white text-gray-800">
    <div class="min-h-screen flex flex-col justify-center bg-white">

        <!-- Navbar Section -->
        <div class="flex justify-between items-center p-6 bg-white shadow-md">
            <div class="text-2xl font-bold text-gray-900">
                Acccueil
            </div>

            @if (Route::has('login'))
            <nav class="space-x-6">
                @auth
                <a
                    href="{{ url('/dashboard') }}"
                    class="text-sm text-gray-700 hover:text-gray-900">
                    Dashboard
                </a>
                @else
                <a
                    href="{{ route('login') }}"
                    class="text-sm text-gray-700 hover:text-gray-900">
                    Se connecter
                </a>

                @if (Route::has('register'))
                <a
                    href="{{ route('register') }}"
                    class="ml-4 text-sm text-gray-700 hover:text-gray-900">
                    Créer un compte
                </a>
                @endif
                @endauth
            </nav>
            @endif
        </div>

        <!-- Main Content Section -->
        <div class="flex flex-1 justify-center items-center px-4 py-16 sm:px-6 lg:px-8 bg-white">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl font-semibold text-gray-900">
                    Bienvenue sur la Boite à idée
                </h1>
                </p>
                <!-- Image added below the text -->
                <div class="mt-8">
                    <img
                        src="{{ asset('img/ampoule.jpg') }}"
                        alt="ampoule"
                        class="w-64 h-64 object-cover rounded-lg shadow-lg mx-auto"/>
                </div>
            </div>
        </div>

        <!-- Idea Box Section -->
        <div class="bg-white mt-8 mb-8 p-8 mx-6 sm:mx-12 shadow-lg rounded-xl">
            <h2 class="text-3xl font-semibold text-gray-900 text-center">
                "Les idées ne sont pas faites pour être pensées mais vécues."
            </h2>
            <p class="mt-4 text-lg text-gray-600 text-center">
                André Malraux.
            </p>
        </div>

        <!-- Additional Text Section -->
        <div class="bg-white py-12">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-2xl font-semibold text-gray-900">
                    Partagez vos idées !
                </h2>
                <p class="mt-4 text-lg text-gray-600">
                    Vous avez une idée ? Nous serions ravis de l'entendre !
                </p>
            </div>
        </div>

        <!-- RGPD Section -->
        <div class="bg-white py-8 px-6 sm:px-12 mt-8 mb-12 shadow-lg rounded-xl">
            <h2 class="text-2xl font-semibold text-gray-900 text-center">

            </h2>
            <p class="mt-4 text-lg text-gray-600 text-center">
                Nous respectons votre vie privée. Pour en savoir plus sur la manière dont nous traitons vos données personnelles, veuillez consulter notre
                <a href="/privacy-policy" class="underline text-blue-600 hover:text-blue-800">politique de confidentialité</a>.
            </p>
        </div>

    </div>
</body>

</html>