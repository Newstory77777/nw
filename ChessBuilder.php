<?php
/**
 * Builder patern is useless for this concrete situation with chess problem
 * We need to use patterns to solve concrete sort of problems they were created for
 * (like Antipattern Telescopic constructor)
 */
interface Behavior
{
    public function check(int $curX, int $curY, int $x, int $y): bool;
}

class VerticalHorizontalBehavior implements Behavior
{
    public function check(int $curX, int $curY, int $x, int $y): bool
    {
        return ($curX == $x || $curY == $y);
    }
}

class DiagonalBehavior implements Behavior
{
    public function check(int $curX, int $curY, int $x, int $y): bool
    {
        return (abs($curX - $x) == abs($curY - $y));
    }
}

class Builder 
{
    public int $curX;
    public int $curY;
    public array $behaviors;

    public function __construct(int $curX, int $curY)
    {
        $this->curX = ($curX >= 0 && $curX <= 7) ? $curX : 0;
        $this->curY = ($curY >= 0 && $curY <= 7) ? $curY : 0;
    }

    public function addBehavior(Behavior $behavior)
    {
        $this->behaviors[] = $behavior;
        return $this;
    }
    public function build ()
    {
        return new ChessFigure($this);
    }
}

class ChessFigure 
{
    private int $curX;
    private int $curY;
    private array $behaviors;

    public function __construct (Builder $builder)
    {
        $this->curX = $builder->curX;
        $this->curY = $builder->curY;
        $this->behaviors = $builder->behaviors;
    }
    public function move (int $x, int $y): bool 
    {
        foreach ($this->behaviors as $behavior) {
            if ($behavior->check($this->curX, $this->curY, $x, $y)) {
                return true;
            }
        }
        return false;

    }

    public function getChessFigureCoords () : string
    {
        return ' ('. $this->curX.', '.$this->curY.') ';
    }
}


$rook = (new Builder(0, 0))->addBehavior(new VerticalHorizontalBehavior)->build();
$bishop = (new Builder(0, 0))->addBehavior(new DiagonalBehavior)->build();
$queen = (new Builder(0, 0))->addBehavior(new VerticalHorizontalBehavior)->addBehavior(new DiagonalBehavior)->build();
$chess = array('Rook' => $rook, 'Bishop' => $bishop, 'Queen' => $queen);
$x = 0;
$y = 5;
foreach ($chess as $key => $figure) {
    if ($figure->move($x, $y)) {
        echo $key . $figure->getChessFigureCoords() . ' can go to (' . $x . ', ' . $y . ')<br/>';
    } else {
        echo $key . $figure->getChessFigureCoords() . ' CAN NOT go to (' . $x . ', ' . $y . ')<br/>';
    }
}
