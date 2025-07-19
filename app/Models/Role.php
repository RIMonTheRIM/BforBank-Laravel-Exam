<?php

namespace App\Models;

enum Role: string {
    case Client = 'client';
    case Gestionnaire = 'gestionnaire';
}
