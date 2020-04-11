var mymap = L.map('mapid').setView([51.891490, 4.485220], 15);

var marker = L.marker([51.891490, 4.485220], {

}).addTo(mymap);
marker.bindPopup("<b>Thuisgeknipt").openPopup();



L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoicmVuYXRvMTIzIiwiYSI6ImNrOHQxd3dwejBsMG8zbXA5eXA5cm5seDMifQ.DFwDXVIyHmN3X9Q682I4Bg', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoicmVuYXRvMTIzIiwiYSI6ImNrOHQxd3dwejBsMG8zbXA5eXA5cm5seDMifQ.DFwDXVIyHmN3X9Q682I4Bg'
}).addTo(mymap);

