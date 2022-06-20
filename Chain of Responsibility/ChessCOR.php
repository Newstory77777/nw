<?php

//Chain of responsibility

interface Checker
{
    public function setNext(Checker $checker): Checker;

    public function check(int $curX, int $curY, int $x, int $y): bool;
}

abstract class AbstractChecker implements Checker
{
    private $nextChecker;

    public function setNext(Checker $checker): Checker
    {
        $this->nextChecker = $checker;

        return $checker;
    }

    public function check(int $curX, int $curY, int $x, int $y): bool
    {
        if ($this->nextChecker) {
            return $this->nextChecker->check($curX, $curY, $x, $y);
        }

        return false;
    }
}

class VerticalHorizontalChecker extends AbstractChecker
{
    public function check(int $curX, int $curY, int $x, int $y): bool
    {
        if ($curX == $x || $curY == $y) {
            return true;
        } else {
            return parent::check($curX, $curY, $x, $y);
        }
    }
}

class DiagonalChecker extends AbstractChecker
{
    public function check(int $curX, int $curY, int $x, int $y): bool
    {
        if (abs($curX - $x) == abs($curY - $y)) {
            return true;
        } else {
            return parent::check($curX, $curY, $x, $y);
        }
    }
}

abstract class ChessFigure {
    private int $curX;
    private int $curY;
    private Checker $behavior;
    public function __construct (int $curX, int $curY){
        $this->curX = ($curX >= 0 && $curX <= 7) ? $curX : 0;
        $this->curY = ($curY >= 0 && $curY <= 7) ? $curY : 0;
        $this->behavior = $this->getBehavior();
    }
    public function move (int $x, int $y): bool {
         return $this->behavior->check($this->curX, $this->curY, $x, $y);
        
    }
    public function getChessFigureInfo () : string{
        return static::class.' ('. $this->curX.', '.$this->curY.') ';
    }
    abstract protected function getBehavior():Checker;
}

class Rook extends ChessFigure {
    protected function getBehavior ():Checker{
        return new VerticalHorizontalChecker();
    }
}
class Bishop extends ChessFigure {
    protected function getBehavior ():Checker{
        return new DiagonalChecker();
    }
}
class Queen extends ChessFigure {
    protected function getBehavior ():Checker{
        $behavior = new VerticalHorizontalChecker;
        return $behavior->setNext (new DiagonalChecker);
    }
}
// Client code
$chess = array (
    new Bishop (0,0),
    new Rook (0,7),
    new Queen (3,3)
);
$x = 0; 
$y = 5;
foreach ($chess as $figure){
    if ($figure->move($x,$y)){
        echo $figure->getChessFigureInfo(). ' can go to ('. $x .', '. $y. ')<br/>';
    } else {
        echo $figure->getChessFigureInfo(). ' CAN NOT go to ('. $x .', '. $y. ')<br/>';
    }
}
