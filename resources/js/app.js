import "./bootstrap";
import { createIcons, icons } from "lucide";
createIcons({ icons });

import "leaflet/dist/leaflet.css";
import L from "leaflet";
window.L = L;
