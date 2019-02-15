<template>
    <div :class="{'alert-success':(shared.notification.status),'alert':true,'alert-dismissable':true,'alert-danger':(!shared.notification.status)}" v-if="shared.notification.show">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" @click="onCloseNotification">&times;</a>
        <strong>Success!</strong> {{ shared.notification.message }}
    </div>
</template>
<script>
    import Store from '../Store.js';
    import Notification from '../notification.js';
    export default {
        data()
        {
            return {
                shared:Store
            };
        },
        methods:{
            onCloseNotification()
            {
                Notification.clear(this.shared.notification);
            }
        }
    }
</script>