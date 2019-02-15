class Errors {
    /**
     * Create a new Errors instance.
     */
    constructor() {
        this.errors = {};
    }


    /**
     * Determine if an errors exists for the given field.
     *
     * @param {string} field
     */
    has(field) {
        return this.errors.hasOwnProperty(field);
    }

    /**
     * Determine if an error exists for image field
     *
     * @returns {boolean}
     */

    hasImageError(){
        var imageError = Object.keys(this.errors).filter(function(k) {
            return k.indexOf('images') == 0;
        });
        return imageError.length > 0;
    }

    getImageError()
    {
        var imageError = Object.keys(this.errors).filter(function(k) {
            return k.indexOf('images') == 0;
        });
        return this.get(imageError[0]);
    }
    /**
     * Determine if we have any errors.
     */
    any() {
        return Object.keys(this.errors).length > 0;
    }


    /**
     * Retrieve the error message for a field.
     *
     * @param {string} field
     */
    get(field) {
        if (this.errors[field]) {
            return this.errors[field][0];
        }
    }


    /**
     * Record the new errors.
     *
     * @param {object} errors
     */
    record(errors) {
        this.errors = errors;
    }


    /**
     * Clear one or all error fields.
     *
     * @param {string|null} field
     */
    clear(field) {
        if (field) {
            delete this.errors[field];

            return;
        }

        this.errors = {};
    }

    clearImageError(){
        var imageErrors = Object.keys(this.errors).filter(function(k) {
            return k.indexOf('images') == 0;
        });
        if(imageErrors.length > 0)
        {
            for (let field in imageErrors) {
                delete this.errors[imageErrors[0]];
            }
        }
        return;
    }
}


export default class Form {
    /**
     * Create a new Form instance.
     *
     * @param {object} data
     */
    constructor(data, url) {
        this.originalData = data;
        this.url = url;
        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new Errors();
    }


    /**
     * Fetch all relevant data for the form.
     */
    data() {
        let data = {};

        for (let property in this.originalData) {
            data[property] = this[property];
        }

        return data;
    }

    /**
     * Fetch all relevant data for the form.
     */
    setData(data) {
        for (let property in this.originalData) {
            if(property=='image_id' || property=='image_title')
            {
                break;
            }
            if(property=='amenities'){
                data[property].forEach(function (amenity) {
                    this[property].push(amenity.id);
                }, this);
            } else if(property=='images'){
                data[property].forEach(function (image) {
                    this.image_id.push(image.id);
                    this.image_title.push(image.title);
                }, this);
                this[property] = data[property];
            } else {
                this[property] = data[property];
            }
        }
    }


    /**
     * Reset the form fields.
     */
    reset() {
        for (let field in this.originalData) {
            this[field] = this.originalData[field];
        }

        this.errors.clear();
    }

    append(formData){
        for (let property in this.originalData) {
            formData.append(property,this[property]);
        }
    }

    /**
     * Send a POST request to the given URL.
     * .
     */
    post(url,data) {
        return this.submit('post', this.resourceUrl(),data);
    }


    /**
     * Send a PUT request to the given URL.
     * .
     */
    put() {
        return this.submit('put', this.resourceUrl());
    }


    /**
     * Send a PATCH request to the given URL.
     * .
     */
    patch() {
        return this.submit('patch', this.resourceUrl());
    }

    resourceUrl() {
        if(this.id == null) {
            return this.url;
        }
        return this.url+"/"+this.id;
    }


    /**
     * Send a DELETE request to the given URL.
     * .
     * @param {string} url
     */
    delete() {
        return this.submit('delete', this.resourceUrl());
    }


    /**
     * Submit the form.
     *
     * @param {string} requestType
     * @param {string} url
     */
    submit(requestType, url,data) {
        return new Promise((resolve, reject) => {
            axios[requestType](url, data)
                .then(response => {
                    this.onSuccess(response.data.status);
                    resolve(response.data);
                })
                .catch(error => {
                    this.onFail(error.response.data);

                    reject(error.response.data);
                });
        });
    }

    fetch(id) {
        this.id = id;
        return new Promise((resolve, reject) => {
            axios.get(this.resourceUrl(), this.data())
              .then(response => {
                  this.setData(response.data);
                  resolve(response.data);
              })
              .catch(error => {
                  this.onFail(error.response.data);

                  reject(error.response.data);
              });
        });
    }


    /**
     * Handle a successful form submission.
     *
     * @param {object} data
     */
    onSuccess(data) {

        this.reset();
    }


    /**
     * Handle a failed form submission.
     *
     * @param {object} errors
     */
    onFail(errors) {
        this.errors.record(errors);
    }
}
