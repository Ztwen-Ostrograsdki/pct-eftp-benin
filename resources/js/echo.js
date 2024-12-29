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

    

e.private('admin')

    .listen('UserHasBeenBlockedSuccessfullyEvent', (user) =>{

        Livewire.dispatch('LiveUserHasBeenBlockedSuccessfullyEvent', user);
        
    })
    
    .listen('NotificationDispatchedToAdminsSuccessfullyEvent', (user) =>{

        Livewire.dispatch('LiveNotificationDispatchedToAdminsSuccessfullyEvent', user);
        
    })
    .listen('TheOrderApprovedSuccessfullyEvent', (order_identifiant) =>{

        Livewire.dispatch('LiveTheOrderApprovedSuccessfullyEventForAdmin', order_identifiant);
        
    })

e.private('App.Models.User.' + window.ClientUser.id)
    .listen('LogoutUserEvent', (ev) =>{

        Livewire.dispatch('LiveLogoutUserEvent', ev);
        
    })
    .listen('OrderCreationHasBeenFailedEvent', (ev) =>{

        Livewire.dispatch('LiveOrderCreationHasBeenFailedEvent', ev);
        
    })
    .listen('NewOrderHasBeenCreatedSuccessfullyEvent', (order) =>{

        Livewire.dispatch('LiveNewOrderHasBeenCreatedSuccessfullyEvent', order);
        
    })
    .listen('TheOrderApprovedSuccessfullyEvent', (order_identifiant) =>{

        Livewire.dispatch('LiveTheOrderApprovedSuccessfullyEvent', order_identifiant);
        
    })

    .listen('InitFedaPayCheckoutEvent', (data) =>{
        
    })
    
    FedaPay.init('#pay-btn', {
        public_key: 'pk_sandbox_lf7ed0OyC_S-JmIEL3RvCE1R',
        
      }
    )

    