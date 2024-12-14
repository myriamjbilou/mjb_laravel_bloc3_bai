<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandeau de Cookies</title>
    <style>
        #cookie-banner {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: rgba(139, 134, 134, 0.93);
            border-color: #fff;
            color: #fff;
            text-align: center;
            padding: 10px;
            z-index: 1000;
        }

        #cookie-banner button {
            margin: 0 10px;
            padding: 5px 10px;
            background-color: rgb(164, 173, 189);
            border: none;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div id="cookie-banner">
        <p>Ce site utilise des cookies pour améliorer votre expérience. <a href="/politique-de-cookie" style="color:rgb(0, 0, 0);">En savoir plus</a></p>
        <button id="accept-cookies">Accepter</button>
        <button id="decline-cookies">Refuser</button>
    </div>

    <!-- Inclure les scripts compilés par Vite -->
    @vite(['resources/js/app.js'])
</body>

</html>