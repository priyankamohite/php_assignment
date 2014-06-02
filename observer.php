<?php

interface Observer
{
    public function update(Observable $subject);
}

interface Observable
{
    public function attachObserver(Observer $dependent);
    public function detachObserver(Observer $dependent);
    public function notify();
}

class King implements Observer{
    public function update(Observable $subject)
    {
        echo "\n Got report of followed orders.\n";
    }
}

class Servant implements Observable{

    public $status;
    private $_observers = array();

    public function __construct()
    {
        $this->attachObserver(new King());
    }

    public function attachObserver(Observer $object)
    {
        echo "\n Listen order \n";
        $this->_observers[] = $object;
    }

    public function detachObserver(Observer $object)
    {
        foreach ($this->_observers as $index => $observer) {
            if ($object == $observer) {
                echo "in detach";
                unset($this->_observers[$index]);
            }
        }
    }

    public function notify()
    {
        foreach ($this->_observers as $observer) {
            $observer->update($this);
        }
    }

    public function report()
    {
        $this->notify($this);
        $this->detachObserver(new King());

    }

}

$servent = new Servant();
$servent->report();


?>