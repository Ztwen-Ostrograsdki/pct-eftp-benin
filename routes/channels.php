<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});



Broadcast::channel('master', function ($user) {

    return $user->isMaster();
});


Broadcast::channel('members', function ($user) {

    return $user->member !== null;
});


Broadcast::channel('admin', function ($user) {

    return $user->isAdminAs();
});

Broadcast::channel('confirmeds', function ($user) {

    return $user->confirmed_by_admin === true && $user->blocked === false && $user->emailVerified();

});

