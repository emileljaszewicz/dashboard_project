<?php
$currentCalendar = $data['currentCalendar'];
$dynamicCalendar = $data['dynamicCalendar'];
?>
<div class="text-center date"><?= $currentCalendar->currentDayName().' '. $currentCalendar->getCurrentDate()
    .' </br> '.$dynamicCalendar->currentMonthName().' '. $dynamicCalendar->getCurrentDate('Y')?></div>
    <?php $dynamicCalendar->tworz_kalendarz();?>

<form class="form-horizontal navButtons" data-month='<?=(int)$dynamicCalendar->getCurrentDate('m'); ?>' data-year='<?=(int)$dynamicCalendar->getCurrentDate('Y'); ?>'>
    <div class="form-inline">

            <ul class="pager">
                <li class="previous"><a href="#" ><span aria-hidden="true">&larr;</span><div class="responsiveHide"> Poprzedni</div></a></li>
                <label  class="form-inline control-label">Miesiąc</label>
                <li class="next"><a href="#"><div class="responsiveHide">Następny</div> <span aria-hidden="true">&rarr;</span></a></li>
            </ul>

    </div>
</form>
