<?php
interface BoxCreator
{
    public function create(): string;
}

class Box implements BoxCreator
{
    public function __construct (private int $height = 10, private int $width = 10){
        
    }

    public function create(): string
    {
        return 'Box (' . $this->height . ' X ' . $this->width . ') ';
    }
}

class Decorator implements BoxCreator
{
    protected $box;
    public function __construct(BoxCreator $box)
    {
        $this->box = $box;
    }
    public function create(): string
    {
        return $this->box->create();
    }
}

class GoldenDotsDecorator extends Decorator
{
    public function create(): string
    {
        return parent::create() . 'with Golden Dots ';
    }
}

class RainbowsDecorator extends Decorator
{
    public function create(): string
    {
        return parent::create() . 'with Rainbows ';
    }
}

class SilverStringsDecorator extends Decorator
{
    public function create(): string
    {
        return parent::create() . 'with Silver Strings ';
    }
}
class FlowersDecorator extends Decorator
{
    public function create(): string
    {
        return parent::create() . 'with Flowers ';
    }
}

$box = new Box(5, 5);
$decorator = new GoldenDotsDecorator($box);
$decorator2 = new RainbowsDecorator($decorator);
echo $decorator2->create();
echo '<br>';

$box = new Box(4, 5);
$decorator = new GoldenDotsDecorator($box);
$decorator2 = new FlowersDecorator($decorator);
$decorator3 = new SilverStringsDecorator($decorator2);
echo $decorator3->create();
