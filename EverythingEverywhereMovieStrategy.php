<?php
interface Move
{
    public function move(): void;
}
class UsualStrategy implements Move
{
    public function move(): void
    {
        echo 'Move like always did<br>';
    }
}
class NinjaStrategy implements Move
{
    public function move(): void
    {
        echo 'Hide like ninja<br>';
    }
}
class KungFuStrategy implements Move
{
    public function move(): void
    {
        echo 'Fight like kung fu master<br>';
    }
}
class Human
{
    private ?Move $strategy = null;
    public function setStrategy(Move $strategy)
    {
        $this->strategy = $strategy;
    }
    public function go()
    {
        return $this->strategy?->move();
    }

}

$hero = new Human();
$situations = array(
    ['danger' => true, 'hide' => true],
    ['danger' => true, 'hide' => false],
    ['danger' => false, 'hide' => true],
);
foreach ($situations as $situation) {
    if ($situation['danger']) {
        if ($situation['hide']) {
            $hero->setStrategy(new NinjaStrategy);
        } else {
            $hero->setStrategy(new KungFuStrategy);
        }
    } else {
        $hero->setStrategy(new UsualStrategy);
    }
    $hero->go();
}
