<?php
class SearchType
{
    const QUESTIONS = 0;
    const USERS = 1;

    static function isValid($input)
    {
        return $input > 0 && $input < 1;
    }
}