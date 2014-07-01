<?php

namespace Jonczek\Immobilienscout24Tracker;

class Sorting
{
    const __default = self::Newest;

    const Standard = 'T';
    const Newest = 2;
    const RateHighestFirst = 3;
    const RateLowestFirst = 4;
    const RoomsHighestFirst = 5;
    const RoomsLowestFirst = 6;
    const AreaHighestFirst = 7;
    const AreaLowestFirst = 8;
}
