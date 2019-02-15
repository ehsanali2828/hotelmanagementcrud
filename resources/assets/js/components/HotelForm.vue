<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div>
        <div class="panel-heading"><span v-if="form.id == null">Add</span><span v-else>Edit</span> Hotel</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form style="display:inline" method="POST" action="/hotel" autocomplete="off" enctype="multipart/form-data" @submit.prevent="onSubmit"
                          @keydown="form.errors.clear($event.target.name)">

                        <div class="form-group">
                            <label class="col-md-4 control-label"> Name</label>

                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" v-model="form.name"/>
                                <p class="help-block">
                                    <span class="help is-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                                </p>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="col-md-4 control-label"> Address1</label>

                            <div class="col-md-6">
                                <textarea name="address1" class="form-control" v-model="form.address1"></textarea>

                                <p class="help-block">
                                    <span class="help is-danger" v-if="form.errors.has('address1')" v-text="form.errors.get('address1')"></span>
                                </p>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="col-md-4 control-label"> Address2</label>

                            <div class="col-md-6">
                                <textarea name="address2" class="form-control" v-model="form.address2"></textarea>

                                <p class="help-block">
                                    <span class="help is-danger" v-if="form.errors.has('address2')" v-text="form.errors.get('address2')"></span>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label"> City</label>

                            <div class="col-md-6">
                                <input type="text" name="city" class="form-control" v-model="form.city"/>

                                <p class="help-block">
                                    <span class="help is-danger" v-if="form.errors.has('city')" v-text="form.errors.get('city')"></span>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label"> State</label>

                            <div class="col-md-6">
                                <input type="text" name="state" class="form-control" v-model="form.state"/>

                                <p class="help-block">
                                    <span class="help is-danger" v-if="form.errors.has('state')" v-text="form.errors.get('state')"></span>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label"> Zip</label>

                            <div class="col-md-6">
                                <input type="text" name="zip" class="form-control" v-model="form.zip"/>

                                <p class="help-block">
                                    <span class="help is-danger" v-if="form.errors.has('zip')" v-text="form.errors.get('zip')"></span>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label"> Country</label>

                            <div class="col-md-6">
                                <input type="text" name="country" class="form-control" v-model="form.country"/>

                                <p class="help-block">
                                    <span class="help is-danger" v-if="form.errors.has('country')" v-text="form.errors.get('country')"></span>
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label"> Image</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control" id="file" name ="file[]" @change="onFileChange" accept="image/*" multiple>
                                <p class="help-block">
                                    <span class="help is-danger" v-if="form.errors.hasImageError()" v-text="form.errors.getImageError()"></span>
                                </p>

                            </div>
                        </div>

                        <div class="row list-group">
                            <label class="col-md-4 control-label" ></label>
                            <div class="col-md-6">
                                <div class="item col-md-12" v-for="(image,index) in images" track-by="$index">
                                    <div class="thumbnail col-md-3">
                                        <img :src="image" height="100" width="100">
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" v-model="form.title[index]" placeholder="Title">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="hotels" class="row list-group" v-if ="form.id != null">
                            <label class="col-md-4 control-label"></label>
                            <div class="col-md-6">
                                <div class="item col-md-12" v-for="(image,index) in form.images">
                                    <div class="thumbnail col-md-3">
                                        <img class="group list-group-image" :src="image.path+'/'+image.name" alt="" style="height:50px;" />
                                        <div class="caption">
                                            <div class="row">
                                                <div class="col-xs-12 col-md-6">
                                                    <a class="btn btn-danger btn-xs glyphicon glyphicon-trash" title="Remove image" href="#" @click.prevent="onImageDelete(image.id,index)" ></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="hidden" v-model="form.image_id[index]">
                                        <input type="text" class="form-control" v-model="form.image_title[index]"  placeholder="Title">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label"> Amenities</label>
                            <div class="col-md-6">
                                <label v-for="(amenity,index) in amenities">
                                    <div class="checkbox">
                                        <label style="padding-right: 15px;"><input type="checkbox" name="amenities[]" v-bind:value="amenity.id" @click="OnChangeAmenity()" v-model="form.amenities"> {{ amenity.name }}</label>
                                    </div>
                                </label>
                                <p class="help-block">
                                    <span class="help is-danger" v-if="form.errors.has('amenities')" v-text="form.errors.get('amenities')"></span>
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-4">
                                <button class="btn btn-primary" :disabled="form.errors.any()"><span v-if="form.id == null">Save</span><span v-else>Update</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import Form from '../Form';
    import Image from '../model/Image.js';
    import Amenities from '../model/Amenities';
    import Store from '../Store.js';
    import Notification from '../notification.js';
    export default {
        watch: {
            '$route' (to)
    {
        this.init(to.params.id);
    }
    },
    data()
    {
        return {
            showForm : false,
            amenities: {},
            images :[],
            form     : new Form({
                name     : '',
                address1 : '',
                address2 : '',
                city     : '',
                state    : '',
                zip      : '',
                country  : '',
                images   : {},
                id       : null,
                amenities: [],
                image_id: [],
                image_title: [],
                title:[]
            }, '/hotel'),
            formData : new FormData(),
            shared : Store
        }
    },

    methods: {
        init(id)
        {
            this.form.reset();
            this.form.id = id;
            if (id == 0) {
                this.form.id = null;
            } else {
                this.form.fetch(id);
            }
            Amenities.all(amenities => this.amenities = amenities);
        },
        onSubmit()
        {
            this.form.append(this.formData);
            this.form.post('/hotel',this.formData)
                 .then(response => {
                 Notification.set(this.shared.notification,response);
                 this.$router.push('/hotel');
             });
        },
        onDelete(event)
        {
            this.form.id = event.id;
            this.form.delete('hotel/' + event.id);
        },
        onFileChange(event)
        {
            this.formData = new FormData();
            this.images = [];
            this.form.title = [];

            var files = event.target.files || event.dataTransfer.files;
            if (!files.length){
                return false;
            }
            for (var i = 0; i < files.length; i++) {
                var file = files.item(i);
                this.formData.append('images[]', file);
                this.updateImageData(file);
            }
            this.form.errors.clearImageError();
            this.$forceUpdate();
        },
        onImageDelete(image_id,index)
        {
            Image.delete(image_id);
            this.form.images = this.form.images.filter(image => image.id != image_id);
            this.form.image_id.splice(index,1);
            this.form.image_title.splice(index,1);

        },
        OnChangeAmenity()
        {
            if(this.form.amenities.length > 0){
               this.form.errors.clear('amenities');
            }
        },
        updateImageData(file){
            var image = new Image();
            var reader = new FileReader();
            var vm = this;
            reader.onload = (e) => {
                vm.images.push(e.target.result);
                vm.form.title.push('');
            };
            reader.readAsDataURL(file);
        }
    },
    created()
    {
        this.init(this.$route.params.id);
    }
    }
</script>
