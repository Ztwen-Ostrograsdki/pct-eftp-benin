import './bootstrap';
import 'preline';
import {
    Carousel,
    initTWE,
  } from "tw-elements";
  
  initTWE({ Carousel });

import { Tooltip } from 'tw-elements';

const myTooltip = new Tooltip(document.getElementById('my-tooltip'));
