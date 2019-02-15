<template>
    <div>
        <div class="panel-heading">Hotel List</div>
        <div class="panel-body">
            <notification></notification>
            <div class="table-responsive">
                <router-link class="btn btn-primary btn-xs" title="Add New HotelList" to="/hotel/0"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></router-link>
                <vuetable ref="vuetable"
                          api-url="/hotel"
                          :fields="fields"
                          pagination-path=""
                          @vuetable:pagination-data="onPaginationData"
                          @vuetable:cell-clicked="onCellClicked"
                        ></vuetable>
                <vuetable-pagination ref="pagination" @vuetable-pagination:change-page="onChangePage" ></vuetable-pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from '../Form';
    import Vuetable from 'vuetable-2/src/components/Vuetable.vue';
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination.vue';
    import Vue from 'vue';
    import Message from './notification.vue';
    import Store from '../Store.js';
    import Notification from '../notification.js';

    export default {
        components: {
            Vuetable,
            VuetablePagination,
            notification:Message
        },
        data()  {
        return {
            hotels: [],
            fields: [
                {
                    name: 'name',
                    title: 'Name'
                },
                {
                    name: 'address1',
                    title: 'Address 1'
                },
                {
                    name: 'address2',
                    title: 'Address 2'
                },
                {
                    name: 'city',
                    title: 'City'
                },
                {
                    name: 'state',
                    title: 'State'
                },
                {
                    name: 'zip',
                    title: 'Zip'
                },
                {
                    name: 'country',
                    title: 'Country'
                },
                {
                    name: 'edit',
                    title: '',
                    callback: 'editButton'
                },
                {
                    name: 'delete',
                    title: '',
                    callback: 'deleteButton'
                },
            ],
            shared:Store
        }
    },

    methods: {
        deleteButton() {
            return '<a class="btn btn-danger btn-xs" title="Delete Hotel"><span class="glyphicon glyphicon-trash" aria-hidden="true"/></a>';
        },
        editButton() {
            return '<a class="btn btn-success btn-xs" title="Edit Hotel"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>';
        },
        onPaginationData (paginationData) {
            this.$refs.pagination.setPaginationData(paginationData)
        },
        onChangePage (page) {
            this.$refs.vuetable.changePage(page)
        },
        deleteContact(id) {
            var temp = new Form({
                id,
                'url': '/hotel'
            });
            temp.delete().then(response=>{
                Notification.set(this.shared.notification,response);
                this.$refs.vuetable.reload();
            });

    },
    onCellClicked (data, field, event) {
        if(field.name == 'edit') {
            this.$router.push('/hotel/'+data.id);
        }
        else if(field.name == 'delete') {
            this.deleteContact(data.id);
        }

    }

    },
    events:{
      "clear-notification":function(){

        }
    },
    created() {
        Event.listen('refresh-contact', this.refresh);
    }
    }
</script>
