/**
 * Created by anil-kumar on 30/1/17.
 */

class Image
{
    static delete(id)
    {
        return axios.get('/delete-image/'+id);
    }

}

export default Image;
