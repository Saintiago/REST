<?php

    /**
     * Skeleton subclass for representing a row from the 'users' table.
     *
     *
     *
     * This class was autogenerated by Propel 1.4.2 on:
     *
     * 05/07/15 13:54:42
     *
     * You should add additional methods to this class to meet the
     * application requirements.  This class will only be generated as
     * long as it does not already exist in the output directory.
     *
     * @package    lib.model
     */
    class Users extends BaseUsers
    {
        public function __toString()
        {
            return $this->getLogin();
        }

    } // Users
