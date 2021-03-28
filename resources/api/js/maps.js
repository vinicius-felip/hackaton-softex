function initMap() {
  const image = [
    "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
    "http://maps.google.com/mapfiles/ms/icons/purple-dot.png",
    "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png",
  ];

  var map = new google.maps.Map(document.getElementById("map"), {
    center: new google.maps.LatLng(-7.978248518771446, -34.8768174365134),
    zoom: 12,
  });
  var infoWindow = new google.maps.InfoWindow();

  downloadUrl("resources/api/maps.php?status", function (data) {
    var xml = data.responseXML;
    var markers = xml.documentElement.getElementsByTagName("marker");
    Array.prototype.forEach.call(markers, function (markerElem) {
      var type = markerElem.getAttribute("type");
      var point = new google.maps.LatLng(
        parseFloat(markerElem.getAttribute("lat")),
        parseFloat(markerElem.getAttribute("lng"))
      );
      var infowincontent = document.createElement("div");
      var strong = document.createElement("strong");
      strong.textContent = type;
      infowincontent.appendChild(strong);
      infowincontent.appendChild(document.createElement("br"));
      var text = document.createElement("text");
      infowincontent.appendChild(text);
      var marker = new google.maps.Marker({
        map: map,
        position: point,
        icon: image[type],
      });
      marker.addListener("click", function () {
        infoWindow.setContent(infowincontent);
        infoWindow.open(map, marker);
      });
    });
  });
}

function downloadUrl(url, callback) {
  var request = window.ActiveXObject
    ? new ActiveXObject("Microsoft.XMLHTTP")
    : new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      request.onreadystatechange = doNothing;
      callback(request, request.status);
    }
  };

  request.open("GET", url, true);
  request.send(null);
}

function doNothing() {}
