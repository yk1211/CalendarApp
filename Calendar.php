<?php
 namespace CalendarApp;


 class Calendar{
   public $prev_month;
   public $year_month;
   public $next_month;
   private $_thisMonth;

   public function __construct(){
     //Getting dateTime object from URL ~/?t=yyyy-mm
      try{
        if(!isset($_GET['t']) || !preg_match('/\A\d{4}-\d{2}\z/', $_GET['t'])){
          throw new \Exception();
        }
        $this->_thisMonth = new \DateTime($_GET['t']);
      }
      catch(\Exception $e){
        $this->_thisMonth = new \DateTime('first day of this month');
      }

     $this->prev_month = $this->_createPrevLink();
     $this->next_month = $this->_createNextLink();
     $this->year_month = $this->_thisMonth -> format('F Y');
   }

   private function _createPrevLink(){
     $dt = clone $this->_thisMonth;
     return $dt->modify('-1 month')->format('Y-m');
   }
   private function _createNextLink(){
     $dt = clone $this->_thisMonth;
     return $dt->modify('+1 month')->format('Y-m');
   }

   public function show(){
     $prev = $this->_getPrev();
     $body = $this->_getBody();
     $next = $this->_getNext();
     $html = '<tr>' . $prev . $body . $next . '</tr>';
     echo $html;
   }

   //Previous Month setting
   private function _getPrev(){
     $prev = '';
     $lastDayofPreviousMonth = new \DateTime('last day of ' . $this->prev_month);
     while($lastDayofPreviousMonth->format('w') < 6){
       $prev = sprintf("<td class='gray'>%d</td>", $lastDayofPreviousMonth->format('d')) . $prev;
       $lastDayofPreviousMonth->sub(new \DateInterval('P1D'));
     }
     return $prev;
   }

   //This month setting
   private function _getBody(){
     $body = '';
     $period = new \DatePeriod(
     new \DateTime('first day of '. $this->year_month),
     new \DateInterval('P1D'),
     new \DateTime('first day of '. $this->year_month . '+1 month')
     );
     $today = new \DateTime('today');
     foreach($period as $day){
       if($day->format('w') === '0'){
         $body .= '</tr><tr>';
       }
       $today_class = $day->format('Y-m-d') === $today->format('Y-m-d')?'today': '';
       $body .= sprintf("<td class='week_%d %s'>%d</td>", $day->format('w'), $today_class, $day->format('d'));
     }
     return $body;
   }

   //Next month setting
   private function _getNext(){
     $next = "";
     $firstDayofNextMonth = new \DateTime('first day of ' . $this->year_month . '+1 month');
     while($firstDayofNextMonth->format('w') > 0){
       $next .= sprintf("<td class='gray'>%d</td>", $firstDayofNextMonth->format('d'));
       $firstDayofNextMonth->add(new \DateInterval('P1D'));
     }
     return $next;
   }
 }

 ?>
