<?php
require 'TrafficLights.php';

class TrafficLightsFactory{


    public function createWorkadayTrafficLightMain(string $time): TrafficLights{
        return new TrafficLights($time, 65, 3, 42);
    }
    public function createWorkadayTrafficLightSecondary(string $time): TrafficLights{
        return new TrafficLights($time, 35, 3, 70, 2);
    }

    public function createWeekendTrafficLightMain(string $time): TrafficLights{
        return new TrafficLights($time, 55, 3, 32);
    }
    public function createWeekendTrafficLightSecondary(string $time): TrafficLights{
        return new TrafficLights($time, 25, 3, 60, 2);
    }
}