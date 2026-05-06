<?php

use App\Models\Lecture;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('lecture-{lecture}', function ($user, Lecture $lecture) {
    return $user->id === $lecture->course->user_id;
});