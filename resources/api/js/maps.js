function initMap() {
  const image = [
    "resources/view/images/lixo1.png",
    "resources/view/images/lixo2.png",
    "resources/view/images/lixo3.png",
    "resources/view/images/lixo4.png",
    "resources/view/images/lixo5.png",
    "resources/view/images/lixo6.png",
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
      var infowincontent =`<div class="container">
                            <div class="row g-1" style="width: 150px">
                              <div class="col-12">
                                <label>Tipo: </label>
                                <select  id="type" disabled>
                                  <option value="0" ${type == '0' ? 'selected': ''}>Orgânico</option>
                                  <option value="1" ${type == '1' ? 'selected': ''}>Plastico</option>
                                  <option value="2" ${type == '2' ? 'selected': ''}>Eletrônico</option>
                                  <option value="3" ${type == '3' ? 'selected': ''}>Vidro</option>
                                  <option value="4" ${type == '4' ? 'selected': ''}>Metal</option>
                                  <option value="5" ${type == '5' ? 'selected': ''}>Papel</option>
                                </select>
                              </div>
                              <div class="col-12">
                                <label>Nome: </label>
                              </div>
                            </div>
                          </div>`;
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
