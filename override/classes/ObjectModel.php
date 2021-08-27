<?php
/**
 *  @author    Ludovic Lemaître <contact@llemaitre.com>
 *  @copyright 2021 Ludovic Lemaître
 *  @license   https://github.com/l-lemaitre/froggycomments  Exemple
*/

class ObjectModel extends ObjectModelCore
{
    public function update($null_values = false)
    {
        if (isset($this->firstname) && !$this->firstname) {
            $this->firstname = null;
        }

        if (isset($this->lastname) && !$this->lastname) {
            $this->lastname = null;
        }

        return parent::update($null_values);
    }
}
