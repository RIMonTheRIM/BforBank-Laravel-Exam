<?php

namespace App\Models;

enum TypeCompte: string
{
    case Epargne = 'epargne';
    case Courant = 'courant';
}
