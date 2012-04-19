var url = "http://68.97.98.48:8081/Demo/parkingMapData.php?q=lot";

function ParkingMapDataHandler(){
    var transferComplete = false;
    var jsonObject;
    var lotCoordinates = [];
    var spaceCoordinates = [];
    var lotPolygons = [];
    var spacePolygons = [];
    var lotRequestHandler = window.XMLHttpRequest? new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP");
    var spaceRequestHandler = window.XMLHttpRequest? new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP");
    this.setLotInfo = function(){
        transferComplete = false;
        lotRequestHandler.onreadystatechange = function () {
            if (lotRequestHandler.readyState === 4 && lotRequestHandler.status === 200){
               jsonObject = JSON.parse(lotRequestHandler.response);
               var length = jsonObject.length;
               var coordinates = [];
               var currentParkingLot;
               while(length-- > -1){
                   coordinates = jsonObject[length].coordinates.split(",");
                   currentParkingLot = jsonObject[length].lotId;
                   lotCoordinates[currentParkingLot] = [];
                   coordinates[1] = parseFloat(coordinates[0]);
                   coordinates[0] = parseFloat(coordinates[1]);
                   lotCoordinates[currentParkingLot].push(new google.maps.LatLng(coordinates[0],coordinates[0]));
               }
             //  alert(lotCoordinates[0][0][0]);
            }
        };
        lotRequestHandler.open("GET",url,true);
        lotRequestHandler.send();
    }
}

function initializeMap(){
var pHandler = new ParkingMapDataHandler();
pHandler.setLotInfo();
}