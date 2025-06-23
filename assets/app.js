import './bootstrap.js';
import  Alpine from 'alpinejs';
import './styles/app.css';
import { createIcons } from 'lucide';
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */


// any CSS you import will output into a single css file (app.css in this case)
window.Alpine=Alpine;
Alpine.start();


document.addEventListener('DOMContentLoaded',()=>{
    createIcons();
});

