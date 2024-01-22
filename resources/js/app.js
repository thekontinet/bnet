import './bootstrap';
import 'flowbite';
import mask from '@alpinejs/mask'
import Alpine from 'alpinejs';

Alpine.plugin(mask)

window.Alpine = Alpine;

Alpine.start();
