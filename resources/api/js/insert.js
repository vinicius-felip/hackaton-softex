var infowindow;
var map;
var icon = [
  "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
  "http://maps.google.com/mapfiles/ms/icons/purple-dot.png",
];
var myOptions = {
  zoom: 12,
  center: new google.maps.LatLng(-7.978248518771446, -34.8768174365134),
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

var addMarker = google.maps.event.addListener(map, "click", function (e) {
  var lat = e.latLng.lat();
  var lng = e.latLng.lng();
  var markerId = getMarkerUniqueId(lat, lng);
  var marker = new google.maps.Marker({
    position: getLatLng(lat, lng),
    sended: true,
    map: map,
    animation: google.maps.Animation.DROP,
    id: "marker_" + markerId,
    html: `<div id='info_${markerId}'>
                <div class='map1'>
                    <p>Tipo de ponto de coleta:</p>
                    <select name="type" id="type">
                        <option value="0">Organico</option>
                        <option value="1">Papel</option>
                        <option value="2">Vidro</option>
                        <option value="3">Metal</option>
                    </select>
                    <button role="button" value='Send' onclick='saveData(${lat},${lng})'>Enviar</button>
                </div>
            </div>`,
  });
  markers[markerId] = marker;
  bindMarkerinfo(marker);
  bindMarkerEvents(marker);
});

var bindMarkerinfo = function (marker) {
  google.maps.event.addListener(marker, "click", function (point) {
    var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng());
    var marker = markers[markerId];
    if (marker.sended) {
      infowindow = new google.maps.InfoWindow();
      infowindow.setContent(marker.html);
      infowindow.open(map, marker);
    }
  });
};

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
  var type = document.getElementById("type").value;
  $.post(
    "hackaton/inserir",
    {
      lat: lat,
      lng: lng,
      type: document.getElementById("type").value,
    },
    function (msg) {
      var markerId = getMarkerUniqueId(lat, lng);
      var manual_marker = markers[markerId];
      manual_marker.sended = false;
      manual_marker.setIcon(icon[type]);
      infowindow.close();
      infowindow.setContent(
        `<div style=' color: purple; font-size: 25px;'>${msg}</div>`
      );
      infowindow.open(map, manual_marker);
    }
  );
}
