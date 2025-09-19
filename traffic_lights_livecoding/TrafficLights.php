<?php
/**
 * У нас є звичайний світлофор, що працює в автоматичному режимі,
 * у нього чітка послідовність і тривалість сигналів.
 * Щодня, о 00:00:00, цикл скидається.
 * Світлофор починає свій цикл із зеленого світла:
 * 50 секунд - зелений
 * 5 секунд - жовтий
 * 30 секунд - червоний
 * Після червоного цикл негайно починається знову із зеленого.
 * Зробіть сервіс, який приймає на вхід час у вигляді строки, наприклад "14:25:31", і повертає значення світлофора.
 */

class TrafficLights
{
    const GREEN = 'зелений';
    const YELLOW = 'жовтий';
    const RED = 'червоний';

    public function __construct(
        private string $time,
        public int $greenSecondsTime,
        public int $yellowSecondsTime,
        public int $redSecondsTime,
        public int $extraSecondsTimeToCircle = 0,
    )
    {
    }

    public function setTime(string $time)
    {
        $this->time = $time;
    }

    public function getTime(): bool|int
    {
        return strtotime("1970-01-01 $this->time UTC");
    }

    public function getOneCircleLights(): int
    {
        return $this->yellowSecondsTime + $this->greenSecondsTime + $this->redSecondsTime + $this->extraSecondsTimeToCircle;
    }

    public function getCurrentLightAsMain(): string
    {
        $timeInSeconds = $this->getTime();
        $lastCircleSeconds = $timeInSeconds % $this->getOneCircleLights();

        if($lastCircleSeconds <= $this->greenSecondsTime){
            return self::GREEN;
        }elseif ($lastCircleSeconds <= ($this->greenSecondsTime + $this->yellowSecondsTime)){
            return self::YELLOW;
        }else{
            return self::RED;
        }
    }

    public function getCurrentLightAsSecondary(): string
    {
        $timeInSeconds = $this->getTime();
        $lastCircleSeconds = $timeInSeconds % $this->getOneCircleLights();

        if($lastCircleSeconds <= $this->redSecondsTime){
            return self::RED;
        }elseif ($lastCircleSeconds <= ($this->greenSecondsTime + $this->redSecondsTime)){
            return self::GREEN;
        }elseif ($lastCircleSeconds <= ($this->greenSecondsTime + $this->redSecondsTime)){
            return self::YELLOW;
        }else{
            return self::RED;
        }
    }

}