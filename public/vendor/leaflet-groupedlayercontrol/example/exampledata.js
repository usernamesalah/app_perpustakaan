(function() {

  var basemaps = {
	'Mapbox Dark': L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiaGFuYWZpMDciLCJhIjoiY2tubmNiY2N6MDV3ZDJvcGdrMXh3aTh3eSJ9.gHOs5sTl8lPwP-IzHYgH_g', {
	  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
	  maxZoom: 18,
	  id: 'mapbox/dark-v10',
	  tileSize: 512,
	  zoomOffset: -1,
	}),
	'Street Map': L.tileLayer("https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png", {
	  maxZoom: 18,
	  alt: "open Topo",
	  attribution: 'Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
	}),
    'Mapbox Street': L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiaGFuYWZpMDciLCJhIjoiY2tubmNiY2N6MDV3ZDJvcGdrMXh3aTh3eSJ9.gHOs5sTl8lPwP-IzHYgH_g', {
	  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
	  maxZoom: 18,
	  id: 'mapbox/streets-v11',
	  tileSize: 512,
	  zoomOffset: -1,
	}),
    'Mapbox Satellite': L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiaGFuYWZpMDciLCJhIjoiY2tubmNiY2N6MDV3ZDJvcGdrMXh3aTh3eSJ9.gHOs5sTl8lPwP-IzHYgH_g', {
	  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
	  maxZoom: 18,
	  id: 'mapbox/satellite-streets-v11',
	  tileSize: 512,
	  zoomOffset: -1,
	})
  };

  var groups = {
    cities: new L.LayerGroup(),
    restaurants: new L.LayerGroup(),
    dogs: new L.LayerGroup(),
    cats: new L.LayerGroup()
  };

  window.ExampleData = {
    LayerGroups: groups,
    Basemaps: basemaps
  };

}());
