<?php

interface Displayable
{
    public function __toString(): string;
    public function toArray(): array;
    public static function getDisplayHeaders(): array;
}
