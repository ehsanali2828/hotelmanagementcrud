import VueRouter from 'vue-router';

let routes = [
  {
    path: '/',
    component: require('./components/HotelList.vue')
  },
  {
    path: '/hotel',
    component: require('./components/HotelList.vue')
  },
  {
    path: '/hotel/:id',
    component: require('./components/HotelForm.vue')
  }
];

export default new VueRouter({
  routes,
  linkActiveClass: 'is-active'
});
