<?php

interface Observer
{
    public function update();
}

interface Observable
{
    public function add(Observer $o);

    public function remove(Observer $o);

    public function notify();
}

class WeatherStation implements Observable
{
    public SplObjectStorage $observers;

    private int $temperature = 0;

    public function __construct()
    {
        $this->observers = new SplObjectStorage();
    }

    public function add(Observer $o)
    {
        $this->observers->attach($o);
    }

    public function remove(Observer $o)
    {
        $this->observers->detach($o);
    }

    public function notify()
    {
        foreach ($this->observers as $o) {
            $o->update();
        }
    }

    public function showInfo(): int
    {
        return $this->temperature;
    }

    /**
     * @throws Exception
     */
    public function changeState()
    {
        $this->temperature = random_int(-50, 50);
        $this->notify();
    }
}

class PhoneDisplay implements Observer
{
    public function __construct(public WeatherStation $weatherStation)
    {
    }

    public function update()
    {
        echo 'Weather changed, the temperature is ' . $this->weatherStation->showInfo() . '<br>';
    }
}

$weatherStation1 = new WeatherStation();
$phone1 = new PhoneDisplay($weatherStation1);
$phone2 = new PhoneDisplay($weatherStation1);
$weatherStation1->add($phone1);
$weatherStation1->add($phone2);
$weatherStation1->changeState();
$weatherStation1->changeState();

