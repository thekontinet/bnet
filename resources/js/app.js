import './bootstrap';
import 'flowbite';
import { createIcons, icons } from 'lucide';
import mask from '@alpinejs/mask'
import Alpine from 'alpinejs';

Alpine.plugin(mask)

createIcons({ icons });

window.Alpine = Alpine;

Alpine.start();
