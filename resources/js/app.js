import './bootstrap';
import chart from './chart';
import * as d3 from "d3";

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

var svg = chart();
d3Target.append(svg);