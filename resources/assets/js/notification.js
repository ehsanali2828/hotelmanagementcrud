/**
 * Created by anil-kumar on 31/1/17.
 */

class Notification {

    static set(notification,response){
        notification.status   = response.status==true;
        notification.message = response.message;
        notification.show = true;
    }

    static clear(notification){
        notification.status   ='';
        notification.message = '';
        notification.show = false;
    }

}
export default Notification;
