var map;
var icon = "resources/view/images/lixo7.png";
var myOptions = {
  zoom: 12,
  center: new google.maps.LatLng(-8.067489, -34.926224),
  styles: [
    {
      "featureType": "poi",
      "elementType": "labels",
      "stylers": [
        {
          "visibility": "off"
        }
      ]
    }
  ],
  mapTypeId: "roadmap",
};
map = new google.maps.Map(document.getElementById("map"), myOptions);

var markers = {};

var getMarkerUniqueId = function (lat, lng) {
  return lat + "_" + lng;
};

var getLatLng = function (lat, lng) {
  return new google.maps.LatLng(lat, lng);
};

var infoWindow = new google.maps.InfoWindow();
var addMarker = google.maps.event.addListener(map, "click", function (e) {
  var lat = e.latLng.lat();
  var lng = e.latLng.lng();
  var markerId = getMarkerUniqueId(lat, lng);
  var marker = new google.maps.Marker({
    position: getLatLng(lat, lng),
    sended: true,
    map: map,
    id: "marker_" + markerId,
    html: `<div class="container">
            <div class="row g-3" style="width:200px">
              <div class="col-12">
                <label for="name" class="form-label">Nome do local</label required>
                <input type="text" class="form-control" id="name" autocomplete="off">
              </div>
              <div class="col-12">
                <label for="type" class="form-label">Tipo: </label>
                <select id="type" class="form-select" aria-label="Tipos" >
                  <option selected>Selecione</option>
                  <option value="0" >Orgânico</option>
                  <option value="1" >Plastico</option>
                  <option value="2" >Eletrônico</option>
                  <option value="3" >Vidro</option>
                  <option value="4" >Metal</option>
                  <option value="5" >Papel</option>
                </select>
              </div>
              <a class="btn btn-sm btn-success" role="button" value='Send' onclick='saveData(${
                lat + "," + lng
              })'>Salvar</a>
            </div>
          </div>`,
  });
  markers[markerId] = marker;
  infoWindow.setContent(marker.html);
  infoWindow.open(map, marker);
  bindMarkerEvents(marker);
});

var bindMarkerEvents = function (marker) {
  google.maps.event.addListener(marker, "rightclick", function (point) {
    var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng());
    var marker = markers[markerId];
    if (marker.sended) {
      removeMarker(marker, markerId);
    }
  });
};

var removeMarker = function (marker, markerId) {
  marker.setMap(null);
  delete markers[markerId];
};

function saveData(lat, lng) {
  $.post(
    "hackaton/inserir",
    {
      name: document.getElementById("name").value,
      lat: lat,
      lng: lng,
      type: document.getElementById("type").value,
    },
    function (msg) {
      var markerId = getMarkerUniqueId(lat, lng);
      var manual_marker = markers[markerId];
      manual_marker.sended = false;
      manual_marker.setIcon(icon);
      infoWindow.close();
      infoWindow.setContent(msg);
      infoWindow.open(map, manual_marker);
    }
  );
}
