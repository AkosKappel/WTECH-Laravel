<?php

function formattedPrice($price): string
{
    return number_format((float) $price, 2, ',', ' ') . ' €';
}

