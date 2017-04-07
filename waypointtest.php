<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Waypoints in directions</title>
    <style>
      #right-panel {
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }

      #right-panel select, #right-panel input {
        font-size: 15px;
      }

      #right-panel select {
        width: 100%;
      }

      #right-panel i {
        font-size: 12px;
      }
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        text-align:center;
      }
      #map {
        height: 600px;
        width: 80%;
        border: 2px solid black;
        text-align: center;
      }
      #right-panel {
        margin: 20px;
        border-width: 2px;
        width: 20%;
        height: 400px;
        float: left;
        text-align: left;
        padding-top: 0;
      }#DriverForm{
        border: 2px solid black;
      }#submit{
        background-color: #4CAF50; /* Green */
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        transition-duration: 0.4s;
      }#confirm{
        background-color: #4CAF50; /* Green */
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        transition-duration: 0.4s;
      }
    </style>
  </head>
  <body>
    <h1> Route Information </h1>
    <div>
    <form method="post" action="DriverDataEntry.php" id="form">
      <table id="DriverForm"; cellspacing = "px"; cellpadding ="5%"; align ="center";>
      <tr>
        <td align="left"><b>Name:</b></td>
        <td align ="right"><input type="text" id="name" name ="name"></input></td>
        <td align ="left"><b>Email:</b></td>
        <td align="right"><input type= "text" id="email" name ="email"></td>
      </tr>
      <tr>
        <td align="left"><b>Departure:</b></td>
	      <td align ="right"><input type="text" id="start" name = "start"></input></td>
        <td align ="left"><b>Starting Date:</b></td>
        <td align="right"><input type= "date" id ="startDate" name ="startDate"></td>
      </tr>
      <tr>
        <td align="left"><b>Destination:</b></td>
        <td align="right"><select id="end" name ="end">
          <option value="22 Rue Eddy, quebec">22 Rue Eddy, Gatineau</option>
          <option value="2008 Wellington St, ottawa">Parliament</option>
          <option value="San Francisco, CA">San Francisco, CA</option>
          <option value="Los Angeles, CA">Los Angeles, CA</option>
        </select> </td>
        <td align="left"><b>Time:</b></td>
        <td align="right"><input type ="time" id="time" name ="time"></td>
      </tr>
      <tr>
        <td align="left"><label><b>Capacity:</b></label></td>
        <td align="right"><select name="capacity" id="capacity">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            </select></td>
        <td align="left"><label><b>Type of Music:</b></label></td>
          <td align="right"><select name="music" id="music">
            <option value="dmetal">Death Metal</option>
            <option value="opera">Opera</option>
            <option value="fmusic">Folk Music</option>
            <option value="Pmusic">Psychedelic Music</option>
            <option value="disco">Disco</option>
            <option value="Amusic">Ambiance Music</option>
            </select></td>
       </tr>    
    <tr>
      <td colspan="4" align="center"><button type="button" id="submit">Display</button></td>
      </tr>
    </table>
  </div>
  <br>
    <div id="map" align="center" style="margin:auto"></div>
    <div>

      <b>Additional Comments</b>
      <br>
        <textarea name="addcomments" id="addcomments"style="width:80%;height:150px;" placeholder="This space is reserved for any comments that you want to share to any potential passengers. Maximum: 400 characters." maxlength="400"></textarea>
        <br>
        <br>
        <button type="submit" id="confirm" name="confirm">Confirm and Post</button>
    </div>
    </form>
    <script>
      function initMap() {
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 10,
          center: {lat: 45.32, lng: -75.68} 
        });
		
        directionsDisplay.setMap(map);

        document.getElementById('submit').addEventListener('click', function() {
          calculateAndDisplayRoute(directionsService, directionsDisplay);
        });
      }

      function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        var waypts = [];

        directionsService.route({
          origin: document.getElementById('start').value,
          destination: document.getElementById('end').value,

          travelMode: 'DRIVING'
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
            var route = response.routes[0];
            var summaryPanel = document.getElementById('directions-panel');
            summaryPanel.innerHTML = '';
            // For each route, display summary information.
            for (var i = 0; i < route.legs.length; i++) {
              var routeSegment = i + 1;
              summaryPanel.innerHTML += '<b>Route Segment' +
                  '</b><br>';
              summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
              summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
              summaryPanel.innerHTML += route.legs[i].distance.text + '<br>';
              summaryPanel.innerHTML += route.legs[i].duration.text + '<br><br>';
            }
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2AjldRKq1iv_sl951s7uMdFmlDXtbSWI&callback=initMap">
    </script>
  </body>
</html>