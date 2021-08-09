<?php
	class ObjectModel extends ObjectModelCore {
		public function update($null_values = false) {
			if(isset($this->firstname) && !$this->firstname) {
				$this->firstname = null;
			}

			if(isset($this->lastname) && !$this->lastname) {
				$this->lastname = null;
			}

		 	return parent::update($null_values);
		}
	}