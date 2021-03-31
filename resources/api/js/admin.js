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
    center: new google.maps.LatLng(-8.067489, -34.926224),
    zoom: 12,
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
    ]
  });

  
  var infoWindow = new google.maps.InfoWindow();

  downloadUrl("resources/api/maps.php", function (data) {
    var xml = data.responseXML;
    var markers = xml.documentElement.getElementsByTagName("marker");
    Array.prototype.forEach.call(markers, function (markerElem) {
      var id = markerElem.getAttribute("id");
      var type = markerElem.getAttribute("type");
      var status = markerElem.getAttribute("status");
      var point = new google.maps.LatLng(
        parseFloat(markerElem.getAttribute("lat")),
        parseFloat(markerElem.getAttribute("lng"))
      );
      var infowincontent = `<div class="container">
                                <div class="row g-3" style="width: 150px">
                                  <div class="col-12">
                                    <label>Tipo: </label>
                                    <select  id="type" disabled>
                                      <option>Indefinido</option>
                                      <option value="0" ${type == '0' ? 'selected': ''}>Orgânico</option>
                                      <option value="1" ${type == '1' ? 'selected': ''}>Plastico</option>
                                      <option value="2" ${type == '2' ? 'selected': ''}>Eletrônico</option>
                                      <option value="3" ${type == '3' ? 'selected': ''}>Vidro</option>
                                      <option value="4" ${type == '4' ? 'selected': ''}>Metal</option>
                                      <option value="5" ${type == '5' ? 'selected': ''}>Papel</option>
                                    </select>
                                  </div>
                                  <div class="col-12">
                                    <label> Ativo: </label>
                                    <input type="checkbox" id="checkbox" value="${id}" ${
                                      status == "on" ? "checked" : ""
                                    }>
                                  </div>
                                  <button class="btn-success" role="button" value='Send' onclick='saveData()'>Salvar</button>
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

function saveData() {
  var confirmed = document.getElementById("checkbox").checked ? 1 : 0;
  var id = document.getElementById("checkbox").value;
  $.post(
    "hackaton/admin",
    {
      status: confirmed == 1 ? "on" : "off",
      id: id,
    },
    function () {
      initMap();
    }
  );
}

function doNothing() {}
