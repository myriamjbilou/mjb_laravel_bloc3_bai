import './bootstrap';
import Alpine from 'alpinejs';
import Cookies from 'js-cookie';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('accept-cookies').addEventListener('click', function() {
        Cookies.set('cookie-consent', 'accepted', { expires: 365 });
        document.getElementById('cookie-banner').style.display = 'none';
    });

    document.getElementById('decline-cookies').addEventListener('click', function() {
        Cookies.set('cookie-consent', 'declined', { expires: 365 });
        document.getElementById('cookie-banner').style.display = 'none';
    });

    // Vérifie si le cookie de consentement existe déjà
    if (Cookies.get('cookie-consent')) {
        document.getElementById('cookie-banner').style.display = 'none';
    }
});