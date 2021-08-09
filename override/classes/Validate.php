<?php
    class Validate extends ValidateCore {
        /**
         * Check whether given name is valid and not empty
         *
         * @param string $name Name to validate
         *
         * @return int 1 if given input is a name, 0 else
         */
        public static function isNameNotEmpty($name) {
            $validityPattern = Tools::cleanNonUnicodeSupport(
                '/^[^0-9!<>,;?=+()@#"°{}_$%:¤| ]*$/u'
            );

            return preg_match($validityPattern, $name);
        }
    }