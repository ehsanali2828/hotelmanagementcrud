/**
 * Created by anil-kumar on 30/1/17.
 */

class Amenities {

    static all(then) {
        return axios.get('/amenities')
            .then(({data})=> then(data));

    }

}

export default Amenities;
