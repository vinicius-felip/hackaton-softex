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

  downloadUrl("resources/api/maps.php", function (data) {
    var xml = data.responseXML;
    var markers = xml.documentElement.getElementsByTagName("marker");
    Array.prototype.forEach.call(markers, function (markerElem) {
      var id = markerElem.getAttribute("id");
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
      var check = document.createElement("input");
      check.setAttribute("type", "checkbox");
      check.setAttribute("id", "checkbox");
      check.setAttribute("value", id);
      infowincontent.appendChild(check);
      var label = document.createElement("label");
      label.setAttribute("for", "checkbox");
      label.textContent = "checkbox";
      infowincontent.appendChild(label);
      var button = document.createElement("button");
      button.setAttribute("type", "button");
      button.setAttribute("onClick", "saveData()");
      button.appendChild(document.createTextNode("Salvar"));
      infowincontent.appendChild(button);
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
    function (msg) {
     console.log(msg);
    }
  );
}

function doNothing() {}
