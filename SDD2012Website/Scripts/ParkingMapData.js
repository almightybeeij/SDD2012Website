var url = "http://68.97.98.48:8081/parkingMapData.php?q=lot";
var spaceurl = "http://68.97.98.48:8081/parkingMapData.php?q=space";
var map;


var UCOMapStyles = [
    {
        elementType:"labels",
        stylers:[
            { visibility:"off" }
        ]
    },
    {
        featureType:"landscape.man_made",
        stylers:[
            { visibility:"off" }
        ]
    },
    {
        featureType:"road",
        stylers:[
            { gamma:0.52 },
            { visibility:"on" },
            { saturation:-96 },
            { lightness:11 }
        ]
    },
    {
        featureType:"poi",
        stylers:[
            { hue:"#3bff00" },
            { lightness:100 },
            { saturation:-100 }
        ]
    }
];


//Used to retrieve data from server to build graphical overlays on the Google map object 'map'.
function ParkingMapDataHandler(mapObject){
    var map = mapObject;
    var jsonObject;
    var spaceBuffer;
    var lotCoordinates = new Array();
    var spaceCoordinates = new Array();
    var lotPolygons = new Array();
    var spacePolygons = new Array();
    var lotRequestHandler = window.XMLHttpRequest? new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP");
    var spaceRequestHandler = window.XMLHttpRequest? new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP");
    this.setLotInfo = function(){
        lotRequestHandler.onreadystatechange = function () {
            if (lotRequestHandler.readyState === 4 && lotRequestHandler.status === 200){
              jsonObject = JSON.parse(lotRequestHandler.responseText);
              var resultIndex = jsonObject.length;
              var coordinates;
              var currentParkingLot;
              var previousParkingLot = '';
              while(--resultIndex > -1){
                  coordinates = jsonObject[resultIndex].coordinates.split(",");
                  currentParkingLot = jsonObject[resultIndex].lotId;
                  if(currentParkingLot != previousParkingLot){
                      lotCoordinates[currentParkingLot] = new Array();
                      lotPolygons[currentParkingLot] = new google.maps.Polygon(
                      {
                        strokeColor:"black",
                        strokeOpacity:0.8,
                        strokeWeight:1,
                        fillOpacity:0.35,
                        zIndex:0
                      });
                      if(jsonObject[resultIndex].studentLot == '1')
                          lotPolygons[currentParkingLot].setOptions({fillColor: "#FF0000"});
                      else
                           lotPolygons[currentParkingLot].setOptions({fillColor:"2C2FD1"});
                  }
                  previousParkingLot = currentParkingLot;
                  coordinates[0] = parseFloat(coordinates[0]);
                  coordinates[1] = parseFloat(coordinates[1]);
                  lotCoordinates[currentParkingLot].push( new google.maps.LatLng((coordinates[1]),(coordinates[0])));
               }
              var length = lotPolygons.length;
              while(lotPolygons[--length] != undefined){
                  lotPolygons[length].setOptions({paths:lotCoordinates[length]});
                  lotPolygons[length].setMap(map);
              }
            }
        };
        lotRequestHandler.open("GET",url,true);
        lotRequestHandler.send();
    };
    this.setSpaceInfo = function(){
        spaceRequestHandler.onreadystatechange = function () {
            if (spaceRequestHandler.readyState === 4 && spaceRequestHandler.status === 200){
                spaceBuffer = JSON.parse(spaceRequestHandler.responseText);
                var resultIndex = spaceBuffer.length;
                var coordinates = new Array();
                var color;
                var tmp;
                while(--resultIndex > -1){
                    spaceCoordinates[resultIndex] = new Array();
                    tmp = spaceBuffer[resultIndex];
                    var i = 5;
                    while(i-- > 1){
                        coordinates = tmp[i].split(",");
                        coordinates[0] = parseFloat(coordinates[0]);
                        coordinates[1] = parseFloat(coordinates[1]);
                        spaceCoordinates[resultIndex].push(new google.maps.LatLng((coordinates[1]),(coordinates[0])));
                    }

                    if(tmp.available == '1')
                       color = "#444444";
                    else if(tmp.studentLot =='1')
                       color = "FF0000";
                    else
                        color = "2C2FD1";

                    spacePolygons[resultIndex] = new google.maps.Polygon(
                        {
                            paths:spaceCoordinates[resultIndex],
                            strokeColor:"black",
                            strokeOpacity:0.8,
                            strokeWeight:.5,
                            fillColor:color,
                            fillOpacity:0.80,
                            zIndex:1
                        }
                    );
                    spacePolygons[resultIndex].setMap(map);
                }
            }
        };

        spaceRequestHandler.open("GET",spaceurl,true);
        spaceRequestHandler.send();

    };
}

function initializeMap(){
    var myOptions = {
        center:new google.maps.LatLng(35.653975, -97.472795),
        zoom:17,
        mapTypeId:google.maps.MapTypeId.ROADMAP,
        styles: UCOMapStyles
    };

    var map = new google.maps.Map(document.getElementById("content"),
        myOptions);

    var pHandler = new ParkingMapDataHandler(map);
    pHandler.setLotInfo();
    pHandler.setSpaceInfo();

}