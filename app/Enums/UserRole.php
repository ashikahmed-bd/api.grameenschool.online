<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case AUTHOR = 'author';
    case INSTRUCTOR = 'instructor';
    case STUDENT = 'student';
}
