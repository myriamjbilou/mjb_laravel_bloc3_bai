<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
>

    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
        }

        header {
            background: #333;
            color: #fff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: rgb(228, 94, 60) 6px solid;
        }

        header a {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }

        header ul {
            padding: 0;
            list-style: none;
        }

        header li {
            display: inline;
            padding: 0 20px 0 20px;
        }

        .content {
            padding: 20px;
            background: #fff;
            margin-top: 20px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2,
        h3 {
            color: #333;
        }

        h4 {
            color: #fff
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <h4>CHARTE DE LA PROTECTION DE LA VIE PRIVEE</h4>
        </div>
    </header>
    <div class="container">
        <div class="content">
            <h2>1. Protection de la Vie Privée</h2>
            <p>Nous nous engageons à protéger la vie privée de nos utilisateurs. Toutes les données personnelles collectées sont traitées conformément aux lois en vigueur et ne seront jamais partagées sans consentement explicite.</p>

            <h2>2. Respect des Droits</h2>
            <p>Nous respectons les droits de nos utilisateurs, y compris les droits d'accès, de rectification et de suppression de leurs données personnelles. Toute demande sera traitée dans les plus brefs délais.</p>

            <h2>3. Durées de Conservation</h2>
            <p>Les données personnelles sont conservées uniquement pendant la durée nécessaire aux finalités pour lesquelles elles ont été collectées, conformément à notre politique de conservation des données et aux exigences du RGPD (https://www.cnil.fr/fr/reglement-europeen-protection-donnees).</p>

            <h2>4. Sécurité des Données</h2>
            <p>Nous mettons en œuvre des mesures de sécurité techniques et organisationnelles pour protéger les données personnelles contre toute perte, accès non autorisé ou divulgation, conformément aux recommandations de la CNIL (https://www.cnil.fr/fr/passer-laction/rgpd-exemples-de-mentions-dinformation).</p>

            <h2>5. Transparence</h2>
            <p>Nous nous engageons à être transparents sur nos pratiques de traitement des données. Les utilisateurs seront informés de toute modification significative de notre politique de confidentialité, comme exigé par le RGPD (https://www.cnil.fr/fr/reglement-europeen-protection-donnees).</p>

            <h2>6. Consentement</h2>
            <p>Le consentement des utilisateurs est requis pour la collecte et le traitement de leurs données personnelles. Les utilisateurs peuvent retirer leur consentement à tout moment, en accord avec les directives du RGPD (https://www.cnil.fr/fr/reglement-europeen-protection-donnees).</p>

            <h2>7. Cookies et Technologies Similaires</h2>
            <p>Nous utilisons des cookies pour améliorer l'expérience utilisateur sur notre site. Les utilisateurs peuvent gérer leurs préférences en matière de cookies via les paramètres de leur navigateur, conformément aux recommandations de la CNIL (https://www.cnil.fr/fr/passer-laction/rgpd-exemples-de-mentions-dinformation).</p>

            <h2>8. Contact</h2>
            <p>Pour toute question ou demande concernant la protection des données, les utilisateurs peuvent nous contacter à l'adresse suivante : BAI@gmail.com.</p>
        </div>
    </div>

    <script>
        document.getElementById('consentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const consentData = {
                analytics: document.getElementById('analytics').checked,
                marketing: document.getElementById('marketing').checked,
                privacy_accepted: document.getElementById('privacy-accept').checked,
                _token: document.querySelector('meta[name="csrf-token"]').content
            };

            fetch('/save-consent', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(consentData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Vos préférences ont été enregistrées');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
        });
    </script>
    </script>
</body>

</html>