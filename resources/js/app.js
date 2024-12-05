import './bootstrap';
import "/node_modules/flag-icons/css/flag-icons.min.css";
import 'preline';
import {
    Carousel,
    initTWE,
  } from "tw-elements";
  
  initTWE({ Carousel });

import { Tooltip } from 'tw-elements';

const myTooltip = new Tooltip(document.getElementById('my-tooltip'));


