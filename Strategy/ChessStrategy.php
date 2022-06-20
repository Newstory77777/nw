<?php
//Pattern Strategy can be used to get mutable logic and encapsulate it in separate classes
//BUT CAN NOT BE USED TO AVOID CODE DUBLICATION IN QueenCheckBehavior
//ALSO DON'T LIKE REALIZATION OF Queen CLASS AT ALL. IT WORKS, BUT IT'S HORRIBLE

interface CheckBehavior
{
    public function check(int $curX, int $curY, int $x, int $y): bool;
}

class DiagonalCheckBehavior implements CheckBehavior
{
    public function check(int $curX, int $curY, int $x, int $y): bool
    {
        return (abs($curX - $x) == abs($curY - $y));
    }
}

class VerticalHorizontalCheckBehavior implements CheckBehavior
{
    public function check(int $curX, int $curY, int $x, int $y): bool
    {
        return ($curX == $x || $curY == $y);
    }
}

/* Code dublication is not needed here by task conditions
class QueenCheckBehavior implements CheckBehavior
{
    public function check(int $curX, int $curY, int $x, int $y): bool
    {

        return (abs($curX - $x) == abs($curY - $y)) || ($curX == $x || $curY == $y);
    }
}

*/

abstract class ChessFigure
{
    private int $curX;
    private int $curY;
    private CheckBehavior $behavior;
    public function __construct(int $curX, int $curY)
    {
        $this->curX = ($curX >= 0 && $curX <= 7) ? $curX : 0;
        $this->curY = ($curY >= 0 && $curY <= 7) ? $curY : 0;
        $this->behavior = $this->getBehavior();
    }
    public function move(int $x, int $y): bool
    {
        return $this->behavior->check($this->curX, $this->curY, $x, $y);
    }
    public function getChessFigureInfo(): string
    {
        return static::class . ' (' . $this->curX . ', ' . $this->curY . ') ';
    }
    abstract protected function getBehavior(): CheckBehavior;

    public function setBehavior(CheckBehavior $behavior): void
    {
        $this->behavior = $behavior;
    }
}

class Rook extends ChessFigure
{
    protected function getBehavior(): CheckBehavior
    {
        return new VerticalHorizontalCheckBehavior();
    }
}

class Bishop extends ChessFigure
{
    protected function getBehavior(): CheckBehavior
    {
        return new DiagonalCheckBehavior();
    }
}

class Queen extends ChessFigure
{
    protected function getBehavior(): CheckBehavior
    {
        return new VerticalHorizontalCheckBehavior();
    }
    public function move(int $x, int $y): bool
    {
        $VHResult = parent::move($x, $y);
        if ($VHResult) {
            return $VHResult;
        } else {
            $this->setBehavior(new DiagonalCheckBehavior());
            return parent::move($x, $y);
        }
    }
}

// Client code
$chess = array(
    new Bishop(0, 0),
    new Rook(0, 0),
    new Queen(0, 0),
);
$x = 1;
$y = 2;
foreach ($chess as $figure) {
    if ($figure->move($x, $y)) {
        echo $figure->getChessFigureInfo() . ' can go to (' . $x . ', ' . $y . ')<br/>';
    } else {
        echo $figure->getChessFigureInfo() . ' CAN NOT go to (' . $x . ', ' . $y . ')<br/>';
    }
}
