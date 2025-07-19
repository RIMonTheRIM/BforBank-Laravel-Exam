<?php

namespace App\Models;

enum TypeTransaction: string
{
    case Depot = 'depot';
    case Retrait = 'retrait';
    case Virement = 'virement';
}
