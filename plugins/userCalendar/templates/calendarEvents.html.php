<?php
$currentCalendar = $data['currentCalendar'];
$dynamicCalendar = $data['dynamicCalendar'];
?>
<div class="text-center" style="font-size: 20px"><?= $currentCalendar->currentDayName().' '. $currentCalendar->getCurrentDate()
    .' </br> '.$dynamicCalendar->currentMonthName().' '. $dynamicCalendar->getCurrentDate('Y')?></div>
    <?php $dynamicCalendar->tworz_kalendarz();?>

<form class="form-horizontal" data-month='<?=(int)$dynamicCalendar->getCurrentDate('m'); ?>' data-year='<?=(int)$dynamicCalendar->getCurrentDate('Y'); ?>'>
    <div class="form-inline">
        <div style="width:300px">
            <ul class="pager">
                <li class="previous"><a href="#" style="background:#f2f2f2"><span aria-hidden="true">&larr;</span> Poprzedni</a></li>
                <label for="inputPassword" class="form-inline control-label">Miesiąc</label>
                <li class="next"><a href="#" style="background:#f2f2f2">Następny <span aria-hidden="true">&rarr;</span></a></li>
            </ul>
        </div>
    </div>
</form>
