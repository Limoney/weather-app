<?php

namespace App\Tests;

use App\Entity\Measurement;
use PHPUnit\Framework\TestCase;

class MeasurementTest extends TestCase
{

    public function dataGetFahrenheit()
    {
        return [
            [0, 32],
            [-100, -148],
            [100, 212],
            [0.5, 32.9],
            [69, 156.2],   
            [420, 788],    
            [2137, 3878.6],
            [69.42, 156.956],     
            [42, 107.6],   
            [101, 213.8],  
        ];
    }

    /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit)
    {
        $measurement = new Measurement();
        $measurement->setTemperatureCelsius($celsius);

        $this->assertEquals($expectedFahrenheit, $measurement->getTemperatureFahrenheit());
    }
}
