<?php

class Sangria
{
    public $pronouns = ["yo", "tu", "él", "nosotros", "vosotros", "ellos"];

    public $endings = [["o", "as", "a", "amos", "áis", "an"],
                       ["o", "es", "e", "emos", "éis", "en"],
                       ["o", "es", "e", "imos",    "ís", "en"]];

    public $irregularVerbs = ["ser" => ["soy", "eres", "es", "somos", "sois", "son"],
                              "tener" => ["tengo", "tienes", "tiene", "tenemos", "tenéis", "tienen"],
                              "estar" => ["estoy", "estas", "está", "estamos", "estáis", "estan"]];

    public $compositePronouns = ["me", "te", "se", "nos", "os", "se"];

    public function isComposite($verb)
    {
        return substr($verb, -2) === "se";
    }

    public function decompose($verb)
    {
        return substr($verb, 0, -2);
    }

    public function findGroup($verb)
    {
        $ending = substr($verb, -2);
        $endingsByGroup = ["ar", "er", "ir"];
        if($ending === "se") {
            findGroup(decompose($verb));
        } else {
            return array_search($ending, $endingsByGroup);
        }
    }

    public function findRoot($verb)
    {
        return substr($verb, 0, -2);
    }

    public function conjugate($verb, $pronounIndex)
    {
        if(array_key_exists($verb, $this->irregularVerbs)) {
            return $this->irregularVerbs[$verb][$pronounIndex]; 
        }

        if($this->isComposite($verb)) {
            $verb = $this->decompose($verb);
            $root = $this->findRoot($verb);
            $group = $this->findGroup($verb);
            return sprintf("%s %s%s", $this->compositePronouns[$pronounIndex], $root, $this->endings[$group][$pronounIndex]);
        } else {
            $group = $this->findGroup($verb);
            return sprintf("%s%s", $this->findRoot($verb), $this->endings[$group][$pronounIndex]);
        }
    }
}
