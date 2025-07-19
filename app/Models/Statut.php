<?php

namespace App\Models;

enum Statut: string
{
    Case En_Attente = 'en_Attente';
    Case Accepte = 'accepte';
    Case Rejete = 'rejete';
}
