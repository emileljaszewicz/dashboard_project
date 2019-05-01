<?php
namespace plugins\userCalendar\Classes;


use Entities\CalendarEvents;
use library\SessionManager;

class Calendar
{
    function __construct($miesiac, $rok){
        $this->miesiac = $miesiac;
        $this->rok = $rok;
    }
    function ile_dni_w_miesiacu(){
        return date("t", mktime(0,0,0,$this->miesiac,1,$this->rok));
    }
    function dni_do_pierwszego_dnia_miesiaca(){
        return date("N", mktime(0,0,0,$this->miesiac,1,$this->rok))-1;
    }
    function dzien_tygodnia($dzienmiesiaca){

        if(($this->dni_do_pierwszego_dnia_miesiaca()+$dzienmiesiaca)%7 == 1){
            echo '<p>';
        }

        if(($this->dni_do_pierwszego_dnia_miesiaca()+$dzienmiesiaca)%7 == 0){
            echo $this->ostatni_dzien_miesiaca($dzienmiesiaca).'</p>';
        }
        else{
            echo $this->ostatni_dzien_miesiaca($dzienmiesiaca);
        }

    }
    function ostatni_dzien_miesiaca($dzien){
        if($dzien <= $this->ile_dni_w_miesiacu()){
            return $this->sprawdz_wydarzenie($dzien);
        }
        else{
            return '<div class="kalendarz_pole" >&nbsp;</div>';
        }
    }
    function sprawdz_wydarzenie($dzien){
        $sessionManager = new SessionManager();
        $existedEvent = new CalendarEvents(['userId' => $sessionManager->getSessionData('userId'), 'eventDate' => $this->rok."-".$this->miesiac."-".$dzien]);

        if(!empty($existedEvent->getEventId())){
            return '<div class="kalendarz_pole event" >'.$dzien.'</div>';
        }
        else{
            return '<div class="kalendarz_pole" >'.$dzien.'</div>';
        }
        return '<div class="kalendarz_pole" >'.$dzien.'</div>';
    }

    function dodaj_dni_iteracji(){
        return 7-date("N",strtotime($this->rok."-".$this->miesiac."-".$this->ile_dni_w_miesiacu()));
    }
    function tworz_kalendarz(){
        $licz = 1;
        $dni_przed_pierwszym = 1;
        echo '<div id="kalendarz_kontener">';
        echo '<div id="dni_tygodnia">
        <p>
        <div class="dzien_tygodnia">Pn</div>
        <div class="dzien_tygodnia">Wt</div>
        <div class="dzien_tygodnia">Śr</div>
        <div class="dzien_tygodnia">Czw</div>
        <div class="dzien_tygodnia">Pt</div>
        <div class="dzien_tygodnia">So</div>
        <div class="dzien_tygodnia">Nd</div>
        </p>
    </div>';
        echo '<div id="dni_miesiaca">';
        while($licz <= $this->ile_dni_w_miesiacu()+$this->dodaj_dni_iteracji()){
            if($dni_przed_pierwszym-$this->dni_do_pierwszego_dnia_miesiaca() <= 0){
                echo '<div class="kalendarz_pole" >&nbsp;</div>';

                $dni_przed_pierwszym++;
            }
            else{

                $this->dzien_tygodnia($licz);
                $licz++;
            }

        }
        echo '</div></div>';
    }
    public function getCurrentDate($dateFormat = 'd / m / Y'){
        return date($dateFormat, mktime(0, 0, 0, $this->miesiac, date('d'), $this->rok));
    }
    public function currentDayName(){
        return date('l', mktime(0, 0, 0, $this->miesiac, date('d'), $this->rok));
    }
    public function currentMonthName(){
        return date('F', mktime(0, 0, 0, $this->miesiac, date('d'), $this->rok));
    }
}
