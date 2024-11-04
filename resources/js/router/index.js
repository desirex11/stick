import { createRouter, createWebHistory } from 'vue-router';
import GameLevel from '../components/GameLevel.vue';

const routes = [
  { path: '/', component: GameLevel }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
