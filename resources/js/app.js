import './bootstrap'

import {
  clearForm,
  oddEven as oe,
  isNumber,
  makeCurrentLink,
  disableScroll,
  enableScroll
} from './helpers'

import Nprogress from 'nprogress'
import '/resources/css/nprogress.css'

import 'flowbite'

import Splide from '@splidejs/splide'
import '@splidejs/splide/css/skyblue';
// import '@splidejs/splide/css/sea-green';

import Alpine from 'alpinejs';

import '@fontsource/commissioner/300.css' // light
import '@fontsource/commissioner/500.css' // medium
// import '@fontsource/commissioner/600.css' // semibold
import '@fontsource/commissioner/700.css' // bold
import '@fontsource/commissioner/900.css' // black

import '@fontsource/montserrat/300.css'
import '@fontsource/montserrat/500.css'
import '@fontsource/montserrat/600.css'
import '@fontsource/montserrat/700.css'
import '@fontsource/montserrat/800.css'
import '@fontsource/montserrat/900.css'

window.Alpine = Alpine;

Alpine.start();

window.Splide = Splide
window.Nprogress = Nprogress

window.clearForm = clearForm
window.oe = oe

