import './bootstrap';

import Alpine from 'alpinejs';
import { Html5Qrcode } from 'html5-qrcode';
import { registerControllers } from './controllers';

window.Alpine = Alpine;
window.Html5Qrcode = Html5Qrcode;

registerControllers(Alpine);

Alpine.start();
