<?php
require 'TrafficLightsFactory.php';

class TrafficLightsController{

    private function isWeekend(): bool
    {
        return date('N') > 5;
    }

    public function printTwoTrafficLightsValues(string $time): void
    {
        $trafficLightsFactory = new TrafficLightsFactory();

        if($this->isWeekend()){
            echo 'Main: '.$trafficLightsFactory->createWeekendTrafficLightMain($time)->getCurrentLightAsMain();
            echo 'Secondary: '.$trafficLightsFactory->createWeekendTrafficLightSecondary($time)->getCurrentLightAsSecondary();
        }else{
            echo 'Main: '.$trafficLightsFactory->createWorkadayTrafficLightMain($time)->getCurrentLightAsMain();
            echo 'Secondary: '.$trafficLightsFactory->createWorkadayTrafficLightSecondary($time)->getCurrentLightAsSecondary();
        }

    }


}