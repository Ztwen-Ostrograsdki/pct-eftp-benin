import Echo from 'laravel-echo';

import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});


var e = window.Echo;

window.ClientUser = {
    id: 0,
};
if (window.User) {
    window.ClientUser = window.User;
}



e.private('master')

e.private('confirmeds')
        .listen('EpreuveWasCreatedSuccessfullyEvent', () =>{

            Livewire.dispatch('LiveEpreuveWasCreatedSuccessfullyEvent');
            
        })
        .listen('SupportFileWasCreatedSuccessfullyEvent', () =>{

            Livewire.dispatch('LiveSupportFileWasCreatedSuccessfullyEvent');
            
        })

    

e.private('admin')

    .listen('UserHasBeenBlockedSuccessfullyEvent', () =>{

        Livewire.dispatch('LiveUserHasBeenBlockedSuccessfullyEvent');
        
    })
    
    .listen('NotificationDispatchedToAdminsSuccessfullyEvent', (user) =>{

        Livewire.dispatch('LiveNotificationDispatchedToAdminsSuccessfullyEvent', user);
        
    })
    .listen('NewEpreuveHasBeenPublishedEvent', (user) =>{

        Livewire.dispatch('LiveNewEpreuveHasBeenPublishedEvent', user);
        
    })
    .listen('EpreuveWasCreatedSuccessfullyEvent', (user) =>{

        Livewire.dispatch('LiveEpreuveWasCreatedSuccessfullyEvent', user);
        
    })
    .listen('NewSupportFileHasBeenPublishedEvent', (user) =>{

        Livewire.dispatch('LiveNewSupportFileHasBeenPublishedEvent', user);
        
    })
    .listen('SupportFileWasCreatedSuccessfullyEvent', (user) =>{

        Livewire.dispatch('LiveSupportFileWasCreatedSuccessfullyEvent', user);
        
    })


e.private('App.Models.User.' + window.ClientUser.id)

    .listen('LogoutUserEvent', (ev) =>{

        Livewire.dispatch('LiveLogoutUserEvent', ev);
        
    })

    .listen('IHaveNewNotificationEvent', (data) =>{

        Livewire.dispatch('LiveIHaveNewNotificationEvent', ev);
        
    })
    .listen('YourMessageHasBeenLikedBySomeoneEvent', (data) =>{

        Livewire.dispatch('LiveYourMessageHasBeenLikedBySomeoneToTheUserEvent', {liker_data: data.liker, user_data: data.user});
        
    })
    .listen('ForumChatSujectHasBeenSubmittedSuccessfullyEvent', (data) =>{

        Livewire.dispatch('LiveForumChatSubjectHasBeenSubmittedToAdminsEvent', { user: data.user});
        
    })

e.join('forumChatRoom')

    .here((users)  => {

        console.log(users);

        Livewire.dispatch('LiveConnectedUsersToForumEvent', {users: users});
        
    })

    .joining((user)  => {
        console.log(user);

    })

    .leaving((user)  => {
        

    })

    .error((users)  => {
        

    })

    .listen('ChatMessageHasBeenSentSuccessfullyEvent', (data) =>{

        Livewire.dispatch('LiveLoadNewMessageEvent', {data: data.user});
        
    })
    .listen('UserIsTypingMessageEvent', (data) =>{

        Livewire.dispatch('LiveUserIsTypingMessageEvent', {user_data: data.user});
        
    })
    .listen('YourMessageHasBeenLikedBySomeoneEvent', (data) =>{

        Livewire.dispatch('LiveYourMessageHasBeenLikedBySomeoneEvent', {liker_data: data.liker, user_data: data.user});
        
    })
    .listen('ForumChatSubjectHasBeenValidatedByAdminsEvent', (data) =>{

        Livewire.dispatch('LiveForumChatSubjectHasBeenValidatedByAdminsEvent', {user: data.user});
        
    })

    
    

    