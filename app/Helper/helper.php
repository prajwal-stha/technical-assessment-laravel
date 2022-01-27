<?php


/*
 *  Used to get date with start midnight time
 *  @param
 *  $date as timestamp or date variable
 *  @return date with start midnight time
 */
function getStartOfDate($date): string
{
    return date('Y-m-d', strtotime($date)).' 00:00';
}

/*
 *  Used to get date with end midnight time
 *  @param
 *  $date as timestamp or date variable
 *  @return date with end midnight time
 */

function getEndOfDate($date): string
{
    return date('Y-m-d', strtotime($date)).' 23:59';
}
