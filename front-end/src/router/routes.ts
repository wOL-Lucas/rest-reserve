import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '',
        component: () => import('pages/IndexPage.vue')
      },
      {
        path: '/reservations',
        children: [
          { path: '', component: () => import('pages/reserve/ReservationsPage.vue') },
        ],
      },
      {
        path: '/menu',
        children: [
          { path: '', component: () => import('pages/menu/MenuPage.vue') },
        ],
      },
    ],
  },
  {
    path: '/auth',
    component: () => import('layouts/OuterLayout.vue'),
    children: [
      { path: 'login', component: () => import('pages/auth/LoginPage.vue') },
      { path: 'signup', component: () => import('pages/auth/SignUpPage.vue') },
    ],
  },
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
