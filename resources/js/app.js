import './bootstrap';


import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';

// Configuration de Notyf
const notyf = new Notyf({
    duration: 3000, 
    position: {
        x: 'right', 
        y: 'top',  
    },
    ripple: false,
    dismissible: true,  
    types: [
        {
            type: 'success',
            background: '#090909',
            className: 'notyf-success border-success border', 
            icon: false, 
            color: '#dddddd',
        },
        {
            type: 'error',
            background: '#090909',
            className: 'notyf-error border-danger border', 
            icon: false,
            color: '#dddddd',
        },
    ],
    background: '#090909',  // Couleur de fond par défaut (sera remplacée par les types)
    icon: {
        className: 'custom-icon', 
        tagName: 'span',  
        color: '#dddddd'    
    }
});

window.notyf = notyf;
