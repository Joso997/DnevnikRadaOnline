import Home from './components/Home.vue';
import Skladiste from './components/Skladiste.vue';
import SkladisteDodaj from './components/SkladisteDodaj.vue';
import Evidencija from './components/Evidencija.vue';
import EvidencijaDodaj from './components/EvidencijaDodaj.vue';
import Mjesta from './components/Mjesta.vue';
import MjestaDodaj from './components/MjestaDodaj.vue';
import Kalendar from './components/Kalendar.vue'
import Statistika from './components/Statistika.vue'
import Login from './components/Login.vue'
import Register from './components/Register.vue'

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'skladiste',
        path: '/skladiste',
        component: Skladiste
    },
    {
        name: 'skladisteDodaj',
        path: '/skladiste/dodaj',
        component: SkladisteDodaj,
        props: true
    },
    {
        name: 'evidencija',
        path: '/evidencija',
        component: Evidencija
    },
    {
        name: 'evidencijaDodaj',
        path: '/evidencija/dodaj',
        component: EvidencijaDodaj,
        props: true
    },
    {
        name: 'mjesta',
        path: '/mjesta',
        component: Mjesta
    },
    {
        name: 'mjestaDodaj',
        path: '/mjesta/dodaj',
        component: MjestaDodaj,
        props: true
    },
    {
        name: 'kalendar',
        path: '/kalendar',
        component: Kalendar
    },
    {
        name: 'statistika',
        path: '/statistika',
        component: Statistika
    },
];