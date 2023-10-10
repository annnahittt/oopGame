<?php

class Player{
    public $name;
    public $coins;
    public function __construct($name, $coins){
        $this->name= $name;
        $this->coins= $coins;
    }
    public function point(Player $player){
        $this->coins++;
        $player->coins--;
    }
    public function bankrupt(){
        return $this->coins ==0;
    }
    public function bank(){
        return $this->coins;
    }
    public function chances(Player $player){
        return round($this->bank()/($this->bank()+$player->bank()),2) *100  .'%';
    }
}
class Game{
    protected $player1;
    protected $player2;
    protected $flips = 1;
    public function __construct(Player $player1, Player $player2){
        $this->player1 = $player1;
        $this->player2 = $player2;

    }
    public function flip(){
        return rand(0, 1) ? 'орел' : 'решка';

    }
    public function start(){

        echo <<<EOT
        {$this->player1->name}: {$this->player1->chances($this->player2)}
        {$this->player2->name}:{$this->player2->chances($this->player1)}

EOT;

        $this->play();
    }

    public function play()

    {
    while (true){
    if ($this->flip() == 'орел') {
        $this->player1->point($this->player2);
    } else {
        $this->player2->point($this->player1);

    }
    if ($this->player1->bankrupt() || $this->player2->bankrupt()) {
        return $this->end();
        }
        $this->flips++;

    }

     }
     public function winner()
     {
        return $this->player1->bank()>$this->player2->bank()? $this->player1:$this->player2;

     }
public function end(){
        echo <<<ЕОТ
        Game Over
        {$this->player1->name}:{$this->player1->coins}
        {$this->player2->name}:{$this->player2->coins}

        Winner: {$this->winner()->name}
        Flips: {$this->flips}
ЕОТ;


}
}

$game = new Game(
    new Player('Joe', 1000),
    new Player('Jane', 100)
);
$game->start();