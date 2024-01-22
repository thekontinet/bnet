import './bootstrap';
import 'flowbite';
import { createIcons, icons } from 'lucide';
import mask from '@alpinejs/mask'
import Alpine from 'alpinejs';

Alpine.plugin(mask)

createIcons();

window.Alpine = Alpine;

Alpine.start();
