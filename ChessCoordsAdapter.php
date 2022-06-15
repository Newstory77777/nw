<?php
interface CP
{
    public function paint();
}

class ChessPiece implements CP
{
    public function __construct(private string $name, private int $curX, private int $curY)
    {
    }
    public function paint(): string
    {
        return $this->name . ' (' . $this->curX . ', ' . $this->curY . ') ';
    }
}

class Adapter implements CP
{
    public function __construct(private ChessFigure $cf)
    {
    }
    public function paint()
    {
        return $this->cf->render();
    }
}
    
class ChessFigure
{
    public function __construct(private string $name, private string $curPoint)
    {
    }
    public function render(){
        return 'Figure '.$this->name.' at position '. $this->curPoint;
    }
}

function clientCode (CP $cp)
{
    echo $cp->paint();
    echo '<br>';
}

$cp1 = new ChessPiece('Rook', 0, 0);
clientCode($cp1);
$cf1 = new ChessFigure('Bishop', 'A8');
//clientCode() can not be used with parameter $cf, because there is no method paint, but
$adapter = new Adapter($cf1);
clientCode($adapter);



