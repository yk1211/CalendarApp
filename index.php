<?php
 require 'Calendar.php';

 function h($s){
   return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
 }

 $cal = new CalendarApp\Calendar();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8' />
  <title>Calender</title>
  <link rel='stylesheet' href='style.css'>
</head>
<body>
  <table>
    <thead>
      <tr>
        <th><a href='/?t=<?php echo h($cal->prev_month); ?>' >&laquo</a></th>
        <th colspan='5'><?php echo h($cal->year_month); ?></a></th>
        <th><a href='/?t=<?php echo h($cal->next_month); ?>' >&raquo</a></th>
      </tr>
    </thead>
    <tbody>
    <tr>
        <td>Sun</td>
        <td>Mon</td>
        <td>Tue</td>
        <td>Wed</td>
        <td>Thu</td>
        <td>Fri</td>
        <td>Sat</td>
    </tr>
    <tr>
        <?php $cal->show();?>
    </tr>

  </tbody>
    <tfoot>
      <th colspan='7'><a href='/'>Today</a></tr>
    </tfoot>
  </table>

</body>
</html>
