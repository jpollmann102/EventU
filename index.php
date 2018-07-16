<!DOCTYPE html>
<html lang="en-US">

<?php
  require "config.php";
  session_set_cookie_params(0);
  session_start();
?>

<html>
  <head>
    <title>EventU</title>
    <script src='lib/jquery.min.js'></script>
    <link rel="stylesheet" href="lib/jqueryui/jquery-ui.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.bundle.min.js" integrity="sha384-CS0nxkpPy+xUkNGhObAISrkg/xjb3USVCwy+0/NMzd5VxgY4CMCyTkItmy5n0voC" crossorigin="anonymous"></script>
    <script src="lib/jqueryui/jquery-ui.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="stylesheet" href='fullcalendar/fullcalendar.css' />
    <script src='lib/moment.js'></script>
    <script src='fullcalendar/fullcalendar.js'></script>

<script> function initialize(addressInput) {
  var geocoder = new google.maps.Geocoder();
  geocoder.geocode({address: addressInput}, function(results, status){

    if (status == google.maps.GeocoderStatus.OK) {
    var myResult = results[0].geometry.location; // reference LatLng value

    var mapOptions = {
      center: myResult,
      zoom: 18,
      mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
  var marker = new google.maps.Marker({
  position:myResult,
  animation:google.maps.Animation.BOUNCE
  });

  marker.setMap(map);
    }
    else{
    }
  })

}
</script>
  </head>

  <body>

    <div class="sidenav">

      <!-- Code for checking if user is logged in or not -->
      <?php if(isset($_SESSION['logged_in'])): ?>
        <?php echo "<p>" . $_SESSION['login_user'] . "</p>"; ?>
        <a href="logout.php">Logout</a>
        <?php if(isset($_SESSION['admin'])): ?>
          <a href="adminDash.php">Admin Dashboard</a>
        <?php endif; ?>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="registerUser.php">Register</a>
      <?php endif; ?>
      <a href="registerRSO.php">Register an RSO</a>
      <a href="joinRSO.php">Join an RSO</a>

    </div>

    <div class="main">
      <h1>EventU</h1>

      <!-- Code for checking if user is logged in or not -->
      <?php if(isset($_SESSION['logged_in'])): ?>
        <?php echo "<p>Welcome " . $_SESSION['login_user'] . "</p>"; ?>
      <?php endif; ?>

      <label>Select University:</label>
      <select id="uni_select">
      <?php
      //require "config.php";
      $sql = "SELECT DISTINCT university_name FROM part_of_university ORDER BY university_name ASC";
      $result = mysqli_query($conn, $sql) or die("Bad SQL: $sql");
      while($row = mysqli_fetch_array($result)){
        ?>
        <option><?php echo $row["university_name"]; ?></option>
        <?php
      }

      ?>
      </select>

      <!-- Put calendar here -->
      <div id='calendar'></div>

      <div id="eventContent" title="Event Details" style="display:none;">

        Start: <span id="startTime"></span><br>
        End: <span id="endTime"></span><br>
        Location: <span id="eventLocation"></span><br><br>

        <h5>Contact Information</h5>
        Email: <span id="eventEmail"></span><br>
        Phone Number: <span id="eventNum"></span><br><br>

        <h5>Description</h5>
        <p id="eventInfo"></p><br><br>
        <div id="map-canvas" style="width:400px;height:400px"></div>

      </div>

    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=<PUT API KEY HERE>&callback=initialize"></script>
  </body>
  <script>
    var uni = "University of Central Florida";
    var dat;
    $.ajax({
      url:"events.php",
      type:"POST",
      dataType: "json",
      data:{uni:uni},
      success:function(data){
        dat=data
      }
    });



    $(function() {$('#calendar').fullCalendar({//put options and callbacks here
    defaultView:'month',
    header:{
      left:   'title',
      center: '',
      right:  'today,month,agendaWeek,agendaDay prev,next'
    },
    events: dat,
    //events: 'events.php',
    eventRender: function (event, element) {
        element.attr('href', 'javascript:void(0);');
        element.click(function() {
            $("#startTime").html(moment(event.start).format('MMM Do h:mm A'));
            $("#endTime").html(moment(event.end).format('MMM Do h:mm A'));
            $("#eventInfo").html(event.description);
            $("#eventLocation").html(event.location);
            $("#eventEmail").html(event.email);
            $("#eventNum").html(event.phone);
            $("#eventContent").dialog({ modal: true, title: event.title, width:440});
            initialize(String(event.location));
        });
    }
    })}).on('click', '.fc-agendaWeek-button', function() {
});
$("#uni_select").change(function(){
      uni=this.value;
      $.ajax({
      url:"events.php",
      type:"POST",
      dataType: "json",
      data:{uni:uni},
      success:function(data){
        dat=data
      }
    });
      $('#calendar').fullCalendar('destroy');
      $(function() {$('#calendar').fullCalendar({//put options and callbacks here
    defaultView:'month',
    header:{
      left:   'title',
      center: '',
      right:  'today,month,agendaWeek,agendaDay prev,next'
    },
    events: dat,
    //events: 'events.php',
    eventRender: function (event, element) {
        element.attr('href', 'javascript:void(0);');
        element.click(function() {
            $("#startTime").html(moment(event.start).format('MMM Do h:mm A'));
            $("#endTime").html(moment(event.end).format('MMM Do h:mm A'));
            $("#eventInfo").html(event.description);
            $("#eventLocation").html(event.location);
            $("#eventEmail").html(event.email);
            $("#eventNum").html(event.phone);
            $("#eventContent").dialog({ modal: true, title: event.title, width:440});
            initialize(String(event.location));
        });
    }
    })}).on('click', '.fc-agendaWeek-button', function() {
});
    });

</script>

</html>
