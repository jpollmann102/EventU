<!DOCTYPE html>
<html lang="en-US">

<html>
  <head>
    <title>EventU</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.bundle.min.js" integrity="sha384-CS0nxkpPy+xUkNGhObAISrkg/xjb3USVCwy+0/NMzd5VxgY4CMCyTkItmy5n0voC" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="stylesheet" href='fullcalendar/fullcalendar.css' />
    <script src='lib/jquery.min.js'></script>
    <script src='lib/moment.js'></script>
    <script src='fullcalendar/fullcalendar.js'></script>
    <script>$(function() {$('#calendar').fullCalendar({//put options and callbacks here
    defaultView:'month',
    header:{
      left:   'title',
      center: '',
      right:  'today,month,agendaWeek,agendaDay prev,next'
    },
    events: 'events.php',
    })}).on('click', '.fc-agendaWeek-button', function() {
});</script>
  </head>

  <body>
    <div class="sidenav">
      <!-- Code for checking if user is logged in or not -->
      <?php if(isset($_SESSION['logged_in'])): ?>
        <?php echo "<p>" . $_SESSION['login_user'] . "</p>" ?>
        <a href="logout.php">Logout</a>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="registerUser.php">Register</a>
      <?php endif; ?>
      <a href="registerRSO.php">Register an RSO</a>
    </div>

    <div class="main">
      <h1>EventU</h1>

      <!-- Code for checking if user is logged in or not -->
      <?php if(isset($_SESSION['logged_in'])): ?>
        <?php echo "<p>Welcome " . $_SESSION['login_user'] . "</p>" ?>
      <?php endif; ?>

      <!-- Put calendar here -->
      <div id='calendar'></div>

    </div>
  </body>

</html>
