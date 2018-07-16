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
    <script src='lib/moment.js'></script>
    <script src="lib/jqueryui/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="lib/bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.min.css" />
    <script src='lib/bootstrap-datetimepicker-master/build/js/bootstrap-datetimepicker.min.js'></script>
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="stylesheet" href='fullcalendar/fullcalendar.css' />
    <link rel="stylesheet" href="css/create_event.css">

    <script src='fullcalendar/fullcalendar.js'></script>
    <script>var pop="test";</script>
    <script>console.log(pop);</script>
    <script>console.log('<?php echo $_SESSION['adm_id'];?>');</script>
    <script>
        var uni = "<?php echo $_SESSION['school'];?>";
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
</script>
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
    <script>console.log('<?php echo $_SESSION['login_username'];?>');</script>
  </head>

  <body>

    <div class="sidenav">
    <script>console.log('<?php echo $_SESSION['login_username'];?>');</script>
      <!-- Code for checking if user is logged in or not -->
      <?php if(isset($_SESSION['logged_in'])): ?>
        <?php echo "<p>" . $_SESSION['login_user'] . "</p>"; ?>
        <a href="logout.php">Logout</a>
        <?php if(isset($_SESSION['admin'])): ?>
          <!-- <a href="adminDash.php">Admin Dashboard</a> -->
        <?php endif; ?>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="registerUser.php">Register</a>
      <?php endif; ?>
      <?php if(isset($_SESSION['logged_in'])): ?>
      <a href="registerRSO.php">Register an RSO</a>
      <a href="joinRSO.php">Join an RSO</a>
      <?php endif; ?>
    </div>
    <script>console.log('<?php echo $_SESSION['login_username'];?>');</script>
    <div class="main">
      <h1>EventU</h1>

      <!-- Code for checking if user is logged in or not -->
      <?php if(isset($_SESSION['logged_in'])): ?>
        <?php echo "<p>Welcome " . $_SESSION['login_user'] . "</p>"; ?>
      <?php endif; ?>
      <script>console.log('<?php echo $_SESSION['login_username'];?>');</script>
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

      <button id="add_event" style="<?php if($_SESSION['admin']){echo "visibility:visible";}else{echo "visibility:hidden";}?>">Create Event</button>
      <script>console.log('<?php echo $_SESSION['login_username'];?>');</script>

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
    <script src="https://maps.googleapis.com/maps/api/js?key=<API KEY HERE>&callback=initialize"></script>
    <div id="myModal" class="modal">
    <script>console.log('<?php echo $_SESSION['login_username'];?>');</script>
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Create Event</h2>
    </div>
    <div class="modal-body">
      Event Name: <input type="text" id="eventname" required /><br />
      Event Location: <input type="text" id="eventlocation" required /><br />
      Event Date/Time: <div class="container">
    <div class="row">
        <div class='col-sm-6'>
            <input type='text' class="form-control" id='startevent' />
        </div>
        <script type="text/javascript">
            $(function () {
                $('#startevent').datetimepicker();
            });
        </script>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class='col-sm-6'>
            <input type='text' class="form-control" id='endevent' />
        </div>
        <script type="text/javascript">
            $(function () {
                $('#endevent').datetimepicker();
            });
        </script>
    </div>
</div>
      Event Category: <input type="text" id="eventcategory" required /><br />
      Event RSO: <select id="rso_select">
        <option>None</option>
      <?php
      //require "config.php";
      $username1=$_SESSION['login_username'];
      $sql = "SELECT DISTINCT RSO_name FROM member_of_rso WHERE user_name = '$username1' ORDER BY RSO_name ASC";
      $result = mysqli_query($conn, $sql) or die("Bad SQL: $sql");
      while($row = mysqli_fetch_array($result)){
        ?>
        <option><?php echo $row["RSO_name"]; ?></option>
        <?php
      }

      ?>
      </select>
      Event Type: <select id="eventtype">
        <option>Public</option>
        <option>Private</option>
        <option>RSO Event</option>
    </select><br />
      Contact Email: <input type="text" id="eventemail" required /><br />
      Contact Number: <input type="text" id="eventnumber" required /><br />
      Event Description: <textarea rows="4" cols="50" id = "eventdescription" required></textarea>
    </div>
    <div class="modal-footer">
    <button id="submit_event">Create Event</button>
    </div>
  </div>

</div>
  </body>
  <script>

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
<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("add_event");
var subbtn = document.getElementById("submit_event");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
    
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
 //formatted1 = start.getFullYear() + "-" + (start.getMonth() + 1) + "-" + start.getDate() + "T" + start.getHours() + ":" + start.getMinutes() + ":" + start.getSeconds();

subbtn.onclick = function(){
  var startt = $('#startevent').data('DateTimePicker').date();
  var endd=$('#endevent').data('DateTimePicker').date();
  //console.log(start.format('YYYY-MM-DD hh:mm:ss'));
    var eventnm = document.getElementById('eventname').value;
    var eventloc = document.getElementById('eventlocation').value;
    var eventcat = document.getElementById('eventcategory').value;
    var eventtyp = document.getElementById('eventtype').value;
    var eventrso = document.getElementById('rso_select').value;
    var eventmail = document.getElementById('eventemail').value;
    var eventnum = document.getElementById('eventnumber').value;
    var eventdesc = document.getElementById('eventdescription').value;
    var eventstart = startt.format('YYYY-MM-DDThh:mm:ss');
    var eventend = endd.format('YYYY-MM-DDThh:mm:ss');
    console.log(eventnm, eventstart, eventend, eventcat, eventloc, eventnum, eventtyp, eventmail, eventdesc, eventrso);
    $.ajax({
      url:"create.php",
      type:"POST",
      data:{eventnm:eventnm, eventloc:eventloc, eventcat:eventcat, eventtyp:eventtyp, eventmail:eventmail, eventnum:eventnum, eventdesc:eventdesc, eventstart:eventstart, eventend:eventend, uni:uni, eventrso:eventrso},
      error:function(ts){
        console.log("<?php echo $_SESSION['adm_id']?>");
      }
    });
    modal.style.display = "none";
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
}
</script>
</html>
