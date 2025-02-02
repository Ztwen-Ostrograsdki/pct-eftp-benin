import './bootstrap';
import "/node_modules/flag-icons/css/flag-icons.min.css";
import 'preline';
import {
    Carousel,
    initTWE,
  } from "tw-elements";
  
  initTWE({ Carousel });

import { Tooltip } from 'tw-elements';

import { Modal } from 'flowbite';

import { Drawer } from 'flowbite';

const myTooltip = new Tooltip(document.getElementById('my-tooltip'));


document.addEventListener('livewire:navigated', () =>{
  initFlowbite();
});






