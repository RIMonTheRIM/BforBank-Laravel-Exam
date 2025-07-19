<?php

namespace App\Models;

enum StatutCarte: string
{
    Case Active = 'active';
    Case Blocked = 'bloquée';
    Case Expired = 'expirée';
}
